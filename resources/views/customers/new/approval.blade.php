@extends('layouts.app')

@section('title','Approval')
@section('breadcrumbs')
    @php
        $breadcrumbs = [
                $menu->parentMenu->label,
                $menu->label,
                'Approval'
            ];
    @endphp
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30">
                        @if($data->user->file_path)
                            <img src="{{env('API_URL').'/'.$data->user->file_path}}"
                                 class="img-circle"
                                 width="150"/>
                        @else
                            <img src="/assets/images/default-avatar.png" class="img-circle"
                                 width="150"/>
                        @endif
                        <h4 class="card-title m-t-10">{{$data->user->name}}</h4>
                        <h6 class="card-subtitle">{{($data->user->city)?$data->user->city->city_name:'-'}}</h6>
                        <h6 class="card-subtitle">{{$data->user->address}}</h6>
                        <h6 class="card-subtitle">{{$data->user->mobile_number}}</h6>
                        <div class="row text-center justify-content-md-center">
                            <div class="col-6"><font class="font-medium">Income :</font></div>
                            <div class="col-6"><font class="font-medium">Register Date :</font></div>
                        </div>
                        <div class="row text-center justify-content-md-center">
                            <div class="col-6"><font class="font-medium">{{$data->income?:'-'}}</font></div>
                            <div class="col-6"><font class="font-medium">{{$data->user->created_at}}</font></div>
                        </div>
                    </center>
                </div>
                <div>
                    <hr>
                </div>
                <div class="card-body">
                    <div class="form-group row pt-3">
                        <div class="col-sm-12">


                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="true"
                                       id="customCheck2" {{($data->latestUpgradeStatus->is_dukcapil==true)?'checked':''}}>
                                <label class="custom-control-label" for="customCheck2">Dukcapil Check</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="true"
                                       id="customCheck3" {{($data->latestUpgradeStatus->is_id==true)?'checked':''}}>
                                <label class="custom-control-label" for="customCheck3">Identity Card</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="true"
                                       id="customCheck4" {{($data->latestUpgradeStatus->is_id_selfie==true)?'checked':''}}>
                                <label class="custom-control-label" for="customCheck4">Selfie with Identity Card</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="true"
                                       id="customCheck5" {{($data->latestUpgradeStatus->is_slip==true)?'checked':''}}>
                                <label class="custom-control-label" for="customCheck5">Slip Income/Income
                                    Statement</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="true"
                                       id="customCheck1" {{($data->latestUpgradeStatus->is_cooperative==true)?'checked':''}}>
                                <label class="custom-control-label" for="customCheck1">Cooperative
                                    : {{($data->cooperative)?$data->cooperative:'-'}}</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" onsubmit="return false;">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row el-element-overlay">
                                        <div class="form-group row">
                                            @foreach($data->customerDocuments as $d)
                                                @if($d->file_path)
                                                    <div class="col-lg-6 col-md-6"
                                                         title="{{$d->document->document_name}}">
                                                        <div class="card-header">
                                                            {{$d->document->document_name}}
                                                        </div>
                                                        <div class="card">
                                                            <div class="el-card-item">
                                                                <div class="el-card-avatar el-overlay-1">
                                                                    @php
                                                                        //$url = \Illuminate\Support\Facades\Storage::url($d->file_path);
                                                                        $url_image_api = env('API_URL').'/'.$d->file_path;
                                                                    @endphp
                                                                    <img src="{{$url_image_api}}"
                                                                         alt="user"/>
                                                                    <div class="el-overlay">
                                                                        <ul class="el-info">
                                                                            <li>
                                                                                <a class="btn default btn-outline image-popup-vertical-fit"
                                                                                   href="{{$url_image_api}}">
                                                                                    <i class="icon-magnifier"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div id="messages"></div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">NIK<i style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="nik"
                                                   placeholder="Identity Number (NIK)" value="{{$data->user->nik}}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Name<i style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="name" placeholder="Name"
                                                   required value="{{$data->user->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Email<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control" name="email" placeholder="Email"
                                                   required value="{{$data->user->email}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Mobile Number<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="mobile_number"
                                                   placeholder="Mobile Number"
                                                   required value="{{$data->user->mobile_number}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Birth<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="birthplace"
                                                   placeholder="Birthplace"
                                                   required value="{{$data->user->birthplace}}">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="date" class="form-control" name="birthdate"
                                                   placeholder="Birthdate"
                                                   required value="{{$data->user->birthdate}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Mother Name<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="mother_name"
                                                   placeholder="Mother Name"
                                                   required value="{{$data->mother_name}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Address<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="address"
                                                   placeholder="Address"
                                                   required value="{{$data->user->address}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">City<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <select name="city_id" class="form-control select2city" required>
                                                @if($data->user->city)
                                                    <option selected
                                                            value="{{$data->user->city->city_id}}">{{$data->user->city->city_name}}
                                                        ({{$data->user->city->tipe_dati2}})
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Postcode<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="postcode"
                                                   placeholder="Postcode" value="{{$data->user->postcode}}"
                                                   required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Job<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <select name="job_id" class="form-control" id="">
                                                @foreach(\App\Models\Job::all() as $i)
                                                    <option value="{{$i->job_id}}" {{($data->job_id==$i->job_id)?'selected':''}}>{{$i->job_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Work Place<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="work_place"
                                                   placeholder="Work Place" value="{{$data->work_place}}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Work Experiance (month)<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <input type="number" class="form-control" name="work_experience"
                                                   placeholder="Work Experiance (month)" min="0"
                                                   value="{{$data->work_experience}}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Income<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <input type="number" class="form-control" name="income"
                                                   placeholder="Income" min="0" value="{{$data->income}}"
                                                   required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Cuatomer Status</label>
                                        <div class="col-md-10">
                                            <select name="customer_status_id" id="" class="form-control">
                                                @foreach(\App\Models\CustomerStatus::all() as $i)
                                                    <option value="{{$i->customer_status_id}}" {{($data->customer_status_id==$i->customer_status_id)?'selected':''}}>{{$i->customer_status_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Upgrade Status</label>
                                        <div class="col-md-10">
                                            <select name="upgrade_status_id" id="" class="form-control">
                                                @foreach(\App\Models\UpgradeStatus::orderBy('upgrade_status_id')->get() as $i)
                                                    <option value="{{$i->upgrade_status_id}}" {{($data->latestUpgradeStatus->upgrade_status_id==$i->upgrade_status_id)?'selected':''}}>{{$i->upgrade_status_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Upgrade Status
                                            Information</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="description"
                                                   placeholder="Upgrade Status Information"
                                                   value="{{$data->latestUpgradeStatus->description}}">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Currency<i
                                                    style="color: red">*</i></label>
                                        <div class="col-md-10">
                                            <select name="currency_id" class="form-control" required>
                                                @foreach(\App\Models\Currency::get() as $i)
                                                    <option value="{{$i->currency_id}}" {{($data->currency_id==$i->currency_id)?'selected':''}}>{{$i->currency_symbol}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Limit</label>
                                        <div class="col-md-10">
                                            <input type="number" class="form-control" name="limit" placeholder="Limit"
                                                   min="0" value="{{$data->limit}}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-2">Join Date</label>
                                        <div class="col-md-10">
                                            <input type="date" class="form-control" name="join_date"
                                                   value="{{$data->join_date}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            @csrf
                                            <input type="hidden" name="customer_uuid" value="{{$data->customer_uuid}}">
                                            <input type="hidden" name="user_uuid" value="{{$data->user_uuid}}">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button type="button" class="btn btn-inverse"
                                                    onclick="window.history.back();">Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="/assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <link href="/dist/css/pages/user-card.css" rel="stylesheet">
@endsection
@section('scripts')
    <!-- Magnific popup JavaScript -->
    <script src="/assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="/assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>

    <script>

        url = '{{url($url)}}';
        $('form').on('submit', function (e) {
            e.preventDefault();
            form = $(this)[0];
            var formData = new FormData(form);
            if ($('#customCheck1').is(':checked')) {
                is_cooperative = true
            } else {
                is_cooperative = false
            }
            formData.append('is_cooperative', is_cooperative);
            if ($('#customCheck2').is(':checked')) {
                is_dukcapil = true
            } else {
                is_dukcapil = false
            }
            formData.append('is_dukcapil', is_dukcapil);
            if ($('#customCheck3').is(':checked')) {
                is_id = true
            } else {
                is_id = false
            }
            formData.append('is_id', is_id);
            if ($('#customCheck4').is(':checked')) {
                is_id_selfie = true
            } else {
                is_id_selfie = false
            }
            formData.append('is_id_selfie', is_id_selfie);
            if ($('#customCheck5').is(':checked')) {
                is_slip = true
            } else {
                is_slip = false
            }
            formData.append('is_slip', is_slip);
            ajaxCustom(url + '/save', formData, 'post')
        });

        $(".select2city").select2(
            {
                placeholder: "City",
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