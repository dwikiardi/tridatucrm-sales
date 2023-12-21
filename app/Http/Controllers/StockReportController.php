<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DataLogs;
use App\Models\Leads;
use App\Models\Stocks;
use App\Models\StocksPosition;
use App\Models\StockLogs;
use App\Models\StocksNoSeri;
use App\Models\Services;
use App\Models\Stocklist;

use DB;
use DataTables;
use PDF;
use URL;
use Storage;
use File;

class StockReportController extends Controller
{
    public function invreport(Request $request){
        if ($request->ajax()) {
            $data =Stocklist::orderBy('id','ASC')->join('stocks','stocks.id','=','stocklist.id')->select('stocklist.*','stocks.unit as unit')->get();
            //dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('modules', function ($row) {
                    switch ($row->modules) {
                        case 'leads':
                            return "Customer";
                            break;
                        case 'staff':
                            return "Technician/Staff";
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

        return view('stocks.invreport');
    }
}
