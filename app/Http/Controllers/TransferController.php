<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Stocks;
use App\Models\Transfer;
use App\Models\TransferDetail;
use App\Models\TransferSerial;
use App\Models\StocksNoSeri;
use App\Models\StocksPosition;
use App\Models\StockLogs;
use App\Models\DataLogs;

use DataTables;


class TransferController extends Controller
{
    public function iindex(Request $request){
        if ($request->ajax()) {
            $data = Transfer::join('users as a','a.id','=','transfer.transferdbyid')->join('users as b','b.id','=','transfer.recievedbyid')
            ->select('transfer.id as ID','transfer.transfer_id as NoTransfer' ,'transfer.transfer_date as Date' , 'transfer.from AS from','transfer.to As to','transfer.note as Note','a.first_name as TransferBy','b.first_name as ReceiveBy')
            ->where('transfer.transfertype','=',0)
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
                // ->editColumn('Email', function ($row) {
                //     return $row->Email ?: '-';
                // })
               
                ->make(true);
        }

        return view('transfer_in.index');
    }

    public function icreate()
    {
        $Users=User::get();
        $Stocks=Stocks::select('id','stockid','stockname','qtytype','unit')->get();
        return view('transfer_in.create',compact('Users','Stocks'));
    }
    public function istore(Request $request){
        //dd($request);
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $transfer_id=$this->getNoorder('TP');
        $old_date = explode('/', $request->transfer_date); 
        $date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
        $status="success";
        $msg="";
        $data=[
            'transfer_id'=>$transfer_id,
            'transfer_date'=>$date,
            'from'=>$request->from,
            'to'=>$request->to,
            'transferdbyid'=>$request->transferdbyid,
            'recievedbyid'=>$request->recievedbyid,
            'transfertype'=>$request->transfertype,
            'note'=>$request->note,
            'createdbyid'=>$request->createdbyid,
            'updatedbyid'=>$request->updatedbyid,
            'transcation_number'=>$transfer_id,
        ];
        
        try {
            $Transfer=Transfer::create($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
        $tID=$Transfer->id;
        //var_dump($data);
        //$orderid="1";
        $items=$request->Item_List;
        foreach ($items as $item) {
            $lsitem=[
                'transfer_id'=>$transfer_id,
                'stockid'=>$item['stockid'],
                'qty'=>$item['qty'],
            ];
            
            try {
                $dtl=TransferDetail::create($lsitem);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage();
            }
            //var_dump($lsitem);
            if($item['qtytype']==1){
                $serials = explode(',', $item['lsnoseri']); 
                foreach ($serials as $serial) {
                    $lserial=[
                        'transfer_id'=>$transfer_id,
                        'stockid'=>$item['stockid'],
                        'stockcode'=>$item['stockcode'],
                        'serial'=>$serial,
                    ];
                    //var_dump($lserial);
                    try {
                        $ListSerial=TransferSerial::create($lserial);
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
                        'module'=>'transfer',
                        'moduleid'=>$tID,
                        'note'=>$request->note,
                        'createdbyid'=>$request->createdbyid,
                        'updatedbyid'=>$request->updatedbyid,
                        'transcation_number'=>$transfer_id,
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
                //     'module'=>'transfer',
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
            'module'=>'Transfer',
            'moduleid'=>$tID,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Transfer Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('transfer_in.iindex')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);
        
    }

    public function iview($id){

        $Transfer=Transfer::where('id','=',$id)->get();
        $TransferSerial=TransferSerial::where('transfer_id','=',$Transfer[0]->transfer_id)->get();
        $TransferDetail=TransferDetail::join('stocks','stocks.id','=','transfer_detail.stockid')->where('transfer_detail.transfer_id','=',$Transfer[0]->transfer_id)
        ->select('stocks.id as StockId','stocks.unit as unit','stocks.stockname as stockname','stocks.qtytype as qtytype','stocks.stockid as Stockcode','transfer_detail.*')->get();
        $transferdbyid=User::where('id','=',$Transfer[0]->transferdbyid)->get();
        $recievedbyid=User::where('id','=',$Transfer[0]->recievedbyid)->get();
        $createdbyid=User::where('id','=',$Transfer[0]->createdbyid)->get();
        $updatedbyid=User::where('id','=',$Transfer[0]->updatedbyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Transfer')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
            ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        return view('transfer_in.view',compact('Transfer','TransferSerial','TransferDetail','recievedbyid','transferdbyid','logs','updatedbyid','createdbyid'));
        
    }

   
    public function icheckExist(Request $request){
        //dd($request);
        //$data=json_decode($request->data);
        $data=explode(',',$request->data);
        //var_dump($data);
        $status="success";
        $msg="";
        
        foreach ($data as $value) {

            if($request->from=="purchase"){
                $cx=StocksNoSeri::where('noseri','=',$value)->count();
                if($cx>0){
                    $status="error";
                    $msg=$msg.$value." Already Registered on system. \n";
                }
            }
            if($request->from=="staff"){
                $cx=StocksNoSeri::where('noseri','=',$value)->where('posmodule','=',$request->from)->where('module_id','=',$request->position)->count();
                if($cx<=0){
                    $status="error";
                    $msg=$msg.$value." Not on staff anymore. \n";
                }
            }
            
        }
        
        
        $msg=substr($msg,0,-1);
        $return=['status'=>$status,'message'=>$msg];
        return json_encode($return);
    }
  
    public function oindex(Request $request){
        if ($request->ajax()) {
            $data = Transfer::join('users as a','a.id','=','transfer.transferdbyid')->join('users as b','b.id','=','transfer.recievedbyid')
            ->select('transfer.id as ID','transfer.transfer_id as NoTransfer' ,'transfer.transfer_date as Date' , 'transfer.from AS from','transfer.to As to','transfer.note as Note','a.first_name as TransferBy','b.first_name as ReceiveBy')
            ->where('transfer.transfertype','=',1)
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
                // ->editColumn('Email', function ($row) {
                //     return $row->Email ?: '-';
                // })
               
                ->make(true);
        }

        return view('transfer_out.index');
    }

    public function ocreate()
    {
        $Users=User::get();
        $Stocks=Stocks::select('id','stockid','stockname','qtytype','unit')->get();
        return view('transfer_out.create',compact('Users','Stocks'));
    }
    public function ostore(Request $request){
        //dd($request);
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        $transfer_id=$this->getNoorder('TP');
        $old_date = explode('/', $request->transfer_date); 
        $date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
        $status="success";
        $msg="";
        $data=[
            'transfer_id'=>$transfer_id,
            'transfer_date'=>$date,
            'from'=>$request->from,
            'to'=>$request->to,
            'transferdbyid'=>$request->transferdbyid,
            'recievedbyid'=>$request->recievedbyid,
            'transfertype'=>$request->transfertype,
            'note'=>$request->note,
            'createdbyid'=>$request->createdbyid,
            'updatedbyid'=>$request->updatedbyid,
        ];
        
        try {
            $Transfer=Transfer::create($data);
        }  catch (\Exception $e) {
            $status="failed";
            $msg=$msg." ".$e->getMessage();
        }
        $tID=$Transfer->id;
        //var_dump($data);
        //$orderid="1";
        $items=$request->Item_List;
        foreach ($items as $item) {
            $lsitem=[
                'transfer_id'=>$transfer_id,
                'stockid'=>$item['stockid'],
                'qty'=>$item['qty'],
            ];
            
            try {
                $dtl=TransferDetail::create($lsitem);
            }  catch (\Exception $e) {
                $status="failed";
                $msg=$msg." ".$e->getMessage();
            }
            //var_dump($lsitem);
            if($item['qtytype']==1){
                $serials = explode(',', $item['lsnoseri']); 
                foreach ($serials as $serial) {
                    $lserial=[
                        'transfer_id'=>$transfer_id,
                        'stockid'=>$item['stockid'],
                        'stockcode'=>$item['stockcode'],
                        'serial'=>$serial,
                    ];
                    //var_dump($lserial);
                    try {
                        $ListSerial=TransferSerial::create($lserial);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage();
                    }
                    
                    
                    try {
                        // $StocksNoSeri=StocksNoSeri::create($noseri);
                        $noseri=[
                            // 'noseri'=>$serial,
                            // 'stockid'=>$item['stockid'],
                            'posmodule'=>$request->to,
                            'module_id'=>$request->recievedbyid,
                        ];
                        $StocksNoSeri=StocksNoSeri::where('noseri',$serial)->update($noseri);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage();
                    }
                    
                    $seriallogs=[
                        'stockid'=>$item['stockid'],
                        'stockcode'=>$item['stockcode'],
                        'serial'=>$serial,
                        'qty'=>1,
                        'transtype'=>3,
                        'module'=>'transfer',
                        'moduleid'=>$tID,
                        'note'=>$request->note,
                        'createdbyid'=>$request->createdbyid,
                        'updatedbyid'=>$request->updatedbyid,
                        'transcation_number'=>$transfer_id,
                    ];
                    $logslist=StockLogs::create($seriallogs);
                }

            }else{

                $current=StocksPosition::where('stockid','=',$item['stockid'])->where('posmodule','=','storage')->get();
                //dd($current[0]->id);
                if ($current->count() > 0) {
                    $cqty=$current[0]->qty;
                    $nqty=(int)$cqty - (int)$item['qty'];
                    $dataupdate=['qty'=>$nqty];
                    try {
                        $update=StocksPosition::where('id','=',$current[0]->id)->update($dataupdate);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage();
                    }
                    
                }else{
                    $stockpos=[
                        'posmodule'=>$request->to,
                        'module_id'=>$request->recievedbyid,
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
                $seriallogs=[
                    'stockid'=>$item['stockid'],
                    'stockcode'=>$item['stockcode'],
                    'serial'=>$serial,
                    'qty'=>1,
                    'transtype'=>3,
                    'module'=>'transfer',
                    'moduleid'=>$tID,
                    'note'=>$request->note,
                    'createdbyid'=>$request->createdbyid,
                    'updatedbyid'=>$request->updatedbyid,
                    'transcation_number'=>$transfer_id,
                ];
                $logslist=StockLogs::create($seriallogs);
            }
            
        }
        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Transfer',
            'moduleid'=>$tID,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Transfer Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('transfer_out.oindex')
            ];
        }else{
            $response=[
                'status'=>'failed',
                'message'=>$msg
            ];
        }
        return json_encode($response);
        
    }

    public function oview($id){

        $Transfer=Transfer::where('id','=',$id)->get();
        $TransferSerial=TransferSerial::where('transfer_id','=',$Transfer[0]->transfer_id)->get();
        $TransferDetail=TransferDetail::join('stocks','stocks.id','=','transfer_detail.stockid')->where('transfer_detail.transfer_id','=',$Transfer[0]->transfer_id)
        ->select('stocks.id as StockId','stocks.unit as unit','stocks.stockname as stockname','stocks.qtytype as qtytype','stocks.stockid as Stockcode','transfer_detail.*')->get();
        $transferdbyid=User::where('id','=',$Transfer[0]->transferdbyid)->get();
        $recievedbyid=User::where('id','=',$Transfer[0]->recievedbyid)->get();
        $createdbyid=User::where('id','=',$Transfer[0]->createdbyid)->get();
        $updatedbyid=User::where('id','=',$Transfer[0]->updatedbyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Transfer')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
            ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        return view('transfer_in.view',compact('Transfer','TransferSerial','TransferDetail','recievedbyid','transferdbyid','logs','updatedbyid','createdbyid'));
        
    }

   
    public function ocheckExist(Request $request){
        //dd($request);
        //$data=json_decode($request->data);
        $data=explode(',',$request->data);
        //var_dump($data);
        $status="success";
        $msg="";
        
        foreach ($data as $value) {

            if($request->from=="storage"){
                $cx=StocksNoSeri::where('noseri','=',$value)->where('posmodule','=',$request->from)->count();
                if($cx!=1){
                    $status="error";
                    $msg=$msg."Stock Number:".$value." Not in Storage anymore\n";
                }
            }
            // if($request->from=="staff"){
            //     $cx=StocksNoSeri::where('noseri','=',$value)->where('posmodule','=',$request->from)->where('module_id','=',$request->position)->count();
            //     if($cx<=0){
            //         $status="error";
            //         $msg=$msg.$value." sudah tidak di teknisi lagi. \n";
            //     }
            // }
            
        }
        
        
        $msg=substr($msg,0,-1);
        $return=['status'=>$status,'message'=>$msg];
        return json_encode($return);
    }
    public function getNoorder($prefixs){
        $bln=date("m");
        $thn=date("Y");
        $now="/".$prefixs."/".$bln."/".$thn;
        $Transfer=Transfer::select('transfer_id')->where('transfer_id','LIKE','%'.$now.'%')->orderBy('id', 'DESC')->first();
        //dd($order->noorder);
        if(empty($Transfer)){
            $noorder="000001".$now;
        }else{
            $no=$Transfer->transfer_id;
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
