<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Accounts;
use App\Models\User;
use App\Models\AccountLogs;
use App\Models\Contacts;
use App\Models\Properties;
use App\Models\Products;

use Yajra\DataTables\Facades\Datatables;


class PropertyController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = Properties::join('users', 'properties.ownerid', '=', 'users.id')
            ->join('accounts', 'properties.accountid', '=', 'accounts.id')
            ->join('contacts', 'properties.contactid', '=', 'contacts.id')
            ->leftJoin('products', function($join) {
                $join->on('products.id', '=', 'properties.productid');
              })
            //->join('products','products.id','=','properties.productid')
            ->select('properties.id as ID','properties.propertyname as Name' , 'properties.address AS Address','contacts.contactname As Contacts','accounts.fullname as Accounts',
            'properties.accountid As AID','properties.contactid as CID','products.productname as Package')
            ->get();
            //dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('Package', function ($row) {
                    return $row->Package ?: '-';
                })
                ->make(true);
        }

        return view('properties.index');
    }


    public function create($aid = null)
    {
        
        $Users=User::get();
        $Accounts=Accounts::get();
        if($aid){//jika dari form Contacts
            $ids=explode("|",$aid);
            $Contacts=Contacts::where('accountid','=',$ids[0])->get();    
            $accs=$ids[0];
            $conts=$ids[1];
        }else{
            $accs="";
            $conts="";
            $Contacts="";    
        }
        $Products=Products::where('producttype','=',0)->get();
        return view('properties.create',compact('Users','Accounts','Contacts','accs','conts','Products','aid'));
    }
    public function getcontact($id)
    {
        $Contacts=Contacts::where('accountid','=',$id)->select('id','contactname as name')->get();
        //dd($Contacts);
        echo json_encode($Contacts);
        //return json_endcode($Contacts);
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        
        $ids=Properties::create($request->all());

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Properties',
            'moduleid'=>$ids->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Property Created',
            'prevdata'=>'',
            'newdata'=>$newdata
        ];
        $ids=AccountLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
        if($request->conts == null) {
            return redirect('properties');
        } else{
            return redirect('contacts/view/'.$request->conts);
        }
        //
    }

    public function view($id){
        $properties=Properties::where('id','=',$id)->get();
        $owner=User::where('id','=',$properties[0]->ownerid)->get();
        $createbyid=User::where('id','=',$properties[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$properties[0]->updatebyid)->get();
        $accounts=Accounts::where('id','=',$properties[0]->accountid)->get();
        $contacts=Contacts::where('id','=',$properties[0]->contactid)->get();
        if($properties[0]->productid === null){
            $product="-";
        }else{
            $products=Products::where('id','=',$properties[0]->productid)->get();
            $product=$products[0]->productname;
        }
        
        $logs=AccountLogs::where('moduleid','=',$id)->where('module','=','Properties')->orderBy('created_at', 'DESC')->join('users', 'accountlogs.userid', '=', 'users.id')
        ->select('accountlogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('properties.view',compact('properties','owner','createbyid','updatebyid','logs','accounts','contacts','product'));
    }

    public function edit($id){
        $Users=User::get();
        $accounts=Accounts::where('id','=',$id)->get();
        return view('accounts.edit',compact('Users','accounts'));
    }
    public function update(Request $request, Accounts $accounts){
        //var_dump($request->all());
        $accounts->update($request->all());
        $accdata=Accounts::where('id','=',$request->id)->get();
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
         return redirect('accounts');
    }

    
}
