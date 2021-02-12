@extends('layouts.app')

@section('title',$menu->label)
@section('breadcrumbs')
    @php
        $breadcrumbs = [
            $menu->parentMenu->label,
            $menu->label,
        ];
    @endphp
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body wizard-content">
                    <form action="#" class="tab-wizard wizard-circle">
                        <!-- Step 1 -->
                        <h6>Product Category</h6>
                        <section>
                            <hr>
                            <div class="row">
                                <div class="d-flex justify-content-end align-items-center">
                                    @if(Auth::user()->isVerificator() && Auth::user()->type==1)
                                        <a class="btn btn-info d-none d-lg-block m-l-15" href="javascript:void(0)"
                                           onclick="modalForm('{{$url.'-category/create'}}')">
                                            <i class="fa fa-plus-circle"></i> Add Category
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="myTable1" class="table table-bordered table-striped" width="100%">
                                    </table>
                                </div>
                            </div>
                            <hr>
                        </section>
                        <!-- Step 2 -->
                        <h6>Product</h6>
                        <section>
                            <hr>
                            <div class="row">
                                <div class="d-flex justify-content-end align-items-center">
                                    @if(Auth::user()->isVerificator())
                                        <a class="btn btn-info d-none d-lg-block m-l-15" href="javascript:void(0)"
                                           onclick="modalForm('{{$url.'/create'}}')">
                                            <i class="fa fa-plus-circle"></i> Add Product
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="myTable2" class="table table-bordered table-striped" width="100%">
                                    </table>
                                </div>
                            </div>
                            <hr>
                        </section>
                        <!-- Step 3 -->
                        <h6>Priduct Item</h6>
                        <section>
                            <hr>
                            <div class="row">
                                <div class="d-flex justify-content-end align-items-center">
                                    <a class="btn btn-info d-none d-lg-block m-l-15" href="javascript:void(0)"
                                       onclick="modalForm('{{$url.'-item/create'}}')">
                                        <i class="fa fa-plus-circle"></i> Add Product Item
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="myTable3" class="table table-bordered table-striped" width="100%">
                                    </table>
                                </div>
                            </div>
                            <hr>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="/assets/node_modules/summernote/dist/summernote-bs4.css">
    <link href="/assets/node_modules/wizard/steps.css" rel="stylesheet">

    <style>
        th, td.td-center {
            text-align: center;
        }
    </style>
@endsection
@section('scripts')
    <script src="/assets/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script src="/assets/node_modules/wizard/jquery.steps.min.js"></script>

    <script>
        $(document).ready(function () {
            url = '{{url($url)}}'
            $(".tab-wizard").steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    finish: "Done"
                },
                onFinished: function (event, currentIndex) {
                    // swal("Form Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
                    window.location = "/product-loan/product-item"
                }
            });

            table1 = $('form section #myTable1').DataTable({
                processing: true,
                serverSide: true,
                ajax: url + '-category/data-table',
                //pageLength: 25,
                "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
                responsive: false,
                // dom: '<"html5buttons"B>lTfgitp',
                columnDefs: [
                    {"targets": 0, "orderable": false, "title": "No", "width": "5%", "className": "td-center",},
                    {"targets": 1, "name": "", "title": "Icon", "orderable": false, "className": "td-center",},
                    {"targets": 2, "name": "product_category_name", "title": "Category Name"},
                    {"targets": 3, "name": "is_active", "title": "Status"},
                    {
                        "targets": 4,
                        "orderable": false,
                        "name": "action",
                        "title": "Action",
                        "width": "10%",
                        "className": "td-center",
                    },
                ],
                "order": [[2, "desc"]],
                buttons: []
            });


            table2 = $('#myTable2').DataTable({
                processing: true,
                serverSide: true,
                ajax: url + '/data-table',
                //pageLength: 25,
                "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
                responsive: false,
                dom: '<"html5buttons"B>lTfgitp',
                columnDefs: [
                    {"targets": 0, "orderable": false, "title": "No", "width": "5%", "className": "td-center",},
                    {"targets": 1, "name": "product_category_name", "title": "Category",},
                    {"targets": 2, "name": "cooperative_name", "title": "Partner"},
                    {"targets": 3, "name": "sku", "title": "SKU"},
                    {"targets": 4, "name": "product_name", "title": "Product Name"},
                    {"targets": 5, "name": "product_description", "title": "Description"},
                    {
                        "targets": 6,
                        "orderable": false,
                        "name": "action",
                        "title": "Action",
                        "width": "10%",
                        "className": "td-center",
                    },
                ],
                "order": [[2, "desc"]],
                buttons: []
            });

            table3 = $('#myTable3').DataTable({
                processing: true,
                serverSide: true,
                ajax: url + '-item/data-table',
                //pageLength: 25,
                "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
                responsive: false,
                dom: '<"html5buttons"B>lTfgitp',
                columnDefs: [
                    {"targets": 0, "orderable": false, "title": "No", "width": "5%", "className": "td-center",},
                    {"targets": 1, "name": "product_category_name", "title": "Category",},
                    {"targets": 2, "name": "product_name", "title": "Product"},
                    {"targets": 3, "name": "sku", "title": "SKU"},
                    {"targets": 4, "name": "product_name", "title": "Product Name"},
                    {"targets": 5, "name": "product_description", "title": "Description"},
                    {"targets": 6, "name": "price", "title": "Price/Qty"},
                    {"targets": 7, "name": "weight_item", "title": "Weight (gram)"},
                    {"targets": 8, "name": "total_stock", "title": "Stock"},
                    {"targets": 9, "name": "total_sold", "title": "Sold"},
                    {"targets": 10, "name": "is_active", "title": "Status"},
                    {
                        "targets": 11,
                        "orderable": false,
                        "name": "action",
                        "title": "Action",
                        "width": "10%",
                        "className": "td-center",
                    },
                ],
                "order": [[3, "desc"]],
                buttons: []
            });
        });

        function modalForm(url) {
            ajaxModal(url, null, 'get', '#modal');
        }

        function deleteData2(url) {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No",
            }).then(function (res) {
                if (res.value) {
                    $.ajax({
                        url: url,
                        type: 'delete',
                        data: {_token: '{{csrf_token()}}'},
                        statusCode: {
                            200: function (res) {
                                swal("Successfully deleted!", "", "success");
                                table1.ajax.reload();
                                table2.ajax.reload();
                                table3.ajax.reload();
                            },
                            500: function () {
                                table1.ajax.reload();
                                table2.ajax.reload();
                                table3.ajax.reload();
                                swal("Failed deleted!", "", "error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "", "error");
                }
            });
        }

    </script>
@endsection