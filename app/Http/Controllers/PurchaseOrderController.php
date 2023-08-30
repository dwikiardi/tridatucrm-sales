<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\User;
use App\Models\Vendors;
use App\Models\Stocks;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\OrderSerialDetail;
use DataTables;

class PurchaseOrderController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Orders::join('vendors','orders.vendorid','=','vendors.id')
            ->select('orders.id as ID','orders.ordernumbers as NoOrder' ,'orders.supno as InvNumber' , 'orders.ordername AS Name','orders.orderdate As Date','orders.note as Note','vendors.vendor_name as Vendor')
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
                // ->editColumn('Email', function ($row) {
                //     return $row->Email ?: '-';
                // })
               
                ->make(true);
        }

        return view('orders.index');
    }

    public function create()
    {
        $Users=User::get();
        $Vendor=Vendors::where('type','=',2)->get();
        $Stocks=Stocks::get();
        return view('orders.create',compact('Users','Vendor','Stocks'));
    }
    public function store(Request $request){
        dd($request);
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $ids=Leads::create($request->all());

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Leads',
            'moduleid'=>$ids->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Lead Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('leads');
    }

    public function view($id){
        $leads=Leads::where('id','=',$id)->get();
        if($leads[0]->type=="lead"){
            $owner=User::where('id','=',$leads[0]->ownerid)->get();
            $createbyid=User::where('id','=',$leads[0]->createbyid)->get();
            $updatebyid=User::where('id','=',$leads[0]->updatebyid)->get();
            $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Leads')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
            ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
            return view('leads.view',compact('leads','owner','createbyid','updatebyid','logs'));
        }else{
            // $accounts = Accounts::where('leadid','=',$leads[0]->id)->get();
            // return view('leads.convert',compact('accounts'));
            return view('leads.convert',compact('leads'));
        
        }
        
        
    }

    public function edit($id){
        $Users=User::get();
        $leads=Leads::where('id','=',$id)->get();
        return view('leads.edit',compact('Users','leads'));
    }
    
    public function update(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        unset($data['_token']);
        $accdata=Leads::where('id','=',$request->id)->get();
        //dd($accdata);
        $leads=Leads::where('id',$request->id)->update($data);
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Leads',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Leads Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('leads/view/'.$request->id);
    }

    public function getquote(Request $request,$id){
        if ($request->ajax()) {
            $data = Quotes::join('users', 'quotes.ownerid', '=', 'users.id')
            ->join('leads', 'quotes.leadid', '=', 'leads.id')
            ->select('quotes.id as ID','quotes.quotenumber as QuoteNo' , 'quotes.quotedate AS Date','quotes.approve As Approve','quotes.toperson as To','quotes.status AS Status','users.last_name AS Owners')
            ->where('leadid','=',$id)
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
                ->editColumn('Approve', function ($row) {
                    //return $row->Phone ?: '-';
                    if($row->Approve==1){
                        return "Approved";
                    }else{
                        return "Waiting to Aprroval";
                    }
                })
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
                        case '4':
                            return "Request Revision";
                            break;
                        
                            
                        default:
                        //1: Waiting For Apporove; 2: Approved; 3:Rejected; 4: Need Revision
                            break;
                    }
                })
                
                ->make(true);
        }

        return view('quotes.index');
    }

    public function autocomplete(Request $request)
    {
        //$data = Accounts::select('account_name as name')
        $data = Accounts::select('account_name as name')
                ->where('account_name','LIKE',"%{$_GET['term']}%")
                ->get();
        return response()->json($data);
        //echo ($_GET['term']);
    }
    public function complateit(Request $request)
    {
        $data = Accounts::where("account_name","LIKE","%".$request->query."%")
                ->get();
        return response()->json($data);
    }

    public function getsurvey(Request $request,$id){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = Surveys::join('leads','leads.id','=','surveys.leadid')->join('users','users.id','=','surveys.surveyorid')->where('surveys.leadid','=',$id)
            ->select('surveys.id as ID','surveys.surveydate as SurveyDate' ,'surveys.requestdate as ReqDate' , 'leads.leadsname AS Property', 'users.first_name AS Petugas','surveys.status As Status','surveys.note As Note')
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
                ->editColumn('SurveyDate', function ($row) {
                    if(isset($row->SurveyDate)){
                        $date=date('d/m/Y',strtotime($row->SurveyDate));
                        return $date;    
                    }else{
                        return '-';
                    }
                    
                })
                ->editColumn('ReqDate', function ($row) {
                    if(isset($row->ReqDate)){
                        $date=date('d/m/Y',strtotime($row->ReqDate));
                        return $date;    
                    }else{
                        return '-';
                    }
                })
                
                ->make(true);
        }
    }

    public function convert($id){
        
        $accdata=Leads::where('id','=',$id)->get();
        $olddata = json_encode($accdata[0]);
        $data=[ 'type'=>"contact" ];
        $leads=Leads::where('id','=',$id)->update($data);

        $newdata = json_encode($accdata=Leads::where('id','=',$id)->get());
        if($accdata[0]->accountid==null){
            $accs=[
                'ownerid'=>$accdata[0]->ownerid,
                'account_name'=>$accdata[0]->account_name,
                'address'=>$accdata[0]->address,
                'city'=>$accdata[0]->city,
                'state'=>$accdata[0]->state,
                'zipcode'=>$accdata[0]->zipcode,
                'country'=>$accdata[0]->country,
                // 'billing_address'=>$accdata[0]->billing_address,
                // 'billing_city'=>$accdata[0]->billing_city,
                // 'billing_state'=>$accdata[0]->billing_state,
                // 'billing_zipcode'=>$accdata[0]->billing_zipcode,
                // 'billing_country'=>$accdata[0]->billing_country,
                'website'=>$accdata[0]->website,
                'email'=>$accdata[0]->email,
                'phone'=>$accdata[0]->phone,
                'createbyid'=>$accdata[0]->createbyid,
                'updatebyid'=>$accdata[0]->updatebyid,
            ];
            
            $ids=Accounts::create($accs);
            //dd($ids);
            $accslog=[
                'module'=>'Accounts',
                'moduleid'=>$ids->id,
                'createbyid'=>Auth::user()->id,
                'logname'=>'Accounts Created ',
                'olddata'=>($olddata),
                'newdata'=>($newdata)
            ];
            $data=[ 'accountid'=> $ids->id ];
            $leads=Leads::where('id','=',$id)->update($data);
            $ids=DataLogs::create($accslog);
        }
        $logs=[
            'module'=>'Leads',
            'moduleid'=>$id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Convert to Contact ',
            'olddata'=>($olddata),
            'newdata'=>($newdata)
        ];
        $ids=DataLogs::create($logs);
        
        $return=['status'=>'success','message'=>'Lead Success Converted'];
        echo json_encode($return);
        
    }
    
    public function cindex(Request $request){
        if ($request->ajax()) {
            $data = Leads::join('users', 'leads.ownerid', '=', 'users.id')
            ->select('leads.id as ID','leads.leadsname as Name' , 'leads.email AS Email','leads.phone As Phone','leads.website as Website','leads.account_name as Company','leads.status AS Status','users.last_name AS Owners')
            ->where('type','=','contact')
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
                ->editColumn('Email', function ($row) {
                    return $row->Email ?: '-';
                })
                ->editColumn('Phone', function ($row) {
                    return $row->Phone ?: '-';
                })
                ->editColumn('Website', function ($row) {
                    return $row->Website ?: '-';
                })
                ->editColumn('Company', function ($row) {
                    return $row->Company ?: '-';
                })
                ->make(true);
        }

        return view('contacts.index');
    }

    public function cview($id){
        $leads=Leads::where('id','=',$id)->get();
        $owner=User::where('id','=',$leads[0]->ownerid)->get();
        $createbyid=User::where('id','=',$leads[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$leads[0]->updatebyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Leads')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        return view('contacts.view',compact('leads','owner','createbyid','updatebyid','logs'));
        
    }

    public function cedit($id){
        $Users=User::get();
        $leads=Leads::where('id','=',$id)->get();
        return view('contacts.edit',compact('Users','leads'));
    }
    
    public function cupdate(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        unset($data['_token']);
        $accdata=Leads::where('id','=',$request->id)->get();
        //dd($accdata);
        $leads=Leads::where('id',$request->id)->update($data);
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Leads',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Contacts Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('contacts/view/'.$request->id);
    }
}