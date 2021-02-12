<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
    <title>@yield('title') - STIA P2P</title>
    <!-- Custom CSS -->
    <link href="/dist/css/style.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- toast CSS -->
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="/assets/node_modules/datatables/media/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="/assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css"/>


    <script src="/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="/assets/node_modules/popper/popper.min.js"></script>
    <script src="/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="/dist/js/custom.min.js"></script>
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <script src="/dist/js/pages/jasny-bootstrap.js"></script><!-- Sweet-Alert  -->
    <script src="/assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script src="/assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script src="/assets/node_modules/datatables/datatables.min.js"></script>
    <script src="/assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>


    @yield('styles')
    <style>
        #custom-loader {
            position: fixed;
            z-index: 99999;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.2);
            transition: 1s 0.4s;
        }
    </style>
</head>

<body class="skin-default-dark fixed-layout">
@include('layouts.preloader')
<div id='custom-loader' style="display: none">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Loading</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    @include('layouts.topbar')
    @include('layouts.sidebar')

    <div class="page-wrapper">

        <div class="container-fluid">
            @include('layouts.breadcrumb')
            @yield('content')
            <div id="modal"></div>
        </div>
    </div>
    @include('layouts.footer')
</div>

<script>
    @php
        $session_flashs = session('flashs');
    @endphp
            @if(!empty($session_flashs))
            @foreach($session_flashs as $flash)
        onload = function () {
        $.toast({
            heading: '{{$flash['title']}}',
            text: '{{$flash['message']}}',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: '{!! $flash['type'] !!}',
            hideAfter: '{!! (isset($flash['time']))?$flash['time']:3000 !!}',
            stack: 6
        });
    };
    @endforeach
            @endif
            @if(isset($flashs))
            @foreach($flashs as $flash)
        onload = function () {
        $.toast({
            heading: '{{$flash['title']}}',
            text: '{{$flash['message']}}',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: '{!! $flash['type'] !!}',
            hideAfter: '{!! (isset($flash['time']))?$flash['time']:3000 !!}',
            stack: 6
        });
    };
    @endforeach
    @endif

    $(document).ajaxError(function (event, jqxhr, settings, thrownError) {
        if (jqxhr.status == 111) {
            alert("Session expired. You'll be take to the login page");
            location.href = "/";
        }
    });

    function ajaxCustom(url, data, type = 'post') {
        $.ajax({
            contentType: false,
            processData: false,
            type: type,
            url: url,
            data: data,
            beforeSend: function () {
                $("#custom-loader").show();
            },
            statusCode: {
                200: function (res) {
                    $("#custom-loader").hide();
                    if (res.message) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + res.message + '</div>');
                    }
                    window.scrollTo(0, 0);
                    if (res.redirect_to != '') {
                        setTimeout(function () {
                            location.href = res.redirect_to;
                        }, 2000);
                    }
                },
                500: function (res) {
                    res = JSON.parse(res.responseText);
                    $("#custom-loader").hide();
                    if (res.message) {
                        $("#messages").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + res.message + '</div>');
                    } else {
                        $("#messages").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Internal Server Error</div>');
                    }
                    window.scrollTo(0, 0);
                },
                111: function () {
                    alaert("session expired");
                    location.href = "/";
                }
            }
        });
    }

    function ajaxModalSave(url, data, type = 'post') {
        $.ajax({
            contentType: false,
            processData: false,
            type: type,
            url: url,
            data: data,
            beforeSend: function () {
                $("#custom-loader").show();
            },
            statusCode: {
                200: function (res) {
                    $("#custom-loader").hide();
                    if (res.message) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + res.message + '</div>');
                    }
                    window.scrollTo(0, 0);
                    $("#myModal").scrollTop(0);
                    setTimeout(function () {
                        $('#myModal').modal('hide');
                    }, 2000);
                    table.ajax.reload();
                },
                500: function (res) {
                    res = JSON.parse(res.responseText);
                    $("#custom-loader").hide();
                    if (res.message) {
                        $("#messages").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + res.message + '</div>');
                    } else {
                        $("#messages").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Internal Server Error</div>');
                    }
                    window.scrollTo(0, 0);
                },
            }
        });
    }

    function ajaxModal(url, data, type = 'post', elementId = null) {
        $.ajax({
            contentType: false,
            processData: false,
            type: type,
            url: url,
            data: data,
            statusCode: {
                200: function (res) {
                    $('#myModal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $(elementId).html('');
                    $(elementId).html(res);
                    $('#myModal').modal('show');
                }
            }
        });
    }

    function deleteData(url) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No",
        }).then(function (res) {
            if (res.value) {
                $.ajax({
                    url: url,
                    type: 'delete',
                    data: {_token: '{{csrf_token()}}'},
                    statusCode: {
                        200: function (res) {
                            swal("Successfully deleted!", "", "success");
                            table.ajax.reload();
                        },
                        500: function () {
                            table.ajax.reload();
                            swal("Failed deleted!", "", "error");
                        }
                    }
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    }
</script>
@yield('scripts')
</body>
</html>