<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

use App\Models\Leads;
use App\Models\Meeting;
use App\Models\MeetingPartisipan;
use App\Models\User;
use App\Models\DataLogs;
use DataTables;

class MeetingController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Meeting::join('users', 'meetings.host', '=', 'users.id')
            ->join('leads', 'meetings.leadid', '=', 'leads.id')
            ->select('meetings.id as ID','meetings.meetingname as Name' , 'meetings.startdate AS Date','meetings.host As Host','leads.leadsname as To')
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
                
                
                ->make(true);
        }

        return view('meetings.index');
    }


    public function create($id=null)
    {
        $Users=User::get();
        if(isset($id)){
            $id=$id;
        }else{
            $id="";
        }
        $Leads=Leads::get();
        return view('meetings.create',compact('Users','id','Leads'));
    }
    public function store(Request $request){
       // dd($request);
        /// insert setiap request dari form ke dalam database via model
       
        $data=[
            'meetingname'=>$request->meetingname,
            'location'=>$request->location,
            'allday'=>false,
            'startdate'=>date('Y-m-d',strtotime(str_replace('/','-',$request->startdate))),
            'starttime'=>$request->starttime,
            'enddate'=>date('Y-m-d',strtotime(str_replace('/','-',$request->enddate))),
            'endtime'=>$request->endtime,
            'host'=>$request->host,
            'leadid'=>$request->leadid,
            'reminder'=>true,
            'detail'=>$request->detail,
            'result'=>$request->result,
            'reminder'=>$request->reminder,
            'remindertime'=>$request->remindertime,
            'createdbyid'=>$request->createdbyid,
            'updatedbyid'=>$request->updatedbyid
        ];
        //var_dump($data);
        $meetings=Meeting::create($data);
        //dd($meetings->id);
        for($i=0; $i<$request->list; $i++){
            $part=[
                'meetingid'=>$meetings->id, 
                'name'=>$request->name[$i], 
                'email'=>$request->email[$i],
                'createdbyid'=>$request->createdbyid, 
                'updatedbyid'=>$request->updatedbyid
            ];
            $meetingpart=MeetingPartisipan::create($part);
            
        }
        
        $newdata=json_encode($data);
        $logs=[
            'module'=>'Meetings',
            'moduleid'=>$meetings->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Meetings Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('meetings');
    }

    public function view($id){
        $meetings=Meeting::where('id','=',$id)->get();
        $Leads=Leads::where('id','=',$meetings[0]->leadid)->get();
        $host=User::where('id','=',$meetings[0]->host)->get();
        $createbyid=User::where('id','=',$meetings[0]->createdbyid)->get();
        $updatebyid=User::where('id','=',$meetings[0]->updatedbyid)->get();
        $meetingpart=MeetingPartisipan::where('meetingid','=',$meetings[0]->id)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','meetings')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        return view('meetings.view',compact('meetings','createbyid','updatebyid','logs','Leads','meetingpart','host'));
        
    }

    public function edit($id){
        $meetings=Meeting::where('id','=',$id)->get();
        $Users =User::get();
        $Leads=Leads::get();
        $createbyid=User::where('id','=',$meetings[0]->createdbyid)->get();
        $updatebyid=User::where('id','=',$meetings[0]->updatedbyid)->get();
        $meetingpart=MeetingPartisipan::where('meetingid','=',$meetings[0]->id)->get();
        return view('meetings.edit',compact('meetings','Users','createbyid','updatebyid','Leads','meetingpart'));
    }
    
    public function update(Request $request){
        //dd($request);
        $old1=Meeting::where('id','=',$request->id)->get();
        $old2=MeetingPartisipan::where('meetingid','=',$request->id)->get();
        $olddata=[
            'meetings'=>$old1,
            'MeetingPartisipan'=>$old2
        ];
        $data=[
            'meetingname'=>$request->meetingname,
            'location'=>$request->location,
            'allday'=>false,
            'startdate'=>date('Y-m-d',strtotime(str_replace('/','-',$request->startdate))),
            'starttime'=>$request->starttime,
            'enddate'=>date('Y-m-d',strtotime(str_replace('/','-',$request->enddate))),
            'endtime'=>$request->endtime,
            'host'=>$request->host,
            'leadid'=>$request->leadid,
            'reminder'=>true,
            'detail'=>$request->detail,
            'result'=>$request->result,
            'reminder'=>$request->reminder,
            'remindertime'=>$request->remindertime,
            'createdbyid'=>$request->updatedbyid,
            'updatedbyid'=>$request->updatedbyid
        ];
        //var_dump($data);
        $meetings=Meeting::where('id','=',$request->id)->update($data);
        $meetingpart=MeetingPartisipan::where('meetingid','=',$request->id)->delete();
        //dd($meetings->id);
        $parts=[];
        for($i=0; $i<$request->list; $i++){
            $part=[
                'meetingid'=>$request->id, 
                'name'=>$request->name[$i], 
                'email'=>$request->email[$i],
                'createdbyid'=>$request->createdbyid, 
                'updatedbyid'=>$request->updatedbyid
            ];
            $meetingpart=MeetingPartisipan::create($part);
            $parts[$i]=$part;
        }
        
        $datas=[
            'meeting'=>$data,
            'MeetingPartisipan'=>$parts
        ];
        $newdata=json_encode($datas);
        $logs=[
            'module'=>'meetings',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'meetings Update',
            'olddata'=>json_encode($olddata),
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('meetings/view/'.$request->id);
    }

   
}
