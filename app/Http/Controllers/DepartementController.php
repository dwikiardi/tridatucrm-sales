<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DataLogs;

use DataTables;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = Departement::select('departements.id as ID','departements.departement_name as name','departements.desk as desk')->get();
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

        return view('departements.index');
    }

    public function create()
    {
        return view('departements.create');
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
            'module'=>'Departement',
            'moduleid'=>$ids->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Departement Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('departement');
    }

    public function view($id){
        $departement=Departement::where('id','=',$id)->get();
        
        $createbyid=User::where('id','=',$departement[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$departement[0]->updatebyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Departement')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('departements.view',compact('departement','createbyid','updatebyid','logs'));
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
