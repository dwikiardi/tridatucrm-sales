<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DataLogs;
use App\Models\Surveys;
use App\Models\Leads;

use DataTables;

class SurveyController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = Surveys::join('leads','leads.id','=','surveys.leadid')->join('users','users.id','=','surveys.surveyorid')
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

        return view('surveys.index');
    }

    public function create($id=null)
    {
        $Users=User::get();
        $Leads=Leads::get();
        return view('surveys.create',compact('Users','id','Leads'));
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        //dd($request->all());
        $data=$request->all();
        if(isset($request->requestdate)){
            $data['requestdate']=date('Y-m-d',strtotime(str_replace('/','-',$request->requestdate)));
        }else{
            unset($data['requestdate']);
        }
        
        if(isset($request->surveydate)){
            $data['surveydate']=date('Y-m-d',strtotime(str_replace('/','-',$request->surveydate)));
        }else{
            unset($data['surveydate']);
        }
        
        unset($data['_token']);
        $ids=Surveys::create($data);

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Surveys',
            'moduleid'=>$ids->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Vendor Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('surveys');
    }

    public function view($id){
        $surveys=Surveys::join('leads','leads.id','=','surveys.leadid')->where('surveys.id','=',$id)->select('surveys.*','leads.leadsname AS leadsname')->get();
        if(isset($surveys[0]->surveyorid)){
            $surveyorids=User::where('id','=',$surveys[0]->surveyorid)->get();
            $surveyorid=$surveyorids[0]->first_name." ".$surveyorids[0]->last_name;
        }else{
            $surveyorid="";
        }
        if(isset($surveys[0]->surveyorto)){
            $surveyortos=User::where('id','=',$surveys[0]->surveyorto)->get();
            $surveyorto=$surveyortos[0]->first_name." ".$surveyortos[0]->last_name;
        }else{
            $surveyorto="";
        }
        $createbyid=User::where('id','=',$surveys[0]->createdbyid)->get();
        $updatebyid=User::where('id','=',$surveys[0]->updatedbyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Surveys')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('surveys.view',compact('surveys','createbyid','updatebyid','logs','surveyorid','surveyorto'));
    }

    public function edit($id){
        $Users=User::get();
        $Leads=Leads::get();
        $surveys=Surveys::where('id','=',$id)->get();
        return view('surveys.edit',compact('Users','surveys','Leads'));
    }
    public function update(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        if(isset($request->requestdate)){
            $data['requestdate']=date('Y-m-d',strtotime(str_replace('/','-',$request->requestdate)));
        }else{
            unset($data['requestdate']);
        }
        
        if(isset($request->surveydate)){
            $data['surveydate']=date('Y-m-d',strtotime(str_replace('/','-',$request->surveydate)));
        }else{
            unset($data['surveydate']);
        }
        
        unset($data['_token']);
        $accdata=Surveys::where('id','=',$request->id)->get();
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($data);
        $logs=[
            'module'=>'Surveys',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Surveys Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $vendor=Surveys::where('id',$request->id)->update($data);
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('surveys/view/'.$request->id);
    }

    
}
