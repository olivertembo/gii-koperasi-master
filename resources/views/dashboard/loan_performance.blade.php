<div class="p-20">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-success"><i class="ti-money"></i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h4 class="m-b-0">Rp 300.450.000</h4>
                            <h6 class="text-muted m-b-0">Loan Total</h6></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-success"><i class="ti-money"></i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h4 class="m-b-0">Rp 450.000</h4>
                            <h6 class="text-muted m-b-0">TKB</h6></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-success"><i class="ti-money"></i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h4 class="m-b-0">Rp 450.000</h4>
                            <h6 class="text-muted m-b-0">NPC</h6></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-success"><i class="ti-money"></i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h4 class="m-b-0">Rp 50.000</h4>
                            <h6 class="text-muted m-b-0">Disperse</h6></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="card-title ">TKB</h5>
                            <div id="tkb" class="ecomm-donute"
                                 style="height: 317px;"></div>
                            <ul class="list-inline m-t-30 text-center">
                                <li class="p-r-20">
                                    <h5 class="text-muted"><i class="fa fa-circle"
                                                              style="color:#01c0c8 ;"></i> Success
                                    </h5>
                                    <h4 class="m-b-0">8500</h4>
                                </li>
                                <li class="p-r-20">
                                    <h5 class="text-muted"><i class="fa fa-circle"
                                                              style="color: #ff0000;"></i> Failed
                                    </h5>
                                    <h4 class="m-b-0">3630</h4>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="card-title ">Total Pinjaman</h5>
                            {{--<ul class="list-inline text-center">--}}
                            {{--<li>--}}
                            {{--<h5><i class="fa fa-circle m-r-5" style="color: #00bfc7;"></i>iMac</h5>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<h5><i class="fa fa-circle m-r-5" style="color: #b4becb;"></i>iPhone</h5>--}}
                            {{--</li>--}}
                            {{--</ul>--}}
                            <div id="area3" style="height: 370px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">NPL</h4>
                    <div id="npl"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Default %</h4>
                    <div id="def"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ketepatan Waktu Pembayaran</h4>
                    <ul class="country-state slimscrollcountry">
                        <li>
                            <h4>Pembayaran Tepat Waktu</h4>
                            <div class="pull-right">10% <i
                                        class="fa fa-level-up text-info"></i>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar"
                                     aria-valuenow="50" aria-valuemin="0"
                                     aria-valuemax="100"
                                     style="width:48%; height: 6px;"><span
                                            class="sr-only">48% Complete</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <h4>Pembayaran Tertunggak</h4>
                            <div class="pull-right">45% <i
                                        class="fa fa-level-up text-warning"></i>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar"
                                     aria-valuenow="50" aria-valuemin="0"
                                     aria-valuemax="100"
                                     style="width:45%; height: 6px;"><span
                                            class="sr-only">48% Complete</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <h4>Pembayaran Terlambat</h4>
                            <div class="pull-right">45% <i
                                        class="fa fa-level-up text-danger"></i>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar"
                                     aria-valuenow="50" aria-valuemin="0"
                                     aria-valuemax="100"
                                     style="width:45%; height: 6px;"><span
                                            class="sr-only">48% Complete</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        //tab3
        tkb = Morris.Donut({
            element: 'tkb',
            data: [{
                label: "Success",
                value: 8500,

            }, {
                label: "Failed",
                value: 3630,
            }],
            resize: true,
            colors: ['#01c0c8', '#ff0000',]
        });
        area3 = Morris.Area({
            element: 'area3',
            data: [{
                period: '2010',
                iMac: 0,
                iPhone: 0,

            }, {
                period: '2011',
                iMac: 130,
                iPhone: 100,

            }, {
                period: '2012',
                iMac: 30,
                iPhone: 60,

            }, {
                period: '2013',
                iMac: 30,
                iPhone: 200,

            }, {
                period: '2014',
                iMac: 200,
                iPhone: 150,

            }, {
                period: '2015',
                iMac: 105,
                iPhone: 90,

            },
                {
                    period: '2016',
                    iMac: 250,
                    iPhone: 150,

                }],
            xkey: 'period',
            ykeys: ['iMac', 'iPhone'],
            labels: ['iMac', 'iPhone'],
            pointSize: 0,
            fillOpacity: 0.4,
            pointStrokeColors: ['#b4becb', '#01c0c8'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 0,
            smooth: true,
            hideHover: 'auto',
            lineColors: ['#b4becb', '#01c0c8'],
            resize: true
        });
        npl = Morris.Bar({
            element: 'npl',
            data: [{
                y: '2011',
                I: 75,
                II: 65,
                III: 40,
                IV: 60
            }, {
                y: '2012',
                I: 100,
                II: 90,
                III: 40,
                IV: 40,
            }],
            xkey: 'y',
            ykeys: ['I', 'II', 'III', 'IV'],
            labels: ['I', 'II', 'III', 'IV'],
            barColors: ['#b8edf0', '#b4c1d7', '#fcc9ba', '#fcd6ba'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });
        def = Morris.Area({
            element: 'def',
            data: [{
                period: '2010',
                iMac: 0,
                iPhone: 0,

            }, {
                period: '2011',
                iMac: 130,
                iPhone: 100,

            }, {
                period: '2012',
                iMac: 30,
                iPhone: 60,

            }, {
                period: '2013',
                iMac: 30,
                iPhone: 200,

            }, {
                period: '2014',
                iMac: 200,
                iPhone: 150,

            }, {
                period: '2015',
                iMac: 105,
                iPhone: 90,

            },
                {
                    period: '2016',
                    iMac: 250,
                    iPhone: 150,

                }],
            xkey: 'period',
            ykeys: ['iMac', 'iPhone'],
            labels: ['iMac', 'iPhone'],
            pointSize: 0,
            fillOpacity: 0.4,
            pointStrokeColors: ['#b4becb', '#01c0c8'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 0,
            smooth: true,
            hideHover: 'auto',
            lineColors: ['#b4becb', '#01c0c8'],
            resize: true

        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            switch (target) {
                case "#tab1":
                    break;
                case "#tab2":
                    break;
                case "#tab3":
                    tkb.redraw();
                    area3.redraw();
                    npl.redraw();
                    def.redraw();
                    $(window).trigger('resize');
                    break;
            }
        });
    });
</script>