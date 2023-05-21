<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Accounts;
use App\Models\User;
use App\Models\Contacts;
use App\Models\AccountLogs;
use DataTables;
//use Yajra\DataTables\Facades\Datatables;

class AccountsController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = Accounts::join('users', 'accounts.ownerid', '=', 'users.id')
            ->select('accounts.id as ID','accounts.fullname as Name' , 'accounts.email AS Email','accounts.phone As Phone','accounts.website as Website',
            \DB::raw('(CASE 
            WHEN accounts.accounttype = "1" THEN "Potential Customer" 
            WHEN accounts.accounttype = "2" THEN "Active Customer" 
            ELSE "In-Active Customer" 
            END) AS AccountType'),'users.last_name AS Owners')
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

        return view('accounts.index');
    }


    public function create()
    {
        $Users=User::get();
        return view('accounts.create',compact('Users'));
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $ids=Accounts::create($request->all());

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Accounts',
            'moduleid'=>$ids->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Account Created',
            'prevdata'=>'',
            'newdata'=>$newdata
        ];
        $ids=AccountLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('accounts');
    }

    public function view($id){
        $accounts=Accounts::where('id','=',$id)->get();
        $owner=User::where('id','=',$accounts[0]->ownerid)->get();
        $createbyid=User::where('id','=',$accounts[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$accounts[0]->updatebyid)->get();
        $logs=AccountLogs::where('moduleid','=',$id)->where('module','=','Accounts')->orderBy('created_at', 'DESC')->join('users', 'accountlogs.userid', '=', 'users.id')
        ->select('accountlogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('accounts.view',compact('accounts','owner','createbyid','updatebyid','logs'));
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
            'userid'=>Auth::user()->id,
            'subject'=>'Account Updated',
            'prevdata'=>$prevdata,
            'newdata'=>$newdata
        ];
        $ids=AccountLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('accounts/view/'.$request->id);
    }

    //Data Tables Contact(Contact List)
    public function contact(Request $request,$id){
        if ($request->ajax()) {
            
            $data = Contacts::join('users', 'contacts.ownerid', '=', 'users.id')
            ->join('accounts','accounts.id','=','contacts.accountid')
            ->where('contacts.accountid','=',$id)
            ->select('contacts.id as ID','contacts.contactname as Name' , 'contacts.email AS Email','contacts.mobile As Mobile','contacts.phone as Phone','users.last_name AS Owners')
            ->get();
            //echo json_encode($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('Email', function ($row) {
                    return $row->Email ?: '-';
                })
                ->editColumn('Mobile', function ($row) {
                    return $row->Mobile ?: '-';
                })
                ->editColumn('Phone', function ($row) {
                    return $row->Phone ?: '-';
                })
                ->make(true);
        }
        //return view('accounts.view');
        $accounts=Accounts::where('id','=',$id)->get();
        $owner=User::where('id','=',$accounts[0]->ownerid)->get();
        $createbyid=User::where('id','=',$accounts[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$accounts[0]->updatebyid)->get();
        $logs=AccountLogs::where('moduleid','=',$id)->where('module','=','Accounts')->orderBy('created_at', 'DESC')->join('users', 'accountlogs.userid', '=', 'users.id')
        ->select('accountlogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        return view('accounts.view',compact('accounts','owner','createbyid','updatebyid','logs'));
        
    }
}
