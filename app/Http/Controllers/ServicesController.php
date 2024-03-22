<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DataLogs;
use App\Models\Services;

use DataTables;

class ServicesController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = Services::select('services.id as ID','services.services_name','services.desk as desk','services.price as price','services.note as note')->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function($row){
                //     $actionBtn = '<a class="edit btn btn-success btn-sm" data-id="'.$row->ID.'">Edit</a> <a  class="delete btn btn-danger btn-sm" data-id="'.$row->ID.'">DeActive</a>';
                //     //$actionBtn=$row->ID;
                //     return $actionBtn;
                // })
                // ->rawColumns(['action'])
                ->editColumn('desk', function ($row) {
                    return $row->desk ?: '-';
                    
                })
                ->editColumn('note', function ($row) {
                    return $row->note ?: '-';
                    
                })
                ->make(true);
        }

        return view('services.index');
    }

    public function create($id=null)
    {
        $Users=User::get();
        return view('services.create',compact('Users','id'));
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        //dd($request->all());
        $data=$request->all();
        
        
        unset($data['_token']);
        $ids=Services::create($data);

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Services',
            'moduleid'=>$ids->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Vendor Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('services');
    }

    public function view($id){
        $services=Services::where('id','=',$id)->get();
        
        $createbyid=User::where('id','=',$services[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$services[0]->updatebyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','services')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('services.view',compact('services','createbyid','updatebyid','logs'));
    }

    public function edit($id){
        $Users=User::get();
        $services=Services::where('id','=',$id)->get();
        return view('services.edit',compact('Users','services'));
    }
    public function update(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        
        
        unset($data['_token']);
        $accdata=Services::where('id','=',$request->id)->get();
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($data);
        $logs=[
            'module'=>'Services',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'services Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $vendor=Services::where('id',$request->id)->update($data);
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('services/view/'.$request->id);
    }

    
}
