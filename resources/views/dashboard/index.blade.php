@extends('layouts.app')

@section('title','Dashboard')
@section('breadcrumbs')
    @php
        $breadcrumbs = [
            'Dashboard',
        ];
    @endphp
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs customtab2" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab1" role="tab"><span
                                class="hidden-sm-up">Overview</span></a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab2" role="tab"><span
                                class="hidden-sm-up">Financing</span></a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab3" role="tab"><span
                                class="hidden-sm-up">Laon Performance</span></a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="tab1" role="tabpanel">
                    @include('dashboard.overview')
                </div>
                <div class="tab-pane" id="tab2" role="tabpanel">
                    @include('dashboard.financing')
                </div>
                <div class="tab-pane" id="tab3" role="tabpanel">
                    @include('dashboard.loan_performance')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- This page CSS -->
    <link href="/assets/node_modules/morrisjs/morris.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="/dist/css/pages/dashboard4.css" rel="stylesheet">
@endsection
@section('scripts')
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--Sky Icons JavaScript -->
    <script src="/assets/node_modules/skycons/skycons.js"></script>
    <!--morris JavaScript -->
    <script src="/assets/node_modules/raphael/raphael-min.js"></script>
    <script src="/assets/node_modules/morrisjs/morris.min.js"></script>
    <script src="/assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Chart JS -->
    {{--<script src="dist/js/dashboard4.js"></script>--}}

    <script>
        // $(document).ready(function () {
        //     $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        //         var target = $(e.target).attr("href") // activated tab
        //         console.log(target)
        //         switch (target) {
        //             case "#tab1":
        //                 donut1.redraw();
        //                 donut2.redraw();
        //                 area1.redraw();
        //                 homeBar.redraw();
        //                 $(window).trigger('resize');
        //                 break;
        //             case "#tab2":
        //                 pencairan.redraw();
        //                 purpose.redraw();
        //                 donut3.redraw();
        //                 area2.redraw();
        //                 bar1.redraw();
        //                 bar2.redraw();
        //                 $(window).trigger('resize');
        //                 break;
        //             case "#tab3":
        //                 tkb.redraw();
        //                 area3.redraw();
        //                 npl.redraw();
        //                 def.redraw();
        //                 $(window).trigger('resize');
        //                 break;
        //         }
        //     });
        // });
    </script>
@endsection