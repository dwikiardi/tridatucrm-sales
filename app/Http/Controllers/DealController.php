<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\User;
use App\Models\AccountLogs;
use App\Models\Contacts;
use App\Models\Properties;
use App\Models\Products;
use App\Models\Leads;
use App\Models\Deal;

use DataTables;

class DealController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $first = Deal::select('deals.id as ID','deals.date as Date','deals.leadid as LPID','leads.leadsname as Name','deals.price as Price','deals.productid as PID','products.productname','deals.dealtype','users.last_name AS Owners')
            ->join('products','products.id','=','deals.productid')
            ->join('leads','leads.id','=','deals.leadid')
            ->join('users', 'deals.ownerid', '=', 'users.id')
            ->where('deals.dealtype','=',1);
 
            $data = Deal::select('deals.id as ID','deals.date as Date','deals.propertiesid as LPID','properties.propertyname as Name','deals.price as Price','deals.productid as PID','products.productname','deals.dealtype','users.last_name AS Owners')
            ->join('properties','properties.id','=','deals.propertiesid')
            ->join('products','products.id','=','deals.productid')
            ->join('users', 'deals.ownerid', '=', 'users.id')
            ->where('deals.dealtype','=',2)
            ->union($first)
            ->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('Date', function ($contact){
                    return date('d/m/Y', strtotime($contact->Date) );
                })
                ->make(true);
        }

        return view('deals.index');
    }


    public function create($aid = null)
    {
        
        $Users=User::get();
        $leads=Leads::get();

        $properties=Properties::join('users', 'properties.ownerid', '=', 'users.id')
        ->join('accounts', 'properties.accountid', '=', 'accounts.id')
        ->join('contacts', 'properties.contactid', '=', 'contacts.id')
        ->leftJoin('products', function($join) {
            $join->on('products.id', '=', 'properties.productid');
          })
        //->join('products','products.id','=','properties.productid')
        ->select('properties.*','properties.propertyname as Name','contacts.contactname As Contacts','accounts.fullname as Accounts')
        ->get();
        $Products=Products::where('producttype','=',0)->get();
        return view('deals.create',compact('Users','Products','leads','properties'));
    }
    public function getlead($id)
    {
        $Leads=Leads::where('id','=',$id)->get();
        //dd($Contacts);
        echo json_encode($Leads);
        //return json_endcode($Contacts);
    }
    public function getproperty($id)
    {
        $Contacts=Properties::join('users', 'properties.ownerid', '=', 'users.id')
        ->join('accounts', 'properties.accountid', '=', 'accounts.id')
        ->join('contacts', 'properties.contactid', '=', 'contacts.id')
        ->select('properties.*','properties.propertyname as Name','contacts.contactname As Contacts','accounts.fullname as Accounts')
        ->where('properties.id','=',$id)->get();
        //dd($Contacts);
        echo json_encode($Contacts);
        //return json_endcode($Contacts);
    }
    public function store(Request $request){
        $data=$request->all();
        unset($data['_token']);
        $data['date']=str_replace("/","-",$data['date']);
        $data['date'] = date("Y-m-d", strtotime($data['date']));
        //dd($data);
        $newdata=json_encode($request->all());
        $ids=Deal::create($data);
        $logs=[
            'module'=>'Deals',
            'moduleid'=>$ids->id,
            'userid'=>Auth::user()->id,
            'subject'=>'Deals Created',
            'prevdata'=>'',
            'newdata'=>$newdata
        ];
        
        $log=AccountLogs::create($logs);
        return redirect('deals');
        
    }

    public function view($id){
        // $deal=Deal::where('id','=',$id)->get();
        // $properties=Properties::where('id','=',$id)->get();
        // $owner=User::where('id','=',$properties[0]->ownerid)->get();
        // $createbyid=User::where('id','=',$properties[0]->createbyid)->get();
        // $updatebyid=User::where('id','=',$properties[0]->updatebyid)->get();
        // $accounts=Accounts::where('id','=',$properties[0]->accountid)->get();
        // $contacts=Contacts::where('id','=',$properties[0]->contactid)->get();
        // if($properties[0]->productid === null){
        //     $product="-";
        // }else{
        //     $products=Products::where('id','=',$properties[0]->productid)->get();
        //     $product=$products[0]->productname;
        // }
        
        // $logs=AccountLogs::where('moduleid','=',$id)->where('module','=','Properties')->orderBy('created_at', 'DESC')->join('users', 'accountlogs.userid', '=', 'users.id')
        // ->select('accountlogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        // return view('properties.view',compact('properties','owner','createbyid','updatebyid','logs','accounts','contacts','product'));
        echo "on proggress";
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
