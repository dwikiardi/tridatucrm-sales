<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Accounts;
use App\Models\User;
use App\Models\AccountLogs;
use App\Models\Contacts;

use Yajra\DataTables\Facades\Datatables;

class ContactsController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            
            $data = Contacts::join('users', 'contacts.ownerid', '=', 'users.id')
            ->join('accounts','accounts.id','=','contacts.accountid')
            ->select('contacts.id as ID','contacts.contactname as Name' , 'contacts.email AS Email','contacts.mobile As Mobile','contacts.phone as Phone','accounts.fullname AS Accounts','contacts.accountid AS AID','users.last_name AS Owners')
            ->get();
            //echo json_encode($data);
            return datatables::of($data)
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
                ->editColumn('Mobile', function ($row) {
                    return $row->Mobile ?: '-';
                })
                ->editColumn('Phone', function ($row) {
                    return $row->Phone ?: '-';
                })
                ->make(true);
        }

        return view('contacts.index');
    }

    public function create($aid = null)
    {
        $Users=User::get();
        $Accounts=Accounts::get();
        if(!empty($aid)){
            $aid=$aid;
        } else {
            $aid="";
            
        } 
        return view('contacts.create',compact('Users','Accounts','aid'));
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $ids=Contacts::create($request->all());

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Contacts',
            'moduleid'=>$ids->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Contacts Created',
            'prevdata'=>'',
            'newdata'=>$newdata
        ];
        $ids=AccountLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
        if($request->aid !='' ){
            return redirect('accounts/view/'.$request->aid);
        }else{
            return redirect('contacts');
        }
        
    }

    public function view($id){
        $contacts=Contacts::where('id','=',$id)->get();
        $owner=User::where('id','=',$contacts[0]->ownerid)->get();
        $accounts=Accounts::where('id','=',$contacts[0]->accountid)->get();
        $createbyid=User::where('id','=',$contacts[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$contacts[0]->updatebyid)->get();
        $logs=AccountLogs::where('moduleid','=',$id)->where('module','=','Contacts')->orderBy('created_at', 'DESC')->join('users', 'accountlogs.userid', '=', 'users.id')
        ->select('accountlogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('contacts.view',compact('contacts','owner','createbyid','updatebyid','logs','accounts'));
    }

    public function edit($id){
        $Users=User::get();
        $accounts=Accounts::get();
        $contacts=Contacts::where('contacts.id','=',$id)
        ->get();
        //var_dump($contacts);
        return view('contacts.edit',compact('Users','accounts','contacts'));
    }
    public function update(Request $request){
        //echo json_encode($request->all());
        $data=$request->all();
        unset($data['_token']);
        //echo json_encode($data);
        $accdata=Contacts::where('id','=',$request->id)->get();
        $update=Contacts::where('id',$request->id)->update($data);
        //echo json_encode($update);
        $prevdata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Contacts',
            'moduleid'=>$request->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Contacts Updated',
            'prevdata'=>$prevdata,
            'newdata'=>$newdata
        ];
        $ids=AccountLogs::create($logs);
        /// redirect jika sukses menyimpan data
        return redirect('contacts/view/'.$request->id);
    }
}
