<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" onsubmit="return false;"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{($data->product_uuid)?'Edit':'Add'}}
                        Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="messages"></div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Partner</label>
                        <select name="cooperative_uuid" class="form-control select2" required>
                            @foreach($partner as $i)
                                <option value="{{$i->cooperative_uuid}}" {{($i->cooperative_uuid==$data->cooperative_uuid)?'selected':''}}>{{$i->cooperative_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Category</label>
                        <select name="product_category_uuid" class="form-control select2" required>
                            <option value="">choose</option>
                            @foreach(\App\Models\ProductCategory::get() as $i)
                                <option value="{{$i->product_category_uuid}}" {{($i->product_category_uuid==$data->product_category_uuid)?'selected':''}}>{{$i->product_category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">SKU</label>
                        <input type="text" class="form-control" name="sku" required
                               value="{{$data->sku}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" required
                               value="{{$data->product_name}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Description</label>
                        <textarea class="form-control summernote"
                                  name="product_description">{{$data->product_description}}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                    @csrf
                    <input type="hidden" name="product_uuid" value="{{$data->product_uuid}}">
                    <input type="submit" class="btn btn-danger waves-effect waves-light" value="Save">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    url = '{{url($url)}}';
    $('.select2').select2({width: '100%'});
    // $('form').on('submit', function (e) {
    //     e.preventDefault();
    //     form = $(this)[0];
    //     var formData = new FormData(form);
    //     ajaxModalSave(url + '/save', formData, 'post')
    // });
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
                    table2.ajax.reload();
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

</script>
<!-- /.modal -->
