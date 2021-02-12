<style>

</style>

<div class="row">
    <div class="col-12">
        <div id="total">

        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <div class="row" id="list">
            {{--<div class="col-lg-3 col-md-6">--}}
            {{--<!-- Card -->--}}
            {{--<div class="card">--}}
            {{--<div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">--}}
            {{--<ol class="carousel-indicators">--}}
            {{--<li data-target="#carouselExampleIndicators2" data-slide-to="0" class="active"></li>--}}
            {{--<li data-target="#carouselExampleIndicators2" data-slide-to="1"></li>--}}
            {{--<li data-target="#carouselExampleIndicators2" data-slide-to="2"></li>--}}
            {{--</ol>--}}
            {{--<div class="carousel-inner" role="listbox">--}}
            {{--<div class="carousel-item active">--}}
            {{--<img class="img-fluid" src="../assets/images/big/img3.jpg" alt="First slide">--}}
            {{--</div>--}}
            {{--<div class="carousel-item">--}}
            {{--<img class="img-fluid" src="../assets/images/big/img4.jpg" alt="Second slide">--}}
            {{--</div>--}}
            {{--<div class="carousel-item">--}}
            {{--<img class="img-fluid" src="../assets/images/big/img5.jpg" alt="Third slide">--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">--}}
            {{--<span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
            {{--<span class="sr-only">Previous</span>--}}
            {{--</a>--}}
            {{--<a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">--}}
            {{--<span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
            {{--<span class="sr-only">Next</span>--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--<div class="card-body">--}}
            {{--<h4 class="card-title">Card title</h4>--}}
            {{--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
            {{--<a href="javascript:void(0)" class="btn btn-primary">Go somewhere</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<!-- Card -->--}}
            {{--</div>--}}

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
            </ul>
        </nav>
    </div>
</div>

<script>

    function deleteItem(url) {
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
                            getItems()
                        },
                        500: function () {
                            swal("Failed deleted!", "", "error");
                            getItems()
                        }
                    }
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    }

    function modalForm(url) {
        ajaxModal(url, null, 'get', '#modal');
    }

    onload = getList(0);

    function getList(offset) {
        $("#custom-loader").show();
        param = '?offset=' + offset
        param += '&product_category_uuid=' + $('#product_category_uuid').val()
        param += '&product_uuid=' + $('#product_uuid').val()
        param += '&is_active=' + $('#is_active').val()
        param += '&search=' + $('#search').val()
        $.get(url + '/item' + param, function (data, status) {
            $('#total').html(' Showing ' + data.pagination.start + ' to ' + data.pagination.end + ' of ' + data.pagination.total + ' entries');

            pagination = '<li class="page-item '
            if (data.pagination.previous == data.pagination.offset)
                pagination += ' disabled '
            pagination += '"><a class="page-link" href="javascript:void(0)" onclick="getItems(data.pagination.previous)" tabindex="-1">Previous</a></li>'
            $.each(data.pagination.page, function (i, item) {
                pagination += '<li class="page-item '
                if (data.pagination.offset == item)
                    pagination += ' disabled '
                pagination += '"><a class="page-link " href="javascript:void(0)"  onclick="getItems(item)">' + (i + 1) + '</a></li>'
            })
            pagination += '<li class="page-item'
            if (data.pagination.next >= data.pagination.total)
                pagination += ' disabled '
            pagination += '"><a class="page-link" href="javascript:void(0)">Next</a></li>'

            $('ul.pagination').html(pagination)

            $('#list').html('');
            $.each(data.product_item, function (i, item) {
                html = '<div class="col-lg-3 col-md-6"><div class="card">'
                //corusel
                html += '<div id="carouselExampleIndicators' + i + '" class="carousel slide" data-ride="carousel">' +
                    '                        <ol class="carousel-indicators">'
                $.each(item.images, function (i, d) {
                    html += '<li data-target="#' + item.product_item_uuid + '" data-slide-to="' + i + '" ';
                    if (i === 0) {
                        html += 'class="active"'
                    }
                    html += '></li>'
                });
                html += '</ol><div class="carousel-inner" role="listbox">'
                $.each(item.images, function (i, d) {
                    html += '<div class="carousel-item '
                    if (i === 0) {
                        html += 'active'
                    }
                    html += '">'
                    html += '<img class="img-fluid" src="{{url('')}}' + d.file_path + '">'
                    html += '</div>'
                });
                html += '                        </div>' +
                    '                        <a class="carousel-control-prev" href="#carouselExampleIndicators' + i + '" role="button" data-slide="prev">' +
                    '                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>' +
                    '                            <span class="sr-only">Previous</span>' +
                    '                        </a>' +
                    '                        <a class="carousel-control-next" href="#carouselExampleIndicators' + i + '" role="button" data-slide="next">' +
                    '                            <span class="carousel-control-next-icon" aria-hidden="true"></span>' +
                    '                            <span class="sr-only">Next</span>' +
                    '                        </a>' +
                    '                    </div>'

                //card body
                html += ' <div class="card-body">'
                html += '<h4 class="card-title">' + item.product_item_name + '</h4>' +
                    '                        <p class="card-text">SKU : ' + item.product_sku + '-' + item.product_item_sku + '</p><hr>' +
                    '                        <p class="card-text">Price : ' + item.currency_symbol + ' ' + item.price + ' / ' + item.quantity + ' ' + item.quantity_type_name + '</p>' +
                    '                        <p class="card-text">Category : ' + item.product_category_name + '</p>' +
                    '                        <p class="card-text">Partner : ' + item.cooperative_name + '</p>' +
                    '                        <p class="card-text">Status : ' + item.status + '</p>'
                html += '<a href="javascript:void(0)" onclick="modalForm(\'{{url($url)}}/detail/' + item.product_item_uuid + '\')" >detail</a>'
                {{--'<a href="javascript:void(0)" onclick="modalForm(\'{{url($url)}}/edit/' + item.product_item_uuid + '\')" class="btn btn-xs btn-primary">edit</a>' +--}}
                        {{--'<a href="javascript:void(0)" onclick="deleteItem(\'{{url($url)}}/delete/' + item.product_item_uuid + '\')"  class="btn btn-xs btn-danger">delete</a>'--}}
                    html += '</div></div></div>'
                $('#list').append(html);
            })
            $("#custom-loader").hide()
        });
    }
</script>