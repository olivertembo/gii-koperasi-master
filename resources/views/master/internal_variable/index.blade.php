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
        <div class="col-lg-12">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#fee" role="tab">
                            <span class="hidden-xs-down">Admin Fee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#age" role="tab">
                            <span class="hidden-xs-down">Age</span>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cities" role="tab">
                            <span class="hidden-xs-down">Cities</span>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#income" role="tab">
                            <span class="hidden-xs-down">Income & Work Exp</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#suspend" role="tab"> <span
                                    class="hidden-xs-down">Suspends</span></a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="fee" role="tabpanel">
                        <div class="p-20">
                            <div class="row">
                                <div class="d-flex justify-content-end align-items-center">
                                    @if(Auth::user()->isVerificator())
                                        <a class="btn btn-info d-none d-lg-block m-l-15" href="javascript:void(0)"
                                           onclick="modalForm('{{$url.'/create/admin-fee'}}')">
                                            <i class="fa fa-plus-circle"></i> Add Admin Fee
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
                        </div>
                    </div>
                    <div class="tab-pane" id="age" role="tabpane2">
                        <div class="p-20">
                            <div class="row">
                                <div class="d-flex justify-content-end align-items-center">
                                    @if(Auth::user()->isVerificator())
                                        <a class="btn btn-info d-none d-lg-block m-l-15" href="javascript:void(0)"
                                           onclick="modalForm('{{$url.'/create/age'}}')">
                                            <i class="fa fa-plus-circle"></i> Add Age
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
                        </div>
                    </div>
                    <div class="tab-pane" id="cities" role="tabpane3">
                        <div class="p-20">
                            <div class="row">
                                <div class="d-flex justify-content-end align-items-center">
                                    @if(Auth::user()->isVerificator())
                                        <a class="btn btn-info d-none d-lg-block m-l-15" href="javascript:void(0)"
                                           onclick="modalForm('{{$url.'/create/cities'}}')">
                                            <i class="fa fa-plus-circle"></i> Add City
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="myTable3" class="table table-bordered table-striped" width="100%">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="income" role="tabpane4">
                        <div class="p-20">
                            <div class="row">
                                <div class="d-flex justify-content-end align-items-center">
                                    @if(Auth::user()->isVerificator())
                                        <a class="btn btn-info d-none d-lg-block m-l-15" href="javascript:void(0)"
                                           onclick="modalForm('{{$url.'/create/income'}}')">
                                            <i class="fa fa-plus-circle"></i> Add Income and Work exp
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="myTable4" class="table table-bordered table-striped" width="100%">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="suspend" role="tabpane5">
                        <div class="p-20">
                            <div class="row">
                                <div class="d-flex justify-content-end align-items-center">
                                    @if(Auth::user()->isVerificator())
                                        <a class="btn btn-info d-none d-lg-block m-l-15" href="javascript:void(0)"
                                           onclick="modalForm('{{$url.'/create/suspends'}}')">
                                            <i class="fa fa-plus-circle"></i> Add Suspend
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="myTable5" class="table table-bordered table-striped" width="100%">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')

@endsection
@section('scripts')
    <script>
        url = '{{url($url)}}'
        table1 = $('#myTable1').DataTable({
            processing: true,
            serverSide: true,
            ajax: url + '/data-table/admin-fee',
            //pageLength: 25,
            "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
            responsive: false,
            dom: '<"html5buttons"B>lTfgitp',
            columnDefs: [
                {"targets": 0, "orderable": false, "title": "No", "width": "5%"},
                {"targets": 1, "name": "is_percentage", "title": "Is Percentage"},
                {"targets": 2, "name": "percentage", "title": "Percentage (%)"},
                {"targets": 3, "name": "amount", "title": "Amount"},
                {"targets": 4, "name": "is_active", "title": "Status"},
                {"targets": 5, "orderable": false, "name": "action", "title": "Action", "width": "10%"},
            ],
            "order": [[4, "desc"]],
            buttons: []
        });

        table2 = $('#myTable2').DataTable({
            processing: true,
            serverSide: true,
            ajax: url + '/data-table/age',
            //pageLength: 25,
            "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
            responsive: false,
            dom: '<"html5buttons"B>lTfgitp',
            columnDefs: [
                {"targets": 0, "orderable": false, "title": "No", "width": "5%"},
                {"targets": 1, "name": "age", "title": "Age"},
                {"targets": 2, "name": "is_active", "title": "Status"},
                {"targets": 3, "orderable": false, "name": "action", "title": "Action", "width": "10%"},
            ],
            "order": [[2, "desc"]],
            buttons: []
        });

        table3 = $('#myTable3').DataTable({
            processing: true,
            serverSide: true,
            ajax: url + '/data-table/cities',
            //pageLength: 25,
            "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
            responsive: false,
            dom: '<"html5buttons"B>lTfgitp',
            columnDefs: [
                {"targets": 0, "orderable": false, "title": "No", "width": "5%"},
                {"targets": 1, "name": "city_name", "title": "City"},
                {"targets": 2, "name": "is_active", "title": "Status"},
                {"targets": 3, "orderable": false, "name": "action", "title": "Action", "width": "10%"},
            ],
            "order": [[2, "desc"]],
            buttons: []
        });

        table4 = $('#myTable4').DataTable({
            processing: true,
            serverSide: true,
            ajax: url + '/data-table/income',
            //pageLength: 25,
            "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
            responsive: false,
            dom: '<"html5buttons"B>lTfgitp',
            columnDefs: [
                {"targets": 0, "orderable": false, "title": "No", "width": "5%"},
                {"targets": 1, "name": "income", "title": "Income"},
                {"targets": 2, "name": "work_exp", "title": "Work Exp (months)"},
                {"targets": 3, "name": "is_active", "title": "Status"},
                {"targets": 4, "orderable": false, "name": "action", "title": "Action", "width": "10%"},
            ],
            "order": [[3, "desc"]],
            buttons: []
        });

        table5 = $('#myTable5').DataTable({
            processing: true,
            serverSide: true,
            ajax: url + '/data-table/suspends',
            //pageLength: 25,
            "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
            responsive: false,
            dom: '<"html5buttons"B>lTfgitp',
            columnDefs: [
                {"targets": 0, "orderable": false, "title": "No", "width": "5%"},
                {"targets": 1, "name": "long_suspend", "title": "Long Suspend (days)"},
                {"targets": 2, "name": "is_active", "title": "Status"},
                {"targets": 3, "orderable": false, "name": "action", "title": "Action", "width": "10%"},
            ],
            "order": [[2, "desc"]],
            buttons: []
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
                                table4.ajax.reload();
                                table5.ajax.reload();
                            },
                            500: function () {
                                table1.ajax.reload();
                                table2.ajax.reload();
                                table3.ajax.reload();
                                table4.ajax.reload();
                                table5.ajax.reload();
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