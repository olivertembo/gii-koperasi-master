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
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped" width="100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        th, td.td-center {
            text-align: center;
        }
    </style>
@endsection
@section('scripts')
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
                {"targets": 0, "orderable": false, "title": "No", "width": "5%", "className": "td-center",},
                {"targets": 1, "name": "name", "title": "Name"},
                {"targets": 2, "name": "email", "title": "Email"},
                {"targets": 3, "name": "mobile_number", "title": "Mobile Number", "className": "td-center"},
                {"targets": 4, "name": "city_name", "title": "City"},
                {"targets": 5, "name": "customer_status_name", "title": "Cust. Status", "className": "td-center"},
                {"targets": 6, "name": "upgrade_status_name", "title": "Upgrade Status", "className": "td-center"},
                {"targets": 7, "name": "users.created_at", "title": "Register at", "className": "td-center"},
                {"targets": 8, "orderable": false, "width": "5%", "className": "td-center",},
            ],
            "order": [[6, "desc"], [7, "desc"]],
            buttons: []
        });

        function modalForm(url) {
            ajaxModal(url, null, 'get', '#modal');
        }
    </script>
@endsection