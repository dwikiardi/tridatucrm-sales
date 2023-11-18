<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DataLogs;
use App\Models\ipaddress;
use App\Models\pops;
use App\Models\Leads;

use DataTables;

class IPAddressController extends Controller
{
    //Index ListView
    public function index(Request $request, $id){
        //dd($request->search["value"]);
        
        if(isset($request->search["value"])){
            if ($request->ajax()) {
                //$data = Accounts::select('*');
                $data = ipaddress::leftJoin('leads','leads.id','=','ip_address.leadid')
                ->leftJoin('pops','pops.id','=','ip_address.popid')
                ->select('ip_address.id as ID' , 'ip_address.name as Name' , 'ip_address.description AS Desk','leads.leadsname','pops.name as popname','ip_address.ip_type as ip_type','ip_address.peruntukan','ip_address.netID')
                ->get();
                //dd($data);
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('position', function($row){
                        $peruntukan="";
                        if($row->peruntukan == "customer"){
                            $peruntukan='Customer: '.$row->leadsname;
                        }
                        if($row->peruntukan == "pop"){
                            $peruntukan='POP: '.$row->popname;
                        }
                        if($row->peruntukan == "server"){
                            $peruntukan="Server";
                        }
                        return $peruntukan;
                    })
                    ->rawColumns(['position'])
                    ->editColumn('ip_type', function ($row) {
                        if($row->ip_type ==  0){
                            $ip_type="Privat IP";
                        }else{
                            $ip_type="Public IP";
                        }
                        return $ip_type;
                    })
                    ->editColumn('netID', function ($row) {
                        $netID=str_replace('/','_',$row->netID);
                        return $netID;
                    })
                    ->make(true);
            }
        }
        if(isset($id)){
            //echo "id is set";
            $ids=str_replace("_","/",$id);
            //dd($id);
            if ($request->ajax()) {
                //$data = Accounts::select('*');
                $data = ipaddress::leftJoin('leads','leads.id','=','ip_address.leadid')
                ->leftJoin('pops','pops.id','=','ip_address.popid')
                ->select('ip_address.id as ID' , 'ip_address.name as Name' , 'ip_address.description AS Desk','leads.leadsname','pops.name as popname','ip_address.ip_type as ip_type','ip_address.peruntukan')
                ->where('ip_address.netID','=',$ids)
                ->get();
                //dd($data);
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('position', function($row){
                        $peruntukan="";
                        if($row->peruntukan == "customer"){
                            $peruntukan='Customer: '.$row->leadsname;
                        }
                        if($row->peruntukan == "pop"){
                            $peruntukan='POP: '.$row->popname;
                        }
                        if($row->peruntukan == "server"){
                            $peruntukan="Server";
                        }
                        return $peruntukan;
                    })
                    ->rawColumns(['position'])
                    ->editColumn('ip_type', function ($row) {
                        if($row->ip_type ==  0){
                            $ip_type="Privat IP";
                        }else{
                            $ip_type="Public IP";
                        }
                        return $ip_type;
                    })
                    ->editColumn('netID', function ($row) {
                        $netID=str_replace('/','_',$row->netID);
                        return $netID;
                    })
                    ->make(true);
            }
        }
        

        return view('ipaddr.index',compact('id'));
    }
    public function netid(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = ipaddress::select('ip_address.netID as Network','ip_address.netID as detail')->groupby('ip_address.netID')
            ->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('detail', function ($row) {
                    $detail=str_replace("/","_",$row->detail);
                    return $detail;
                })
                ->make(true);
        }

        return view('ipaddr.netid');
    }
    //public function checkip(Request $request){
    public function checkip($ip){
        //echo "checkIP";
        //dd($ip);
        //$ip=$request->ipaddress;
        $data = ipaddress::where('ip_address','=',$ip)->count();
        //dd($data);
        return $data;
    }
    // public function create($id=null)
    // {
    //     return view('pops.create');
    // }
    public function store(Request $request){
        $user_id=Auth::user()->id;
        $type=$request->type;
        $cidr=$request->ip."/24";
        $range = array();
        $cidr = explode('/', $cidr);
        $range[0] = long2ip((ip2long($cidr[0])) & ((-1 << (32 - (int)$cidr[1]))));
        $range[1] = long2ip((ip2long($range[0])) + pow(2, (32 - (int)$cidr[1])) - 1);
        //var_dump($range);
        $prefix=substr($range[0],0,-1);
        $netID=$prefix."0/24";
        try {

            for($i=0;$i<=255;$i++){
                if($i==0){
                    $ip= $prefix.$i;
                    
                    $data=[
                        'ip_address'=>$ip,
                        'name'=>$ip,
                        'description'=>'Network ID',
                        'ip_type'=>$type,
                        'createdbyid'=>$user_id,
                        'updatedbyid'=>$user_id,
                        'netID'=>$netID
                    ];
                }elseif($i==255){
                    $ip= $prefix.$i;
                    $data=[
                        'ip_address'=>$ip,
                        'name'=>$ip,
                        'description'=>'Broadcast',
                        'ip_type'=>$type,
                        'createdbyid'=>$user_id,
                        'updatedbyid'=>$user_id,
                        'netID'=>$netID
                    ];
                }else{
                    $ip= $prefix.$i;
                    $data=[
                        'ip_address'=>$ip,
                        'name'=>$ip,
                        'description'=>'',
                        'ip_type'=>$type,
                        'createdbyid'=>$user_id,
                        'updatedbyid'=>$user_id,
                        'netID'=>$netID
                    ];
                }
               
                $ids=ipaddress::create($data);
        
                $newdata=json_encode($data);
                $logs=[
                    'module'=>'ipaddress',
                    'moduleid'=>$ids->id,
                    'createbyid'=>Auth::user()->id,
                    'logname'=>'New IP:'.$ip.' Created',
                    'olddata'=>'',
                    'newdata'=>$newdata
                ];
                $ids=DataLogs::create($logs);
            }
            return response()->json([
                'status' => 'success',
                'msg'    => 'Data Create Successfully',
            ]);
          } catch (\Exception $e) {
          
            $msg= $e->getMessage();
            return response()->json([
                'status' => 'error',
                'msg'    => $msg,
            ]);
          }
       
    }

    public function view($id){
        $ipaddress=ipaddress::where('id','=',$id)->get();
        
        $createdbyid=User::where('id','=',$ipaddress[0]->createdbyid)->get();
        $updatedbyid=User::where('id','=',$ipaddress[0]->updatedbyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','ipaddress')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        $netID=str_replace("/","_",$ipaddress[0]->netID);
        return view('ipaddr.view',compact('ipaddress','createdbyid','updatedbyid','logs','netID'));
    }

    public function edit($id){
        $ipaddress=ipaddress::where('id','=',$id)->get();
        $leads=Leads::select('id','leadsname','property_name')->where('active','=',1)->get();
        $pops=pops::select('id','name')->get();
        return view('ipaddr.edit',compact('ipaddress','leads','pops'));
    }
    public function update(Request $request){
        $data=$request->all();
        //dd($data);
        switch ($request->peruntukan) {
            case 'customer':
                $ndata=[
                    'name'=>$request->name,
                    'ip_address'=>$request->name,
                    'description'=>$request->description,
                    'leadid'=>$request->leadid,
                    'popid'=>null,
                    'ip_type'=>$request->type,
                    'peruntukan'=>$request->peruntukan,
                    'updatedbyid'=>$request->updatedbyid
                ];
                break;
            case 'pops':
                $ndata=[
                    'name'=>$request->name,
                    'ip_address'=>$request->name,
                    'description'=>$request->description,
                    'leadid'=>null,
                    'popid'=>$request->popid,
                    'ip_type'=>$request->type,
                    'peruntukan'=>$request->peruntukan,
                    'updatedbyid'=>$request->updatedbyid
                ];
                break;
            default:
                $ndata=[
                    'name'=>$request->name,
                    'ip_address'=>$request->name,
                    'description'=>$request->description,
                    'leadid'=>null,
                    'popid'=>null,
                    'ip_type'=>$request->type,
                    'peruntukan'=>$request->peruntukan,
                    'updatedbyid'=>$request->updatedbyid
                ];
                break;
        }
        
        $accdata=ipaddress::where('id','=',$request->id)->get();
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($ndata);
        $logs=[
            'module'=>'ipaddress',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'IP Address Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $pops=ipaddress::where('id',$request->id)->update($ndata);
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         //return redirect('ipaddress/view/'.$data->id);
        $response=[
            'status'=>'success',
            'message'=>route('ipaddress.view',$request->id)
        ];
        return json_encode($response);
    }
}
