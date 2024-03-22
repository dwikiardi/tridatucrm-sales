<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Models\Leads;
use App\Models\Accounts;
use App\Models\User;
use App\Models\DataLogs;
use DataTables;

class AccountsController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //DB::enableQueryLog();
            //$data = Accounts::select('*');
            // $data = Accounts::join('users', 'accounts.ownerid', '=', 'users.id')->join('leads','leads.accountid','=','accounts.id')->join('pops','pops.id','=','leads.popid')
            // ->select('accounts.id as ID','accounts.account_name as Name' , 'accounts.email AS Email','accounts.phone As Phone','accounts.website as Website','users.last_name AS Owners')
            $data = Accounts::leftJoin('leads', 'leads.accountid', '=', 'accounts.id')
            ->leftJoin('pops', 'pops.id', '=', 'leads.popid')
            ->leftJoin('services', 'services.id', '=', 'leads.packageid')
            ->join('users', 'accounts.ownerid', '=', 'users.id')
            ->select(
                'accounts.id AS accid',
                'accounts.account_name AS accname',
                'leads.id AS prid',
                'leads.property_name AS property',
                'services.id AS svid',
                'services.services_name AS package',
                'services.price AS price',
                'pops.name AS pop_name',
                'pops.id AS popid',
                'users.id AS uid',
                'users.first_name AS fuid',
                'users.last_name AS luid'
            )
            //->toSql();
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
                ->editColumn('property', function ($row) {
                    return $row->property ?: '-';
                })
                ->editColumn('package', function ($row) {
                    return $row->package ?: '-';
                })
                ->editColumn('price', function ($row) {
                    return $row->price ?: '0';
                })
                ->editColumn('pop_name', function ($row) {
                    return $row->pop_name ?: '-';
                })
                ->addColumn('owner', function($row){
                    $actionBtn = $row->fuid ." ". $row->luid;
                    //$actionBtn=$row->ID;
                    return $actionBtn;
                })
                ->rawColumns(['owner'])
                ->make(true);
        }

        return view('accounts.index');
    }

    public function view($id){
        $accounts=Accounts::where('id','=',$id)->get();
        $owner=User::where('id','=',$accounts[0]->ownerid)->get();
        $createbyid=User::where('id','=',$accounts[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$accounts[0]->updatebyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Accounts')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('accounts.view',compact('accounts','owner','createbyid','updatebyid','logs'));
    }
    public function create(){
        $Users=User::get();
        return view('accounts.create',compact('Users'));
    }
    public function edit($id){
        $Users=User::get();
        $accounts=Accounts::where('id','=',$id)->get();
        return view('accounts.edit',compact('Users','accounts'));
    }
    public function update(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        unset($data['_token']);
        $accdata=Accounts::where('id','=',$request->id)->get();
        $accounts=Accounts::where('id',$request->id)->update($data);
        $prevdata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Accounts',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Accounts Updated ',
            'olddata'=>($prevdata),
            'newdata'=>($newdata)
        ];
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('accounts/view/'.$request->id);
    }
    public function store(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        unset($data['_token']);
        //$accdata=Accounts::where('id','=',$request->id)->get();
        $accounts=Accounts::create($data);
        $prevdata = "";
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Accounts',
            'moduleid'=>$accounts->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Accounts Created ',
            'olddata'=>($prevdata),
            'newdata'=>($newdata)
        ];
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('accounts/view/'.$accounts->id);
    }

    //Data Tables Contact(Contact List)
    public function contact(Request $request,$id){
        if ($request->ajax()) {
            
            $data = Leads::join('users', 'leads.ownerid', '=', 'users.id')
            ->join('accounts','accounts.id','=','leads.accountid')
            ->where('leads.accountid','=',$id)
            ->select('leads.id as ID','leads.property_name as Name' , 'leads.property_address as Address' , 'leads.pic_contact As Contact', 'leads.note As Note','leads.pic_mobile As Mobile','leads.phone as Phone','users.last_name AS Owners')
            ->get();
            //echo json_encode($data);
            return DataTables::of($data)
                ->addIndexColumn()
                
                ->editColumn('Mobile', function ($row) {
                    return $row->Mobile ?: '-';
                })
                ->editColumn('Phone', function ($row) {
                    return $row->Phone ?: '-';
                })
                ->make(true);
        }
        //return view('accounts.view');
        // $accounts=Accounts::where('id','=',$id)->get();
        // $owner=User::where('id','=',$accounts[0]->ownerid)->get();
        // $createbyid=User::where('id','=',$accounts[0]->createbyid)->get();
        // $updatebyid=User::where('id','=',$accounts[0]->updatebyid)->get();
        // $logs=AccountLogs::where('moduleid','=',$id)->where('module','=','Accounts')->orderBy('created_at', 'DESC')->join('users', 'accountlogs.userid', '=', 'users.id')
        // ->select('accountlogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        // return view('accounts.view',compact('accounts','owner','createbyid','updatebyid','logs'));
        
    }
    
}
