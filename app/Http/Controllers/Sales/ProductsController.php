<?php

namespace App\Http\Controllers\Sales;

use App\ConsignmentOrderDetails;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProductsController extends Controller
{

    public function index()
    {
        if (auth()->user()->role =='mi'){
            return view('sales.products');
        }else if(auth()->user()->role =='sohnen'){
            return view('sales.sohnen');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function products(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::select('exec [MiTech].[mi].[sp_SohnenSalesReport] ?,?',[$request->dateFrom,$request->dateTo]);

            return Datatables::of($data)
                ->editColumn('OverallTotalQtySold', '<a href="#" class="details-btn">{{$OverallTotalQtySold}}</a>')
                ->addIndexColumn()
                ->rawColumns(['OverallTotalQtySold'])
                ->setRowId(function ($data) {
                    return $data->MIProductSKU;
                })->make(true);
        }
    }


    public function details(Request $request)
    {
        if ($request->ajax()) {

        $data = ConsignmentOrderDetails::query();

        return Datatables::of($data)->filter(function($query) use($request){
            if($sku = $request->sku){
                $query->where('MappedProductSKU',$sku);
            }
            if($salesRange = $request->salesRange){
                $dates = explode(" - ", $request->salesRange);
                $query->whereBetween('OrderDate',[$dates[0],$dates[1]]);
            }
        })
            ->addIndexColumn()
            ->rawColumns(['MappedProductSKU'])
            ->setRowId(function ($data) {
                return $data->MappedProductSKU;
            })->make(true);
        }
        return false;
    }

}
