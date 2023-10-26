<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DataLogs;
use App\Models\pops;
use App\Models\Leads;

use DataTables;

class PoPsController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = pops::select('pops.id as ID' , 'pops.name as Name' , 'pops.description AS Desk')
            ->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pops.index');
    }

    public function create($id=null)
    {
        return view('pops.create');
    }
    public function store(Request $request){
        $data=$request->all();
        
        
        unset($data['_token']);
        $ids=pops::create($data);

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'pops',
            'moduleid'=>$ids->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'New POP Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('pops');
    }

    public function view($id){
        $pops=pops::where('id','=',$id)->get();
        
        $createdbyid=User::where('id','=',$pops[0]->createdbyid)->get();
        $updatedbyid=User::where('id','=',$pops[0]->updatedbyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','pops')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('pops.view',compact('pops','createdbyid','updatedbyid','logs'));
    }

    public function edit($id){
        $pops=pops::where('id','=',$id)->get();
        return view('pops.edit',compact('pops'));
    }
    public function update(Request $request){
        $data=$request->all();
        
        
        unset($data['_token']);
        $accdata=pops::where('id','=',$request->id)->get();
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($data);
        $logs=[
            'module'=>'Stock_Categories',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Stock Categories Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $pops=pops::where('id',$request->id)->update($data);
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('pops/view/'.$request->id);
    }

}
