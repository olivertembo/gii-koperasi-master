<div class="p-20">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-success"><i class="ti-user"></i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0">{{$customer_total}}</h3>
                            <h5 class="text-muted m-b-0">User Customers</h5></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-danger"><i class="ti-wallet"></i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0">{{$transaction_total}}</h3>
                            <h5 class="text-muted m-b-0">Transaction Total</h5></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-info"><i class="ti-anchor"></i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0">80%</h3>
                            <h5 class="text-muted m-b-0">TKB</h5></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="round align-self-center round-info"><i class="ti-pin"></i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0">2%</h3>
                            <h5 class="text-muted m-b-0">NPC</h5></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="card-title m-b-0">Customer</h5>
                            <center>
                                <ul class="country-state slimscrollcountry">
                                    <li>
                                        <h4>Gender</h4>
                                        <div>Men {{$gender['men']}}% - {{$gender['women']}}% Women<i
                                                    class="fa fa-level-up text-danger"></i>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                 aria-valuenow="{{$gender['men']}}" aria-valuemin="0"
                                                 aria-valuemax="100"
                                                 style="width:{{$gender['men']}}%; height: 6px;"><span
                                                        class="sr-only"></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </center>
                            <hr>
                            <ul class="country-state slimscrollcountry">
                                <li>
                                    <h4>21-25 tahun</h4>
                                    <div class="pull-right">{{($age['jml']!=0&& $age['age_21_25']!=0)?round(($age['age_21_25']/$age['jml']*100)):0}}
                                        % ({{$age['age_21_25']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age['jml']!=0&& $age['age_21_25']!=0)?round(($age['age_21_25']/$age['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age['jml']!=0&& $age['age_21_25']!=0)?round(($age['age_21_25']/$age['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h4>26-30 tahun</h4>
                                    <div class="pull-right">{{($age['jml']!=0&& $age['age_26_30']!=0)?round(($age['age_26_30']/$age['jml']*100)):0}}
                                        % ({{$age['age_26_30']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age['jml']!=0&& $age['age_26_30']!=0)?round(($age['age_26_30']/$age['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age['jml']!=0&& $age['age_26_30']!=0)?round(($age['age_26_30']/$age['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h4>31-40 tahun</h4>
                                    <div class="pull-right">{{($age['jml']!=0&& $age['age_31_40']!=0)?round(($age['age_31_40']/$age['jml']*100)):0}}
                                        % ({{$age['age_31_40']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age['jml']!=0&& $age['age_31_40']!=0)?round(($age['age_31_40']/$age['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age['jml']!=0&& $age['age_31_40']!=0)?round(($age['age_31_40']/$age['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h4>41-50 tahun</h4>
                                    <div class="pull-right">{{($age['jml']!=0&& $age['age_41_50']!=0)?round(($age['age_41_50']/$age['jml']*100)):0}}
                                        % ({{$age['age_41_50']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age['jml']!=0&& $age['age_41_50']!=0)?round(($age['age_41_50']/$age['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age['jml']!=0&& $age['age_41_50']!=0)?round(($age['age_41_50']/$age['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h4>51-60 tahun</h4>
                                    <div class="pull-right">{{($age['jml']!=0&& $age['age_51_60']!=0)?round(($age['age_51_60']/$age['jml']*100)):0}}
                                        % ({{$age['age_51_60']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age['jml']!=0&& $age['age_51_60']!=0)?round(($age['age_51_60']/$age['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age['jml']!=0&& $age['age_51_60']!=0)?round(($age['age_51_60']/$age['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h4>>60 tahun</h4>
                                    <div class="pull-right">{{($age['jml']!=0&& $age['age_60']!=0)?round(($age['age_60']/$age['jml']*100)):0}}
                                        % ({{$age['age_60']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age['jml']!=0&& $age['age_60']!=0)?round(($age['age_60']/$age['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age['jml']!=0&& $age['age_60']!=0)?round(($age['age_60']/$age['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="card-title m-b-0">Latest Transaction</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Trx</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($latest_trx as $i)
                                        <tr>
                                            <td>{{$i->transaction_number}}</td>
                                            <td>{{$i->name}}</td>
                                            <td><label class="{{$i->status_class}}">{{$i->status_name}}</label></td>
                                            <td>{{number_format($i->total,0,',','.')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <h5 class="card-title m-b-0">City</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>City</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($city as $n=> $i)
                                        <tr>
                                            <td>{{$n+1}}</td>
                                            <td>{{$i->city_name}}</td>
                                            <td>{{$i->jml}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="card-title ">Registration</h5>
                            <div id="donut1" class="ecomm-donute"
                                 style="height: 317px;"></div>
                            <ul class="list-inline m-t-30 text-center">
                                <li class="p-r-20">
                                    <h5 class="text-muted"><i class="fa fa-circle"
                                                              style="color: #fb9678;"></i> Sesuai
                                    </h5>
                                    <h4 class="m-b-0">{{$registration['sesuai_kriteria']}}</h4>
                                </li>
                                <li class="p-r-20">
                                    <h5 class="text-muted"><i class="fa fa-circle"
                                                              style="color: #01c0c8;"></i> Tidak
                                        Sesuai
                                    </h5>
                                    <h4 class="m-b-0">{{$registration['tidak_sesuai_kriteria']}}</h4>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="card-title ">Detail</h5>
                            <table width="100" class="table">
                                <tr>
                                    <td>Total Pendaftar</td>
                                    <td>:</td>
                                    <td>{{$registration['total_pendaftar']}}</td>
                                </tr>
                                <tr>
                                    <td>Sesuai Kriteria</td>
                                    <td>:</td>
                                    <td>{{$registration['sesuai_kriteria']}}</td>
                                </tr>
                                <tr>
                                    <td>Tidak Sesuai Kriteria</td>
                                    <td>:</td>
                                    <td>{{$registration['tidak_sesuai_kriteria']}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="card-title ">Transaction Status</h5>
                            <div id="donut2" class="ecomm-donute"
                                 style="height: 317px;"></div>
                            <ul class="list-inline m-t-30 text-center">
                                <li class="p-r-20">
                                    <h5 class="text-muted"><i class="fa fa-circle"
                                                              style="color:#01c0c8 ;"></i> Approved
                                    </h5>
                                    <h4 class="m-b-0">{{$transaction['approved']}}</h4>
                                </li>
                                <li class="p-r-20">
                                    <h5 class="text-muted"><i class="fa fa-circle"
                                                              style="color: #ff0000;"></i> Rejected
                                    </h5>
                                    <h4 class="m-b-0">{{$transaction['rejected']}}</h4>
                                </li>
                            </ul>

                        </div>
                        <div class="col-sm-6">
                            <h5 class="card-title ">Transaction Graphic</h5>
                            {{--<ul class="list-inline text-center">--}}
                            {{--<li>--}}
                            {{--<h5><i class="fa fa-circle m-r-5" style="color: #00bfc7;"></i>iMac</h5>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<h5><i class="fa fa-circle m-r-5" style="color: #b4becb;"></i>iPhone</h5>--}}
                            {{--</li>--}}
                            {{--</ul>--}}
                            <div id="area1" style="height: 370px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="card-title m-b-0">Partner</h5>
                            <center>
                                <ul class="country-state slimscrollcountry">
                                    <li>
                                        <h4>Gender</h4>
                                        <div>Men {{$gender_member['men']}}% - {{$gender_member['women']}}% Women<i
                                                    class="fa fa-level-up text-danger"></i>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                 aria-valuenow="{{$gender_member['men']}}" aria-valuemin="0"
                                                 aria-valuemax="100"
                                                 style="width:{{$gender_member['men']}}%; height: 6px;"><span
                                                        class="sr-only"></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </center>
                            <hr>

                            <ul class="country-state slimscrollcountry">
                                <li>
                                    <h4>21-25 tahun</h4>
                                    <div class="pull-right">{{($age_member['jml']!=0&& $age_member['age_21_25']!=0)?round(($age_member['age_21_25']/$age_member['jml']*100)):0}}
                                        % ({{$age_member['age_21_25']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age_member['jml']!=0&& $age_member['age_21_25']!=0)?round(($age_member['age_21_25']/$age_member['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age_member['jml']!=0&& $age_member['age_21_25']!=0)?round(($age_member['age_21_25']/$age_member['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h4>26-30 tahun</h4>
                                    <div class="pull-right">{{($age_member['jml']!=0&& $age_member['age_26_30']!=0)?round(($age_member['age_26_30']/$age_member['jml']*100)):0}}
                                        % ({{$age_member['age_26_30']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age_member['jml']!=0&& $age_member['age_26_30']!=0)?round(($age_member['age_26_30']/$age_member['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age_member['jml']!=0&& $age_member['age_26_30']!=0)?round(($age_member['age_26_30']/$age_member['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h4>31-40 tahun</h4>
                                    <div class="pull-right">{{($age_member['jml']!=0&& $age_member['age_31_40']!=0)?round(($age_member['age_31_40']/$age_member['jml']*100)):0}}
                                        % ({{$age_member['age_31_40']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age_member['jml']!=0&& $age_member['age_31_40']!=0)?round(($age_member['age_31_40']/$age_member['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age_member['jml']!=0&& $age_member['age_31_40']!=0)?round(($age_member['age_31_40']/$age_member['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h4>41-50 tahun</h4>
                                    <div class="pull-right">{{($age_member['jml']!=0&& $age_member['age_41_50']!=0)?round(($age_member['age_41_50']/$age_member['jml']*100)):0}}
                                        % ({{$age_member['age_41_50']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age_member['jml']!=0&& $age_member['age_41_50']!=0)?round(($age_member['age_41_50']/$age_member['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age_member['jml']!=0&& $age_member['age_41_50']!=0)?round(($age_member['age_41_50']/$age_member['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h4>51-60 tahun</h4>
                                    <div class="pull-right">{{($age_member['jml']!=0&& $age_member['age_51_60']!=0)?round(($age_member['age_51_60']/$age_member['jml']*100)):0}}
                                        % ({{$age_member['age_51_60']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age_member['jml']!=0&& $age_member['age_51_60']!=0)?round(($age_member['age_51_60']/$age_member['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age_member['jml']!=0&& $age_member['age_51_60']!=0)?round(($age_member['age_51_60']/$age_member['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h4>>60 tahun</h4>
                                    <div class="pull-right">{{($age_member['jml']!=0&& $age_member['age_60']!=0)?round(($age_member['age_60']/$age_member['jml']*100)):0}}
                                        % ({{$age_member['age_60']}} p)<i
                                                class="fa fa-level-up text-info"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{($age_member['jml']!=0&& $age_member['age_60']!=0)?round(($age_member['age_60']/$age_member['jml']*100)):0}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{($age_member['jml']!=0&& $age_member['age_60']!=0)?round(($age_member['age_60']/$age_member['jml']*100)):0}}%; height: 6px;">
                                            <span class="sr-only">48% Complete</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round align-self-center round-success">
                                                    <i class="ti-user"></i>
                                                </div>
                                                <div class="m-l-10 align-self-center">
                                                    <h3 class="m-b-0">{{\App\Models\Cooperative::count()}}</h3>
                                                    <h5 class="text-muted m-b-0">Jumlah
                                                        Partner</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round align-self-center round-success">
                                                    <i class="ti-user"></i>
                                                </div>
                                                <div class="m-l-10 align-self-center">
                                                    <h3 class="m-b-0">{{\App\Models\CooperativeMember::count()}}</h3>
                                                    <h5 class="text-muted m-b-0">Jumlah Member</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Partner</th>
                                                <th>City</th>
                                                <th>Member</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($city_partner_member as $n => $i)
                                                <tr>
                                                    <td>{{$n+1}}</td>
                                                    <td>{{$i->cooperative_name}}</td>
                                                    <td>{{$i->city_name}}</td>
                                                    <td>{{$i->jml}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <h5 class="card-title m-b-0">City</h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>City</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($city_member as $n => $i)
                                                <tr>
                                                    <td>{{$n+1}}</td>
                                                    <td>{{$i->city_name}}</td>
                                                    <td>{{$i->jml}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        donut1 = Morris.Donut({
            element: 'donut1',
            data: [{
                label: "Sesuai",
                value: "{{$registration['sesuai_kriteria']}}",

            }, {
                label: "Tidak Sesuai",
                value: "{{$registration['tidak_sesuai_kriteria']}}",
            }],
            resize: true,
            colors: ['#fb9678', '#01c0c8',]
        });
        donut2 = Morris.Donut({
            element: 'donut2',
            data: [{
                label: "Approved",
                value: '{{$transaction['approved']}}',

            }, {
                label: "Rejected",
                value: '{{$transaction['rejected']}}',
            }],
            resize: true,
            colors: ['#01c0c8', '#ff0000',]
        });
        area1 = Morris.Area({
            element: 'area1',
            data: JSON.parse('{!! $transaction_year !!}'),
            xkey: 'period',
            ykeys: ['approved', 'rejected'],
            labels: ['approved', 'rejected'],
            pointSize: 0,
            fillOpacity: 0.4,
            pointStrokeColors: ['#01c0c8', '#ff0000'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 0,
            smooth: true,
            hideHover: 'auto',
            lineColors: ['#01c0c8', '#ff0000'],
            resize: true
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            switch (target) {
                case "#tab1":
                    donut1.redraw();
                    donut2.redraw();
                    area1.redraw();
                    $(window).trigger('resize');
                    break;
                case "#tab2":
                    break;
                case "#tab3":
                    break;
            }
        });
    });
</script>