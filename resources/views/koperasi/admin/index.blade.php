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
                                <i class="fa fa-plus-circle"></i> Add {{$menu->label}}
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
    <link href="/assets/node_modules/datatables/media/css/dataTables.bootstrap4.css" rel="stylesheet">
@endsection
@section('scripts')
    <script src="/assets/node_modules/datatables/datatables.min.js"></script>
    <script>
        url = '{{url($url)}}'
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
                {"targets": 1, "name": "name", "title": "Name"},
                {"targets": 2, "name": "email", "title": "Email"},
                {"targets": 3, "name": "mobile", "title": "phone"},
                {"targets": 4, "name": "role_name", "title": "Role"},
                {"targets": 5, "name": "status_name", "title": "Status"},
                {"targets": 6, "name": "cooperative_name", "title": "Partner"},
                {"targets": 7, "name": "last_login_at", "title": "Last Login"},
                {"targets": 8, "orderable": false, "name": "action", "title": "Action", "width": "10%"},
            ],
            "order": [[1, "asc"], [1, "asc"]],
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
    </script>
@endsection