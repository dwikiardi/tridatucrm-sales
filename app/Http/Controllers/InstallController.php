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

use DB;
use DataTables;


class InstallController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Instalation::join('users as a','a.id','=','installation.installerid')->join('leads as b','b.id','=','installation.leadid')
            ->select('installation.id as ID','installation.noinstall as NoInstallation' ,'installation.installdate as Date' , 'installation.status AS status','installation.note as Note','a.first_name as InstallationBy','b.property_name as customer')
            ->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn="";
                    if(($row->status == 1) || ($row->status == 2)){
                        $actionBtn = '<a class="edit btn btn-success btn-sm" data-id="'.$row->ID.'">Finish</a> <a  class="delete btn btn-danger btn-sm" data-id="'.$row->ID.'">Report</a>';
                        $actionBtn = $actionBtn . '<a class="edit btn btn-success btn-sm" data-id="'.$row->ID.'">Process</a> <a  class="delete btn btn-danger btn-sm" data-id="'.$row->ID.'">Report</a>';
                        $actionBtn = $actionBtn .'<a class="edit btn btn-success btn-sm" data-id="'.$row->ID.'">Cancel</a> <a  class="delete btn btn-danger btn-sm" data-id="'.$row->ID.'">Report</a>';
                        //$actionBtn=$row->ID;
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
               
                ->make(true);
        }

        return view('installasi.index');
    }

    public function create()
    {
        $Users=User::select('id','first_name','last_name')->get();
        $Category=StockCategorys::get();
        $Stocks=Stocks::select('id','stockid','stockname','qtytype','unit','categoryid')->get();
        $Customers=Leads::select('id','property_name','property_address')->get();
        $stockPos=StocksPosition::where('posmodule','=','staff')->get();
        $pops=pops::get();
        $StocksNoSeri=StocksNoSeri::select('stockid','posmodule','noseri','module_id')->where('posmodule','=','staff')->get();
        $ipaddress=ipaddress::where('peruntukan','=','')->orWhere('peruntukan', '=', null)->get();
        //dd($ipaddress);
        $mstock=DB::select("select stocks.id,stocks.stockid,stocks.stockname,stocks.categoryid,stocks.unit,stocks_position.posmodule from stocks inner JOIN stocks_position on stocks.id=stocks_position.stockid WHERE stocks_position.posmodule='staff' UNION ALL select stocks.id,stocks.stockid,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule from stocks inner JOIN stocks_no_seri on stocks.id=stocks_no_seri.stockid WHERE stocks_no_seri.posmodule='staff' GROUP BY stocks.id,stocks.stockid,stocks.stockname,stocks.categoryid,stocks.unit,stocks_no_seri.posmodule;");
        return view('installasi.create',compact('Users','Stocks','Customers','Category','StocksNoSeri','stockPos','mstock','ipaddress','pops'));
    }

    public function store(Request $request){
        dd($request);
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $installation_id=$this->getNoorder('TP');
        $old_date = explode('/', $request->installation_date); 
        $date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
        $status="success";
        $msg="";
        $data=[
            'installation_id'=>$installation_id,
            'installation_date'=>$date,
            'from'=>$request->from,
            'to'=>$request->to,
            'installationdbyid'=>$request->installationdbyid,
            'recievedbyid'=>$request->recievedbyid,
            'installationtype'=>$request->installationtype,
            'note'=>$request->note,
            'createdbyid'=>$request->createdbyid,
            'updatedbyid'=>$request->updatedbyid,
            'transcation_number'=>$installation_id,
        ];
        
        try {
            $Installation=Installation::create($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
        $tID=$Installation->id;
        //var_dump($data);
        //$orderid="1";
        $items=$request->Item_List;
        foreach ($items as $item) {
            $lsitem=[
                'installation_id'=>$installation_id,
                'stockid'=>$item['stockid'],
                'qty'=>$item['qty'],
            ];
            
            try {
                $dtl=InstalltionDetail::create($lsitem);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage();
            }
            //var_dump($lsitem);
            if($item['qtytype']==1){
                $serials = explode(',', $item['lsnoseri']); 
                foreach ($serials as $serial) {
                    $lserial=[
                        'installation_id'=>$installation_id,
                        'stockid'=>$item['stockid'],
                        'stockcode'=>$item['stockcode'],
                        'serial'=>$serial,
                    ];
                    //var_dump($lserial);
                    try {
                        $ListSerial=InstallationSerial::create($lserial);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage();
                    }
                    
                   
                    try {
                        if($request->from=='purchase'){
                            $noseri=[
                                'noseri'=>$serial,
                                'stockid'=>$item['stockid'],
                                'posmodule'=>"storage",
                                'module_id'=>0,
                            ];
                            $StocksNoSeri=StocksNoSeri::create($noseri);
                        }else{
                            $noseri=[
                                // 'noseri'=>$serial,
                                // 'stockid'=>$item['stockid'],
                                'posmodule'=>"storage",
                                'module_id'=>0,
                            ];
                            $StocksNoSeri=StocksNoSeri::where('noseri',$serial)->update($noseri);
                        }
                        
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage();
                    }
                    switch ($request->from) {
                        case 'purchase':
                            $transtype=1;
                            break;
                        case 'staff':
                            $transtype=2;
                            break;
                    }
                    $seriallogs=[
                        'stockid'=>$item['stockid'],
                        'stockcode'=>$item['stockcode'],
                        'serial'=>$serial,
                        'qty'=>1,
                        'transtype'=>$transtype,
                        'module'=>'installation',
                        'moduleid'=>$tID,
                        'note'=>$request->note,
                        'createdbyid'=>$request->createdbyid,
                        'updatedbyid'=>$request->updatedbyid,
                        'transcation_number'=>$installation_id,
                    ];
                    $logslist=StockLogs::create($seriallogs);
                }

            }else{

                $current=StocksPosition::where('stockid','=',$item['stockid'])->where('posmodule','=','storage')->get();
                //dd($current[0]->id);
                if ($current->count() > 0) {
                    $cqty=$current[0]->qty;
                    $nqty=(int)$cqty + (int)$item['qty'];
                    $dataupdate=['qty'=>$nqty];
                    try {
                        $update=StocksPosition::where('id','=',$current[0]->id)->update($dataupdate);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage();
                    }
                    
                }else{
                    $stockpos=[
                        'posmodule'=>'storage',
                        'module_id'=>0,
                        'stockid'=>$item['stockid'],
                        'qty'=>$item['qty'],
                    ];
                    try {
                        $current=StocksPosition::create($stockpos);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg .$e->getMessage();
                    }
                    
                }
                // $seriallogs=[
                //     'stockid'=>$item['stockid'],
                //     'stockcode'=>$item['stockcode'],
                //     'serial'=>$serial,
                //     'qty'=>1,
                //     'transtype'=>$transtype,
                //     'module'=>'installation',
                //     'moduleid'=>$tID,
                //     'note'=>$request->note,
                //     'createdbyid'=>$request->createdbyid,
                //     'updatedbyid'=>$request->updatedbyid,
                // ];
                // $logslist=StockLogs::create($seriallogs);
            }
            
        }
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
                'message'=>route('installation_in.iindex')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);
        
    }
    public function view()
    {
        $Users=User::get();
        $Stocks=Stocks::select('id','stockid','stockname','qtytype','unit')->get();
        return view('installasi.create',compact('Users','Stocks'));
    }
}
