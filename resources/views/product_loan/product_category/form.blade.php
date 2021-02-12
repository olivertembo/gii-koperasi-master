<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" onsubmit="return false;"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{($data->product_category_uuid)?'Edit':'Add'}}
                        Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="messages"></div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Category Name</label>
                        <input type="text" class="form-control" name="product_category_name" required
                               value="{{$data->product_category_name}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Icon (.png)</label>
                        <input type="file" class="form-control" name="file" accept="image/png" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Status</label>
                        <select name="is_active" class="form-control">
                            <option value="t" {{($data->is_active==true and !is_null($data->is_active))?'selected':''}}>
                                Active
                            </option>
                            <option value="f" {{($data->is_active==false and !is_null($data->is_active))?'selected':''}}>
                                Deactive
                            </option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                    @csrf
                    <input type="hidden" name="product_category_uuid" value="{{$data->product_category_uuid}}">
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
    // $('form').on('submit', function (e) {
    //     e.preventDefault();
    //     form = $(this)[0];
    //     var formData = new FormData(form);
    //     ajaxModalSave(url + '/save', formData, 'post')
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
                    window.scrollTo(0, 0);
                    setTimeout(function () {
                        $('#myModal').modal('hide');
                    }, 2000);
                    table1.ajax.reload();
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
    });
</script>
<!-- /.modal -->
