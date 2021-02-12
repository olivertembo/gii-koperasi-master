<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-7 align-self-center text-left">
        <div class="d-flex align-items-center">
            @yield('breadcrumbs')
            @if(isset($breadcrumbs))
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    @foreach($breadcrumbs as $key => $value)
                        @if(is_int($key))
                            @if ($loop->last)
                                <li class="breadcrumb-item active">{{ $value }}</li>
                            @else
                                <li class="breadcrumb-item">{{ $value }}</li>
                            @endif
                        @else
                            @if ($loop->last)
                                <li class="breadcrumb-item active">{{ $key }}</li>
                            @else
                                <li class="breadcrumb-item"><a href={{ $value }} >{{ $key }}</a></li>
                            @endif
                        @endif
                    @endforeach
                </ol>
            @endif
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->