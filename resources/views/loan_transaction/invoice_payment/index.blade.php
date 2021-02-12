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
                {"targets": 1, "name": "installments.due_date", "title": "Due Date", "className": "td-center"},
                {"targets": 2, "name": "invoice_number", "title": "Inv", "className": "td-center"},
                {"targets": 3, "name": "transaction_number", "title": "Trx No.", "className": "td-center"},
                {"targets": 4, "name": "customer_number", "title": "Customer Number", "className": "td-center"},
                {"targets": 5, "name": "name", "title": "Name"},
                {"targets": 6, "name": "installment_amount", "title": "Installment Amount"},
                {"targets": 7, "name": "interest_amount", "title": "Interest"},
                {"targets": 8, "name": "fine_total_amount", "title": "Fine"},
                {"targets": 9, "name": "pay_at", "title": "Status"},
                {"targets": 10, "orderable": false, "name": "", "title": ""},
            ],
            "order": [[1, "desc"]],
            buttons: []
        });

        function modalForm(url) {
            ajaxModal(url, null, 'get', '#modal');
        }
    </script>
@endsection