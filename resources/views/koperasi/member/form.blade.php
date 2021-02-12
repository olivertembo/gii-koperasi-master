@extends('layouts.app')

@section('title',$menu->label)
@section('breadcrumbs')
    @php
        $breadcrumbs = [
            $menu->parentMenu->label,
            $menu->label,
            ($data->cooperative_member_uuid)?'Edit':'Create'
        ];
    @endphp
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="messages"></div>
                    <form class="form" method="post" action="{{url($url)}}/save" onsubmit="return false;"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Partner</label>
                                    <div class="col-9">
                                        <select name="cooperative_uuid" class="form-control select2" required>
                                            @foreach($partner as $i)
                                                <option value="{{$i->cooperative_uuid}}" {{($i->cooperative_uuid==$data->cooperative_uuid)?'selected':''}}>{{$i->cooperative_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Identity Number (NIK)</label>
                                    <div class="col-9">
                                        <input class="form-control" name="nik" type="text"
                                               value="{{$data->nik}}"
                                               required maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Member Number</label>
                                    <div class="col-9">
                                        <input class="form-control" name="member_number" type="text"
                                               value="{{$data->member_number}}"
                                               maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Name</label>
                                    <div class="col-9">
                                        <input class="form-control" name="name" type="text"
                                               value="{{$data->name}}"
                                               required maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Gender</label>
                                    <div class="col-9">
                                        <select name="gender_id" class="form-control">
                                            @foreach(\App\Models\Gender::get() as $i)
                                                <option value="{{$i->gender_id}}" {{($data->gender_id==$i->gender_id)?'selected':''}}>{{$i->gender_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Email</label>
                                    <div class="col-9">
                                        <input class="form-control" name="email" type="email"
                                               value="{{$data->email}}"
                                               required maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Phone</label>
                                    <div class="col-9">
                                        <input class="form-control" name="mobile_number" type="text"
                                               value="{{$data->mobile_number}}"
                                               required maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Join Date</label>
                                    <div class="col-9">
                                        <input class="form-control" name="join_date" type="date"
                                               value="{{$data->join_date}}"
                                               required maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Mother Name</label>
                                    <div class="col-9">
                                        <input class="form-control" name="mother_name" type="text"
                                               value="{{$data->mother_name}}"
                                               required maxlength="100">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Limit</label>
                                    <div class="col-9">
                                        <input class="form-control" name="limit" type="number"
                                               value="{{$data->limit}}"
                                               required min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Birthplace</label>
                                    <div class="col-9">
                                        <input class="form-control" name="birthplace" type="text"
                                               value="{{$data->birthplace}}"
                                               required maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Birthdate</label>
                                    <div class="col-9">
                                        <input class="form-control" name="birthdate" type="date"
                                               value="{{$data->birthdate}}"
                                               required maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Address</label>
                                    <div class="col-9">
                                        <input class="form-control" name="address" type="text"
                                               value="{{$data->address}}"
                                               required maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">City</label>
                                    <div class="col-9">
                                        <select name="city_id" class="form-control select2city" required>
                                            @if($data->city)
                                                <option selected
                                                        value="{{$data->city->city_id}}">{{$data->city->city_name}}
                                                    ({{$data->city->tipe_dati2}})
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Postcode</label>
                                    <div class="col-9">
                                        <input class="form-control" name="postcode" type="text"
                                               value="{{$data->postcode}}"
                                               required maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Status</label>
                                    <div class="col-4">
                                        <select name="customer_status_id" class="form-control">
                                            @foreach(\App\Models\CustomerStatus::get() as $i)
                                                <option value="{{$i->customer_status_id}}" {{($data->customer_status_id==$i->customer_status_id)?'selected':''}}>{{$i->customer_status_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label text-right ">Photo</label>
                                    <div class="col-9">
                                        <input class="form-control" name="file" type="file">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-3 col-form-label text-right "></label>
                                    <div class="col-9">
                                        <input type="hidden" value="{{$data->cooperative_member_uuid}}"
                                               name="cooperative_member_uuid">
                                        <input type="submit" class="btn btn-info">
                                    </div>
                                </div>
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
        url = '{{url($url)}}';
        $('form').on('submit', function (e) {
            e.preventDefault();
            form = $(this)[0];
            var formData = new FormData(form);
            ajaxCustom(url + '/save', formData, 'post')
        });

        $('.select2').select2();

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