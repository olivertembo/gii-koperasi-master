<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" onsubmit="return false;"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{($data->product_uuid)?'Edit':'Add'}}
                        Product Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="messages"></div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Product</label>
                        <select name="product_uuid" class="form-control select2" required>
                            <option value="">choose</option>
                            @foreach($product as $i)
                                <option value="{{$i->product_uuid}}" {{($data->product_uuid==$i->product_uuid)?'selected':''}}>{{$i->product_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">SKU</label>
                        <input type="text" class="form-control" name="sku" required
                               value="{{$data->sku}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Product Item Name (title)</label>
                        <input type="text" class="form-control" name="product_item_name" required
                               value="{{$data->product_item_name}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Quantity</label>
                        <div class="row">
                            <div class="col-8">
                                <input type="number" class="form-control" name="quantity" required
                                       value="{{$data->quantity}}" min="0">
                            </div>
                            <div class="col-4">
                                <select name="quantity_type_uuid" class="form-control" required>
                                    @foreach(\App\Models\QuantityType::get() as $i)
                                        <option value="{{$i->quantity_type_uuid}}" {{($data->quantity_type_uuid==$i->quantity_type_uuid)?'selected':''}}>{{$i->quantity_type_name}}
                                            ({{$i->quantity_type_symbol}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Price</label>
                        <div class="row">
                            <div class="col-3">
                                <select name="currency_id" class="form-control" required>
                                    @foreach(\App\Models\Currency::get() as $i)
                                        <option value="{{$i->currency_id}}" {{($data->currency_id==$i->currency_id)?'selected':''}}>{{$i->currency_symbol}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-9">
                                <input type="number" class="form-control" name="price" required
                                       value="{{$data->price}}" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Weight (gram)</label>
                        <input type="number" class="form-control" name="weight_item" required min="0"
                               value="{{$data->weight_item}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Total Stock</label>
                        <input type="number" class="form-control" name="total_stock" required min="0"
                               value="{{$data->total_stock}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Description</label>
                        <textarea class="form-control summernote"
                                  name="product_item_description">{{$data->product_item_description}}</textarea>
                    </div>
                    @if(Auth::user()->isVerificator())
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Status</label>
                            <select name="is_active" class="form-control">
                                <option value="t" {{($data->is_active==true and !is_null($data->is_active))?'selected':''}}>
                                    Active
                                </option>
                                <option value="f" {{($data->is_active==false and !is_null($data->is_active))?'selected':''}}>
                                    Deactive
                                </option>
                            </select>
                        </div>
                    @endif
                    @if($data->productItemImages)
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Images Uploaded</label>
                            <div class="row" id="image_uploaded"></div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Images</label>
                        <input type="file" accept="image/*" name="file[]" multiple class="form-control" id="uploadFile">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Preview</label>
                        <div id="image_preview" class="row"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    @csrf
                    <input type="hidden" name="product_item_uuid" value="{{$data->product_item_uuid}}">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" id="btnSubmit" class="btn btn-danger waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<style>
    /* Container needed to position the button. Adjust the width as needed */
    .container {
        position: relative;
        width: 50%;
    }

    /* Make the image responsive */
    .container img {
        width: 100%;
        height: auto;
    }

    /* Style the button and place it in the middle of the container/image */
    .container .btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        opacity: 0.5;
        background-color: lightgrey;
        color: white;
        border: none;
        cursor: pointer;
    }

    .container .btn:hover {
        opacity: 0.5;
        background-color: black;

    }
</style>
<script>

    <?php if ($data->product_item_uuid){ ?>
        onload = productItemImage('{{url($url.'/product-item-image/'.$data->product_item_uuid)}}');

    <?php }?>

    function productItemImage(url) {
        $('#image_uploaded').html('')
        $.get(url, function (data) {
            $.each(data, function (i, item) {
                if (item.product_item_image_uuid) {
                    $('#image_uploaded').append(
                        '<div class="container col-md-4">' +
                        '<img class="img-thumbnail" src="' + item.file_path + '">' +
                        '<button type="button" class="btn btn-sm" onclick="removeImage(\'{{url($url.'/product-item-image')}}/' + item.product_item_image_uuid + '\')">Remove</button>' +
                        '</div>');
                }
            })
        })
    }

    function removeImage(url) {
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
                            productItemImage('{{url($url.'/product-item-image/'.$data->product_item_uuid)}}')
                            getItems()
                        },
                        500: function () {
                            swal("Failed deleted!", "", "error");
                            productItemImage('{{url($url.'/product-item-image/'.$data->product_item_uuid)}}')
                        }
                    }
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    }


    $("#uploadFile").change(function () {
        $('#image_preview').html("");
        var total_file = document.getElementById("uploadFile").files.length;
        for (var i = 0; i < total_file; i++) {
            $('#image_preview').append(
                '<div class="col-md-4">' +
                '<img class="img-thumbnail" src="' + URL.createObjectURL(event.target.files[i]) + '">' +
                // '<button type="button" class="btn" onclick="btnRemove(' + i + ')">Remove</button>' +
                '</div>');
        }
    });

    function btnRemove(index) {
        console.log($('#uploadFile')[0].files[index]);
        $('#uploadFile').val($('#uploadFile')[0].files[index].name);
        console.log(index, $('#uploadFile')[0].files[index].remove);
    }


    url = '{{url($url)}}';
    $('.select2').select2({width: '100%'});
    // $('form').on('submit', function (e) {
    //     e.preventDefault();
    //     form = $(this)[0];
    //     var formData = new FormData(form);
    //     $.ajax({
    //         contentType: false,
    //         processData: false,
    //         type: 'post',
    //         url: url + '/save',
    //         data: formData,
    //         beforeSend: function () {
    //             $("#custom-loader").show();
    //         },
    //         statusCode: {
    //             200: function (res) {
    //                 $("#custom-loader").hide();
    //                 if (res.message) {
    //                     $("#messages").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + res.message + '</div>');
    //                     $("#myModal").scrollTop(0);
    //                     setTimeout(function () {
    //                         $('#myModal').modal('hide');
    //                     }, 2000);
    //                 } else {
    //                     $("#myModal").scrollTop(0);
    //                     $("#messages").html(res);
    //                 }
    //                 getItems()
    //             },
    //             500: function (res) {
    //                 res = JSON.parse(res.responseText);
    //                 $("#custom-loader").hide();
    //                 if (res.message) {
    //                     $("#messages").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + res.message + '</div>');
    //                 } else {
    //                     $("#messages").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Internal Server Error</div>');
    //                 }
    //                 $("#myModal").scrollTop(0);
    //             },
    //         }
    //     });
    // });
    $('form').on('submit', function (e) {
        e.preventDefault();
        form = $(this)[0];
        var formData = new FormData(form);
        $.ajax({
            contentType: false,
            processData: false,
            type: 'post',
            url: url + '/save',
            data: formData,
            beforeSend: function () {
                $("#custom-loader").show();
            },
            statusCode: {
                200: function (res) {
                    $("#custom-loader").hide();
                    if (res.message) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + res.message + '</div>');
                    }
                    $("#myModal").scrollTop(0);
                    setTimeout(function () {
                        $('#myModal').modal('hide');
                    }, 2000);
                    table3.ajax.reload();
                },
                500: function (res) {
                    res = JSON.parse(res.responseText);
                    $("#custom-loader").hide();
                    if (res.message) {
                        $("#messages").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + res.message + '</div>');
                    } else {
                        $("#messages").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Internal Server Error</div>');
                    }
                    $("#myModal").scrollTop(0);
                },
            }
        });
    });


    $('.summernote').summernote({
        height: 100, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false, // set focus to editable area after initializing summernote
        toolbar: [
            // ['style', ['style']],
            ['font', ['bold', 'italic', 'underline',
                // 'clear'
            ]],
            // ['fontname', ['fontname']],
            // ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            // ['table', ['table']],
            // ['insert', ['link', 'picture', 'hr']],
            // ['view', ['fullscreen', 'codeview']],
            // ['help', ['help']]
        ],
    });

</script>
<!-- /.modal -->
