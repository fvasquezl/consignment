<?php

namespace App\Http\Controllers;

use App\ConsignmentOrderDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SalesController extends Controller
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
            $dates = explode(" - ", $request->salesRange);

            $data = DB::select('exec [MiTech].[mi].[sp_SohnenSalesReport] ?,?',[$dates[0],$dates[1]]);

            return Datatables::of($data)
                ->editColumn('MIProductSKU', '<a href="#" class="details-btn">{{$MIProductSKU}}</a>')
                ->addIndexColumn()
                ->rawColumns(['MIProductSKU'])
                ->setRowId(function ($data) {
                    return $data->MIProductSKU;
                })->make(true);
        }

        if (auth()->user()->role =='mi'){
            return view('sales.mi');
        }else if(auth()->user()->role =='sohnen'){
            return view('sales.sohnen');

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    public function products(Request $request)
    {
        if ($request->ajax()) {
           // $dates = explode(" - ", $request->salesRange);

//        $data = ConsignmentOrderDetails::where('MITProductSKU',$request->sku)
//            ->whereBetween('OrderDate',[$dates[0],$dates[1]]);
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
