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
        dd($request);
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
        $transfer_id=$Transfer->id;
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
                    
                    $noseri=[
                        'noseri'=>$serial,
                        'stockid'=>$item['stockid'],
                        'posmodule'=>"storage",
                        'module_id'=>0,
                    ];
                    try {
                        $StocksNoSeri=StocksNoSeri::create($noseri);
                    }  catch (\Exception $e) {
                        $status="failed";
                        $msg=$msg." ".$e->getMessage();
                    }
                    
                }
            }else{

                $current=StocksPosition::where('stockid','=',$item['stockid'])->where('posmodule','=','storeage')->get();
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
            }
        }
        if($status=="success"){
            $response=[
                'status'=>'success',
                'message'=>route('transfer_in.index')
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

        $order=Orders::where('id','=',$id)->get();
        $Vendor=Vendors::where('id','=',$order[0]->vendorid)->get();
        $details=OrdersDetail::join('stocks','stocks.id','=','orders_details.stockid')
        ->where('ordernumbers','=',$order[0]->id)
        ->select('orders_details.id as id','stocks.id as StockId','orders_details.qty as qty','orders_details.hpp as hpp','stocks.unit as unit','stocks.stockname as stockname','stocks.qtytype as qtytype','stocks.stockid as Stockcode')->get();
        //dd($details);
        $serial=OrdersSerialDetail::where('ordernumbers','=',$order[0]->id)->get();
        return view('orders.view',compact('order','details','Vendor','serial'));
        
    }

    public function iupdate(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        unset($data['_token']);
        $accdata=Leads::where('id','=',$request->id)->get();
        //dd($accdata);
        $leads=Leads::where('id',$request->id)->update($data);
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Leads',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Leads Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('leads/view/'.$request->id);
    }
    public function icheckExist(Request $request){
        dd($request);
        //$data=json_decode($request->data);
        $data=explode(',',$request->data);
        //var_dump($data);
        $status="success";
        $msg="";
        foreach ($data as $value) {
            $cx=StocksNoSeri::where('noseri','=',$value)->where('posmodule','=',"storage")->count();
            if($cx>0){
                $status="error";
                $msg=$msg.$value.",";
            }
        }
        $msg=substr($msg,0,-1);
        $return=['status'=>$status,'message'=>$msg];
        return json_encode($return);
    }
  
    public function getNoorder($prefixs){
        $bln=date("m");
        $thn=date("Y");
        $now=$prefixs.$bln."/".$thn;
        $Transfer=Transfer::select('transfer_id')->where('transfer_id','LIKE','%'.$now.'%')->orderBy('id', 'DESC')->first();
        //dd($order->noorder);
        if(empty($Transfer)){
            $noorder="000001".$now;
        }else{
            $no=$order->noorder;
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
