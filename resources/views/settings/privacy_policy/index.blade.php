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
                    <div id="messages"></div>
                    <form class="form" method="post" action="{{url($url)}}/save">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <br>
                            {{$data->title}}
                        </div>
                        <div class="form-group">
                            <label class="control-label">Content</label>
                            <textarea class="form-control summernote" name="content">{{$data->content}}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" value="{{$data->title}}" name="title">
                            <input type="hidden" value="{{$data->setting_uuid}}" name="setting_uuid">
                            <input type="submit" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="/assets/node_modules/summernote/dist/summernote-bs4.css">
@endsection
@section('scripts')
    <script src="/assets/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
        url = '{{url($url)}}'
        $('.summernote').summernote({
            height: 500, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false, // set focus to editable area after initializing summernote
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline',
                    // 'clear'
                ]],
                ['fontname', ['fontname']],
                // ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                // ['table', ['table']],
                // ['insert', ['link', 'picture', 'hr']],
                // ['view', ['fullscreen', 'codeview']],
                // ['help', ['help']]
            ],
        });

        $('form').on('submit', function (e) {
            e.preventDefault();
            form = $(this)[0];
            var formData = new FormData(form);
            ajaxCustom(url + '/save', formData, 'post')
        });
    </script>
@endsection