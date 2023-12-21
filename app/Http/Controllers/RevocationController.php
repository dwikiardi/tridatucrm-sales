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
use App\Models\Revocation;
use App\Models\RevocationDetail;
use App\Models\StocksNoSeri;
use App\Models\Services;

use DB;
use DataTables;
use PDF;
use URL;
use Storage;
use File;

class RevocationController extends Controller
{
    public function index(Request $request)//OK
    {
        if ($request->ajax()) {
            $data = Revocation::join('users as a','a.id','=','revocation.staffid')->join('leads as b','b.id','=','revocation.leadid')
            ->select('revocation.id as ID','revocation.notrans as notrans' ,'revocation.date AS Date' , 'revocation.status AS status','a.first_name as staff','b.property_name as customer')
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
                            
                            $actionBtn = '<a class="printjo btn btn-primary btn-sm" data-id="'.$row->ID.'" ">Process</a> ';
                            $actionBtn = $actionBtn . '<a class="cancel btn btn-danger btn-sm" data-id="'.$row->ID.'">Cancel</a> ';
                            break;
                        case '2':
                            $actionBtn = '<a class="printjo btn btn-primary btn-sm" data-id="'.$row->ID.'" ">Job Order</a> ';
                            $actionBtn = $actionBtn . '<a  class="finish btn btn-success btn-sm" data-id="'.$row->ID.'" href="'. route('revocation.finish',$row->ID) .'">Finish</a> ';
                            $actionBtn = $actionBtn . '<a class="cancel btn btn-danger btn-sm" data-id="'.$row->ID.'" >Cancel</a> ';
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
        
        return view('revocation.index');
    }

    public function create()
    {
        $Users=User::select('id','first_name','last_name')->get();
        $Customers=Leads::leftJoin('pops','pops.id','=','leads.popid')
        ->leftJoin('ip_address','ip_address.leadid','=','leads.id')
        ->leftJoin('services','services.id','=','leads.packageid')
        ->select('leads.id','leads.property_name','leads.property_address','pops.name as popname','ip_address.ip_address','leads.pic_contact','leads.pic_mobile','services.services_name as services','ip_address.id as ipid','leads.packageid as packageid','leads.popid as popid')->get();
        //dd($Customers);
        $pops=pops::get();
        $ipaddress=ipaddress::where('peruntukan','=','')->orWhere('peruntukan', '=', null)->get();
        
        return view('revocation.create',compact('Users','Customers','ipaddress','pops'));
    }

    public function checkCustomer($id)
    {
        $installed=DB::select("SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, stocks_position.qty, stocks.stockname, stocks.unit, '' AS noseri FROM stocks INNER JOIN stocks_position ON stocks.id = stocks_position.stockid WHERE stocks_position.posmodule = 'leads' AND stocks_position.module_id = '".$id."' UNION ALL SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, '1' AS qty, stocks.stockname, stocks.unit, stocks_no_seri.noseri as noseri FROM stocks INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid WHERE stocks_no_seri.posmodule = 'leads' AND stocks_no_seri.module_id = '".$id."';");       
        return json_encode($installed);
    }
    public function view($id)
    {
        $revocation=Revocation::join('leads','leads.id','=','revocation.leadid')
        ->join('ip_address','ip_address.leadid','=','leads.id')
        ->join('pops','pops.id','=','leads.popid')
        ->join('services','services.id','=','leads.packageid')
        ->join('users','users.id','=','revocation.staffid')
        ->select('revocation.*','ip_address.ip_address as ips','leads.property_name as customer','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib','services.services_name as services')
        ->where('revocation.id','=',$id)->get();
        $idx=$revocation[0]->leadid;
        $installed=DB::select("SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, stocks_position.qty, stocks.stockname, stocks.unit, '' AS noseri FROM stocks INNER JOIN stocks_position ON stocks.id = stocks_position.stockid WHERE stocks_position.posmodule = 'leads' AND stocks_position.module_id = ".$idx." UNION ALL SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, '1' AS qty, stocks.stockname, stocks.unit, stocks_no_seri.noseri as noseri FROM stocks INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid WHERE stocks_no_seri.posmodule = 'leads' AND stocks_no_seri.module_id = ".$idx.";");       
        //dd($installed);
        return view('revocation.view',compact('revocation','installed'));
    }

    public function getNoorder($prefixs){
        $bln=date("m");
        $thn=date("Y");
        $now="/".$prefixs."/".$bln."/".$thn;
        $Revocation=Revocation::select('notrans')->where('notrans','LIKE','%'.$now.'%')->orderBy('id', 'DESC')->first();
        //dd($order->noorder);
        if(empty($Revocation)){
            $noorder="000001".$now;
        }else{
            $no=$Revocation->notrans;
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

    public function store(Request $request){
        // dd($request);
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $notrans=$this->getNoorder('REV');
        $old_date = explode('/', $request->date); 
        $date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
        $status="success";
        $msg="";
        $data=[
            'notrans'=>$notrans,
            'date'=>$date,
            'leadid'=>$request->customer,
            'ipid'=>$request->ipid,
            'pops'=>$request->popid,
            'packageid'=>$request->packageid,
            'staffid'=>$request->staffid,
            'status'=>1,
            'createdbyid'=>$request->createbyid,
            'updatedbyid'=>$request->updatebyid,
        ];
        //dd($data);
        try {
            $Revocation=Revocation::create($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
        $tID=$Revocation->id;
        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Revocation',
            'moduleid'=>$tID,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Revocation Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('revocation.index')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);
        
    }

    public function printjo($id)
    {
        $update=['status'=>2];
        $revocation=Revocation::where('id','=',$id)->update($update);
        $revocation=Revocation::join('leads','leads.id','=','revocation.leadid')
        ->join('ip_address','ip_address.leadid','=','leads.id')
        ->join('pops','pops.id','=','leads.popid')
        ->join('services','services.id','=','leads.packageid')
        ->join('users','users.id','=','revocation.staffid')
        ->select('revocation.*','ip_address.ip_address as ips','leads.property_name as customer','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib','services.services_name as services')
        ->where('revocation.id','=',$id)->get();
        $idx=$revocation[0]->leadid;
        
        $detail=DB::select("SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, stocks_position.qty, stocks.stockname, stocks.unit, '' AS noseri FROM stocks INNER JOIN stocks_position ON stocks.id = stocks_position.stockid WHERE stocks_position.posmodule = 'leads' AND stocks_position.module_id = ".$idx." UNION ALL SELECT stocks.id, stocks.stockid AS stockcodename, stocks.qtytype, '1' AS qty, stocks.stockname, stocks.unit, stocks_no_seri.noseri as noseri FROM stocks INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid WHERE stocks_no_seri.posmodule = 'leads' AND stocks_no_seri.module_id = ".$idx.";");       
        //dd($installed);
        $revocations[0]=$revocation[0];
        $revocations[0]['ListItems']=$detail;
        $newdata=json_encode($revocations);
        $logs=[
            'module'=>'Revocation',
            'moduleid'=>$id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Revocation Process',
            'olddata'=> json_encode(["status" => 1 ]),
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        $fileName=str_replace('/','_',$revocation[0]->notrans) . '.pdf';
        //dd(File::exists( URL::to('/storage/app/public/pdf/'.$fileName)));
        if (File::exists( URL::to('/storage/app/public/pdf/'.$fileName))){
            $returnfile= URL::to('/storage/app/public/pdf/'.$fileName);
            $results=array(
                'status'=>'exist',
                'file'=>$returnfile
            );
        }else{
            $pdf = PDF::loadView('revocation.printjo', compact('revocation','detail'));
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
        $update=['status'=>0];
        $revocation=Revocation::where('id','=',$id)->update($update);
        
        $logs=[
            'module'=>'Revocation',
            'moduleid'=>$id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Revocation Cancel',
            'olddata'=> '',
            'newdata'=>json_encode(['status'=>0])
        ];
        $ids=DataLogs::create($logs);
        $results=array(
            'status'=>'success',
            'message'=> 'Cancelation success..' 
        );
    
        

        return json_encode($results);   
    }

    public function finish($id)
    {
        
        $revocation=Revocation::join('leads','leads.id','=','revocation.leadid')
        ->join('ip_address','ip_address.leadid','=','leads.id')
        ->join('pops','pops.id','=','leads.popid')
        ->join('services','services.id','=','leads.packageid')
        ->join('users','users.id','=','revocation.staffid')
        ->select('revocation.*','ip_address.ip_address as ips','leads.property_name as customer','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib','services.services_name as services')
        ->where('revocation.id','=',$id)->get();
        $idx=$revocation[0]->leadid;
        
        $detail=DB::select("SELECT stocks.id, stocks.stockid as stockid, stocks.stockid AS stockcodename, stocks.qtytype, stocks_position.qty, stocks.stockname, stocks.unit, '' AS noseri FROM stocks INNER JOIN stocks_position ON stocks.id = stocks_position.stockid WHERE stocks_position.posmodule = 'leads' AND stocks_position.module_id = ".$idx." UNION ALL SELECT stocks.id, stocks.stockid as stockid, stocks.stockid AS stockcodename, stocks.qtytype, '1' AS qty, stocks.stockname, stocks.unit, stocks_no_seri.noseri as noseri FROM stocks INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid WHERE stocks_no_seri.posmodule = 'leads' AND stocks_no_seri.module_id = ".$idx.";");       
        //dd($installed);
        return view('revocation.finish',compact('revocation','detail'));
    }

    public function refinish(Request $request){
        //dd($request);
        //Change IP Allocation
        $id=$request->id;
        $olddata=Revocation::where('revocation.id','=',$id)->get();
        $leadid=$olddata[0]->leadid;
       
        $status="success";
        $msg="";
        $notrans=$olddata[0]->notrans;
        // //dd($olddata[0]->ipid != $request->ipaddr);
        //reset old IP data
        $IPAdd=ipaddress::where('leadid','=',$olddata[0]->leadid)->get();
        $ipold=json_encode($IPAdd);
        $resetIP=['leadid'=>null];
        foreach ($IPAdd as $lsIP) {
            try {
                $resetit=ipaddress::where('id','=',$lsIP->id)->update($resetIP);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage();
            }
            $logs=[
                'module'=>'ip_address',
                'moduleid'=>$lsIP->id,
                'createbyid'=>Auth::user()->id,
                'logname'=>'Reset Customer because Revocation',
                'olddata'=>$ipold,
                'newdata'=>json_encode($resetIP)
            ];
            $ids=DataLogs::create($logs);
        }
        
        
        //Update Leads
        $leadupd=[
            'popid'=>null,
            'packageid'=>null,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updatebyid'=>$request->updatebyid,
        ];
        $leads=Leads::where('id','=',$leadid)->update($leadupd);
        //End Change


        //Update Instalation Detail
        $InItem=array();
        $rows=$request->indexs;
        for ($i=0; $i < $rows; $i++) { 
            if($request->qty[$i]>=1 || $request->qty[$i]!='' || $request->qty[$i]!=null){
                $rowID=$i;
                if($request->qtytype[$rowID] == 1 ){
                    $instaledserial=count($request->serials[$rowID]);
                }else{
                    $instaledserial=0;
                }
                
                if($request->qtytype[$rowID] == 1 ){
                    //Set Installser No Seri From Teknisi to Customer/Lead
                    $serials=$request->serials[$rowID];
                    $lsserial=[
                        'posmodule'=>'storage',
                        'module_id'=>0,
                        'status'=>$request->status[$rowID],
                    ];
                    foreach($serials as $noseri){
                        $setnoseri=StocksNoSeri::where('noseri','=',$noseri)->update($lsserial);
                        $seriallogs=[
                            'stockid'=>$request->stockid[$i],
                            'stockcode'=>'',
                            'serial'=>$noseri,
                            'qty'=>1,
                            'transtype'=>5,
                            'module'=>'revocation',
                            'moduleid'=>$id,
                            'note'=>"Revocation Customer",
                            'createdbyid'=>Auth::user()->id,
                            'updatedbyid'=>Auth::user()->id,
                            'transcation_number'=>$notrans,
                        ];
                        $logslist=StockLogs::create($seriallogs);
                    }
                    $revserial=implode(', ', $request->serials[$i]);
                    
                }else{
                    //Set Stock Non Serial
                    //Get Current Stock from Customer and reduce
                    $current=StocksPosition::where('stockid','=',$request->stockid[$rowID])->where('posmodule','=','leads')->where('module_id','=',$leadid)->get();
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
                        'transtype'=>5,
                        'module'=>'revocation',
                        'moduleid'=>$id,
                        'note'=>'Reduce From Customer',
                        'createdbyid'=>Auth::user()->id,
                        'updatedbyid'=>Auth::user()->id,
                        'transcation_number'=>$notrans,
                    ];
                    $logslist=StockLogs::create($seriallogs);
    
                    //Get Current Stock On Storage and Add It
                    $currentLead=StocksPosition::where('stockid','=',$request->stockid[$rowID])->where('posmodule','=','storage')->where('module_id','=',0)->get();
                    if ($currentLead->count() > 0) {
                        //if any add
                        $cqty=$currentLead[0]->qty;
                        $nqty=(int)$cqty + (int)$request->qty[$rowID];
                        $dataupdate=['qty'=>$nqty];
                        $update=StocksPosition::where('id','=',$currentLead[0]->id)->update($dataupdate);
                    
                    }else{
                        //if not avalable yet create
                        $stockpos=[
                            'posmodule'=>'storage',
                            'module_id'=>0,
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
                        'transtype'=>5,
                        'module'=>'Revocation',
                        'moduleid'=>$id,
                        'note'=>'Transfer Postion To storage',
                        'createdbyid'=>Auth::user()->id,
                        'updatedbyid'=>Auth::user()->id,
                        'transcation_number'=>$notrans,
                    ];
                    $logslist=StockLogs::create($seriallogs);
                    $revserial='';
                }

                $ditem=[
                    'notrans'=>$notrans,
                    'stockid'=>$request->stockid[$i],
                    'qty'=>$request->iqty[$i],
                    'serial'=>$request->inserial[$i],
                    'status'=>$request->status[$i],
                    'revserial'=>$revserial,
                    'revqty'=>$request->qty[$i],
                ];
                try {
                    $RevocationDetail=RevocationDetail::create($ditem);
                }  catch (\Exception $e) {
                    $status="failed";
                    $msg=$msg." ".$e->getMessage();
                }
            }
           
        }
        
        //End Update
       
        // //Set Main Revocation
        $data=[
            'status'=>3,
        ];
        $oldsdata=Revocation::where('id','=',$id)->get();
        try {
            $Installation=Revocation::where('id','=',$request->id)->update($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
        $ndata=Revocation::where('id','=',$id)->get();
        $items=RevocationDetail::where('notrans','=',$notrans)->get();
        $ndata[0]['ListItem']=$items;
        $newdata=json_encode($ndata);
        $logs=[
            'module'=>'Revocation',
            'moduleid'=>$id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Revocation Finish',
            'olddata'=>json_encode($oldsdata),
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('revocation.index')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);


    }

    public function installed($id)
    {
       
        $revocation=Revocation::join('leads','leads.id','=','revocation.leadid')
        ->join('ip_address','ip_address.id','=','revocation.ipid')
        ->join('pops','pops.id','=','revocation.pops')
        ->join('services','services.id','=','revocation.packageid')
        ->join('users','users.id','=','revocation.staffid')
        ->select('revocation.*','ip_address.ip_address as ips','leads.property_name as customer','leads.property_address as address','pops.name as pops','users.first_name as teknisia','users.last_name as teknisib','services.services_name as services')
        ->where('revocation.id','=',$id)->get();
        //dd($revocation);
        $notrans=$revocation[0]->notrans;
        $detail=RevocationDetail::join('stocks','stocks.id','=','revocation_detail.stockid')->where('notrans','=',$notrans)
        ->select('revocation_detail.*','stocks.stockid AS stockcodename', 'stocks.qtytype', 'stocks.stockname', 'stocks.unit')->get();
       // dd($detail);
       
        $fileName=str_replace('/','_',$revocation[0]->notrans) . '.pdf';
        //dd(File::exists( URL::to('/storage/app/public/pdf/'.$fileName)));
        if (File::exists( URL::to('/storage/app/public/pdf/'.$fileName))){
            $returnfile= URL::to('/storage/app/public/pdf/'.$fileName);
            $results=array(
                'status'=>'exist',
                'file'=>$returnfile
            );
        }else{
            $pdf = PDF::loadView('revocation.report', compact('revocation','detail'));
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

}
