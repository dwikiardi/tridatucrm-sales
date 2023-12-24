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
use App\Models\Instalation;
use App\Models\InstalationDetail;
use App\Models\StocksNoSeri;
use App\Models\Services;

use DB;
use DataTables;
use PDF;
use URL;
use Storage;
use File;


class InstallController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Instalation::join('users as a','a.id','=','installation.installerid')->join('leads as b','b.id','=','installation.leadid')->join('services','services.id','=','installation.packageid')
            ->select('installation.id as ID','installation.noinstall as NoInstallation' ,'installation.date AS Date' , 'installation.status AS status','installation.note as Note','a.first_name as InstallationBy','b.property_name as customer' ,'services.services_name as services')
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
                            $actionBtn = '<a class="edit btn btn-warning btn-sm" data-id="'.$row->ID.'" href="'. route('installasi.view',$row->ID) .'">Update</a> ';
                            $actionBtn = $actionBtn . '<a class="process btn btn-primary btn-sm" data-id="'.$row->ID.'" href="'. route('installasi.process',$row->ID) .'">Process</a> ';
                            $actionBtn = $actionBtn . '<a class="cancel btn btn-danger btn-sm" data-id="'.$row->ID.'" href="'. route('installasi.cancel',$row->ID) .'">Cancel</a> ';
                            break;
                        case '2':
                            $actionBtn = '<a class="printjo btn btn-primary btn-sm" data-id="'.$row->ID.'" ">Job Order</a> ';
                            $actionBtn = $actionBtn . '<a  class="finish btn btn-success btn-sm" data-id="'.$row->ID.'" href="'. route('installasi.finish',$row->ID) .'">Finish</a> ';
                            $actionBtn = $actionBtn . '<a class="cancel btn btn-danger btn-sm" data-id="'.$row->ID.'" href="'. route('installasi.cancel',$row->ID) .'">Cancel</a> ';
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

        return view('installasi.index');
    }

    public function create()
    {
        $Users=User::select('id','first_name','last_name')->get();
        // $Category=StockCategorys::get();
        // $Stocks=Stocks::select('id','stockid','stockname','qtytype','unit','categoryid')->get();
        $Customers=Leads::select('id','property_name','property_address')->get();
        // $stockPos=StocksPosition::where('posmodule','=','staff')->get();
        $pops=pops::get();
        $services=Services::get();
        // $StocksNoSeri=StocksNoSeri::select('stockid','posmodule','noseri','module_id')->where('posmodule','=','staff')->get();
        $ipaddress=ipaddress::where('peruntukan','=','')->orWhere('peruntukan', '=', null)->get();
        //dd($ipaddress);
        $mstock=DB::select("select stocks.id,stocks.stockid,stocks.stockname,stocks.categoryid,stocks.unit,stocks_position.posmodule from stocks inner JOIN stocks_position on stocks.id=stocks_position.stockid WHERE stocks_position.posmodule='staff' UNION ALL select stocks.id,stocks.stockid,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule from stocks inner JOIN stocks_no_seri on stocks.id=stocks_no_seri.stockid WHERE stocks_no_seri.posmodule='staff' GROUP BY stocks.id,stocks.stockid,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule;");
        //return view('installasi.create-sales',compact('Users','Stocks','Customers','Category','StocksNoSeri','stockPos','mstock','ipaddress','pops'));
        return view('installasi.create',compact('Users','Customers','ipaddress','pops','services','mstock'));
    }

    public function store(Request $request){
        // dd($request);
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $installation_id=$this->getNoorder('INS');
        $old_date = explode('/', $request->installasidate); 
        $date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
        $status="success";
        $msg="";
        $data=[
            'noinstall'=>$installation_id,
            'date'=>$date,
            'leadid'=>$request->customer,
            'ipid'=>$request->ipaddr,
            'popid'=>$request->pops,
            'installerid'=>$request->installerid,
            'packageid'=>$request->packageid,
            'note'=>$request->note,
            'status'=>1,
            'createdbyid'=>$request->createbyid,
            'updatedbyid'=>$request->updatebyid,
        ];
        
        try {
            $Installation=Instalation::create($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
        $tID=$Installation->id;
        //var_dump($data);
        //$orderid="1";
        $IPAdd=ipaddress::where('id','=',$request->ipaddr)->get();
        $ipold=json_encode($IPAdd);
        $ipupdate=['leadid'=>$request->customer];
       
        try {
            $IPAdd=ipaddress::where('id','=',$request->ipaddr)->update($ipupdate);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
        $leadupd=['popid'=>$request->pops];
        $leads=Leads::where('id','=',$request->customer)->update($leadupd);

        $logs=[
            'module'=>'ip_address',
            'moduleid'=>$request->ipaddr,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Set To Customer',
            'olddata'=>$ipold,
            'newdata'=>json_encode($ipupdate)
        ];
        $ids=DataLogs::create($logs);
        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Installation',
            'moduleid'=>$tID,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Installation Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('installasi.index')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);
        
    }

    public function view($id)
    {
        $Instalation=Instalation::join('ip_address','ip_address.id','=','installation.ipid')
        ->join('leads','leads.id','=','installation.leadid')
        ->join('pops','pops.id','=','installation.popid')
        ->join('services','services.id','=','installation.packageid')
        ->join('users','users.id','=','installation.installerid')
        ->select('installation.*','ip_address.ip_address as ips','leads.property_name as customer','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib','services.services_name as services')
        ->where('installation.id','=',$id)->get();
        // $Instalation=Instalation::where('installation.id','=',$id)->get();
        //dd($Instalation);
        return view('installasi.view',compact('Instalation'));
    }

    public function edit($id)
    {
        $Users=User::select('id','first_name','last_name')->get();
        $Customers=Leads::select('id','property_name','property_address')->get();
        $pops=pops::get();
        $services=Services::get();
        $ipaddress=ipaddress::where('peruntukan','=','')->orWhere('peruntukan', '=', null)->get();
        $Instalation=Instalation::join('leads','leads.id','=','installation.leadid')
        ->select('installation.*','leads.property_address as address')
        ->where('installation.id','=',$id)->get();
        //dd($Instalation);
        return view('installasi.edit',compact('Users','Customers','ipaddress','pops','Instalation','services'));
    }

    public function update(Request $request){
        //dd($request);
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $id=$request->id;
        $olddata=Instalation::where('installation.id','=',$id)->get();
        
        $oldleads=Leads::where('id','=',$request->customer)->get();
        $old_date = explode('/', $request->installasidate); 
        $date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
        $status="success";
        $msg="";
        //dd($olddata[0]->ipid != $request->ipaddr);
        if($olddata[0]->ipid != $request->ipaddr){
            //reset old IP data
            $IPAdd=ipaddress::where('id','=',$olddata[0]->ipid)->get();
            $ipold=json_encode($IPAdd);
            $resetIP=['leadid'=>null];
            try {
                $resetit=ipaddress::where('id','=',$olddata[0]->ipid)->update($resetIP);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage();
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
                $msg=$msg." ".$e->getMessage();
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
        if($oldleads[0]->popid != $request->pops){
            //set New POP Data
            $uppops=['popid'=>$request->pops];
            try {
                $popupd=Leads::where('id','=',$request->customer)->update($uppops);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage();
            }
           
        }
        $data=[
            'date'=>$date,
            'ipid'=>$request->ipaddr,
            'popid'=>$request->pops,
            'installerid'=>$request->installerid,
            'packageid'=>$request->packageid,
            'note'=>$request->note,
            'updatedbyid'=>$request->updatebyid,
        ];
        $oldsdata=Instalation::where('id','=',$request->id)->get();
        try {
            $Installation=Instalation::where('id','=',$request->id)->update($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
       
        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Installation',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Installation Update',
            'olddata'=>json_encode($oldsdata),
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('installasi.index')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);
        
    }

    public function process($id)
    {
        $Category=StockCategorys::select('id','category_name')->get();
        $Stocks=Stocks::select('id','stockid','stockname','qtytype','unit','categoryid')->get();
         $stockPos=StocksPosition::where('posmodule','=','storage')->get();
         $StocksNoSeri=StocksNoSeri::select('stockid','posmodule','noseri','module_id')->where('posmodule','=','storage')->get();
        $ipaddress=ipaddress::where('peruntukan','=','')->orWhere('peruntukan', '=', null)->get();
        //dd($ipaddress);
        $Instalation=Instalation::join('ip_address','ip_address.id','=','installation.ipid')
        ->join('leads','leads.id','=','installation.leadid')
        ->join('pops','pops.id','=','installation.popid')
        ->join('users','users.id','=','installation.installerid')
        ->join('services','services.id','=','installation.packageid')
        ->select('installation.*','ip_address.ip_address as ips','leads.property_name as customer','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib','services.services_name as services')
        ->where('installation.id','=',$id)->get();
        //$mstock=DB::select("select stocks.id,stocks.stockid,stocks.qtytype,stocks.stockname,stocks.categoryid,stocks.unit,stocks_position.posmodule from stocks inner JOIN stocks_position on stocks.id=stocks_position.stockid WHERE stocks_position.posmodule='storage' UNION ALL select stocks.id,stocks.stockid,stocks.qtytype,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule from stocks inner JOIN stocks_no_seri on stocks.id=stocks_no_seri.stockid WHERE stocks_no_seri.posmodule='storage' GROUP BY stocks.id,stocks.stockid,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule,stocks.qtytype;");
        $mstock=DB::select("SELECT stocks.id, stocks.stockid, stocks.qtytype, stocks.stockname, stocks.categoryid, stocks.unit, stocks_position.posmodule,stocks_position.qty as qty FROM stocks INNER JOIN stocks_position ON stocks.id = stocks_position.stockid WHERE stocks_position.posmodule = 'storage' AND stocks_position.module_id = 0 UNION ALL SELECT stocks.id, stocks.stockid, stocks.qtytype, stocks.stockname, stocks.categoryid, stocks.unit, stocks_no_seri.posmodule, count(stocks_no_seri.noseri) as qty FROM stocks INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid WHERE stocks_no_seri.posmodule = 'storage' AND stocks_no_seri.module_id = 0 GROUP BY stocks.id, stocks.stockid, stocks.stockname, stocks.categoryid, stocks.unit, stocks_no_seri.posmodule, stocks.qtytype;;");
        return view('installasi.process',compact('Stocks','Category','StocksNoSeri','stockPos','mstock','Instalation'));
    }
    
    public function reprocess(Request $request){
        //dd($request);
        $status="success";
        $msg="";
        $id=$request->id;
        $Instalation=Instalation::where('installation.id','=',$request->id)->get();
        $noinstall=$Instalation[0]->noinstall;
        $installerid=$Instalation[0]->installerid;
        $leadid=$Instalation[0]->leadid;
        $InItem=array();
        $rows=$request->row;
        //set Detail Item For Instalation
        for($i=0;$i<$rows;$i++){
            //save per line item of Instalasi if qty is not 0
            if($request->qty[$i]!='' || $request->qty[$i]!=null){
                if($request->qty[$i] >0){
                    $items=[
                        'noinstall'=>$noinstall,
                        'category'=>$request->catID[$i],
                        'stockid'=>$request->stockid[$i],
                        'serial'=>$request->mserial[$i],
                        'qty'=>$request->qty[$i],
                        'status'=>$request->status[$i]
                    ];
                
                    $InItem[]=$items;
                    try {
                        $Installation=InstalationDetail::create($items);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage();
                    }
                    if($request->qtytype[$i] == 1 ){
                        //untuk semua list item yang memiliki nomor seri pindahkan status dari gudang ke teknisi
                        $serials=explode(',',$request->mserial[$i]);
                        foreach($serials as $noseri){
                            $lsserial=[
                                'posmodule'=>'staff',
                                'module_id'=>$installerid,
                                'status'=>$request->status[$i],
                            ];
                            $setnoseri=StocksNoSeri::where('noseri','=',$noseri)->update($lsserial);
                            $seriallogs=[
                                'stockid'=>$request->stockid[$i],
                                'stockcode'=>'',
                                'serial'=>$noseri,
                                'qty'=>1,
                                'transtype'=>4,
                                'module'=>'install',
                                'moduleid'=>$id,
                                'note'=>"Transfer For Installation",
                                'createdbyid'=>Auth::user()->id,
                                'updatedbyid'=>Auth::user()->id,
                                'transcation_number'=>$noinstall,
                            ];
                            $logslist=StockLogs::create($seriallogs);
                        }
                        
                    }else{
                        //set non serial
                        //Get Current Stock from Staff and Add
                        $currentPosition=StocksPosition::where('posmodule','=','staff')->where('module_id','=',$installerid)->where('stockid','=',$request->stockid[$i])->get();
                        //dd($currentPosition);
                        if($currentPosition->count()>0){
                            $qty=(int)$currentPosition[0]->qty + (int)$request->qty[$i];
                            $CreateNeStock=[
                                'qty'=>$qty,
                            ];
                            $setNewStock=StocksPosition::where('id','=',$currentPosition[0]->id)->update($CreateNeStock);
                        }else{
                            $qty=$request->qty[$i];
                            $CreateNeStock=[
                                'posmodule'=>'staff',
                                'module_id'=>$installerid,
                                'stockid'=>$request->stockid[$i],
                                'qty'=>$qty,
                            ];
                            $setNewStock=StocksPosition::create($CreateNeStock);
                        }
                        
                        $seriallogs=[
                            'stockid'=>$request->stockid[$i],
                            'stockcode'=>'',
                            'serial'=>'',
                            'qty'=>$request->qty[$i],
                            'transtype'=>4,
                            'module'=>'install',
                            'moduleid'=>$id,
                            'note'=>"Transfer For Installation",
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);

                        //Check Stock from Storeage Add Reduce
                        $currentPositions=StocksPosition::where('posmodule','=','storage')->where('stockid','=',$request->stockid[$i])->first();
                        $qtys=((int)$currentPositions->qty) - ((int)$request->qty[$i]);
                        
                        $updateStock=[
                            'qty'=>$qtys,
                        ];
                        $updStock=StocksPosition::where('id','=',$currentPositions->id)->update($updateStock);
                        
                        
                        
                        $seriallogs=[
                            'stockid'=>$request->stockid[$i],
                            'stockcode'=>'',
                            'serial'=>'',
                            'qty'=>$qty,
                            'transtype'=>4,
                            'module'=>'install',
                            'moduleid'=>$id,
                            'note'=>"Add Stock to Customer",
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);
                    }
                }
            }
        }
        //update Instalation Status
        $insUpd=[ 'status'=>2,'processbyid'=>Auth::user()->id];
        $updInst=Instalation::where('installation.id','=',$request->id)->update($insUpd);
        $newdata="";
        $newIns=Instalation::where('installation.id','=',$request->id)->get();
        $newIns['itemDetail']=$InItem;
        $newdata=json_encode($newIns);
        $logs=[
            'module'=>'Installation',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Installation Processed',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('installasi.index')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);
        
    }
    
    public function finish($id){
        //dd($id);
        $Instalation=Instalation::join('leads','leads.id','=','installation.leadid')
        ->join('users','users.id','=','installation.installerid')
        ->select('installation.*','leads.property_name as customer','leads.property_address as address','users.first_name as teknisia','users.last_name as teknisib')
        ->where('installation.id','=',$id)->get();
        $detail=InstalationDetail::join('stocks','stocks.id','=','installationdtl.stockid')
        ->select('installationdtl.*','stocks.stockname','stocks.stockid as stockcode','stocks.unit','stocks.qtytype')
        ->where('installationdtl.noinstall','=',$Instalation[0]->noinstall)->get();
        $stockPos=StocksPosition::where('posmodule','=','staff')->get();
        $StocksNoSeri=StocksNoSeri::select('stockid','posmodule','noseri','module_id')->where('posmodule','=','staff')->where('module_id','=',$Instalation[0]->installerid)->get();
        $ipaddress=ipaddress::where('peruntukan','=','')->orWhere('peruntukan', '=', null)->orWhere('leadid', '=', $Instalation[0]->leadid)->get();
        //dd($ipaddress);
        $pops=pops::get();
        $services=Services::get();
        $mstock=DB::select("select stocks.id,stocks.stockid,stocks.qtytype,stocks.stockname,stocks.categoryid,stocks.unit,stocks_position.posmodule from stocks inner JOIN stocks_position on stocks.id=stocks_position.stockid WHERE stocks_position.posmodule='staff' and stocks_position.module_id='".$Instalation[0]->installerid."' UNION ALL select stocks.id,stocks.stockid,stocks.qtytype,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule from stocks inner JOIN stocks_no_seri on stocks.id=stocks_no_seri.stockid WHERE stocks_no_seri.posmodule='staff' and stocks_no_seri.module_id='".$Instalation[0]->installerid."' GROUP BY stocks.id,stocks.stockid,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule,stocks.qtytype;");
        //dd("select stocks.id,stocks.stockid,stocks.qtytype,stocks.stockname,stocks.categoryid,stocks.unit,stocks_position.posmodule from stocks inner JOIN stocks_position on stocks.id=stocks_position.stockid WHERE stocks_position.posmodule='staff' and stocks_position.module_id='".$Instalation[0]->installerid."' UNION ALL select stocks.id,stocks.stockid,stocks.qtytype,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule from stocks inner JOIN stocks_no_seri on stocks.id=stocks_no_seri.stockid WHERE stocks_no_seri.posmodule='staff' and stocks_no_seri.module_id='".$Instalation[0]->installerid."' GROUP BY stocks.id,stocks.stockid,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule,stocks.qtytype;");
        return view('installasi.finish',compact('Stocks','StocksNoSeri','stockPos','mstock','Instalation','ipaddress','pops','detail','services'));
    }

    public function refinish(Request $request){
        dd($request);
        //Change IP Allocation
        $id=$request->id;
        $olddata=Instalation::where('installation.id','=',$id)->get();
        $installerid=$olddata[0]->installerid;
        $leadid=$olddata[0]->leadid;
        $old_date = explode('/', $request->installasidate); 
        $date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
        $status="success";
        $msg="";
        $noinstall=$olddata[0]->noinstall;
        // //dd($olddata[0]->ipid != $request->ipaddr);
        if($olddata[0]->ipid != $request->ipaddr){
            //reset old IP data
            $IPAdd=ipaddress::where('id','=',$olddata[0]->ipid)->get();
            $ipold=json_encode($IPAdd);
            $resetIP=['leadid'=>null];
            try {
                $resetit=ipaddress::where('id','=',$olddata[0]->ipid)->update($resetIP);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage();
            }
            
            $logs=[
                'module'=>'ip_address',
                'moduleid'=>$olddata[0]->ipid,
                'createbyid'=>Auth::user()->id,
                'logname'=>'Reset Customer',
                'olddata'=>$ipold,
                'newdata'=>json_encode($resetIP)
            ];
            $ids=DataLogs::create($logs);
            //set New IP Data
            $IPAdd=ipaddress::where('id','=',$request->ipaddr)->get();
            $ipupdate=['leadid'=>$olddata[0]->leadid];
            try {
                $updateIP=ipaddress::where('id','=',$request->ipaddr)->update($ipupdate);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage();
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
        //Update POP on Leads
        if($olddata[0]->popid != $request->pops){
            $leadupd=['popid'=>$request->pops];
            $leads=Leads::where('id','=',$request->customer)->update($leadupd);
        }
        //End Change


        //Update Instalation Detail
        $InItem=array();
        $rows=$request->row;
        if ($rows==1){
            $rowID=$request->detail[0];
            $ditem=[
                'status'=>$request->status[$rowID],
                'instaledserial'=>count($request->installserial[$rowID]),
                'installedqty'=>$request->qty[$rowID],
            ];
            // $InItem[]=$ditem;
            try {
                $Installation=InstalationDetail::where('id','=',$rowID)->update($ditem);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage();
            }
            //Stock type is serial
            if($request->qtytype[$rowID] == 1 ){
                //Installed Serial Number Set To Customer/leads
                $serials=$request->installserial[$rowID];
                $lsserial=[
                    'posmodule'=>'leads',
                    'module_id'=>$leadid,
                    'status'=>$request->status[$rowID],
                ];
                foreach($serials as $noseri){
                    
                    $setnoseri=StocksNoSeri::where('noseri','=',$noseri)->update($lsserial);
                    $seriallogs=[
                        'stockid'=>$request->stockid[$i],
                        'stockcode'=>'',
                        'serial'=>$noseri,
                        'qty'=>1,
                        'transtype'=>4,
                        'module'=>'install',
                        'moduleid'=>$id,
                        'note'=>$olddata[0]->note,
                        'createdbyid'=>Auth::user()->id,
                        'updatedbyid'=>Auth::user()->id,
                        'transcation_number'=>$noinstall,
                    ];
                    $logslist=StockLogs::create($seriallogs);
                }
                //Un Installed Serial Number return To Storage
                $uninstall= $Installation=InstalationDetail::where('id','=',$rowID)->get();
                $lsuninstall=explode(',',$uninstall[0]->serial);
                $rnoseri=array_diff($lsuninstall,$serials);
                $returnit=['posmodule'=>'storage', 'module_id'=>0, 'status'=>''];
                foreach ($rnoseri as $rtnoseri) {
                    $returnNoseri=StocksNoSeri::where('noseri','=',$rtnoseri)->update($returnit);
                    $seriallogs=[
                        'stockid'=>$request->stockid[$i],
                        'stockcode'=>'',
                        'serial'=>$rtnoseri,
                        'qty'=>1,
                        'transtype'=>4,
                        'module'=>'storage',
                        'moduleid'=>0,
                        'note'=>'Return To Storage: '.$olddata[0]->note,
                        'createdbyid'=>Auth::user()->id,
                        'updatedbyid'=>Auth::user()->id,
                        'transcation_number'=>$noinstall,
                    ];
                    $logslist=StockLogs::create($seriallogs);
                }
                
            }else{
                //Set Stock Non Serial
                //Get Current Stock from Staff and reduce
                $current=StocksPosition::where('stockid','=',$request->stockid[$rowID])->where('posmodule','=','staff')->where('module_id','=',$installerid)->get();
                //dd($current[0]->id);
                if ($current->count() > 0) {
                    $cqty=$current[0]->qty;
                    $nqty=(int)$cqty - (int)$request->qty[$rowID];
                    $dataupdate=['qty'=>$nqty];
                    $update=StocksPosition::where('id','=',$current[0]->id)->update($dataupdate);
                   
                }else{
                    $stockpos=[
                        'posmodule'=>'leads',
                        'module_id'=>$leadid,
                        'stockid'=>$request->stockid[$rowID],
                        'qty'=>-1*$request->qty[$rowID],
                        'status'=>$request->status[$rowID],
                    ];
                    $update=StocksPosition::create($stockpos);
                }
                $seriallogs=[
                    'stockid'=>$request->stockid[$rowID],
                    'stockcode'=>'',
                    'serial'=>'',
                    'qty'=>$request->qty[$rowID],
                    'transtype'=>4,
                    'module'=>'install',
                    'moduleid'=>$id,
                    'note'=>'Reduce From Staff',
                    'createdbyid'=>Auth::user()->id,
                    'updatedbyid'=>Auth::user()->id,
                    'transcation_number'=>$noinstall,
                ];
                $logslist=StockLogs::create($seriallogs);
                //Get Current Stock On Customer
                $currentLead=StocksPosition::where('stockid','=',$request->stockid[$rowID])->where('posmodule','=','lead')->where('module_id','=',$leadid)->get();
                if ($currentLead->count() > 0) {
                    $cqty=$currentLead[0]->qty;
                    $nqty=(int)$cqty + (int)$request->qty[$rowID];
                    $dataupdate=['qty'=>$nqty];
                    $update=StocksPosition::where('id','=',$currentLead[0]->id)->update($dataupdate);
                   
                }else{
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
                    'transtype'=>4,
                    'module'=>'install',
                    'moduleid'=>$id,
                    'note'=>'Transfer Postion To Customer',
                    'createdbyid'=>Auth::user()->id,
                    'updatedbyid'=>Auth::user()->id,
                    'transcation_number'=>$noinstall,
                ];
                $logslist=StockLogs::create($seriallogs);
                
            }
        }else{
            foreach ($request->detail as  $value) {
                // $rowID=$request->detail[$value];
                //echo "<br> ID : ".$value;
                $rowID=$value;
                if($request->qtytype[$rowID] == 1 ){
                    $instaledserial=count($request->installserial[$rowID]);
                }else{
                    $instaledserial=0;
                }
                $ditem=[
                    'status'=>$request->status[$rowID],
                    'instaledserial'=>$instaledserial,
                    'installedqty'=>$request->qty[$rowID],
                ];
                
                // $InItem[]=$ditem;
                try {
                    $Installation=InstalationDetail::where('id','=',$rowID)->update($ditem);
                }  catch (\Exception $e) {
                    $status="failed";
                    $msg=$msg." ".$e->getMessage();
                }
                if($request->qtytype[$rowID] == 1 ){
                    //Set Installser No Seri From Teknisi to Customer/Lead
                    $serials=$request->installserial[$rowID];
                    $lsserial=[
                        'posmodule'=>'leads',
                        'module_id'=>$leadid,
                        'status'=>$request->status[$rowID],
                    ];
                    foreach($serials as $noseri){
                        $setnoseri=StocksNoSeri::where('noseri','=',$noseri)->update($lsserial);
                        $seriallogs=[
                            'stockid'=>$request->stockid[$i],
                            'stockcode'=>'',
                            'serial'=>$noseri,
                            'qty'=>1,
                            'transtype'=>4,
                            'module'=>'install',
                            'moduleid'=>$id,
                            'note'=>$olddata[0]->note,
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);
                    }
                    //Un Installed Serial Number return To Storage
                    $uninstall= $Installation=InstalationDetail::where('id','=',$rowID)->get();
                    $lsuninstall=explode(',',$uninstall[0]->serial);
                    $rnoseri=array_diff($lsuninstall,$serials);
                    $returnit=['posmodule'=>'storage', 'module_id'=>0, 'status'=>''];
                    foreach ($rnoseri as $rtnoseri) {
                        $returnNoseri=StocksNoSeri::where('noseri','=',$rtnoseri)->update($returnit);
                        $seriallogs=[
                            'stockid'=>$request->stockid[$i],
                            'stockcode'=>'',
                            'serial'=>$rtnoseri,
                            'qty'=>1,
                            'transtype'=>4,
                            'module'=>'storage',
                            'moduleid'=>0,
                            'note'=>'Return To Storage: '.$olddata[0]->note,
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);
                    }
                    
                }else{
                   //Set Stock Non Serial
                    //Get Current Stock from Staff and reduce
                    $current=StocksPosition::where('stockid','=',$request->stockid[$rowID])->where('posmodule','=','staff')->where('module_id','=',$installerid)->get();
                    dd($current);
                    //dd($current[0]->id);
                    if ($current->count() > 0) {
                        $cqty=$current[0]->qty;
                        $nqty=(int)$cqty - (int)$request->qty[$rowID];
                        $dataupdate=['qty'=>$nqty];
                        $update=StocksPosition::where('id','=',$current[0]->id)->update($dataupdate);
                    
                    }else{
                        $stockpos=[
                            'posmodule'=>'staff',
                            'module_id'=>$installerid,
                            'stockid'=>$request->stockid[$rowID],
                            'qty'=>-1*$request->qty[$rowID],
                            'status'=>$request->status[$rowID],
                        ];
                        $update=StocksPosition::create($stockpos);
                    }
                    $seriallogs=[
                        'stockid'=>$request->stockid[$rowID],
                        'stockcode'=>'',
                        'serial'=>'',
                        'qty'=>$request->qty[$rowID],
                        'transtype'=>4,
                        'module'=>'install',
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
                        //if any add
                        $cqty=$currentLead[0]->qty;
                        $nqty=(int)$cqty + (int)$request->qty[$rowID];
                        $dataupdate=['qty'=>$nqty];
                        $update=StocksPosition::where('id','=',$currentLead[0]->id)->update($dataupdate);
                    
                    }else{
                        //if not avalable yet create
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
                        'transtype'=>4,
                        'module'=>'install',
                        'moduleid'=>$id,
                        'note'=>'Transfer Postion To Customer',
                        'createdbyid'=>Auth::user()->id,
                        'updatedbyid'=>Auth::user()->id,
                        'transcation_number'=>$noinstall,
                    ];
                    $logslist=StockLogs::create($seriallogs);
                    
                }
            }
            //dd($request);
        }
        
        //End Update
        // //Set Leads
        $data=[ 'packageid'=>$request->packageid ];
        try {
            $Leads=Leads::where('id','=',$leadid)->update($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
        // //Set Main Instalation
        $data=[
            'ipid'=>$request->ipaddr,
            'popid'=>$request->pops,
            'packageid'=>$request->packageid,
            'status'=>3,
            'installdate'=>$date,
            'updatedbyid'=>$request->updatebyid,
        ];
        $oldsdata=Instalation::where('id','=',$request->id)->get();
        try {
            $Installation=Instalation::where('id','=',$request->id)->update($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
       
        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Installation',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Installation Update',
            'olddata'=>json_encode($oldsdata),
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('installasi.index')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);


    }
    
    public function printjo($id){
        $instalation=Instalation::join('leads','leads.id','=','installation.leadid')
        ->join('users','users.id','=','installation.installerid')
        ->join('ip_address','ip_address.id','=','installation.ipid')
        ->join('pops','pops.id','=','installation.popid')
        ->join('services','services.id','=','installation.packageid')
        ->select('installation.*','users.first_name as teknisia','users.last_name as teknisib','ip_address.ip_address as ips','pops.name as pops',
        'leads.property_name as contact','leads.property_address as address','leads.property_city as city','leads.pic_contact as contactname','leads.pic_mobile as contactmobile','services.services_name as services')
        ->where('installation.id','=',$id)->get();

        $detail=InstalationDetail::join('stocks','stocks.id','=','installationdtl.stockid')
        ->select('installationdtl.*','stocks.stockname as stocknames','stocks.stockid as stockcodename','stocks.unit as unit','stocks.qtytype as type')
        ->where('installationdtl.noinstall','=',$instalation[0]->noinstall)->get();
        
        $fileName=str_replace('/','_',$instalation[0]->noinstall) . '.pdf';
        //dd(File::exists( URL::to('/storage/app/public/pdf/'.$fileName)));
        if (File::exists( URL::to('/storage/app/public/pdf/'.$fileName))){
            $returnfile= URL::to('/storage/app/public/pdf/'.$fileName);
            $results=array(
                'status'=>'exist',
                'file'=>$returnfile
            );
        }else{
            $pdf = PDF::loadView('installasi.printjo', compact('instalation','detail'));
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
        // return view('installasi.printjo',compact('instalation','detail'));
    }
    
    public function installed($id){
        $instalation=Instalation::join('leads','leads.id','=','installation.leadid')
        ->join('users','users.id','=','installation.installerid')
        ->join('ip_address','ip_address.id','=','installation.ipid')
        ->join('pops','pops.id','=','installation.popid')
        ->join('services','services.id','=','installation.packageid')
        ->select('installation.*','users.first_name as teknisia','users.last_name as teknisib','ip_address.ip_address as ips','pops.name as pops',
        'leads.property_name as contact','leads.property_address as address','leads.property_city as city','leads.pic_contact as contactname','leads.pic_mobile as contactmobile','services.services_name as services')
        ->where('installation.id','=',$id)->get();

        $detail=InstalationDetail::join('stocks','stocks.id','=','installationdtl.stockid')
        ->select('installationdtl.*','stocks.stockname as stocknames','stocks.stockid as stockcodename','stocks.unit as unit','stocks.qtytype as type')
        ->where('installationdtl.noinstall','=',$instalation[0]->noinstall)->get();
        
        $fileName=str_replace('/','_',$instalation[0]->noinstall) . '.pdf';
        //dd(File::exists( URL::to('/storage/app/public/pdf/'.$fileName)));
        if (File::exists( URL::to('/storage/app/public/pdf/'.$fileName))){
            $returnfile= URL::to('/storage/app/public/pdf/'.$fileName);
            $results=array(
                'status'=>'exist',
                'file'=>$returnfile
            );
        }else{
            $pdf = PDF::loadView('installasi.report', compact('instalation','detail'));
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

    public function cancel($id)
    {
        $Instalation=Instalation::where('id','=',$id)->get(); 
        $InstalationDetail=InstalationDetail::join('stocks','stocks.id','=','installationdtl.stockid')->where('noinstall','=',$Instalation[0]->noinstall)
        ->select('installationdtl.*','stocks.qtytype','stocks.stockid as stockcode')->get();
        $staffid=$Instalation[0]->instaled;
        $laststatus=$Instalation[0]->status;
        //Reset Ip status;
        $ips=[
            'leadid'=>null,
        ];
        $accdata=ipaddress::where('id','=',$Instalation[0]->ipid)->update($ips);


        //Update Status To Cancel
        $insUpdate=[
            'status'=>0
        ];
        $updInst=Instalation::where('id','=',$id)->update($insUpdate);
        
        if($laststatus==2){ 
            foreach ($InstalationDetail as $detail) {
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
                        'qty'=>(int)$getCurentPosition[0]->qty - (int)$detail->qty,
                    ];
                    $update=StocksPosition::where('id','=',$getCurentPosition[0]->id)->update($dataupdate2);
                    $seriallogs=[
                        'stockid'=>$request->stockid[$rowID],
                        'stockcode'=>'',
                        'serial'=>'',
                        'qty'=>$request->qty[$rowID],
                        'transtype'=>8,
                        'module'=>'install',
                        'moduleid'=>$id,
                        'note'=>'Cancel Instalation Return to Storage',
                        'createdbyid'=>Auth::user()->id,
                        'updatedbyid'=>Auth::user()->id,
                        'transcation_number'=>$noinstall,
                    ];
                    $logslist=StockLogs::create($seriallogs);

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
                            'transtype'=>8,
                            'module'=>'Installation',
                            'moduleid'=>$Instalation[0]->id,
                            'note'=>"cancel Installation",
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$detail->noinstall,
                        ];
                        $logslist=StockLogs::create($seriallogs);
                    }

                }
            }
        }
       
        $oldData=$Instalation[0];
        $olddata['ItemDetail']=$InstalationDetail;
        $oldData=json_encode($oldData);
        $nInstalation=Instalation::where('id','=',$id)->get(); 
        $nInstalationDetail=InstalationDetail::join('stocks','stocks.id','=','installationdtl.stockid')->where('noinstall','=',$nInstalation[0]->noinstall)->get();
        $newdata=$nInstalation;
        $newdata['ItemDetail']=$nInstalationDetail;
        $newdata=json_encode($newdata);
        $logs=[
            'module'=>'Installation',
            'moduleid'=>$id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Installation Canceled',
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
        $Installasi=Instalation::select('noinstall')->where('noinstall','LIKE','%'.$now.'%')->orderBy('id', 'DESC')->first();
        //dd($order->noorder);
        if(empty($Installasi)){
            $noorder="000001".$now;
        }else{
            $no=$Installasi->noinstall;
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
