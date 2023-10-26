<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Leads;
use App\Models\Quotes;
use App\Models\User;
use App\Models\DataLogs;
use DataTables;

class QuoteController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Quotes::leftjoin('users', 'quotes.approvedbyid', '=', 'users.id')
            ->join('leads', 'quotes.leadid', '=', 'leads.id')
            ->select('quotes.id as ID','quotes.quotenumber as QuoteNo' , 'quotes.quotedate AS Date','users.first_name As By','quotes.toperson as To','quotes.status AS Status')
            //->where('type','=','lead')
            ->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function($row){
                //     $actionBtn = '<a class="edit btn btn-success btn-sm" data-id="'.$row->ID.'">Edit</a> <a  class="delete btn btn-danger btn-sm" data-id="'.$row->ID.'">DeActive</a>';
                //     //$actionBtn=$row->ID;
                //     return $actionBtn;
                // })
                // ->rawColumns(['action'])
                ->editColumn('Date', function ($row) {
                    $date=date('d/m/Y',strtotime($row->Date));
                    return $date;
                })
                ->editColumn('By', function ($row) {
                    return $row->By ?: '-';
                })
                // ->editColumn('Approve', function ($row) {
                //     //return $row->Phone ?: '-';
                //     if($row->Approve==1){
                //         return "Approved";
                //     }else{
                //         return "Waiting to Aprroval";
                //     }
                // })
                ->editColumn('Status', function ($row) {
                    //return $row->Website ?: '-';
                    switch ($row->Status) {
                        case '1':
                            return "Waiting For Approve";
                            break;
                        case '2':
                            return "Approved";
                            break;
                        case '3':
                            return "Rejected";
                            break;
                        // case '4':
                        //     return "Request Revision";
                        //     break;
                        
                            
                        default:
                        //1: Waiting For Apporove; 2: Approved; 3:Rejected; 4: Need Revision
                            break;
                    }
                })
                
                ->make(true);
        }

        return view('quotes.index');
    }


    public function create($id=null)
    {
        $Users=User::get();
        if(isset($id)){
            $id=$id;
        }else{
            $id="";
        }
        //dd($id);
        $Leads=Leads::get();
        return view('quotes.create',compact('Users','id','Leads'));
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $file = $request->file('file');
        //dd(date('Y-m-d',strtotime(str_replace('/','-',$request->quotedate))));
        $path = "public/attach_file/".str_replace('/','_',$request->quotenumber);
        $file->move($path,$file->getClientOriginalName());
        $dates=date('Y-m-d H:i:s');
        $data=[
            'ownerid'=>$request->ownerid,
            'leadid'=>$request->leadid,
            'quotenumber'=>$request->quotenumber,
            'quotedate'=>date('Y-m-d',strtotime(str_replace('/','-',$request->quotedate))),
            'quotename'=>$request->quotename,
            'toperson'=>$request->toperson,
            'toaddress'=>$request->toaddress,
            'approve'=>0,
            'status'=>1,
            'note'=>$request->note,
            'attcfile'=>$path."/".$file->getClientOriginalName(),
            'createbyid'=>$request->createbyid,
            'updatebyid'=>$request->updatebyid,
            'created_at'=>$dates,
            'updated_at'=>$dates
        ];
        $quotes=Quotes::create($data);
        $newdata=json_encode($data);
        $logs=[
            'module'=>'Quotes',
            'moduleid'=>$quotes->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Quotes Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('quotes');
    }

    public function view($id){
        $quotes=quotes::join('leads','leads.id','=','quotes.leadid')->where('quotes.id','=',$id)->select('quotes.*','leads.leadsname AS leadsname','leads.property_name AS property_name','leads.type AS leadtype')->get();
        //$quotes=quotes::where('id','=',$id)->get();
        $owner=User::where('id','=',$quotes[0]->ownerid)->get();
        $lead=Leads::where('id','=',$quotes[0]->leadid)->get();
        $createbyid=User::where('id','=',$quotes[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$quotes[0]->updatebyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','quotes')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        return view('quotes.view',compact('quotes','owner','createbyid','updatebyid','logs','lead'));
        
    }

    public function edit($id){
        $Users=User::get();
        $quotes=Quotes::where('id','=',$id)->get();
        $Leads=Leads::get();
        return view('quotes.edit',compact('Users','quotes','Leads'));
    }
    
    public function update(Request $request){
        $file = $request->file('file');
        //dd($file);
        $olddata=Quotes::where('id','=',$request->id)->get();
        $dates=date('Y-m-d H:i:s');
        if(isset($file)){
            unlink( public_path($olddata[0]->attcfile));
            //dd(assets());
            $path = "public/attach_file/".str_replace('/','_',$request->quotenumber);
            $file->move($path,$file->getClientOriginalName());
            
            $data=[
                'ownerid'=>$request->ownerid,
                'leadid'=>$request->leadid,
                'quotenumber'=>$request->quotenumber,
                'quotedate'=>date('Y-m-d',strtotime(str_replace('/','-',$request->quotedate))),
                'quotename'=>$request->quotename,
                'toperson'=>$request->toperson,
                'toaddress'=>$request->toaddress,
                'approve'=>0,
                'status'=>1,
                'note'=>$request->note,
                'attcfile'=>"attach_file/".str_replace('/','_',$request->quotenumber)."/".$file->getClientOriginalName(),
                'updatebyid'=>$request->updatebyid,
                'updated_at'=>$dates
            ];
        }else{
            $data=[
                'ownerid'=>$request->ownerid,
                'leadid'=>$request->leadid,
                'quotenumber'=>$request->quotenumber,
                'quotedate'=>date('Y-m-d',strtotime(str_replace('/','-',$request->quotedate))),
                'quotename'=>$request->quotename,
                'toperson'=>$request->toperson,
                'toaddress'=>$request->toaddress,
                'approve'=>0,
                'status'=>1,
                'note'=>$request->note,
                'updatebyid'=>$request->updatebyid,
                'updated_at'=>$dates
            ];
        }
        
        
        $quotes=Quotes::where('id','=',$request->id)->update($data);
        $newdata=json_encode($data);
        $logs=[
            'module'=>'Quotes',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Quotes Update',
            'olddata'=>json_encode($olddata),
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('quotes/view/'.$request->id);
    }

    public function approve(Request $request, $id){
        //dd($_GET['request']);
        $appid=$_GET['request'];
        $data=[ 'status'=>2, 'approvedbyid'=>$appid ];
        //dd($data);
        $quotes=Quotes::where('id','=',$id)->update($data);
        
        $newdata=json_encode($data);
        $logs=[
            'module'=>'Quotes',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Quotes Approved',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        
        $return=['status'=>'success','message'=>'Quote Approved'];
        echo json_encode($return);
        
    }
    public function reject(Request $request, $id){
        
        $appid=$_GET['request'];
        $data=[ 'status'=>3, 'approvedbyid'=>$appid ];
        $quotes=Quotes::where('id','=',$id)->update($data);
        $newdata=json_encode($data);
        $logs=[
            'module'=>'Quotes',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Quotes Rejected',
            'olddata'=>"",
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        
        $return=['status'=>'success','message'=>'Quote Approved'];
        echo json_encode($return);
        
    }
   
}
