<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            {{--<a class="navbar-brand" href="/" STYLE="margin-left: 30%">--}}
            <a class="navbar-brand" href="/">
                <!-- Logo icon -->
                <b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                {{--<img src="/assets/images/logo-icon.png" alt="homepage" class="dark-logo"/>--}}
                <!-- Light Logo icon -->
                    {{--<img src="/assets/images/logo-light-icon.png" alt="homepage" class="light-logo"/>--}}
                    {{--STIA P2P--}}
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span>
                    STIA P2P
                    <!-- dark Logo text -->
                {{--<img src="/assets/images/logo-text.png" alt="homepage" class="dark-logo"/>--}}
                <!-- Light Logo text -->
                    {{--<img src="/assets/images/logo-light-text.png" class="light-logo" alt="homepage"/>--}}
                </span>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"><a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark"
                                        href="javascript:void(0)"><i class="ti-menu"></i></a></li>
                <li class="nav-item"><a
                            class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                            href="javascript:void(0)"><i class="icon-menu"></i></a></li>
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                {{--<li class="nav-item">--}}
                {{--<form class="app-search d-none d-md-block d-lg-block">--}}
                {{--<input type="text" class="form-control" placeholder="Search & enter">--}}
                {{--</form>--}}
                {{--</li>--}}
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0 mr-5">
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">{{\Illuminate\Support\Facades\Auth::user()->name}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Comment -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- mega menu -->
                <!-- ============================================================== -->
            {{--<li class="nav-item dropdown mega-dropdown">--}}
            {{--<a class="nav-link dropdown-toggle waves-effect waves-dark"--}}
            {{--href="" data-toggle="dropdown" aria-haspopup="true"--}}
            {{--aria-expanded="false"><i--}}
            {{--class="ti-layout-width-default"></i></a>--}}
            {{--<div class="dropdown-menu animated bounceInDown">--}}
            {{--<ul class="mega-dropdown-menu row">--}}
            {{--<li class="col-lg-3 col-xlg-2 m-b-30">--}}
            {{--<h4 class="m-b-20">CAROUSEL</h4>--}}
            {{--<!-- CAROUSEL -->--}}
            {{--<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">--}}
            {{--<div class="carousel-inner" role="listbox">--}}
            {{--<div class="carousel-item active">--}}
            {{--<div class="container"><img class="d-block img-fluid"--}}
            {{--src="/assets/images/big/img1.jpg"--}}
            {{--alt="First slide"></div>--}}
            {{--</div>--}}
            {{--<div class="carousel-item">--}}
            {{--<div class="container"><img class="d-block img-fluid"--}}
            {{--src="/assets/images/big/img2.jpg"--}}
            {{--alt="Second slide"></div>--}}
            {{--</div>--}}
            {{--<div class="carousel-item">--}}
            {{--<div class="container"><img class="d-block img-fluid"--}}
            {{--src="/assets/images/big/img3.jpg"--}}
            {{--alt="Third slide"></div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<a class="carousel-control-prev" href="#carouselExampleControls" role="button"--}}
            {{--data-slide="prev"> <span class="carousel-control-prev-icon"--}}
            {{--aria-hidden="true"></span> <span class="sr-only">Previous</span>--}}
            {{--</a>--}}
            {{--<a class="carousel-control-next" href="#carouselExampleControls" role="button"--}}
            {{--data-slide="next"> <span class="carousel-control-next-icon"--}}
            {{--aria-hidden="true"></span> <span--}}
            {{--class="sr-only">Next</span> </a>--}}
            {{--</div>--}}
            {{--<!-- End CAROUSEL -->--}}
            {{--</li>--}}
            {{--<li class="col-lg-3 m-b-30">--}}
            {{--<h4 class="m-b-20">ACCORDION</h4>--}}
            {{--<!-- Accordian -->--}}
            {{--<div class="accordion" id="accordionExample">--}}
            {{--<div class="card m-b-0">--}}
            {{--<div class="card-header bg-white p-0" id="headingOne">--}}
            {{--<h5 class="mb-0">--}}
            {{--<button class="btn btn-link" type="button" data-toggle="collapse"--}}
            {{--data-target="#collapseOne" aria-expanded="true"--}}
            {{--aria-controls="collapseOne">--}}
            {{--Collapsible Group Item #1--}}
            {{--</button>--}}
            {{--</h5>--}}
            {{--</div>--}}

            {{--<div id="collapseOne" class="collapse show" aria-labelledby="headingOne"--}}
            {{--data-parent="#accordionExample">--}}
            {{--<div class="card-body">--}}
            {{--Anim pariatur cliche reprehenderit, enim eiusmod high.--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="card m-b-0">--}}
            {{--<div class="card-header bg-white p-0" id="headingTwo">--}}
            {{--<h5 class="mb-0">--}}
            {{--<button class="btn btn-link collapsed" type="button"--}}
            {{--data-toggle="collapse" data-target="#collapseTwo"--}}
            {{--aria-expanded="false"--}}
            {{--aria-controls="collapseTwo">--}}
            {{--Collapsible Group Item #2--}}
            {{--</button>--}}
            {{--</h5>--}}
            {{--</div>--}}
            {{--<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"--}}
            {{--data-parent="#accordionExample">--}}
            {{--<div class="card-body">--}}
            {{--Anim pariatur cliche reprehenderit, enim eiusmod high.--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="card m-b-0">--}}
            {{--<div class="card-header bg-white p-0" id="headingThree">--}}
            {{--<h5 class="mb-0">--}}
            {{--<button class="btn btn-link collapsed" type="button"--}}
            {{--data-toggle="collapse" data-target="#collapseThree"--}}
            {{--aria-expanded="false"--}}
            {{--aria-controls="collapseThree">--}}
            {{--Collapsible Group Item #3--}}
            {{--</button>--}}
            {{--</h5>--}}
            {{--</div>--}}
            {{--<div id="collapseThree" class="collapse" aria-labelledby="headingThree"--}}
            {{--data-parent="#accordionExample">--}}
            {{--<div class="card-body">--}}
            {{--Anim pariatur cliche reprehenderit, enim eiusmod high.--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</li>--}}
            {{--<li class="col-lg-3  m-b-30">--}}
            {{--<h4 class="m-b-20">CONTACT US</h4>--}}
            {{--<!-- Contact -->--}}
            {{--<form>--}}
            {{--<div class="form-group">--}}
            {{--<input type="text" class="form-control" id="exampleInputname1"--}}
            {{--placeholder="Enter Name"></div>--}}
            {{--<div class="form-group">--}}
            {{--<input type="email" class="form-control" placeholder="Enter email"></div>--}}
            {{--<div class="form-group">--}}
            {{--<textarea class="form-control" id="exampleTextarea" rows="3"--}}
            {{--placeholder="Message"></textarea>--}}
            {{--</div>--}}
            {{--<button type="submit" class="btn btn-info">Submit</button>--}}
            {{--</form>--}}
            {{--</li>--}}
            {{--<li class="col-lg-3 col-xlg-4 m-b-30">--}}
            {{--<h4 class="m-b-20">List style</h4>--}}
            {{--<!-- List style -->--}}
            {{--<ul class="list-style-none">--}}
            {{--<li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> You can--}}
            {{--give link</a></li>--}}
            {{--<li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Give link</a>--}}
            {{--</li>--}}
            {{--<li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another--}}
            {{--Give link</a></li>--}}
            {{--<li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Forth link</a>--}}
            {{--</li>--}}
            {{--<li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another--}}
            {{--fifth link</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--</li>--}}
            <!-- ============================================================== -->
                <!-- End mega menu -->
                <!-- ============================================================== -->
                {{--<li class="nav-item right-side-toggle"><a class="nav-link  waves-effect waves-light"--}}
                {{--href="javascript:void(0)"><i class="ti-settings"></i></a></li>--}}
            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->