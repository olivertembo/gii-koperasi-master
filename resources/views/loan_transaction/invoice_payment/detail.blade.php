@extends('layouts.app')

@section('title','Invoice & Payment Detail')
@section('breadcrumbs')
    @php
        $breadcrumbs = [
        'Loan Transaction',
        'Invoice & Payment',
        'Detail',
        ];
    @endphp
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="printableArea" class="card card-body ">
                <div class="row">
                    <div class="col-12 text-right">
                        <button id="print" class="btn btn-default btn-outline" type="button">
                            <span><i class="fa fa-print"></i> Print</span>
                        </button>
                        <h3><span class="pull-right">{{$data->invoice_number}}</span></h3>
                    </div>
                </div>
                <HR>
                <div class="row">
                    <div class="col-8">
                        <div class="pull-left">
                            <address>
                                <h4>Invoice To</h4>
                                <h5>{{$data->transaction->customer->user->name}}</h5>
                                <p class="text-muted m-l-30">{{$data->transaction->customer->user->address}},
                                    <br/> {{$data->transaction->customer->user->city->city_name}}
                                    - {{$data->transaction->customer->user->postcode}}
                                    <br>{{$data->transaction->customer->user->mobile_number}}
                                </p>
                            </address>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="pull-left">
                            <address>
                                <table>
                                    <tr>
                                        <td>Transaction Ref</td>
                                        <td>:</td>
                                        <td>{{$data->transaction->transaction_number}}</td>
                                    </tr>
                                    <tr>
                                        <td>Transaction Status</td>
                                        <td>:</td>
                                        <td>
                                            @if($data->transaction->latestTransferStatus)
                                                {{$data->transaction->latestTransferStatus->transferStatus->transfer_status_name}}
                                            @elseif($data->transaction->latestShippingStatus)
                                                {{$data->transaction->latestShippingStatus->shippingStatus->shipping_status_name}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Transaction Duedate</td>
                                        <td>:</td>
                                        <td>{{date('d M Y', strtotime($data->due_date))}}</td>
                                    </tr>
                                </table>
                            </address>
                        </div>
                    </div>
                </div>
                @if($data->transaction->loan_type==2)
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table color-table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Sub Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->transaction->tProductItems as $n=> $i)
                                    <tr>
                                        <td>{{$n+1}}</td>
                                        <td>{{$i->productItem->product_item_name}}</td>
                                        <td>{{$i->currency->currency_symbol}} {{number_format($i->price_amount,0, ',','.')}}</td>
                                        <td>{{$i->quantity}}</td>
                                        <td>{{$i->currency->currency_symbol}} {{number_format($i->price_total_amount,0, ',','.')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right text-right">
                                <p>Loan amount
                                    : {{$data->currency->currency_symbol}} {{number_format($data->transaction->loan_amount,0, ',','.')}}</p>
                                <p>Fee
                                    ({{($data->transaction->tFee->is_percentage==true)?$data->transaction->tFee->percentage.'%':$data->transaction->tFee->amount}}
                                    )
                                    : {{$data->currency->currency_symbol}} {{number_format($data->transaction->fee_amount,0, ',','.')}} </p>

                                <p>Courier Cost
                                    : {{$data->currency->currency_symbol}} {{number_format($data->transaction->courier_cost,0, ',','.')}}</p>
                                <hr>
                                <p>
                                <h4><b>Total
                                        : {{$data->currency->currency_symbol}} {{number_format($data->transaction->loan_amount+$data->transaction->courier_cost+$data->transaction->fee_amount,0, ',','.')}}</b>
                                </h4></p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" style="clear: both;">
                            <table class="table color-table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>INV</th>
                                    <th>Due date</th>
                                    <th>Installment</th>
                                    <th>Interest</th>
                                    <th>Fine</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Ref.</th>
                                    <th>Pay at</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->transaction->installments as $i)
                                    <tr>
                                        <td>{{$i->installment_to}}</td>
                                        <td>{{$i->invoice_number}}</td>
                                        <td>{{$i->due_date}}</td>
                                        <td>{{number_format($i->installment_amount,0, ',','.')}}</td>
                                        <td>{{number_format($i->interest_amount,0, ',','.')}}</td>
                                        <td>{{number_format($i->fine_total_amount,0, ',','.')}}</td>
                                        <td>{{$data->currency->currency_symbol}} {{number_format($i->installment_amount+$i->interest_amount + $i->fine_total_amount,0, ',','.')}}</td>
                                        <td>{!! ($i->pay_at)?'<label class="label label-success">paid</label>':'<label class="label label-danger">unpaid</label>' !!}</td>
                                        <td>{{$i->payment_transaction_number}}</td>
                                        <td>{{$i->pay_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right text-right">
                            @if($data->transaction->loan_type==1)
                                <p>Fee
                                    ({{($data->transaction->tFee->is_percentage==true)?$data->transaction->tFee->percentage.'%':$data->transaction->tFee->amount}}
                                    )
                                    : {{$data->currency->currency_symbol}} {{number_format($data->transaction->fee_amount,0, ',','.')}} </p>
                                <p>Loan amount
                                    : {{$data->currency->currency_symbol}} {{number_format($data->transaction->loan_amount,0, ',','.')}}</p>
                            @endif
                            <hr>
                            <h3><b>Installment to Pay
                                    : </b>{{$data->currency->currency_symbol}} {{number_format($data->installment_amount+$data->interest_amount + $data->fine_total_amount,0, ',','.')}}
                            </h3>
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

    <script src="/dist/js/pages/jquery.PrintArea.js" type="text/JavaScript"></script>

    <script>
        $("#print").click(function () {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("#printableArea").printArea(options);
        });
    </script>
@endsection