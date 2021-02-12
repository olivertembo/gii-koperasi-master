@extends('layouts.app')

@section('title',$menu->label)
@section('breadcrumbs')
    @php
        $breadcrumbs = [
           $menu->label
        ];
    @endphp
@endsection

@section('content')
    <iframe src="https://web.freshchat.com" width="100%"></iframe>
@endsection

@section('styles')
@endsection
@section('scripts')
    <script>

    </script>
@endsection