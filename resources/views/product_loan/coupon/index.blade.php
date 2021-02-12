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
                                <a class="btn btn-info d-none d-lg-block m-l-15" href="javascript:void(0)"
                                   onclick="modalForm('{{$url.'/create'}}')">
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
    <link href="/assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
          rel="stylesheet">
@endsection
@section('scripts')
    <script src="/assets/node_modules/moment/moment.js"></script>
    <script src="/assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
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
                {"targets": 1, "name": "coupon_name", "title": "Name"},
                {"targets": 2, "name": "is_percentage", "title": "is Percentage"},
                {"targets": 3, "name": "percentage", "title": "Percentage"},
                {"targets": 4, "name": "amount", "title": "Amount"},
                {"targets": 5, "name": "begin_at", "title": "Begin at"},
                {"targets": 6, "name": "expired_at", "title": "Expired at"},
                {"targets": 7, "orderable": false, "name": "action", "title": "Action", "width": "10%"},
            ],
            "order": [[1, "desc"]],
            buttons: []
        });

        function modalForm(url) {
            ajaxModal(url, null, 'get', '#modal');
        }
    </script>
@endsection