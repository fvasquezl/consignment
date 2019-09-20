<?php

namespace App\Http\Controllers;

use App\ConsignmentOrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $topTenSku = $this->getTopTeen();

        return view('dashboard.index',compact('topTenSku'));
    }

    public function getTotalSales(Request $request)
    {
        $months = [];$totalSales=[];$totalCost =[];

        $year = $request->year?$request->year: date('Y');
        $sales = DB::select('exec [MiTech].[mi].[sp_GetTotalSales] '.$year);

        foreach ($sales as $key =>$sale){
            $months[] = $sales[$key]->Month_Name;
            $totalSales[] = $sales[$key]->TotalSales;
            $totalCost[] = $sales[$key]->TotalCost;
        }

        $profit = array_sum($totalSales) - array_sum($totalCost);


        return ['months'=>$months,'totalSales'=>$totalSales,'totalCost'=>$totalCost,'profit'=> $profit];
    }

    public function getProducts(Request $request)
    {
        $months = [];$qtySold=[];

        $year = $request->year?$request->year: date('Y');
        $sales = DB::select('exec [MiTech].[mi].[sp_GetTotalProducts] '.$year);

        foreach ($sales as $key =>$sale){
            $months[] = $sales[$key]->Month_Name;
            $qtySold[] = $sales[$key]->QtySold;
        }

        $qtyProducts = array_sum($qtySold);


        return ['months'=>$months,'qtySold'=>$qtySold,'qtyProducts'=> $qtyProducts];
    }

    public function getTopTeen()
    {
        return ConsignmentOrderDetails::select('ShippedSKU','UnitCost',DB::raw('SUM (TotalPrice) AS [TotalSales]'))
            ->groupBy('ShippedSKU','UnitCost')
            ->orderBy(DB::raw('SUM (TotalPrice)'),'desc')
            ->take(10)->get();

    }
}
