<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Stocks;
use App\Models\User;
use App\Models\DataLogs;
use App\Models\StockCategorys;
use App\Models\Stocklist;

use DataTables;

class StocksController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = Stocks::join('stock_categories','stock_categories.id','=','stocks.categoryid')
            ->select('stocks.id as ID' , 'stocks.stockid AS StockID','stocks.stockname as Name' , 'stocks.desk AS Desk','stock_categories.category_name as Category','stocks.unit As Unit','stocks.qtytype As Type',)
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
                ->editColumn('Type', function ($row) {
                    if($row->Type==1){
                        return "By Summary of Serial Number";
                    }else{
                        return "Qty";
                    }
                    
                })
                ->editColumn('Desk', function ($row) {
                    if($row->Desk==""){
                        return "-";
                    }else{
                        return $row->Desk;
                    }
                    
                })
                ->make(true);
        }

        return view('stocks.index');
    }

    public function create()
    {
        $categorys = StockCategorys::get();
        return view('stocks.create',compact('categorys'));
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        //dd($request->all());
        $ids=Stocks::create($request->all());

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Stocks',
            'moduleid'=>$ids->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Products Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('product');
    }

    public function view($id){
        $stocks=Stocks::join('stock_categories','stock_categories.id','=','stocks.categoryid')->select('stocks.*','stock_categories.category_name',)->where('stocks.id','=',$id)->get();
        $categorys = StockCategorys::get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','stocks')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('stocks.view',compact('stocks','categorys','logs'));
    }

    public function edit($id){
        $categorys = StockCategorys::get();
        $stocks=Stocks::where('id','=',$id)->get();
        return view('stocks.edit',compact('stocks','categorys'));
    }
    public function update(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        unset($data['_token']);
        $accdata=Stocks::where('id','=',$request->id)->get();
        $olddata = json_encode($accdata[0]);
        $newdata = json_encode($request->all());
        $logs=[
            'module'=>'Stock',
            'moduleid'=>$request->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Product Updated',
            'olddata'=>$olddata,
            'newdata'=>$newdata
        ];
        $vendor=Stocks::where('id',$request->id)->update($data);
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('product/view/'.$request->id);
    }

    public function getStock(Request $request,$id){
        if ($request->ajax()) {
            $data = Stocklist::where('id','=',$id)->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function($row){
                //     $actionBtn = '<a class="edit btn btn-success btn-sm" data-id="'.$row->ID.'">Edit</a> <a  class="delete btn btn-danger btn-sm" data-id="'.$row->ID.'">DeActive</a>';
                //     //$actionBtn=$row->ID;
                //     return $actionBtn;
                // })
                // ->rawColumns(['action'])
                // ->editColumn('Date', function ($row) {
                //     $date=date('d/m/Y',strtotime($row->Date));
                //     return $date;
                // })
                ->editColumn('desk', function ($row) {
                    if($row->desk==""){
                        return "-";
                    }else{
                        return $row->Desk;
                    }
                })
                ->editColumn('Name', function ($row) {
                    switch ($row->Name) {
                        case 'leads':
                            return "Customer";
                            break;
                        case 'staff':
                            return "Technisian/Staff";
                            break;
                        case 'storage':
                            return "Storage";
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                })
                ->make(true);
        }
    }
    
}
