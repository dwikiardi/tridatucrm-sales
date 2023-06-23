<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DataLogs;
use App\Models\StockCategorys;

use DataTables;

class StocCategoryController extends Controller
{
    //Index ListView
    public function index(Request $request){
        if ($request->ajax()) {
            //$data = Accounts::select('*');
            $data = StockCategorys::select('stock_categories.id as ID','stock_categories.category_name as name','stock_categories.desk as desk')->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function($row){
                //     $actionBtn = '<a class="edit btn btn-success btn-sm" data-id="'.$row->ID.'">Edit</a> <a  class="delete btn btn-danger btn-sm" data-id="'.$row->ID.'">DeActive</a>';
                //     //$actionBtn=$row->ID;
                //     return $actionBtn;
                // })
                // ->rawColumns(['action'])
                ->editColumn('desk', function ($row) {
                    return $row->desk ?: '-';
                    
                })
                ->editColumn('note', function ($row) {
                    return $row->note ?: '-';
                    
                })
                ->make(true);
        }

        return view('stockcategories.index');
    }

    public function create()
    {
        return view('stockcategories.create');
    }
    public function store(Request $request){
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        //dd($request->all());
        $data=$request->all();
        
        
        unset($data['_token']);
        $ids=StockCategorys::create($data);

        $newdata=json_encode($request->all());
        $logs=[
            'module'=>'Stock_Categories',
            'moduleid'=>$ids->id,
            'createbyid'=>Auth::user()->id,
            'logname'=>'Category Product Created',
            'olddata'=>'',
            'newdata'=>$newdata
        ];
        $ids=DataLogs::create($logs);
        //echo $newdata;
        /// redirect jika sukses menyimpan data
         return redirect('category');
    }

    public function view($id){
        $category=StockCategorys::get();
        
        $createbyid=User::where('id','=',$category[0]->createbyid)->get();
        $updatebyid=User::where('id','=',$category[0]->updatebyid)->get();
        $logs=DataLogs::where('moduleid','=',$id)->where('module','=','Stock_Categories')->orderBy('created_at', 'DESC')->join('users', 'datalogs.createbyid', '=', 'users.id')
        ->select('datalogs.*' ,'users.first_name as firstname', 'users.last_name as lastname')->get();
        
        return view('stockcategories.view',compact('category','createbyid','updatebyid','logs'));
    }

    public function edit($id){
        $category=StockCategorys::where('id','=',$id)->get();
        return view('stockcategories.edit',compact('category'));
    }
    public function update(Request $request){
        //var_dump($request->all());
        $data=$request->all();
        
        
        unset($data['_token']);
        $accdata=StockCategorys::where('id','=',$request->id)->get();
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
        $vendor=StockCategorys::where('id',$request->id)->update($data);
        $ids=DataLogs::create($logs);
        /// redirect jika sukses menyimpan data
         return redirect('category/view/'.$request->id);
    }

    
}
