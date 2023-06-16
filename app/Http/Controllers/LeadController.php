<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Leads;
use App\Models\Accounts;
use App\Models\User;
use App\Models\DataLogs;
use DataTables;

class LeadController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Leads::join('users', 'leads.ownerid', '=', 'users.id')
            ->select('leads.id as ID','leads.leadsname as Name' , 'leads.email AS Email','leads.phone As Phone','leads.website as Website','leads.account_name as Company','leads.status AS Status','users.last_name AS Owners')
            ->where('type','=','lead')
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
                ->editColumn('Company', function ($row) {
                    return $row->Company ?: '-';
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
            'createbyid'=>Auth::user()->id,
            'logname'=>'Lead Created',
            'prevdata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('leads');
    }

    public function view($id){
        $leads=Leads::where('id','=',$id)->get();
        $owner=User::where('id','=',$leads[0]->ownerid)->get();
        $createbyid=User::where('id','=',$leads[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$leads[0]->updatebyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Leads')->orderBy('created_at', 'DESC')->join('users', 'DataLogs.createbyid', '=', 'users.id')
        ->select('DataLogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        if($leads[0]->convert == 0 ){
            return view('leads.view',compact('leads','owner','createbyid','updatebyid','logs'));
        }else{
            $accounts = Accounts::where('leadid','=',$leads[0]->id)->get();
            return view('leads.convert',compact('accounts'));
        }
        
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
        //dd($accdata);
        $leads=Leads::where('id',$request->id)->update($data);
        $prevdata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Leads',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Leads Updated',
            'prevdata'=>$prevdata,
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('leads/view/'.$request->id);
    }

    public function convert($id){
        
        $lead=Leads::where('id','=',$id)->get();
        $owners=Auth::user()->id;
        $cAccounts=[
            'fullname'=>$lead[0]->leadsname,
            'ownerid'=>$lead[0]->ownerid,
            'address'=>$lead[0]->address,
            'city'=>$lead[0]->city,
            'province'=>$lead[0]->province,
            'country'=>$lead[0]->country,
            'zipcode'=>$lead[0]->zipcode,
            'website'=>$lead[0]->website,
            'email'=>$lead[0]->email,
            'fax'=>$lead[0]->fax,
            'phone'=>$lead[0]->phone,
            'description'=>$lead[0]->description,
            'accounttype'=>1,
            'createbyid'=>$owners,
            'updatebyid'=>$owners,
            'leadid'=>$id,
        ];
        $accID = Accounts::create($cAccounts);
        $cContacts=[
            'contactname'=>$lead[0]->first_name." ".$lead[0]->last_name,
            'ownerid'=>$lead[0]->ownerid,
            'accountid'=>$accID->id,
            'email'=>$lead[0]->email,
            'address'=>$lead[0]->address,
            'city'=>$lead[0]->city,
            'province'=>$lead[0]->province,
            'country'=>$lead[0]->country,
            'zipcode'=>$lead[0]->zipcode,
            'fax'=>$lead[0]->fax,
            'phone'=>$lead[0]->phone,
            'mobile'=>$lead[0]->mobile,
            'note'=>$lead[0]->description,
            'createbyid'=>$owners,
            'updatebyid'=>$owners,
        ];
        $contID=Contacts::create($cContacts);
        $cProperties=[
            'propertyname'=>$lead[0]->leadsname,
            'ownerid'=>$lead[0]->ownerid,
            'accountid'=>$accID->id,
            'contactid'=>$contID->id,
            'address'=>$lead[0]->address,
            'city'=>$lead[0]->city,
            'province'=>$lead[0]->province,
            'country'=>$lead[0]->country,
            'zipcode'=>$lead[0]->zipcode,
            'fax'=>$lead[0]->fax,
            'phone'=>$lead[0]->phone,
            'mobile'=>$lead[0]->mobile,
            'email'=>$lead[0]->email,
            'maplat'=>$lead[0]->maplat,
            'maplong'=>$lead[0]->maplong,
            'mapurl'=>$lead[0]->mapurl,
            'note'=>$lead[0]->description,
            'createbyid'=>$owners,
            'updatebyid'=>$owners,
        ];
        $prop=Properties::create($cProperties);
        $prevdata=['Modules'=>'Leads','id'=>$id];
        $newdata=[
            'Accounts'=>[
                'Modules'=>'Accounts','id'=>$accID->id,
                
            ],
            'Contacts'=>[
                'Modules'=>'Contacts','id'=>$contID->id,
            ],
            'Properties'=>[
                'Modules'=>'Properties','id'=>$prop->id
            ],
        ];
        $logs=[
            'module'=>'Leads',
            'moduleid'=>$id,
            'userid'=>Auth::user()->id,
            'subject'=>'Convert to Contact',
            'prevdata'=>json_encode($prevdata),
            'newdata'=>json_encode($newdata)
        ];
        $ids=DataLogs::create($logs);
        $logs=[
            'module'=>'Accounts',
            'moduleid'=>$accID->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Convert to Accounts',
            'prevdata'=>json_encode($prevdata),
            'newdata'=>json_encode($newdata)
        ];
        $ids=DataLogs::create($logs);
        $logs=[
            'module'=>'Contacts',
            'moduleid'=>$contID->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Convert to Contacts',
            'prevdata'=>json_encode($prevdata),
            'newdata'=>json_encode($newdata)
        ];
        $ids=DataLogs::create($logs);
        $logs=[
            'module'=>'Properties',
            'moduleid'=>$prop->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Convert to Property ',
            'prevdata'=>json_encode($prevdata),
            'newdata'=>json_encode($newdata)
        ];
        $ids=DataLogs::create($logs);
        $data=[ 'convert'=>1 ];
        $leads=Leads::where('id','=',$id)->update($data);
        $accounts = Accounts::where('leadid','=',$id)->get();
        return view('leads.convert',compact('accounts'));
    }
    
}
