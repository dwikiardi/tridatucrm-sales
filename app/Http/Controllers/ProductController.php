<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AccountLogs;
use App\Models\Vendors;
use App\Models\Products;
use App\Models\ProductsSN;

use Yajra\DataTables\Facades\Datatables;

class ProductController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = Products::where('producttype','=',1)->select('products.id as ID','products.productname as Name' , 'products.description AS Description','products.note AS Note',
            \DB::raw('(CASE 
            WHEN products.havesn = "0" THEN "No" 
            WHEN products.havesn = "1" THEN "Yes"
            END) AS Serial'))
            ->get();
            //dd($data);
            return datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function($row){
                //     $actionBtn = '<a class="edit btn btn-success btn-sm" data-id="'.$row->ID.'">Edit</a> <a  class="delete btn btn-danger btn-sm" data-id="'.$row->ID.'">DeActive</a>';
                //     //$actionBtn=$row->ID;
                //     return $actionBtn;
                // })
                // ->rawColumns(['action'])
                ->editColumn('Description', function ($row) {
                    return $row->Description ?: '-';
                })
                ->editColumn('Note', function ($row) {
                    return $row->Note ?: '-';
                })
                ->make(true);
        }

        return view('products.index');
    }

    public function create()
    {
        $Users=User::get();
        return view('products.create',compact('Users'));
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        //dd($request->all());
        $ids=Products::create($request->all());

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Products',
            'moduleid'=>$ids->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Product Created',
            'prevdata'=>'',
            'newdata'=>$newdata
        ];
        $ids=AccountLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('products');
    }

    public function view($id){
        $products=Products::where('id','=',$id)->get();
        //$owner=User::where('id','=',$vendors[0]->ownerid)->get();
        $createbyid=User::where('id','=',$products[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$products[0]->updatebyid)->get();
        $logs=AccountLogs::where('moduleid','=',$id)->where('module','=','Products')->orderBy('created_at', 'DESC')->join('users', 'accountlogs.userid', '=', 'users.id')
        ->select('accountlogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('products.view',compact('products','createbyid','updatebyid','logs'));
    }

    public function edit($id){
        $Users=User::get();
        $products=Products::where('id','=',$id)->get();
        return view('products.edit',compact('Users','products'));
    }
    public function update(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        unset($data['_token']);
        $accdata=Products::where('id','=',$request->id)->get();
        $prevdata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Products',
            'moduleid'=>$request->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Products Updated',
            'prevdata'=>$prevdata,
            'newdata'=>$newdata
        ];
        $vendor=Products::where('id',$request->id)->update($data);
        $ids=AccountLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('products/view/'.$request->id);
    }

    //Index ListView
    public function sindex(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = Products::where('producttype','=',0)->select('products.id as ID','products.productname as Name' , 'products.description AS Description','products.note AS Note')->get();
            //dd($data);
            return datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function($row){
                //     $actionBtn = '<a class="edit btn btn-success btn-sm" data-id="'.$row->ID.'">Edit</a> <a  class="delete btn btn-danger btn-sm" data-id="'.$row->ID.'">DeActive</a>';
                //     //$actionBtn=$row->ID;
                //     return $actionBtn;
                // })
                // ->rawColumns(['action'])
                ->editColumn('Description', function ($row) {
                    return $row->Description ?: '-';
                })
                ->editColumn('Note', function ($row) {
                    return $row->Note ?: '-';
                })
                ->make(true);
        }

        return view('services.index');
    }

    public function screate()
    {
        $Users=User::get();
        return view('services.create',compact('Users'));
    }
    public function sstore(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        //dd($request->all());
        $ids=Products::create($request->all());

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Products',
            'moduleid'=>$ids->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Product Created',
            'prevdata'=>'',
            'newdata'=>$newdata
        ];
        $ids=AccountLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('services');
    }

    public function sview($id){
        $products=Products::where('id','=',$id)->get();
        //$owner=User::where('id','=',$vendors[0]->ownerid)->get();
        $createbyid=User::where('id','=',$products[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$products[0]->updatebyid)->get();
        $logs=AccountLogs::where('moduleid','=',$id)->where('module','=','Products')->orderBy('created_at', 'DESC')->join('users', 'accountlogs.userid', '=', 'users.id')
        ->select('accountlogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('services.view',compact('products','createbyid','updatebyid','logs'));
    }

    public function sedit($id){
        $Users=User::get();
        $products=Products::where('id','=',$id)->get();
        return view('services.edit',compact('Users','products'));
    }
    public function supdate(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        unset($data['_token']);
        $accdata=Products::where('id','=',$request->id)->get();
        $prevdata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Products',
            'moduleid'=>$request->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Products Updated',
            'prevdata'=>$prevdata,
            'newdata'=>$newdata
        ];
        $vendor=Products::where('id',$request->id)->update($data);
        $ids=AccountLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('services/view/'.$request->id);
    }
}
