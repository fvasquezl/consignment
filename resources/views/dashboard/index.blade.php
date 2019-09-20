@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">


            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Total Sales vs Total Cost</h3>
                            <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg" id="profit"></span>
                                <span>Sales Over Time</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                  <i class="fas fa-arrow-up"></i>
                                </span>
                                <span class="text-muted">Sales Over Time</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="sales-chart" height="200" width="731" class="chartjs-render-monitor"
                                    style="display: block; width: 731px; height: 200px;"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                          <span class="mr-2">
                            <i class="fas fa-square text-primary"></i> Total Sales
                          </span>

                            <span>
                    <i class="fas fa-square text-gray"></i> Total Cost
                  </span>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Top Ten Products</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                            <tr>
                                <th>ShippedSKU</th>
                                <th>UnitCost</th>
                                <th>TotalSales</th>
                                <th>More</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($topTenSku as $sku)
                                <tr>
                                    <td>
                                        {{$sku->ShippedSKU}}
                                    </td>
                                    <td> $ {{$sku->UnitCost}}</td>
                                    <td>
                                        $ {{$sku->TotalSales}}
                                    </td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Total Products Sale by Month</h3>
                            <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg" id="totalProducts"></span>
                                <span>Products Over Time</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i>
                                </span>
                                <span class="text-muted">Since last month</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="products-chart" height="200" style="display: block; width: 731px; height: 200px;"
                                    width="731" class="chartjs-render-monitor"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Total Products by Month
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                {{--                <div class="card">--}}
                {{--                    <div class="card-header border-0">--}}
                {{--                        <h3 class="card-title">Online Store Overview</h3>--}}
                {{--                        <div class="card-tools">--}}
                {{--                            <a href="#" class="btn btn-sm btn-tool">--}}
                {{--                                <i class="fas fa-download"></i>--}}
                {{--                            </a>--}}
                {{--                            <a href="#" class="btn btn-sm btn-tool">--}}
                {{--                                <i class="fas fa-bars"></i>--}}
                {{--                            </a>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="card-body">--}}
                {{--                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">--}}
                {{--                            <p class="text-success text-xl">--}}
                {{--                                <i class="ion ion-ios-refresh-empty"></i>--}}
                {{--                            </p>--}}
                {{--                            <p class="d-flex flex-column text-right">--}}
                {{--                    <span class="font-weight-bold">--}}
                {{--                      <i class="ion ion-android-arrow-up text-success"></i> 12%--}}
                {{--                    </span>--}}
                {{--                                <span class="text-muted">CONVERSION RATE</span>--}}
                {{--                            </p>--}}
                {{--                        </div>--}}
                {{--                        <!-- /.d-flex -->--}}
                {{--                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">--}}
                {{--                            <p class="text-warning text-xl">--}}
                {{--                                <i class="ion ion-ios-cart-outline"></i>--}}
                {{--                            </p>--}}
                {{--                            <p class="d-flex flex-column text-right">--}}
                {{--                    <span class="font-weight-bold">--}}
                {{--                      <i class="ion ion-android-arrow-up text-warning"></i> 0.8%--}}
                {{--                    </span>--}}
                {{--                                <span class="text-muted">SALES RATE</span>--}}
                {{--                            </p>--}}
                {{--                        </div>--}}
                {{--                        <!-- /.d-flex -->--}}
                {{--                        <div class="d-flex justify-content-between align-items-center mb-0">--}}
                {{--                            <p class="text-danger text-xl">--}}
                {{--                                <i class="ion ion-ios-people-outline"></i>--}}
                {{--                            </p>--}}
                {{--                            <p class="d-flex flex-column text-right">--}}
                {{--                    <span class="font-weight-bold">--}}
                {{--                      <i class="ion ion-android-arrow-down text-danger"></i> 1%--}}
                {{--                    </span>--}}
                {{--                                <span class="text-muted">REGISTRATION RATE</span>--}}
                {{--                            </p>--}}
                {{--                        </div>--}}
                {{--                        <!-- /.d-flex -->--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
@stop
@push('styles')
    <style type="text/css">/* Chart.js */
        @keyframes chartjs-render-animation {
            from {
                opacity: .99
            }
            to {
                opacity: 1
            }
        }

        .chartjs-render-monitor {
            animation: chartjs-render-animation 1ms
        }

        .chartjs-size-monitor,
        .chartjs-size-monitor-expand,
        .chartjs-size-monitor-shrink {
            position: absolute;
            direction: ltr;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
            visibility: hidden;
            z-index: -1
        }

        .chartjs-size-monitor-expand >
        div {
            position: absolute;
            width: 1000000px;
            height: 1000000px;
            left: 0;
            top: 0
        }

        .chartjs-size-monitor-shrink >
        div {
            position: absolute;
            width: 200%;
            height: 200%;
            left: 0;
            top: 0
        }
    </style>
@endpush

{{-- page level scripts --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <script src="{{ asset('js/charts.js') }}"></script>

@endpush

