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
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-end align-items-center">
                            <a class="btn btn-info d-none d-lg-block m-l-15" href="{{url($url)}}/create">
                                <i class="fa fa-plus-circle"></i> Add Role
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped">
                            </table>
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
        $(document).ready(function () {
            table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: url + '/data-table',
                //pageLength: 25,
                "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
                responsive: false,
                dom: '<"html5buttons"B>lTfgitp',
                columnDefs: [
                    {"targets": 0, "orderable": false, "title": "No", "width": "5%"},
                    {"targets": 1, "name": "role_code", "title": "Code"},
                    {"targets": 2, "name": "role_name", "title": "Role Name"},
                    {"targets": 3, "name": "is_active", "title": "Status"},
                    {"targets": 4, "name": "is_verificator", "title": "Verificator"},
                    {"targets": 5, "name": "loan_type", "title": "Loan Type"},
                    {"targets": 6, "name": "role_type", "title": "Role Type"},
                    {"targets": 7, "name": "upgrad_status_name", "title": "Upgrade Status"},
                    {"targets": 8, "orderable": false, "name": "action", "title": "Action", "width": "10%"},
                ],
                "order": [[2, "desc"], [1, "asc"]],
                buttons: [
                    // {extend: 'copy'},
                    // {extend: 'csv', title: filename},
                    // {extend: 'excel', title: filename},
                    // {extend: 'pdf', title: filename},
                    // {
                    //     extend: 'print',
                    //     customize: function (win) {
                    //         $(win.document.body).addClass('white-bg');
                    //         $(win.document.body).css('font-size', '10px');
                    //         $(win.document.body).find('table')
                    //             .addClass('compact')
                    //             .css('font-size', 'inherit');
                    //     }
                    // }
                ]
            });
        });

        function deleteData(id) {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No",
                // closeOnConfirm: false,
                // closeOnCancel: false
            }).then(function (res) {
                if (res.value) {
                    $.ajax({
                        url: url + '/delete/' + id,
                        type: 'delete',
                        data: {_token: '{{csrf_token()}}'},
                    }).done(function () {
                        swal("Successfully deleted!", "", "success");
                        table.ajax.reload();
                    }).fail(function () {
                        swal("Failed deleted!", "", "error");
                    })
                } else {
                    swal("Cancelled", "", "error");
                }
            });
        }
    </script>
@endsection