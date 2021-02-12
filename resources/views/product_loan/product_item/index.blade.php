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
                    {{--<div class="row">--}}
                        {{--@if(Auth::user()->isVerificator())--}}
                            {{--<a class="btn btn-info m-l-15" href="javascript:void(0)"--}}
                               {{--onclick="modalForm('{{$url.'/create'}}')">--}}
                                {{--<i class="fa fa-plus-circle"></i> Add Product Item--}}
                            {{--</a>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    {{--<br>--}}
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label class="control-label">Category</label>
                                <select name="" id="product_category_uuid" class="form-control" onchange="getList(0)">
                                    <option value="">All</option>
                                    @foreach(\App\Models\ProductCategory::get() as $i)
                                        <option value="{{$i->product_category_uuid}}">{{$i->product_category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label class="control-label">Product</label>
                                <select name="" id="product_uuid" class="form-control" onchange="getList(0)">
                                    <option value="">All</option>
                                    @foreach(\App\Models\Product::get() as $i)
                                        <option value="{{$i->product_uuid}}">{{$i->product_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <select name="" id="is_active" class="form-control" onchange="getList(0)">
                                    <option value="">All</option>
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Search</label>
                                <input type="text" id="search" class="form-control" placeholder="Search"
                                       onkeyup="getList(0)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="item"></div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="/assets/node_modules/summernote/dist/summernote-bs4.css">
    <style>
        th, td.td-center {
            text-align: center;
        }

        .carousel-inner .carousel-item {
            height: 200px;
            background-size: cover;
            background-position: center center;
        }
    </style>
@endsection
@section('scripts')
    <script src="/assets/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
        url = '{{url($url)}}'
        // $('#product_category_uuid').select2({width: '100%'});
        // $('#product_uuid').select2({width: '100%'});
        // $('#is_active').select2({width: '100%'});

        function modalForm(url) {
            ajaxModal(url, null, 'get', '#modal');
        }

        onload = getItems();

        function getItems() {
            $("#custom-loader").show();
            $.get(url + '/card', function (data, status) {
                $('#item').html(data);
                $("#custom-loader").hide();
            });
        }
    </script>
@endsection