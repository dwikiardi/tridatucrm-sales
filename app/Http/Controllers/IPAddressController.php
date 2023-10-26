<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DataLogs;
use App\Models\ipaddress;
use App\Models\Leads;

use DataTables;

class IPAddressController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = ipaddress::leftJoin('leads','leads.id','=','ip_address.leadid')
            ->leftJoin('pops','pops.id','=','ip_address.popid')
            ->select('ip_address.id as ID' , 'ip_address.name as Name' , 'ip_address.description AS Desk','leads.leadsname','pops.name as popname','ip_address.ip_type','ip_address.peruntukan')
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
                ->make(true);
        }

        return view('ipaddr.index');
    }

    public function checkip(Request $request){
        
        $ip=$request->ipaddress;
        $data = ipaddress::where('ip_address','=',$ip)->count();
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
                        'updatedbyid'=>$user_id
                    ];
                }elseif($i==255){
                    $ip= $prefix.$i;
                    $data=[
                        'ip_address'=>$ip,
                        'name'=>$ip,
                        'description'=>'Broadcast',
                        'ip_type'=>$type,
                        'createdbyid'=>$user_id,
                        'updatedbyid'=>$user_id
                    ];
                }else{
                    $ip= $prefix.$i;
                    $data=[
                        'ip_address'=>$ip,
                        'name'=>$ip,
                        'description'=>'',
                        'ip_type'=>$type,
                        'createdbyid'=>$user_id,
                        'updatedbyid'=>$user_id
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
        
        return view('ipaddr.view',compact('ipaddress','createdbyid','updatedbyid','logs'));
    }

    public function edit($id){
        $pops=pops::where('id','=',$id)->get();
        return view('pops.edit',compact('pops'));
    }
    public function update(Request $request){
        $data=$request->all();
        
        
        unset($data['_token']);
        $accdata=pops::where('id','=',$request->id)->get();
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($data);
        $logs=[
            'module'=>'Stock_Categories',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Stock Categories Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $pops=pops::where('id',$request->id)->update($data);
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('pops/view/'.$request->id);
    }
}
