@extends('layouts.master')

@section('content')
    <div class="col-lg-12 my-3">
        <div class="card panel-primary">
            <div class="card-body">

                @include('sales.partials.formSearch')

                <table class="table table-striped table-bordered table-hover" id="products-table">
                    <thead>
                    <tr>
                        <th>MITProductSKU</th>
                        <th>SupplierSKU</th>
                        <th>UnitCost</th>
                        <th>Name</th>
                        <th>OverallTotal QtyReceived</th>
                        <th>OverallTotal QtySold</th>
                        <th>Consignment RemainingQty</th>
                        <th>QOH</th>
                        <th>QtySold</th>
                        <th>AvgSelling Price</th>
                        <th>TotalSales</th>
                        <th>Shipping Charge</th>
                        <th>Shipping Cost</th>
                        <th>CostOf GoodsSold</th>
                        <th>Marketplace FeesEstimate</th>
                        <th>Marketplace NetProfit</th>
                        <th>MarketplaceNet ProfitMargin</th>
                        <th>MarketplaceGross ProfitMargin</th>
                        <th>Marketplace ProfitMarkup</th>
                        <th>Supplier Payout</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('sales.partials.modalProductDetails')
@stop

{{-- page level styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"/>
    <style>
        div.dt-buttons {
            float: none;
            text-align: center;
        }
        .table tbody tr:hover td, .table tbody tr:hover th {
            background-color: lightgoldenrodyellow;
        }
    </style>
@endpush

{{-- page level scripts --}}
@push('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>


    <script src="{{ asset('js/common.js') }}"></script>
    <script>
        let $productsTable;

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#salesRange').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                startDate: moment().subtract(30,'days'),
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });


            $productsTable = $('#products-table').DataTable({
                pageLength: 25,
                lengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']],
                scrollY: "50vh",
                scrollX: true,
                scrollCollapse: true,
                processing: true,
                stateSave: true,
                serverSide:true,

                dom: '"<\'row\'<\'col-md-6\'B><\'col-md-6\'f>>" +\n' +
                    '"<\'row\'<\'col-sm-12\'tr>>" +\n' +
                    '"<\'row\'<\'col-sm-12 col-md-5\'i ><\'col-sm-12 col-md-7\'p>>"',

                buttons: {
                    dom: {
                        container: {
                            tag: 'div',
                            className: 'flexcontent'
                        },
                        buttonLiner: {
                            tag: null
                        }
                    },

                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fas fa-file-excel"></i> Excel',
                            title: 'Products to Excel',
                            titleAttr: 'Excel',
                            className: 'btn btn-success',
                            init: function(api, node, config) {
                                $(node).removeClass('btn-secondary buttons-html5 buttons-excel')
                            },
                        },
                        {
                            extend: 'pageLength',
                            titleAttr: 'Show Records',
                            className: 'btn selectTable btn-primary',
                        },
                    ],
                },

                ajax: {
                    url: '{!! route('sales.index') !!}',
                    data: function (d) {
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                        d.salesRange=$('#salesRange').val();
                    }
                },

                columns: [
                    {"data":"MITProductSKU",name:"MITProductSKU"},
                    {"data":"SupplierSKU",name:"SupplierSKU"},
                    {"data":"UnitCost",name:"UnitCost"},
                    {"data":"Name",name:"Name"},
                    {"data":"OverallTotalQtyReceived",name:"OverallTotalQtyReceived"},
                    {"data":"OverallTotalQtySold",name:"OverallTotalQtySold"},
                    {"data":"ConsignmentRemainingQty",name:"ConsignmentRemainingQty"},
                    {"data":"QOH",name:"QOH"},
                    {"data":"QtySold",name:"QtySold"},
                    {"data":"AvgSellingPrice",name:"AvgSellingPrice"},
                    {"data":"TotalSales",name:"TotalSales"},
                    {"data":"ShippingCharge",name:"ShippingCharge"},
                    {"data":"ShippingCost",name:"ShippingCost"},
                    {"data":"CostOfGoodsSold",name:"CostOfGoodsSold"},
                    {"data":"MarketplaceFeesEstimate",name:"MarketplaceFeesEstimate"},
                    {"data":"MarketplaceNetProfit",name:"MarketplaceNetProfit"},
                    {"data":"MarketplaceNetProfitMargin",name:"MarketplaceNetProfitMargin"},
                    {"data":"MarketplaceGrossProfitMargin",name:"MarketplaceGrossProfitMargin"},
                    {"data":"MarketplaceProfitMarkup",name:"MarketplaceProfitMarkup"},
                    {"data":"SupplierPayout",name:"SupplierPayout"},
                ],
                columnDefs: [
                    {
                        targets: 3,width: 500
                    },
                    {
                        targets: [2,9,10,11,12,13,14,15,19],
                        className: "text-right",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '$ ' )},
                    {
                        targets: [0,4,5,6,7,8,16,17,18],
                        className: "text-center"
                    },

                ]
            });


            $('#mySearch').on('submit',function(e){
                e.preventDefault();
                $productsTable.draw();
            });

        });

        $(document).on('click','.details-btn',function(e){
            e.stopPropagation();
            let $tr = $(this).closest('tr');
            let rowId = $tr.attr('id');
            $('#modalProductDetails').on('shown.bs.modal', function(){
                $(this).find(".modal-title").html("Details of - "+rowId);

            }).modal('show');
        });



    </script>
@endpush
