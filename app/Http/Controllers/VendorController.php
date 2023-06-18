<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DataLogs;
use App\Models\Vendors;

use DataTables;
//use Yajra\DataTables\Facades\Datatables;

class VendorController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = Vendors::select('vendors.id as ID','vendors.vendor_name as Name' , 'vendors.contact AS Contact','vendors.address As Address','vendors.mobile As Mobile','vendors.email As Email',
            \DB::raw('(CASE 
            WHEN vendors.type = "1" THEN "Vendor Jasa" 
            WHEN vendors.type = "2" THEN "Vendor Barang" 
            ELSE "Vendor Lain" 
            END) AS Type'))
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
                ->editColumn('Contact', function ($row) {
                    return $row->Contact ?: '-';
                })
                ->editColumn('Address', function ($row) {
                    return $row->Address ?: '-';
                })
                ->editColumn('Mobile', function ($row) {
                    return $row->Email ?: '-';
                })
                ->editColumn('Email', function ($row) {
                    return $row->Email ?: '-';
                })
                ->make(true);
        }

        return view('vendors.index');
    }

    public function create()
    {
        
        return view('vendors.create');
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        //dd($request->all());
        $ids=Vendors::create($request->all());

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Vendors',
            'moduleid'=>$ids->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Vendor Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('vendors');
    }

    public function view($id){
        $vendors=Vendors::where('id','=',$id)->get();
        $createbyid=User::where('id','=',$vendors[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$vendors[0]->updatebyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Vendors')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('vendors.view',compact('vendors','createbyid','updatebyid','logs'));
    }

    public function edit($id){
        $Users=User::get();
        $vendors=Vendors::where('id','=',$id)->get();
        return view('vendors.edit',compact('Users','vendors'));
    }
    public function update(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        unset($data['_token']);
        $accdata=Vendors::where('id','=',$request->id)->get();
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Vendors',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Vendors Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $vendor=Vendors::where('id',$request->id)->update($data);
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('vendors/view/'.$request->id);
    }

    
}
