@extends('layouts.app')

@section('title', $menu->label.' Detail')
@section('breadcrumbs')
    @php
        $breadcrumbs = [
                $menu->parentMenu->label,
                $menu->label,
                 $menu->label.' Detail'
            ];
    @endphp
@endsection

@section('content')
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30">
                        @if($data->customer->user->file_path)
                            <img src="{{env('API_URL').'/'.$data->customer->user->file_path}}"
                                 class="img-circle"
                                 width="150"/>
                        @else
                            <img src="/assets/images/default-avatar.png" class="img-circle"
                                 width="150"/>
                        @endif
                        <h4 class="card-title m-t-10">{{$data->customer->user->name}}</h4>
                        <h6 class="card-subtitle">{{($data->customer->user->city)?$data->customer->user->city->city_name:'-'}}</h6>
                        <h6 class="card-subtitle">{{$data->customer->user->address}}</h6>
                        <h6 class="card-subtitle">{{$data->customer->user->mobile_number}}</h6>
                        <div class="row text-center justify-content-md-center">
                            <div class="col-6"><font class="font-medium">Income :</font></div>
                            <div class="col-6"><font class="font-medium">Join Date :</font></div>
                        </div>
                        <div class="row text-center justify-content-md-center">
                            <div class="col-6">
                                <font class="font-medium">{{($data->customer->income)?number_format($data->customer->income,0,',','.'):'-'}}</font>
                            </div>
                            <div class="col-6"><font class="font-medium">{{$data->customer->join_date}}</font></div>
                        </div>
                    </center>
                </div>
                <hr>
                <div class="card-body">
                    @if(count($data->tProductItems)!=0)
                        <center>
                            <h3 class="text-muted">Product Loan</h3>
                        </center>
                        <br>
                        @foreach($data->tProductItems as $i)
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h4 class="m-b-0 text-info">{{$i->productItem->product_item_name}}</h4>
                                    <h6 class="text-muted m-b-0">{{$i->productItem->product->sku}}
                                        -{{$i->productItem->sku}}</h6>
                                    <h6 class="text-muted m-b-0">{{number_format($i->price_amount,0, ',','.')}}
                                        * {{$i->quantity}}</h6>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    @else
                        <center>
                            <h3 class="text-muted">Money Loan </h3>
                            <br>
                            <h4 class="text-info">{{$data->currency->currency_symbol}} {{number_format($data->loan_amount,0, ',','.')}}</h4>
                        </center>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="#" class="form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="messages"></div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Trx ID</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" readonly
                                                   value="{{$data->transaction_number}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Trx at</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" readonly
                                                   value="{{$data->created_at}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Tenure</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" readonly
                                                   value="{{$data->tInterest->tenure}} {{$data->tInterest->interestType->interest_type_name}}, {{$data->tInterest->interest_percentage}}% / {{$data->tInterest->day_amount}} day">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Loan Amount</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" readonly
                                                   value="{{$data->currency->currency_symbol}} {{number_format($data->loan_amount,0, ',','.')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Fee Amount</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" readonly
                                                   value="{{$data->currency->currency_symbol}} {{number_format($data->fee_amount,0, ',','.')}}">
                                        </div>
                                    </div>

                                    @if(count($data->tProductItems)==0)
                                    @else
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Coupon</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" readonly
                                                       value="{{$data->currency->currency_symbol}} {{number_format($data->discount,0, ',','.')}}">
                                            </div>
                                        </div>
                                    @endif
                                    @if(count($data->tProductItems)==0)
                                        <hr>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Purposed Loan</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" readonly
                                                       value="{{$data->loanPurpose->loan_purpose_name}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Fund to Transfer</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" readonly
                                                       value="{{$data->currency->currency_symbol}} {{number_format($data->loan_amount - $data->fee_amount,0, ',','.')}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Bank</label>
                                            <div class="col-md-9">
                                                <select name="bank_uuid" id="" class="form-control select2"
                                                        {{(($data->latestTransferStatus)?(in_array($data->latestTransferStatus->transfer_status_id,[3,4])?'disabled':''):'')}} required>
                                                    @foreach(\App\Models\Bank::get() as $i)
                                                        <option value="{{ $i->bank_uuid }}" {{($i->bank_uuid==$data->tTransferAccount->bank_uuid)?'selected':''}}>{{$i->bank_name}}
                                                            ({{$i->bank_code}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Account Number</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="account_number" required
                                                       {{(($data->latestTransferStatus)?(in_array($data->latestTransferStatus->transfer_status_id,[3,4])?'disabled':''):'')}}
                                                       value="{{$data->tTransferAccount->account_number}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Recipient Name</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="recipient_name" required
                                                       {{(($data->latestTransferStatus)?(in_array($data->latestTransferStatus->transfer_status_id,[3,4])?'disabled':''):'')}}
                                                       value="{{$data->tTransferAccount->recipient_name}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Branch</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="branch" required
                                                       {{(($data->latestTransferStatus)?(in_array($data->latestTransferStatus->transfer_status_id,[3,4])?'disabled':''):'')}}
                                                       value="{{$data->tTransferAccount->branch}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Transaction Status</label>
                                            <div class="col-md-9">
                                                <select class="form-control"
                                                        name="transfer_status_id"
                                                        {{(($data->latestTransferStatus)?(in_array($data->latestTransferStatus->transfer_status_id,[3,4])?'disabled':''):'')}}>
                                                    @foreach(\App\Models\TransferStatus::orderBy('transfer_status_id','asc')->get() as $i)
                                                        <option value="{{$i->transfer_status_id}}"{{($data->latestTransferStatus->transfer_status_id==$i->transfer_status_id)?'selected':''}}>{{$i->transfer_status_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Status
                                                Information</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="information"
                                                       {{(($data->latestTransferStatus)?(in_array($data->latestTransferStatus->transfer_status_id,[3,4])?'disabled':''):'')}}
                                                       value="{{$data->latestTransferStatus->information}}">
                                            </div>
                                        </div>
                                    @else
                                        <hr>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Cooperative</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="information" disabled
                                                       value="{{($data->cooperative)?$data->cooperative->cooperative_name:'-'}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Shipping Status</label>
                                            <div class="col-md-9">
                                                <select class="form-control"
                                                        name="shipping_status_id"
                                                        {{(($data->latestShippingStatus)?(in_array($data->latestShippingStatus->shipping_status_id,[8,7])?'disabled':''):'')}}>
                                                    @foreach(\App\Models\ShippingStatus::orderBy('shipping_status_id','asc')->get() as $i)
                                                        <option value="{{$i->shipping_status_id}}"{{($data->latestShippingStatus->shipping_status_id==$i->shipping_status_id)?'selected':''}}>{{$i->shipping_status_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Status
                                                Information</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="information"
                                                       {{(($data->latestShippingStatus)?(in_array($data->latestShippingStatus->shipping_status_id,[8,7])?'disabled':''):'')}}
                                                       value="{{$data->latestShippingStatus->information}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Recipient</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="recipient_name" required
                                                       {{(($data->latestShippingStatus)?(in_array($data->latestShippingStatus->shipping_status_id,[8,7])?'disabled':''):'')}}
                                                       value="{{$data->tShippingAddress->recipient_name}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Address</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="address" required
                                                       {{(($data->latestShippingStatus)?(in_array($data->latestShippingStatus->shipping_status_id,[8,7])?'disabled':''):'')}}
                                                       value="{{$data->tShippingAddress->address}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">City</label>
                                            <div class="col-md-9">
                                                <select name="city_id" class="form-control select2city" required
                                                        {{(($data->latestShippingStatus)?(in_array($data->latestShippingStatus->shipping_status_id,[8,7])?'disabled':''):'')}}
                                                >
                                                    @if($data->tShippingAddress->city)
                                                        <option selected
                                                                value="{{$data->tShippingAddress->city->city_id}}">{{$data->tShippingAddress->city->city_name}}
                                                            ({{$data->tShippingAddress->city->tipe_dati2}})
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Phone</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="mobile_number" required
                                                       {{(($data->latestShippingStatus)?(in_array($data->latestShippingStatus->shipping_status_id,[8,7])?'disabled':''):'')}}
                                                       value="{{$data->tShippingAddress->mobile_number}}">
                                            </div>
                                        </div>
                                        <hr>
                                        @php
                                            $origin =  json_decode($data->cooperative->origin_details, true);
                                            $dest =  json_decode($data->destination_details, true);
                                        @endphp
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Courier</label>
                                            <div class="col-md-9">
                                                <div>
                                                    @if($dest)
                                                        <table>
                                                            <tr>
                                                                <td>Code</td>
                                                                <td>:</td>
                                                                <td>{{$data->courier_code}}
                                                                    - {{$data->courier_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Sevice</td>
                                                                <td>:</td>
                                                                <td>{{$data->courier_service_code}}
                                                                    - {{$data->courier_service_description}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Origin</td>
                                                                <td>:</td>
                                                                <td>{{$origin['province']}}
                                                                    , {{$origin['city']}} {{$origin['type']}}
                                                                    , {{$origin['subdistrict_name']}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Destination</td>
                                                                <td>:</td>
                                                                <td>{{$dest['province']}}
                                                                    , {{$dest['city']}} {{$dest['type']}}
                                                                    , {{$dest['subdistrict_name']}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Cost</td>
                                                                <td>:</td>
                                                                <td>{{number_format($data->courier_cost,0, ',','.')}}</td>
                                                            </tr>
                                                        </table>
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Courier Resi</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="courier_resi"
                                                       value="{{$data->courier_resi}}">
                                            </div>
                                        </div>
                                        @if($histori)
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Summary</label>
                                                <div class="col-md-9">
                                                    Receiver : {{$histori['summary']['receiver_name']}}<br>
                                                    Waybill date : {{$histori['summary']['waybill_date']}}
                                                    <br>
                                                    Shipper : {{$histori['summary']['shipper_name']}}<br>
                                                    Origin : {{$histori['summary']['origin']}}<br>
                                                    Destination : {{$histori['summary']['destination']}}<br>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Delivey Status</label>
                                                <div class="col-md-9">
                                                    {{$histori['delivery_status']['status']}} <br>
                                                    {{$histori['delivery_status']['pod_receiver']}}<br>
                                                    {{$histori['delivery_status']['pod_date']}} {{$histori['delivery_status']['pod_time']}}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Manifest</label>
                                                <div class="col-md-9">
                                                    <table>
                                                        @foreach($histori['manifest'] as $i)
                                                            <tr>
                                                                <td>
                                                                    <span class="text-info">{{$i['manifest_date']}} {{$i['manifest_time']}}</span>
                                                                    <br>{{$i['manifest_description']}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @if((($data->latestTransferStatus)?(!in_array($data->latestTransferStatus->transfer_status_id,[3,4])):''))
                                <hr>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            @csrf
                                            <input type="hidden" name="transaction_uuid"
                                                   value="{{$data->transaction_uuid}}">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button type="button" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                                {{--                            @elseif((($data->latestShippingStatus)?(!in_array($data->latestShippingStatus->shipping_status_id,[8,7])):''))--}}
                            @elseif($data->latestShippingStatus)
                                <hr>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            @csrf
                                            <input type="hidden" name="transaction_uuid"
                                                   value="{{$data->transaction_uuid}}">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button type="button" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(count($data->installments)!=0)
        <div class="row">
            <div class="col-lg-12 col-xlg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table color-table">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>INV</th>
                                            <th>Due date</th>
                                            <th>Installment</th>
                                            <th>Interest</th>
                                            <th>Fine</th>
                                            <th>Grand Total</th>
                                            <th>Status</th>
                                            <th>Ref.</th>
                                            <th>Pay at</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data->installments as $i)
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
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('styles')
@endsection
@section('scripts')
    <script>
        url = '{{url($url)}}';
        $(".select2").select2();
        $('form').on('submit', function (e) {
            e.preventDefault();
            form = $(this)[0];
            var formData = new FormData(form);
            ajaxCustom(url + '/save', formData, 'post')
        });

        $(".select2city").select2(
            {
                placeholder: "City Name",
                allowClear: true,
                width: '100%',
                ajax: {
                    type: "GET",
                    url: '{{url('/open/city')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            }
        );
    </script>
@endsection