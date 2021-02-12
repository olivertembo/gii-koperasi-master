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
                {"targets": 1, "name": "tenure", "title": "Tenure"},
                {"targets": 2, "name": "interest_percentage", "title": "% / days"},
                {"targets": 3, "orderable": false, "name": "action", "title": "Action", "width": "10%"},
            ],
            "order": [[2, "desc"]],
            buttons: []
        });

        function modalForm(url) {
            ajaxModal(url, null, 'get', '#modal');
        }
    </script>
@endsection