@extends('layouts.app')

@section('title',(($data->cooperative_uuid)?'Edit':'Add') .' '.$menu->label)
@section('breadcrumbs')
    @php
        $breadcrumbs = [
            $menu->parentMenu->label,
            $menu->label,
            (($data->cooperative_uuid)?'Edit':'Add')
        ];
    @endphp
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="messages"></div>
                    <form method="post" onsubmit="return false;"
                          enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Code</label>
                                    <input type="text" class="form-control" name="cooperative_code" required
                                           value="{{$data->cooperative_code}}">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Partner Name</label>
                                    <input type="text" class="form-control" name="cooperative_name" required
                                           value="{{$data->cooperative_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Address</label>
                                    <textarea type="text" class="form-control" name="cooperative_address"
                                              required>{{$data->cooperative_address}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">City</label>
                                    <select name="city_id" class="form-control select2city" required>
                                        @if($data->city)
                                            <option selected value="{{$data->city->city_id}}">{{$data->city->city_name}}
                                                ({{$data->city->tipe_dati2}})
                                            </option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class=pho"control-label">Phone</label>
                                    <input type="text" class="form-control" name="phone"
                                           required value="{{$data->phone}}">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class=pho"control-label">Email</label>
                                    <input type="text" class="form-control" name="email"
                                           required value="{{$data->email}}">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class=pho"control-label">Website</label>
                                    <input type="text" class="form-control" name="website"
                                           value="{{$data->email}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="recipient-name" class=pho"control-label">Member Additional Limit</label>
                                    <input type="number" class="form-control" name="additional_limit" required
                                           value="{{$data->additional_limit}}" min="0">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class=pho"control-label">Parner Type</label>
                                    <select name="partner_type_id" id="" class="form-control" required>
                                        @foreach(\App\Models\PartnerType::get() as $i)
                                            <option value="{{$i->partner_type_id}}" {{($i->partner_type_id==$data->partner_type_id)?'selected':''}}>{{$i->partner_type_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class=pho"control-label">Profit Sharing (Money) (%)</label>
                                    <input type="number" class="form-control" name="profit_sharing_money" required
                                           value="{{$data->profit_sharing_money}}" min="0">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class=pho"control-label">Profit Sharing Tenor
                                        (Money) (months)</label>
                                    <input type="number" class="form-control" name="profit_sharing_money_tenure" required
                                           value="{{$data->profit_sharing_money_tenure}}" min="0">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class=pho"control-label">Profit Sharing
                                        (Product) (%)</label>
                                    <input type="number" class="form-control" name="profit_sharing_product" required
                                           value="{{$data->profit_sharing_product}}" min="0">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Courier Provinces</label>
                                    <select name="courier_province" id="courier-provinces" required>
                                        <option value="">choose</option>
                                        @foreach($courier_provinces as $i)
                                            <option value="{{$i['province_id']}}" {{($data->courier_province_id==$i['province_id'])?'selected':''}}>{{$i['province']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Courier City</label>
                                    <select name="courier_city" id="courier-city" required>
                                        <option value="">choose</option>
                                        @foreach($courier_cities as $i)
                                            <option value="{{$i['city_id']}}" {{($data->courier_city_id==$i['city_id'])?'selected':''}}>{{$i['city_name']}}
                                                ({{$i['type']}})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Courier Subdistrict</label>
                                    <select name="origin" id="courier-subdistrict" required>
                                        <option value="">choose</option>
                                        @foreach($courier_subdistricts as $i)
                                            <option value="{{$i['subdistrict_id']}}"{{($data->origin==$i['subdistrict_id'])?'selected':''}}>{{$i['subdistrict_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                                <label for="recipient-name" class=pho"control-label"></label>
                                @csrf
                                <input type="hidden" id="origin-type" name="origin_type" value="{{$data->origin_type}}">
                                <input type="hidden" name="cooperative_uuid" value="{{$data->cooperative_uuid}}">
                                <input type="submit" class="btn btn-danger" value="Save">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            url = '{{url($url)}}';
            $('form').on('submit', function (e) {
                e.preventDefault();
                form = $(this)[0];
                var formData = new FormData(form);
                ajaxCustom(url + '/save', formData, 'post')
            });

            $("select").select2({width: '100%'});

            $('#courier-provinces').change(function () {
                $("#custom-loader").show();
                option = '<option value="">choose</option>'
                $("#courier-subdistrict").html(option);
                $.get(url + '/cities?province=' + this.value, function (data) {
                    data.forEach(function (item, index) {
                        option += '<option value="' + item.city_id + '">' + item.city_name + ' (' + item.type + ')</option>'
                    });
                    $("#courier-city").html(option);
                    $("#custom-loader").hide();
                })
            });

            $('#courier-city').change(function () {
                $("#custom-loader").show();
                option = '<option value="">choose</option>'
                $.get(url + '/subdistrict?city=' + this.value, function (data) {
                    data.forEach(function (item, index) {
                        option += '<option value="' + item.subdistrict_id + '">' + item.subdistrict_name + '</option>'
                    });
                    $("#courier-subdistrict").html(option);
                    $("#custom-loader").hide();
                })
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
        });
    </script>
@endsection