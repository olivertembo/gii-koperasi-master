@extends('layouts.app')

@section('title',$menu->label)
@section('breadcrumbs')
    @php
        $breadcrumbs = [
            $menu->parentMenu->label,
            $menu->label,
            ($data->user_uuid)?'Edit':'Create'
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
                                           class="col-2 col-form-label text-right ">Name</label>
                                    <div class="col-10">
                                        <input class="form-control" name="name" type="text"
                                               value="{{$data->name}}"
                                               required maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Gender</label>
                                    <div class="col-10">
                                        <select name="gender_id" class="form-control">
                                            @foreach(\App\Models\Gender::get() as $i)
                                                <option value="{{$i->gender_id}}" {{($data->gender_id==$i->gender_id)?'selected':''}}>{{$i->gender_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Email</label>
                                    <div class="col-10">
                                        <input class="form-control" name="email" type="email"
                                               value="{{$data->email}}"
                                               required maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Phone</label>
                                    <div class="col-10">
                                        <input class="form-control" name="mobile_number" type="text"
                                               value="{{$data->mobile_number}}"
                                               required maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Password</label>
                                    <div class="col-10">
                                        <input class="form-control" name="password" type="password"
                                               value=""
                                               @if(!$data->user_uuid)required @endif maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Password Confirm</label>
                                    <div class="col-10">
                                        <input class="form-control" name="password_confirmation" type="password"
                                               value=""
                                               @if(!$data->user_uuid)required @endif maxlength="50">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Birthdate</label>
                                    <div class="col-10">
                                        <input class="form-control" name="birthdate" type="date"
                                               value="{{$data->birthdate}}"
                                               required maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Address</label>
                                    <div class="col-10">
                                        <input class="form-control" name="address" type="text"
                                               value="{{$data->address}}"
                                               required maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Role</label>
                                    <div class="col-4">
                                        <select name="role_uuid" class="form-control">
                                            @foreach(\App\Models\Role::where('is_active',true)->where('role_type',2)->get() as $i)
                                                <option value="{{$i->role_uuid}}" {{(in_array($i->role_uuid, (($data->roles)?$data->roles->pluck('role_uuid')->toArray():[])))?'selected':''}}>{{$i->role_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Status</label>
                                    <div class="col-4">
                                        <select name="user_status_id" class="form-control">
                                            @foreach(\App\Models\UserStatus::get() as $i)
                                                <option value="{{$i->user_status_id}}" {{($data->user_status_id==$i->user_status_id)?'selected':''}}>{{$i->user_status_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Partner</label>
                                    <div class="col-10">
                                        <select name="cooperative_uuid" class="form-control select2" required>
                                            @foreach(\App\Models\Cooperative::get() as $i)
                                                <option value="{{$i->cooperative_uuid}}" {{(in_array($i->cooperative_uuid, (($data->cooperative)?$data->cooperative->pluck('cooperative_uuid')->toArray():[])))?'selected':''}}>{{$i->cooperative_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Photo</label>
                                    <div class="col-10">
                                        <input class="form-control" name="file" type="file">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-2 col-form-label text-right "></label>
                                    <div class="col-10">
                                        <input type="hidden" value="{{$data->user_uuid}}" name="user_uuid">
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
    </script>
@endsection