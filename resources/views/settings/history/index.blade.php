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
                {"targets": 1, "name": "type", "title": "Type"},
                {"targets": 2, "name": "request", "title": "Request"},
                {"targets": 3, "name": "reference", "title": "Reference"},
                {"targets": 4, "name": "name", "title": "Name"},
                {"targets": 5, "name": "created_at", "title": "Time"},
            ],
            "order": [[5, "desc"]],
            buttons: []
        });

        function modalForm(url) {
            ajaxModal(url, null, 'get', '#modal');
        }
    </script>
@endsection