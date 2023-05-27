<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Leads;
use App\Models\User;
use App\Models\AccountLogs;
use DataTables;

class LeadController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Leads::join('users', 'leads.ownerid', '=', 'users.id')
            ->select('leads.id as ID','leads.leadsname as Name' , 'leads.email AS Email','leads.phone As Phone','leads.website as Website','leads.website as Company',
            \DB::raw('(CASE 
            WHEN leads.leadstatus = "1" THEN "Akan Dihibungi" 
            WHEN leads.leadstatus = "2" THEN "Segera Dihubungi" 
            WHEN leads.leadstatus = "3" THEN "Sudah Dihibungi" 
            WHEN leads.leadstatus = "4" THEN "Menunggu Keputusan" 
            WHEN leads.leadstatus = "5" THEN "Tidak dapat dihubungi" 
            ELSE "None" 
            END) AS Status'),'users.last_name AS Owners')
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
                ->make(true);
        }

        return view('leads.index');
    }


    public function create()
    {
        $Users=User::get();
        return view('leads.create',compact('Users'));
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $ids=Leads::create($request->all());

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Leads',
            'moduleid'=>$ids->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Account Created',
            'prevdata'=>'',
            'newdata'=>$newdata
        ];
        $ids=AccountLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('leads');
    }

    public function view($id){
        $leads=Leads::where('id','=',$id)->get();
        $owner=User::where('id','=',$leads[0]->ownerid)->get();
        $createbyid=User::where('id','=',$leads[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$leads[0]->updatebyid)->get();
        $logs=AccountLogs::where('moduleid','=',$id)->where('module','=','Leads')->orderBy('created_at', 'DESC')->join('users', 'accountlogs.userid', '=', 'users.id')
        ->select('accountlogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('leads.view',compact('leads','owner','createbyid','updatebyid','logs'));
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
        $leads=Leads::where('id',$request->id)->update($data);
        $prevdata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Leads',
            'moduleid'=>$request->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Account Updated',
            'prevdata'=>$prevdata,
            'newdata'=>$newdata
        ];
        $ids=AccountLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('leads/view/'.$request->id);
    }

    
}
