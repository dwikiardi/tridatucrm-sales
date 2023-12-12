<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DataLogs;
use App\Models\ipaddress;
use App\Models\pops;
use App\Models\Leads;
use App\Models\Stocks;
use App\Models\StocksPosition;
use App\Models\StockCategorys;
use App\Models\StockLogs;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use App\Models\StocksNoSeri;

use DB;
use DataTables;
use PDF;
use URL;
use Storage;
use File;

class MaintenanceController extends Controller
{
    public function index(Request $request)//OK
    {
        if ($request->ajax()) {
            $data = Maintenance::join('users as a','a.id','=','maintenance.staffid')->join('leads as b','b.id','=','maintenance.leadid')
            ->select('maintenance.id as ID','maintenance.nomaintenance as NoMaintenance' ,'maintenance.date AS Date' , 'maintenance.status AS status','maintenance.note as Note','a.first_name as MaintenanceBy','b.property_name as customer')
            ->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn="";
                    
                    switch ($row->status) {
                        case '0':
                            $actionBtn="";
                            break;
                        case '1':
                            $actionBtn = '<a class="edit btn btn-warning btn-sm" data-id="'.$row->ID.'" href="'. route('maintenance.view',$row->ID) .'">Update</a> ';
                            $actionBtn = $actionBtn . '<a class="process btn btn-primary btn-sm" data-id="'.$row->ID.'" href="'. route('maintenance.process',$row->ID) .'">Process</a> ';
                            $actionBtn = $actionBtn . '<a class="cancel btn btn-danger btn-sm" data-id="'.$row->ID.'" href="'. route('maintenance.cancel',$row->ID) .'">Cancel</a> ';
                            break;
                        case '2':
                            $actionBtn = '<a class="printjo btn btn-primary btn-sm" data-id="'.$row->ID.'" ">Job Order</a> ';
                            $actionBtn = $actionBtn . '<a  class="finish btn btn-success btn-sm" data-id="'.$row->ID.'" href="'. route('maintenance.finish',$row->ID) .'">Finish</a> ';
                            $actionBtn = $actionBtn . '<a class="cancel btn btn-danger btn-sm" data-id="'.$row->ID.'" href="'. route('maintenance.cancel',$row->ID) .'">Cancel</a> ';
                            break;
                        case '3':
                            $actionBtn="";
                            $actionBtn = $actionBtn . '<a class="prininstal btn btn-primary btn-sm" data-id="'.$row->ID.'" >Report</a> ';
                            break;
                        default:
                            # code...
                            break;
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('status', function ($row) {
                    //status : 1->Open; 2->Onproggress; 3->done; 0->canceled
                    switch ($row->status) {
                        case 0:
                            $status="Canceled";
                            break;
                        case 1:
                            $status="Open";
                            break;
                        case 2:
                            $status="OnProgress";
                            break;
                        case 3:
                            $status="Done";
                            break;
                        default:
                            # code...
                            break;
                    }
                   
                    return $status;
                })
                ->editColumn('Date', function ($row) {
                    if(isset($row->Date)){
                        $date=date('d/m/Y',strtotime($row->Date));
                        return $date;    
                    }else{
                        return '-';
                    }
                    
                })
                ->make(true);
        }
        
        return view('maintenance.index');
    }

    public function create()//OK
    {
        $Users=User::select('id','first_name','last_name')->get();
        $Customers=Leads::leftJoin('pops','pops.id','=','leads.popid')
        ->leftJoin('ip_address','ip_address.leadid','=','leads.id')
        ->select('leads.id','leads.property_name','leads.property_address','pops.name as popname','ip_address.ip_address','leads.pic_contact','leads.pic_mobile')->get();
        $pops=pops::get();
        $ipaddress=ipaddress::where('peruntukan','=','')->orWhere('peruntukan', '=', null)->get();
        
        return view('maintenance.create',compact('Users','Customers','ipaddress','pops'));
    }

    public function store(Request $request)//OK
    {
        //dd($request);
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $maintenance_id=$this->getNoorder('MTS');
        $old_date = explode('/', $request->date); 
        $date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
        $status="success";
        $msg="";
        if($request->reqstock){
            $reqstock=1;
        }else{
            $reqstock=0;
        }
        $data=[
            'nomaintenance'=>$maintenance_id,
            'date'=>$date,
            'leadid'=>$request->customer,
            'staffid'=>$request->staffid,
            'problem'=>$request->problem,
            'reqstock'=>$reqstock,
            'status'=>1,
            'createdbyid'=>$request->createbyid,
            'updatedbyid'=>$request->updatebyid,
        ];
        
        try {
            $Maintenance=Maintenance::create($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
        $tID=$Maintenance->id;
       
        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Maintenance',
            'moduleid'=>$tID,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Maintenance Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('maintenance.index')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);
        
    }

    public function view($id)//OK
    {
        $Maintenance=Maintenance::join('leads','leads.id','=','maintenance.leadid')
        ->join('users','users.id','=','maintenance.staffid')
        ->leftJoin('ip_address','ip_address.leadid','=','leads.id')
        ->leftJoin('pops','pops.id','=','leads.popid')
        ->select('maintenance.*','ip_address.ip_address as ips','leads.property_name as customer','leads.pic_contact as contact','leads.pic_mobile as mobile','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib')
        ->where('maintenance.id','=',$id)->get();
        // $Maintenance=Maintenance::where('maintenance.id','=',$id)->get();
        //dd($Maintenance);
        return view('maintenance.view',compact('Maintenance'));
    }

    public function edit($id)//OK
    {
        $Maintenance=Maintenance::join('leads','leads.id','=','maintenance.leadid')
        ->join('users','users.id','=','maintenance.staffid')
        ->leftJoin('ip_address','ip_address.leadid','=','leads.id')
        ->leftJoin('pops','pops.id','=','leads.popid')
        ->select('maintenance.*','ip_address.ip_address as ips','leads.property_name as customer','leads.pic_contact as contact','leads.pic_mobile as mobile','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib')
        ->where('maintenance.id','=',$id)->get();

        $Users=User::select('id','first_name','last_name')->get();
        $Customers=Leads::leftJoin('pops','pops.id','=','leads.popid')
        ->leftJoin('ip_address','ip_address.leadid','=','leads.id')
        ->select('leads.id','leads.property_name','leads.property_address','pops.name as popname','ip_address.ip_address','leads.pic_contact','leads.pic_mobile')->get();
        $pops=pops::get();
        $ipaddress=ipaddress::where('peruntukan','=','')->orWhere('peruntukan', '=', null)->where('leadid','=',$Maintenance[0]->leadid)->get();
        
        return view('maintenance.edit',compact('Users','Customers','ipaddress','pops','Maintenance'));
    }

    public function update(Request $request)//OK
    {
        //dd($request);
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $id=$request->id;
        $old_date = explode('/', $request->date); 
        $date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
        $status="success";
        $msg="";
        if($request->reqstock){
            $reqstock=1;
        }else{
            $reqstock=0;
        }
        $data=[
            'date'=>$date,
            'leadid'=>$request->customer,
            'staffid'=>$request->staffid,
            'problem'=>$request->problem,
            'reqstock'=>$reqstock,
            'updatedbyid'=>$request->updatebyid,
        ];
        
        try {
            $Maintenance=Maintenance::where('id','=',$id)->update($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
       
        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Maintenance',
            'moduleid'=>$id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Maintenance Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('maintenance.index')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);
        
    
        
    }

    public function process($id)//OK
    {
        $Maintenance=Maintenance::join('leads','leads.id','=','maintenance.leadid')
        ->join('users','users.id','=','maintenance.staffid')
        ->leftJoin('ip_address','ip_address.leadid','=','leads.id')
        ->leftJoin('pops','pops.id','=','leads.popid')
        ->select('maintenance.*','ip_address.ip_address as ips','leads.property_name as customer','leads.pic_contact as contact','leads.pic_mobile as mobile','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib')
        ->where('maintenance.id','=',$id)->get();
        if($Maintenance[0]->reqstock==1){
            $Stocks=Stocks::select('id','stockid','stockname','qtytype','unit','categoryid')->get();
            $stockPos=StocksPosition::where('posmodule','=','storage')->get();
            $StocksNoSeri=StocksNoSeri::select('stockid','posmodule','noseri','module_id')->where('posmodule','=','storage')->get();
            $mstock=DB::select("select stocks.id,stocks.stockid,stocks.qtytype,stocks.stockname,stocks.categoryid,stocks.unit from stocks inner JOIN stocks_position on stocks.id=stocks_position.stockid WHERE stocks_position.posmodule='storage' UNION ALL select stocks.id,stocks.stockid,stocks.qtytype,stocks.stockname,stocks.categoryid,stocks.unit from stocks inner JOIN stocks_no_seri on stocks.id=stocks_no_seri.stockid WHERE stocks_no_seri.posmodule='storage' GROUP BY stocks.id,stocks.stockid,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule,stocks.qtytype;");
            return view('maintenance.process',compact('Stocks','stockPos','StocksNoSeri','stockPos','mstock','Maintenance'));
        }else{
            $insUpdate=[
                'status'=>2
            ];
            $updInst=Maintenance::where('id','=',$id)->update($insUpdate);
            
            
            $oldData=$Maintenance[0];
            $oldData=json_encode($oldData);
            $nMaintenance=Maintenance::where('id','=',$id)->get(); 
            $nMaintenanceDetail=$request->Item_List;
            $newdata=$nMaintenance;
            $newdata['ItemDetail']=$nMaintenanceDetail;
            $newdata=json_encode($newdata);
            $logs=[
                'module'=>'Maintenance',
                'moduleid'=>$id,
                'createbyid'=>Auth::user()->id,
                'logname'=>'Maintenance Procesed',
                'olddata'=>$oldData,
                'newdata'=>$newdata
            ];
            $ids=DataLogs::create($logs);
            return view('maintenance.index');
        }
        //return view('maintenance.process',compact('Users','Customers','pops','stockPos','mstock','Maintenance'));
    }
    
    public function reprocess(Request $request)//OK
    {
        //dd($request->Item_List[1]['qty']);
        $status="success";
        $msg="";
        $Maintenance=Maintenance::where('maintenance.id','=',$request->id)->get();
        $nomaintenance=$Maintenance[0]->nomaintenance;
        $staffid=$Maintenance[0]->staffid;
        $InItem=array();
        $rows=$request->row;
        //set Detail Item For Maintenance
        for($i=0;$i<=$rows;$i++){
            //save per line item of Instalasi if qty is not 0
            $Item_List=$request->Item_List[$i];
            if( $Item_List['qty']!='' || $Item_List['qty']!=null){
                if($Item_List['qty']>0 ){
                    $items=[
                        'nomaintenance'=>$nomaintenance,
                        'stockid'=>$Item_List['stockid'],
                        'serial'=>$Item_List['mserial'],
                        'qty'=>$Item_List['qty'],
                        'status'=>0
                    ];
                
                    $InItem[]=$items;
                    try {
                        $Maintenance=MaintenanceDetail::create($items);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage();
                    }
                    if($Item_List['qtytype'] == 1 ){
                        //untuk semua list item yang memiliki nomor seri pindahkan status dari gudang ke teknisi
                        $serials=explode(',',$Item_List['mserial']);
                        foreach($serials as $noseri){
                            $lsserial=[
                                'posmodule'=>'staff',
                                'module_id'=>$staffid,
                            ];
                            $setnoseri=StocksNoSeri::where('noseri','=',$noseri)->update($lsserial);
                            
                        }
                        
                        
                    }
                }
            }
        }
        //dd($InItem);
        $insUpd=[ 'status'=>2,'updatedbyid'=>Auth::user()->id];
        $updInst=Maintenance::where('maintenance.id','=',$request->id)->update($insUpd);
        $newdata="";
        $newIns=Maintenance::where('maintenance.id','=',$request->id)->get();
        $newIns['itemDetail']=$InItem;
        $newdata=json_encode($newIns);
        $logs=[
            'module'=>'Maintenance',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Maintenance Processed',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('maintenance.index')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);
        
    }
    
    public function finish($id)//OK
    {
        //dd($id);
        $maintenance=Maintenance::join('leads','leads.id','=','maintenance.leadid')
        ->join('users','users.id','=','maintenance.staffid')
        ->leftJoin('ip_address','ip_address.leadid','=','leads.id')
        ->leftJoin('pops','pops.id','=','leads.popid')
        ->select('maintenance.*','ip_address.ip_address as ips','leads.property_name as customer','leads.pic_contact as contact','leads.pic_mobile as mobile','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib')
        ->where('maintenance.id','=',$id)->get();

        $detail=MaintenanceDetail::join('stocks','stocks.id','=','maintenance_detail.stockid')
        ->select('maintenance_detail.*','stocks.stockname as stocknames','stocks.stockid as stockcodename','stocks.unit as unit','stocks.qtytype as qtytype')
        ->where('maintenance_detail.nomaintenance','=',$maintenance[0]->nomaintenance)->get();
        
        //$installed=DB::select("SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, stocks_position.qty, stocks.stockname, stocks.unit, '' AS noseri FROM stocks INNER JOIN stocks_position ON stocks.id = stocks_position.stockid WHERE stocks_position.posmodule = 'leads' AND stocks_position.module_id = '".$maintenance[0]->leadid."' UNION ALL SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, '1' AS qty, stocks.stockname, stocks.unit, stocks_no_seri.noseri FROM stocks INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid WHERE stocks_no_seri.posmodule = 'leads' AND stocks_no_seri.module_id = '".$maintenance[0]->leadid."' GROUP BY stocks.id, stocks.stockid, stocks.stockname, stocks.unit, stocks.qtytype;");
        $installed=DB::select("SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, stocks_position.qty, stocks.stockname, stocks.unit, '' AS noseri FROM stocks INNER JOIN stocks_position ON stocks.id = stocks_position.stockid WHERE stocks_position.posmodule = 'leads' AND stocks_position.module_id = '".$maintenance[0]->leadid."' UNION ALL SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, '1' AS qty, stocks.stockname, stocks.unit, stocks_no_seri.noseri as noseri FROM stocks INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid WHERE stocks_no_seri.posmodule = 'leads' AND stocks_no_seri.module_id = '".$maintenance[0]->leadid."';");
        //dd($installed);
        $ipaddress=ipaddress::where('peruntukan','=','')->orWhere('peruntukan', '=', null)->orWhere('leadid', '=', $maintenance[0]->leadid)->get();
        $pops=pops::get();
        return view('maintenance.finish',compact('maintenance','detail','installed','ipaddress','pops'));
    }
    public function refinish(Request $request)//OK
    {
        if(is_null($request->result)|| $request->result ==''){
            $response=[
                'status'=>'failed',
                'message'=>"Result Is Still Empty"
            ];
            return json_encode($response);
        }
        //dd($request);
        
        $id=$request->id;
        $olddata=Maintenance::where('maintenance.id','=',$id)->get();
        $noinstall=$olddata[0]->nomaintenance;
        $leadid=$olddata[0]->leadid;
        $installerid=$olddata[0]->staffid;
        $old_date = explode('/', $request->date); 
        $date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
        $status="success";
        $msg="";
        // //dd($olddata[0]->ipid != $request->ipaddr);
        //Change IP Allocation
        if($olddata[0]->ipid != $request->ipaddr){
            //reset old IP data
            $IPAdd=ipaddress::where('id','=',$olddata[0]->ipid)->get();
            $ipold=json_encode($IPAdd);
            $resetIP=['leadid'=>null];
            try {
                $resetit=ipaddress::where('id','=',$olddata[0]->ipid)->update($resetIP);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage()." 1";
            }
            
            $logs=[
                'module'=>'ip_address',
                'moduleid'=>$olddata[0]->ipid,
                'createbyid'=>Auth::user()->id,
                'logname'=>'Reset Customer',
                'olddata'=>$ipold,
                'newdata'=>json_encode($resetIP)
            ];
            //set New IP Data
            $IPAdd=ipaddress::where('id','=',$request->ipaddr)->get();
            $ipupdate=['leadid'=>$olddata[0]->leadid];
            try {
                $updateIP=ipaddress::where('id','=',$request->ipaddr)->update($ipupdate);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage()." 2";
            }
            //dd(ipaddress::where('id','=',$request->ipaddr)->get());
            $logs=[
                'module'=>'ip_address',
                'moduleid'=>$request->ipaddr,
                'createbyid'=>Auth::user()->id,
                'logname'=>'Set To Customer',
                'olddata'=>json_encode($IPAdd),
                'newdata'=>json_encode($ipupdate)
            ];
            $ids=DataLogs::create($logs);
        }
        //End Change IP Allocation


        //Update Maintenance Detail
        $InItem=array();
        foreach ($request->detail as  $value) {
            // $rowID=$request->detail[$value];
            //echo "<br> ID : ".$value;
            $rowID=$value;
            //jika Qty tidak 0 atau ada yang di pasang di pelanggan
            if($request->qty[$rowID]!='' ||$request->qty[$rowID]!=null){
                if($request->qty[$rowID]>0 ){
                    $setStatus=1;
                    if($request->qtytype[$rowID] == 1 ){
                        //jika stok dengan serial
                        $$lsintallserial="";
                        $instaledserial=count($request->installserial[$rowID]);
                        $serials=$request->installserial[$rowID];
                        $lsserial=[
                            'posmodule'=>'leads',
                            'module_id'=>$leadid,
                            'status'=>$request->status[$rowID],
                        ];
                        foreach($serials as $noseri){
                            $lsintallserial=$lsintallserial.$noseri.',';
                            $x=1;//Remove
                            try {
                                $setnoseri=StocksNoSeri::where('noseri','=',$noseri)->update($lsserial);
                            }  catch (\Exception $e) {
                                $status="failed";
                                $msg=$msg." ".$e->getMessage()." 3".$x;//Remove change
                            }
                            $x++;//Remove
                            $seriallogs=[
                                'stockid'=>$request->stockid[$rowID],
                                'stockcode'=>'',
                                'serial'=>$noseri,
                                'qty'=>1,
                                'transtype'=>9,
                                'module'=>'maintenance',
                                'moduleid'=>$id,
                                'note'=>"Installed to Customer (maintenance issue)",
                                'createdbyid'=>Auth::user()->id,
                                'updatedbyid'=>Auth::user()->id,
                                'transcation_number'=>$noinstall,
                            ];
                            $logslist=StockLogs::create($seriallogs);
                        }
                        //return Unused Serial Number  To Storage
                        $uninstall= MaintenanceDetail::where('id','=',$rowID)->get();
                        $lsuninstall=explode(',',$uninstall[0]->serial);
                        $rnoseri=array_diff($lsuninstall,$serials);
                        $returnit=['posmodule'=>'storage', 'module_id'=>0, 'status'=>0];
                        foreach ($rnoseri as $rtnoseri) {
                            $x=1;//Remove
                            try {
                                $returnNoseri=StocksNoSeri::where('noseri','=',$rtnoseri)->update($returnit);
                            }  catch (\Exception $e) {
                                $status="failed";
                                $msg=$msg." ".$e->getMessage()." 4".$x;//Remove change
                            }
                            $x++;//Remove
                            $seriallogs=[
                                'stockid'=>$request->stockid[$rowID],
                                'stockcode'=>'',
                                'serial'=>$rtnoseri,
                                'qty'=>1,
                                'transtype'=>9,
                                'module'=>'maintenance',
                                'moduleid'=>0,
                                'note'=>'Return To Storage: Un Used Maintenance',
                                'createdbyid'=>Auth::user()->id,
                                'updatedbyid'=>Auth::user()->id,
                                'transcation_number'=>$noinstall,
                            ];
                            $logslist=StockLogs::create($seriallogs);
                        }
                    }else{
                    //Jika stok Non Serial
                        $instaledserial=0;
                        $lsintallserial="";
                        $current=StocksPosition::where('stockid','=',$request->stockid[$rowID])->where('posmodule','=','staff')->where('module_id','=',$installerid)->get();
                        //dd($current[0]->id);
                        if ($current->count() > 0) {
                            //if any reduce
                            $cqty=$current[0]->qty;
                            $nqty=(int)$cqty - (int)$request->qty[$rowID];
                            $dataupdate=['qty'=>$nqty];
                            
                            $x=1;//Remove
                            try {
                                $update=StocksPosition::where('id','=',$current[0]->id)->update($dataupdate);
                            }  catch (\Exception $e) {
                                $status="failed";
                                $msg=$msg." ".$e->getMessage()." 5".$x;//Remove change
                            }
                            $x++;//Remove
                        }else{
                            //if not available create and reduce/set minus
                            $stockpos=[
                                'posmodule'=>'leads',
                                'module_id'=>$leadid,
                                'stockid'=>$request->stockid[$rowID],
                                'qty'=>-1*$request->qty[$rowID],
                                'status'=>$request->status[$rowID],
                            ];
                            
                            $x=1;//Remove
                            try {
                                $update=StocksPosition::create($stockpos);
                            }  catch (\Exception $e) {
                                $status="failed";
                                $msg=$msg." ".$e->getMessage()." 6".$x;//Remove change
                            }
                            $x++;//Remove
                        }
                        $seriallogs=[
                            'stockid'=>$request->stockid[$rowID],
                            'stockcode'=>'',
                            'serial'=>'',
                            'qty'=>$request->qty[$rowID],
                            'transtype'=>9,
                            'module'=>'maintenance',
                            'moduleid'=>$id,
                            'note'=>'Reduce From Staff',
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);

                        //Get Current Stock On Customer and Add It
                        $currentLead=StocksPosition::where('stockid','=',$request->stockid[$rowID])->where('posmodule','=','leads')->where('module_id','=',$leadid)->get();
                        if ($currentLead->count() > 0) {
                            //if available add it
                            $cqty=$currentLead[0]->qty;
                            $nqty=(int)$cqty + (int)$request->qty[$rowID];
                            $dataupdate=['qty'=>$nqty];
                            $update=StocksPosition::where('id','=',$currentLead[0]->id)->update($dataupdate);
                        
                        }else{
                            //if not available create it
                            $stockpos=[
                                'posmodule'=>'leads',
                                'module_id'=>$leadid,
                                'stockid'=>$request->stockid[$rowID],
                                'qty'=>$request->qty[$rowID],
                                'status'=>$request->status[$rowID],
                            ];
                            $update=StocksPosition::create($stockpos);
                        }
                    
                        
                        $seriallogs=[
                            'stockid'=>$request->stockid[$rowID],
                            'stockcode'=>'',
                            'serial'=>'',
                            'qty'=>$request->qty[$rowID],
                            'transtype'=>9,
                            'module'=>'maintenance',
                            'moduleid'=>$id,
                            'note'=>'Transfer Postion To Customer',
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);
                    }
                    $ditem=[
                        'status'=>$setStatus,
                        'installed'=>$instaledserial,
                        'instaledserial'=>$lsintallserial,
                        'installedqty'=>$request->qty[$rowID],
                    ];
                    
                    // $InItem[]=$ditem;
                    
                    $x=1;//Remove
                    try {
                        $details=MaintenanceDetail::where('id','=',$rowID)->update($ditem);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage()." 7".$x;//Remove change
                    }
                    $x++;//Remove
                
                }else{
                    $setStatus=2;
                    //Qty = 0 //Unused
                    //if serial
                    if($request->qtytype[$rowID] == 1 ){
                        //jika stok dengan serial return it to storage
                        $instaledserial=count($request->installserial[$rowID]);
                        $serials=$request->installserial[$rowID];
                        $lsserial=[
                            'posmodule'=>'storage',
                            'module_id'=>0,
                            'status'=>0,
                        ];
                        foreach($serials as $noseri){
                            
                            $x=1;//Remove
                            try {
                                $setnoseri=StocksNoSeri::where('noseri','=',$noseri)->update($lsserial);
                            }  catch (\Exception $e) {
                                $status="failed";
                                $msg=$msg." ".$e->getMessage()." 8".$x;//Remove change
                            }
                            $x++;//Remove
                            $seriallogs=[
                                'stockid'=>$request->stockid[$rowID],
                                'stockcode'=>'',
                                'serial'=>$noseri,
                                'qty'=>1,
                                'transtype'=>9,
                                'module'=>'maintenance',
                                'moduleid'=>$id,
                                'note'=>"Return To Storage unused on maintenance",
                                'createdbyid'=>Auth::user()->id,
                                'updatedbyid'=>Auth::user()->id,
                                'transcation_number'=>$noinstall,
                            ];
                            $logslist=StockLogs::create($seriallogs);
                        }
                        //return Unused Serial Number  To Storage
                        
                    }else{
                    //Jika stok Non Serial
                        $instaledserial=0;
                        // Get Total in Staff and Reduce 
                        $current=StocksPosition::where('stockid','=',$request->stockid[$rowID])->where('posmodule','=','staff')->where('module_id','=',$installerid)->get();
                        //dd($current[0]->id);
                        if ($current->count() > 0) {
                            //if any reduce from staff
                            $cqty=$current[0]->qty;
                            $nqty=(int)$cqty - (int)$request->qty[$rowID];
                            $dataupdate=['qty'=>$nqty];
                            
                            $x=1;//Remove
                            try {
                                $update=StocksPosition::where('id','=',$current[0]->id)->update($dataupdate);
                            }  catch (\Exception $e) {
                                $status="failed";
                                $msg=$msg." ".$e->getMessage()." 9".$x;//Remove change
                            }
                            $x++;//Remove
                        }else{
                            //if not available create and reduce/set minus
                            $stockpos=[
                                'posmodule'=>'staff',
                                'module_id'=>$installerid,
                                'stockid'=>$request->stockid[$rowID],
                                'qty'=>-1*$request->qty[$rowID],
                                'status'=>$request->status[$rowID],
                            ];
                            
                            $x=1;//Remove
                            try {
                                $update=StocksPosition::create($stockpos);
                            }  catch (\Exception $e) {
                                $status="failed";
                                $msg=$msg." ".$e->getMessage()." 10".$x;//Remove change
                            }
                            $x++;//Remove
                        }
                        $seriallogs=[
                            'stockid'=>$request->stockid[$rowID],
                            'stockcode'=>'',
                            'serial'=>'',
                            'qty'=>$request->qty[$rowID],
                            'transtype'=>9,
                            'module'=>'maintenance',
                            'moduleid'=>$id,
                            'note'=>'Reduce From Staff',
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);

                        //Get Current Stock On Storage and Return It
                        $currentLead=StocksPosition::where('stockid','=',$request->stockid[$rowID])->where('posmodule','=','storage')->where('module_id','=',0)->get();
                        if ($currentLead->count() > 0) {
                            //if available add it
                            $cqty=$currentLead[0]->qty;
                            $nqty=(int)$cqty + (int)$request->qty[$rowID];
                            $dataupdate=['qty'=>$nqty];
                            $update=StocksPosition::where('id','=',$currentLead[0]->id)->update($dataupdate);
                        
                        }else{
                            //if not available create it
                            $stockpos=[
                                'posmodule'=>'storage',
                                'module_id'=>0,
                                'stockid'=>$request->stockid[$rowID],
                                'qty'=>$request->qty[$rowID],
                                'status'=>0,
                            ];
                            $update=StocksPosition::create($stockpos);
                        }
                    
                        
                        $seriallogs=[
                            'stockid'=>$request->stockid[$rowID],
                            'stockcode'=>'',
                            'serial'=>'',
                            'qty'=>$request->qty[$rowID],
                            'transtype'=>9,
                            'module'=>'maintenance',
                            'moduleid'=>$id,
                            'note'=>'Return to Storage Un Used on Maintenance',
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);
                    }
                    $ditem=[
                        'status'=>$setStatus,
                        'installed'=>0,
                        'instaledserial'=>"",
                        'installedqty'=>0,
                    ];
                    
                    // $InItem[]=$ditem;
                
                    $x=1;//Remove
                    try {
                        $details=MaintenanceDetail::where('id','=',$rowID)->update($ditem);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage()." 11".$x;//Remove change
                    }
                    $x++;//Remove  
                }
            }
        }
        //End Update Maintenance Detail

        //Update Revocation if Any 
        foreach ($request->detaili as  $nval) {
            // $rowID=$request->detail[$value];
            //echo "<br> ID : ".$nval;
            $rowID=$nval;
            //If Qty > 0 or is any revocation from customer
            if($request->qtyi[$rowID]!='' ||$request->qtyi[$rowID]!=null){
                if($request->qtyi[$rowID]>0){
                    $setStatus=3;
                    if($request->qtytypei[$rowID] == 1 ){
                        //If Stock Is serial return to storage
                        $installseriali=count($request->installseriali[$rowID]);
                        $serials=$request->installseriali[$rowID];
                        $lsserial=[
                            'posmodule'=>'storage',
                            'module_id'=>0,
                            'status'=>0,
                        ];
                        foreach($serials as $noseri){
                            $setnoseri=StocksNoSeri::where('noseri','=',$noseri)->update($lsserial);
                            $seriallogs=[
                                'stockid'=>$request->stockidi[$rowID],
                                'stockcode'=>'',
                                'serial'=>$noseri,
                                'qty'=>1,
                                'transtype'=>9,
                                'module'=>'maintenance',
                                'moduleid'=>$id,
                                'note'=>"Revocation from Customer (maintenance issue)",
                                'createdbyid'=>Auth::user()->id,
                                'updatedbyid'=>Auth::user()->id,
                                'transcation_number'=>$noinstall,
                            ];
                            $logslist=StockLogs::create($seriallogs);
                        }
                        // add to Mintenance Detail as Revocation
                        $addMaintDetail=[
                            'nomaintenance'=>$noinstall,
                            'stockid'=>$request->stockidi[$rowID],
                            'qty'=>$request->qtyi[$rowID],
                            'serial'=>implode(',',$request->installseriali[$rowID]),
                            'status'=>$setStatus,//1:used, 2:return, 0=reqstock,3:revocation
                            'instaledserial'=>0,
                            'installedqty'=>0,
                        ];
                        
                    }else{
                    //Jika stok Non Serial
                        $instaledserial=0;
                        //Check on customer
                        $current=StocksPosition::where('stockid','=',$request->stockidi[$rowID])->where('posmodule','=','leads')->where('module_id','=',$leadid)->get();
                        //dd($current[0]->id);
                        if ($current->count() > 0) {
                            //if any reduce
                            $cqty=$current[0]->qty;
                            $nqty=(int)$cqty - (int)$request->qtyi[$rowID];
                            $dataupdate=['qty'=>$nqty];
                            $update=StocksPosition::where('id','=',$current[0]->id)->update($dataupdate);
                        
                        }else{
                            //if not available create and reduce/set minus
                            $stockpos=[
                                'posmodule'=>'leads',
                                'module_id'=>$leadid,
                                'stockid'=>$request->stockidi[$rowID],
                                'qty'=>-1*$request->qtyi[$rowID],
                                'status'=>$request->statusi[$rowID],
                            ];
                            $update=StocksPosition::create($stockpos);
                        }
                        $seriallogs=[
                            'stockid'=>$request->stockidi[$rowID],
                            'stockcode'=>'',
                            'serial'=>'',
                            'qty'=>$request->qtyi[$rowID],
                            'transtype'=>9,
                            'module'=>'maintenance',
                            'moduleid'=>$id,
                            'note'=>'Reduce From Staff',
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);

                        //Get Current Stock On Customer and Add It
                        $currentLead=StocksPosition::where('stockid','=',$request->stockidi[$rowID])->where('posmodule','=','storage')->where('module_id','=',0)->get();
                        if ($currentLead->count() > 0) {
                            //if available add it
                            $cqty=$currentLead[0]->qty;
                            $nqty=(int)$cqty + (int)$request->qtyi[$rowID];
                            $dataupdate=['qty'=>$nqty];
                            $update=StocksPosition::where('id','=',$currentLead[0]->id)->update($dataupdate);
                        
                        }else{
                            //if not available create it
                            $stockpos=[
                                'posmodule'=>'storage',
                                'module_id'=>0,
                                'stockid'=>$request->stockidi[$rowID],
                                'qty'=>$request->qtyi[$rowID],
                                'status'=>0,
                            ];
                            $update=StocksPosition::create($stockpos);
                        }
                    
                        
                        $seriallogs=[
                            'stockid'=>$request->stockidi[$rowID],
                            'stockcode'=>'',
                            'serial'=>'',
                            'qty'=>$request->qtyi[$rowID],
                            'transtype'=>9,
                            'module'=>'maintenance',
                            'moduleid'=>$id,
                            'note'=>'Transfer Postion To Customer',
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);
                        $addMaintDetail=[
                            'nomaintenance'=>$noinstall,
                            'stockid'=>$request->stockidi[$rowID],
                            'qty'=>$request->qtyi[$rowID],
                            'serial'=>'',
                            'status'=>$setStatus,//1:used, 2:return, 0=reqstock, 3:revocation
                            'instaledserial'=>0,
                            'installedqty'=>0,
                        ];
                    }
                    //dd($addMaintDetail);
                    try {
                        $details=MaintenanceDetail::create($addMaintDetail);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage()." x5";
                    }
                    
                    // $InItem[]=$ditem;
                    
                }
            }
        }
        // //Set Main Update
        $data=[
            
            'result'=>$request->result,
            'status'=>3,
            'maintenancedate'=>$date,
            'updatedbyid'=>$request->updatebyid,
        ];
        $oldsdata=Maintenance::where('id','=',$request->id)->get();
        try {
            $Maintenance=Maintenance::where('id','=',$request->id)->update($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage()."-6";
        }
       
        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Maintenance',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Maintenance Update',
            'olddata'=>json_encode($oldsdata),
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('maintenance.index')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);


    }
    public function printjo($id)//OK
    {
        $maintenance=Maintenance::join('leads','leads.id','=','maintenance.leadid')
        ->join('users','users.id','=','maintenance.staffid')
        ->leftJoin('ip_address','ip_address.leadid','=','leads.id')
        ->leftJoin('pops','pops.id','=','leads.popid')
        ->select('maintenance.*','ip_address.ip_address as ips','leads.property_name as customer','leads.pic_contact as contact','leads.pic_mobile as mobile','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib')
        ->where('maintenance.id','=',$id)->get();
        
        $detail=MaintenanceDetail::join('stocks','stocks.id','=','maintenance_detail.stockid')
        ->select('maintenance_detail.*','stocks.stockname as stocknames','stocks.stockid as stockcodename','stocks.unit as unit','stocks.qtytype as type')
        ->where('maintenance_detail.nomaintenance','=',$maintenance[0]->nomaintenance)->get();
        
        //$installed=DB::select("SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, stocks_position.qty, stocks.stockname, stocks.unit, '' AS noseri FROM stocks INNER JOIN stocks_position ON stocks.id = stocks_position.stockid WHERE stocks_position.posmodule = 'leads' AND stocks_position.module_id = '".$maintenance[0]->leadid."' UNION ALL SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, '1' AS qty, stocks.stockname, stocks.unit, stocks_no_seri.noseri FROM stocks INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid WHERE stocks_no_seri.posmodule = 'leads' AND stocks_no_seri.module_id = '".$maintenance[0]->leadid."' GROUP BY stocks.id, stocks.stockid, stocks.stockname, stocks.unit, stocks.qtytype;");
        $installed=DB::select("SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, stocks_position.qty, stocks.stockname, stocks.unit, '' AS noseri FROM stocks INNER JOIN stocks_position ON stocks.id = stocks_position.stockid WHERE stocks_position.posmodule = 'leads' AND stocks_position.module_id =  '".$maintenance[0]->leadid."'  UNION ALL SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, '1' AS qty, stocks.stockname, stocks.unit, stocks_no_seri.noseri as noseri FROM stocks INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid WHERE stocks_no_seri.posmodule = 'leads' AND stocks_no_seri.module_id =  '".$maintenance[0]->leadid."';");
        //dd($installed);
        $fileName=str_replace('/','_',$maintenance[0]->nomaintenance) . '.pdf';
        //dd(File::exists( URL::to('/storage/app/public/pdf/'.$fileName)));
        if (File::exists( URL::to('/storage/app/public/pdf/'.$fileName))){
            $returnfile= URL::to('/storage/app/public/pdf/'.$fileName);
            $results=array(
                'status'=>'exist',
                'file'=>$returnfile
            );
        }else{
            $pdf = PDF::loadView('maintenance.printjo', compact('maintenance','detail','installed'));
            $content=$pdf->download($fileName);
            Storage::put('public/pdf/'.$fileName ,$content) ;
            $path = storage_path('app/public/pdf/'.$fileName);
            $returnfile= URL::to('/storage/app/public/pdf/'.$fileName);
            $results=array(
                'status'=>'success',
                'file'=>$returnfile
            );
        }
        

        return json_encode($results);        
        // return view('maintenance.printjo',compact('maintenance','detail'));
    }
    
    public function installed($id)
    {
        $maintenance=Maintenance::join('leads','leads.id','=','maintenance.leadid')
        ->join('users','users.id','=','maintenance.staffid')
        ->leftJoin('ip_address','ip_address.leadid','=','leads.id')
        ->leftJoin('pops','pops.id','=','leads.popid')
        ->select('maintenance.*','ip_address.ip_address as ips','leads.property_name as customer','leads.property_state as city','leads.pic_contact as contact','leads.pic_mobile as mobile','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib')
        ->where('maintenance.id','=',$id)->get();


        $detail=MaintenanceDetail::join('stocks','stocks.id','=','maintenance_detail.stockid')
        ->select('maintenance_detail.*','stocks.stockname as stocknames','stocks.stockid as stockcodename','stocks.unit as unit','stocks.qtytype as type')
        ->where('maintenance_detail.nomaintenance','=',$maintenance[0]->nomaintenance)->where('status','=',1)->get();
        $installed=MaintenanceDetail::join('stocks','stocks.id','=','maintenance_detail.stockid')
        ->select('maintenance_detail.*','stocks.stockname as stocknames','stocks.stockid as stockcodename','stocks.unit as unit','stocks.qtytype as type')
        ->where('maintenance_detail.nomaintenance','=',$maintenance[0]->nomaintenance)->where('status','=',3)->get();
        
        $fileName=str_replace('/','_',$maintenance[0]->nomaintenance) . '.pdf';
        //dd(File::exists( URL::to('/storage/app/public/pdf/'.$fileName)));
        if (File::exists( URL::to('/storage/app/public/pdf/'.$fileName))){
            $returnfile= URL::to('/storage/app/public/pdf/'.$fileName);
            $results=array(
                'status'=>'exist',
                'file'=>$returnfile
            );
        }else{
            $pdf = PDF::loadView('maintenance.report', compact('maintenance','detail','installed'));
            $content=$pdf->download($fileName);
            Storage::put('public/pdf/'.$fileName ,$content) ;
            $path = storage_path('app/public/pdf/'.$fileName);
            $returnfile= URL::to('/storage/app/public/pdf/'.$fileName);
            $results=array(
                'status'=>'success',
                'file'=>$returnfile
            );
        }
        

        return json_encode($results);   
    }

    public function cancel($id) //OK
    {
        $Maintenance=Maintenance::where('id','=',$id)->get(); 
        $MaintenanceDetail=MaintenanceDetail::join('stocks','stocks.id','=','maintenance_detail.stockid')->where('nomaintenance','=',$Maintenance[0]->nomaintenance)
        ->select('maintenance_detail.*','stocks.qtytype','stocks.stockid as stockcode')->get();
        $staffid=$Maintenance[0]->instaled;
        $laststatus=$Maintenance[0]->status;
        //Reset Ip status;
        $ips=[
            'leadid'=>null,
        ];
        $accdata=ipaddress::where('id','=',$Maintenance[0]->ipid)->update($ips);


        //Update Status To Cancel
        $insUpdate=[
            'status'=>0
        ];
        $updInst=Maintenance::where('id','=',$id)->update($insUpdate);
        
        if($laststatus==2){ 
            foreach ($MaintenanceDetail as $detail) {
                if($detail->qtytype==0){
                    //last Position in Technisi
                    $getCurentPosition=StocksPosition::where('posmodule','=','staff')->where('module_id','=',$staffid)->where('stockid','=',$detail->stockid)->get();
                    //then Add it to Storage
                    $OnStorage=StocksPosition::where('posmodule','=','storage')->where('stockid','=',$detail->stockid)->get();
                    $dataupdate=[
                        'qty'=>(int)$OnStorage[0]->qty + (int)$detail->qty,
                    ];
                    $update=StocksPosition::where('id','=',$OnStorage[0]->id)->update($dataupdate);
                    //Remove From technisi
                    $dataupdate2=[
                        'qty'=>(int)$getCurentPosition[0]->qty - (int)$detail->installedqty,
                    ];
                    $update=StocksPosition::where('id','=',$getCurentPosition[0]->id)->update($dataupdate2);
                }
                if($detail->qtytype==1){
                    $lsseri=explode(',',$detail->serial);
                    foreach ($lsseri as $noseri) {
                        //Set Nomor seri To Storage
                        $data=[
                            'posmodule'=>'storage',
                            'module_id'=>0,
                        ];
                        $update=StocksNoSeri::where('noseri','=',$noseri)->update($data);
                        $seriallogs=[
                            'stockid'=>$detail->stockid,
                            'stockcode'=>$detail->stockid,
                            'serial'=>$noseri,
                            'qty'=>1,
                            'transtype'=>9,
                            'module'=>'maintenance',
                            'moduleid'=>$Maintenance[0]->id,
                            'note'=>"cancel Maintenance",
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$detail->nomaintenance,
                        ];
                        $logslist=StockLogs::create($seriallogs);
                    }

                }
            }
        }
        $oldData=$Maintenance[0];
        $olddata['ItemDetail']=$MaintenanceDetail;
        $oldData=json_encode($oldData);
        $nMaintenance=Maintenance::where('id','=',$id)->get(); 
        $nMaintenanceDetail=MaintenanceDetail::join('stocks','stocks.id','=','maintenance_detail.stockid')->where('nomaintenance','=',$nMaintenance[0]->nomaintenance)->get();
        $newdata=$nMaintenance;
        $newdata['ItemDetail']=$nMaintenanceDetail;
        $newdata=json_encode($newdata);
        $logs=[
            'module'=>'Maintenance',
            'moduleid'=>$id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Maintenance Canceled',
            'olddata'=>$oldData,
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        
        $response=[
            'status'=>'success',
            'message'=>'Data Canceled Successfully.'
        ];
    
        return json_encode($response);

    }

    public function getNoorder($prefixs){
        $bln=date("m");
        $thn=date("Y");
        $now="/".$prefixs."/".$bln."/".$thn;
        $Maintenance=Maintenance::select('nomaintenance')->where('nomaintenance','LIKE','%'.$now.'%')->orderBy('id', 'DESC')->first();
        //dd($order->noorder);
        if(empty($Maintenance)){
            $noorder="000001".$now;
        }else{
            $no=$Maintenance->nomaintenance;
            $nnow=substr($no,0,strlen($no)-strlen($now));
            $nnow=(int)$nnow;
            $newnow=$nnow+1;
            //echo "Here";
            switch(strlen($newnow)){
                case 1:
                    $noorder="00000".$newnow.$now;
                    break;
                case 2:
                    $noorder="0000".$newnow.$now;
                    break;
                case 3:
                    $noorder="000".$newnow.$now;
                    break;
                case 4:
                    $noorder="00".$newnow.$now;
                    break;
                case 5:
                    $noorder="0".$newnow.$now;
                    break;
                case 6:
                    $noorder=$newnow.$now;
                    break;
            }  
        }
        //$count=$order->count();
        //echo $count;
        //dd($noorder);

        return $noorder;
    }
}
