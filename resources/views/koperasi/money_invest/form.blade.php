@extends('layouts.app')

@section('title',$menu->label)
@section('breadcrumbs')
    @php
        $breadcrumbs = [
            $menu->parentMenu->label,
            $menu->label,
            ($data->money_invest_uuid)?'Edit':'Create'
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
                                           class="col-2 col-form-label text-right ">Partner</label>
                                    <div class="col-10">
                                        <select name="cooperative_uuid" class="form-control select2" required>
                                            @foreach($partner as $i)
                                                <option value="{{$i->cooperative_uuid}}" {{($i->cooperative_uuid=$data->cooperative_uuid)?'selected':''}}>{{$i->cooperative_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Currency</label>
                                    <div class="col-10">
                                        <select name="currency_id" class="form-control select2" required>
                                            @foreach(\App\Models\Currency::get() as $i)
                                                <option value="{{$i->currency_id}}" {{($i->currency_id == $data->currency_id)?'selected':''}}>{{$i->currency_symbol}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-2 col-form-label text-right ">Amount</label>
                                    <div class="col-10">
                                        <input type="number" name="amount" class="form-control" required min="0"
                                               value="{{$data->amount}}">
                                    </div>
                                </div>
                                @if(Auth::user()->cooperatives->isEmpty())
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-2 col-form-label text-right ">Status</label>
                                        <div class="col-10">
                                            <select name="verified" class="form-control select2" required>
                                                <option value="1" {{($data->verified_at)?'selected':''}}>Verified
                                                </option>
                                                <option value="0" {{(is_null($data->verified_at))?'selected':''}}>
                                                    Unverified
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-2 col-form-label text-right "></label>
                                    <div class="col-10">
                                        <input type="hidden" value="{{$data->money_invest_uuid}}"
                                               name="money_invest_uuid">
                                        <input type="submit" class="btn btn-info">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
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