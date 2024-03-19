<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\Models\User;
use App\Models\Roles;
use App\Models\Departement;

use App\Models\DataLogs;

use DataTables;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = User::select('users.id as ID','users.*','departements.departement_name as departements','roles.rolename as rolename')->join('departements','departements.id','=','users.departmentid')->join('roles','roles.id','=','users.roleid')->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('desk', function ($row) {
                    return $row->desk ?: '-';
                    
                })
                ->editColumn('status', function ($row) {
                    if($row->active == 0){
                        $status= "In Active" ;
                    }else{
                        $status = "Active";
                    }
                    return $status;
                })
                ->editColumn('note', function ($row) {
                    return $row->note ?: '-';
                    
                })
                ->addColumn('name', function($row){
                    $actionBtn = $row->first_name . " " . $row->last_name;
                    //$actionBtn=$row->ID;
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->addColumn('action', function($row){                   
                    if($row->active == 0){
                        $actionBtn= "-" ;
                    }else{
                        $actionBtn = '<a class="edit btn btn-success btn-sm" data-id="'.$row->ID.'">Edit</a> 
                            <a  class="delete btn btn-danger btn-sm" data-id="'.$row->ID.'">DeActive</a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                
                ->make(true);
        }

        return view('staff.index');
    }

    public function create()
    {
        $departments=Departement::get();
        $roles=Roles::get();
        return view('staff.create',compact('departments','roles'));
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        //dd($request->all());
        $data=$request->all();
        
        
        unset($data['_token']);
        $ids=Departement::create($data);

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Staff',
            'moduleid'=>$ids->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Staff Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('staff');
    }

    public function view($id){
        $staff = User::select('users.id as ID','users.*','departements.departement_name as departements','roles.rolename as rolename')
        ->join('departements','departements.id','=','users.departmentid')
        ->join('roles','roles.id','=','users.roleid')->where('users.id','=',$id)->get();
        
        $createbyid=User::where('id','=',$staff[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$staff[0]->updatebyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Staff')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('staff.view',compact('staff','createbyid','updatebyid','logs'));
    }

    public function edit($id){
        $departement=Departement::where('id','=',$id)->get();
        return view('departements.edit',compact('departement'));
    }
    public function update(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        
        
        unset($data['_token']);
        $accdata=Departement::where('id','=',$request->id)->get();
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($data);
        $logs=[
            'module'=>'Departement',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Departement Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $vendor=Departement::where('id',$request->id)->update($data);
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('departement/view/'.$request->id);
    }
}
