<?php

namespace App\Http\Controllers\Orders;

use App\ConsignmentOrderDetails;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DetailsController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $this->validate($request,[
                'dateFrom' => 'required|date_format:Y-m-d',
                'dateTo' => 'required|date_format:Y-m-d|after_or_equal:dateFrom',
            ]);

            $data = ConsignmentOrderDetails::query();

            return Datatables::of($data)->filter(function($query) use($request){

                    $query->whereBetween('OrderDate',[$request->dateFrom, $request->dateTo]);

            })
                ->addIndexColumn()
                ->setRowId(function ($data) {
                    return $data->{'CA Order ID'};
                })->make(true);
        }

       return view('orders.index');
   }
}
