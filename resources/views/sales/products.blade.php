@extends('layouts.master')

@section('content')
    <div class="col-lg-12 my-3">
        <div class="card panel-primary">
            <div class="card-body">

                @include('sales.partials.formSearch')

                <table class="table table-striped table-bordered table-hover" id="productsTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th>MIProductSKU</th>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <style>
        td.details-control {
            background: url('img/details_open.png') no-repeat center center;
            cursor:pointer;
        }

        tr.shown td.details-control {
            background: url('img/details_close.png') no-repeat center center;
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="{{ asset('js/common.js') }}"></script>
    <script>
        let $productsTable;
        let $productsDetails;

        function format(d){
            let result = '';
           return `<div>
                <object type="text/html" data="`+d+`" width="100%" height="100%"></object>
            </div>`;
        }

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#dateFromPicker').datetimepicker({
                defaultDate: moment().subtract(30,'days'),
                format: 'YYYY-MM-DD',
                autoclose: true,
                todayBtn: true,
            });
            $('#dateToPicker').datetimepicker({
                defaultDate: moment(),
                format: 'YYYY-MM-DD',
                autoclose: true,
                todayBtn: true
            });


            $productsTable = $('#productsTable').DataTable({
                pageLength: 25,
                lengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']],
                scrollY: "60vh",
                scrollX: true,
                scrollCollapse: true,
                processing: true,
                stateSave: true,
                serverSide:true,

                dom:"<'row'<'col-sm-12 col-md-6 d-flex justify-content-start'f><'col-sm-12 col-md-6 d-flex justify-content-end'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

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
                            className: 'btn btn-success mr-1',
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
                    url: '{!! route('sales.products') !!}',
                    data: function (d) {
                        d.dateFrom=$('#dateFrom').val();
                        d.dateTo=$('#dateTo').val();
                    }
                },

                columns: [
                    {},
                    {"data":"MIProductSKU",name:"MIProductSKU"},
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
                        targets: 0,
                        className: "details-control",
                        orderable: false,
                        data: null,
                        defaultContent: ''
                    },{
                        targets: 4,width: 500
                    },{
                        targets: [3,10,11,12,13,14,15,16,20],
                        className: "text-right",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '$ ' )},
                    {
                        targets: [1,5,6,7,8,9,17,18,19],
                        className: "text-center"
                    },

                ]
            });

            $('#productsTable tbody').on('click', 'td.details-control', function () {
                let tr = $(this).closest('tr');
                let row = $productsTable.row( tr );
                // let attributes = getRowData(row.data().SKU,'','/getAttribute');
                let rowId = tr.attr('id');
                let pictures = `<div>
                                <object type="text/html" data="http://photos.discount-merchant.com/photos/sku/`+rowId+`/index.php" width="100%" height="100%"></object>
                                </div>`;


                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    row.child( pictures ).show();
                    tr.addClass('shown');
                }
            });


            $('#MyForm').on('submit',function(e){
                e.preventDefault();
                let dateFrom=new Date($('#dateFrom').val());
                let dateTo=new Date($('#dateTo').val());
                if (dateFrom > dateTo){
                    $('#dateFrom').addClass('is-invalid');
                    $('#dateTo').addClass('is-invalid');
                }else{
                    $('#dateFrom').removeClass('is-invalid');
                    $('#dateTo').removeClass('is-invalid');
                    $productsTable.draw();
                }
            });

        });

        $(document).on('click','.details-btn',function(e){
            e.stopPropagation();
            let $modalProductDetails =  $('#modalProductDetails');

            let tr = $(this).closest('tr');
            let row = $productsTable.row( tr );
            let rowId = tr.attr('id');
            let name = row.data().Name;

            $modalProductDetails.on('shown.bs.modal', function(){
                $(this).find(".modal-title").html("Details - "+rowId+" - "+name);

                $(this).find(".modal-body").html(`<table class="table table-striped table-bordered " id="productsDetails">
                    <thead>
                    <tr>
                        <th></th>
                        <th>OrderID</th>
                        <th>OMOrderID</th>
                        <th>SupplierSKU</th>
                        <th>UnitCost</th>
                        <th>QtySold</th>
                        <th>UnitPrice</th>
                        <th>TaxPrice</th>
                        <th>ShippingPrice</th>
                        <th>ShippingCost</th>
                        <th>ShippingTaxPrice</th>
                        <th>TotalPrice</th>
                    </tr>
                    </thead>
                </table>`);

                $productsDetails=$('#productsDetails').DataTable({
                    pageLength: 25,
                    lengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']],
                    scrollY: "50vh",
                    scrollX: true,
                    scrollCollapse: true,
                    processing: true,
                    stateSave: true,
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
                        url: '{!! route('sales.details') !!}',
                        data: function (d) {
                            d.sku = rowId;
                            d.salesRange=$('#salesRange').val();
                        }
                    },
                    columns: [
                        {},
                        {"data": "CA Order ID", name: "CA Order ID"},
                        {"data": "OM Order Number", name: "OM Order Number"},
                        {"data": "SupplierSKU", name: "SupplierSKU"},
                        {"data": "UnitCost", name: "UnitCost"},
                        {"data": "QtySold", name: "QtySold"},
                        {"data": "UnitPrice", name: "UnitPrice"},
                        {"data": "TaxPrice", name: "TaxPrice"},
                        {"data": "ShippingPrice", name: "ShippingPrice"},
                        {"data": "ShippingCost", name: "ShippingCost"},
                        {"data": "ShippingTaxPrice", name: "ShippingTaxPrice"},
                        {"data": "TotalPrice", name: "TotalPrice"},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            className: "details-control",
                            orderable: false,
                            data: null,
                            defaultContent: ''
                        },{
                            targets: [4,6,7,8,9,10,11],
                            className: "text-right",
                            render: $.fn.dataTable.render.number( ',', '.', 2, '$ ' )
                        },{
                            targets: [1,2,3,5],
                            className: "text-center"
                        },
                    ]

                });

                $('#productsDetails tbody').on('click', 'td.details-control', function () {
                    let tr = $(this).closest('tr');
                    let row = $productsDetails.row( tr );

                    let rowId = tr.attr('id');
                    let table = ` <tr>
                                        <td><b>SiteMap</b></td><td>`+row.data().sitename+`</td>
                                        <td><b>OM Order Num</b></td><td>`+row.data().SupplierID+`</td>
                                    </tr>
                                    <tr>
                                        <td><b>AccountName</b></td><td>`+row.data().AccountName+`</td>
                                        <td><b>OrderDate</b></td><td>`+row.data().OrderDate+`</td>
                                    </tr>
                                    <tr>
                                        <td><b>Profile_Id</b></td><td>`+row.data().Profile_Id+`</td>
                                        <td><b>MarketplaceSKU</b></td><td>`+row.data().MarketplaceSKU+`</td>
                                    </tr>
                                    <tr>
                                        <td><b>Marketplace Order ID</b></td><td>`+row.data()['Marketplace Order ID']+`</td>
                                        <td><b>MappedProductSKU</b></td><td>`+row.data().MappedProductSKU+`</td>
                                    </tr>`;

                    if ( row.child.isShown() ) {
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        row.child( table ).show();
                        tr.addClass('shown');
                    }
                });


            }).modal('show');

            $modalProductDetails.on('hidden.bs.modal', function(){
                $(this).find(".modal-body").html('');
            });
        });



    </script>
@endpush
