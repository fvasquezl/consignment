@extends('layouts.master')

@section('content')
    <div class="col-lg-12 my-3">
        <div class="card panel-primary">
            <div class="card-body">

                @include('sales.partials.formSearch')

                <table class="table table-striped table-bordered table-hover" id="products-table">
                    <thead>
                    <tr>
                        <th>SupplierSKU</th>
                        <th>Name</th>
                        <th>UnitCost</th>
                        <th>OverallTotal QtyReceived</th>
                        <th>OverallTotal QtySold</th>
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
                    url: '{!! route('sohnen.index') !!}',
                    data: function (d) {
                        d.salesRange=$('#salesRange').val();
                    }
                },

                columns: [
                    {"data":"SupplierSKU",name:"SupplierSKU"},
                    {"data":"Name",name:"Name"},
                    {"data":"UnitCost",name:"UnitCost"},
                    {"data":"OverallTotalQtyReceived",name:"OverallTotalQtyReceived"},
                    {"data":"OverallTotalQtySold",name:"OverallTotalQtySold"},
                    {"data":"SupplierPayout",name:"SupplierPayout"},
                ],
                columnDefs: [
                    {
                        targets: 1,width: 500
                    },
                    {
                        targets: [2,3,5],
                        className: "text-right",
                        render: $.fn.dataTable.render.number( ',', '.', 2, '$ ' )},
                    {
                        targets: [0,4],
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
            let $modalProductDetails =  $('#modalProductDetails');

            let tr = $(this).closest('tr');
            let row = $productsTable.row( tr );
            let rowId = tr.attr('id');
            let name = row.data().Name;

            $modalProductDetails.on('shown.bs.modal', function(){
                $(this).find(".modal-title").html("Details - "+rowId+" - "+name);

                $(this).find(".modal-body").html(`<table class="table table-striped table-bordered table-hover " id="products-details">
                    <thead>
                    <tr>
                        <th>OrderDate</th>
                        <th>SupplierSKU</th>
                        <th>UnitCost</th>
                        <th>QtySold</th>
                    </tr>
                    </thead>
                </table>`);


                $('#products-details').DataTable({
                    processing: true,
                    pageLength: 25,
                    lengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']],
                    scrollY: "45vh",

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
                        url: '{!! route('sohnen.details') !!}',
                        data: function (d) {
                            d.sku = rowId;
                            d.salesRange=$('#salesRange').val();
                        }
                    },
                    columns: [
                        {"data": "OrderDate", name: "OrderDate"},
                        {"data": "SupplierSKU", name: "SupplierSKU"},
                        {"data": "UnitCost", name: "UnitCost"},
                        {"data": "QtySold", name: "QtySold"},
                    ],
                    columnDefs: [
                        {
                            targets: [2,3],
                            className: "text-right",
                            render: $.fn.dataTable.render.number( ',', '.', 2, '$ ' )},
                        {
                            targets: [0,1],
                            className: "text-center"
                        },

                    ]

                });

            }).modal('show');

            $modalProductDetails.on('hidden.bs.modal', function(){
                $(this).find(".modal-body").html('');
            });
        });
    </script>
    <script src="{{ asset('js/common.js') }}"></script>
@endpush
