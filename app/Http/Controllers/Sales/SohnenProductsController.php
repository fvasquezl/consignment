<?php

namespace App\Http\Controllers\Sales;

use App\ConsignmentOrderDetails;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SohnenProductsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::select('exec [MiTech].[mi].[sp_SohnenSalesReport] ?,?',[$request->dateFrom,$request->dateTo]);

            return Datatables::of($data)
                ->editColumn('SupplierSKU', '<a href="#" class="details-btn">{{$SupplierSKU}}</a>')
                ->addIndexColumn()
                ->rawColumns(['SupplierSKU'])
                ->setRowId(function ($data) {
                    return $data->SupplierSKU;
                })->make(true);
        }

    }


    public function details(Request $request)
    {
        if ($request->ajax()) {
            $data = ConsignmentOrderDetails::query();


            return Datatables::of($data)->filter(function($query) use($request){
                if($sku = $request->sku){
                    $query->where('SupplierSKU',$sku);
                }
                    $query->whereBetween('OrderDate',[$request->dateFrom,$request->dateTo]);

            })
                ->addIndexColumn()
                ->rawColumns(['SupplierSKU'])
                ->setRowId(function ($data) {
                    return $data->MappedProductSKU;
                })->make(true);
        }
        return false;
    }
}
