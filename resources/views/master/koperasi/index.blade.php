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
                            @if(Auth::user()->isVerificator())
                                <a class="btn btn-info d-none d-lg-block m-l-15" href="{{$url.'/create'}}">
                                    <i class="fa fa-plus-circle"></i> Add
                                </a>
                            @endif
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
                {"targets": 1, "name": "partner_type_name", "title": "Partner Type"},
                {"targets": 2, "name": "cooperative_code", "title": "Code"},
                {"targets": 3, "name": "cooperative_name", "title": "Name"},
                {"targets": 4, "name": "cooperative_address", "title": "Address"},
                {"targets": 5, "name": "city_name", "title": "City"},
                {"targets": 6, "name": "phone", "title": "Phone"},
                {"targets": 7, "name": "email", "title": "Email"},
                {"targets": 8, "name": "website", "title": "Website"},
                {"targets": 9, "name": "additional_limit", "title": "Additional Limit"},
                {"targets": 10, "name": "origin", "title": "Courier Origin"},
                {"targets": 11, "orderable": false, "name": "action", "title": "Action", "width": "10%"},
            ],
            "order": [[3, "desc"]],
            buttons: []
        });

        function modalForm(url) {
            ajaxModal(url, null, 'get', '#modal');
        }
    </script>
@endsection