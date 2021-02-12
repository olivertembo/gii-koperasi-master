<div id="myModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" onsubmit="return false;"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{($data->iv_admin_fee_uuid)?'Edit':'Add'}} Admin Fee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="messages"></div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">is Pecentage</label>
                        <select name="is_percentage" id="is_percentage" class="form-control" required>
                            <option value="">choose</option>
                            <option value="true" {{($data->is_percentage==true && !is_null($data->is_percentage))?'selected':''}}>
                                true
                            </option>
                            <option value="false" {{($data->is_percentage==false && !is_null($data->is_percentage))?'selected':''}}>
                                false
                            </option>
                        </select>
                    </div>
                    <script>
                        $('#is_percentage').change(function () {
                            if (this.value == 'true') {
                                $('#percentage').show();
                                $('#amount').hide();
                            } else if (this.value == 'false') {
                                $('#percentage').hide();
                                $('#amount').show();
                            }
                        })
                    </script>
                    <div id="percentage"
                         class="form-group"
                         style="{{($data->is_percentage!=true)?'display: none':''}}">
                        <label for="recipient-name" class=pho"control-label">Percentage (%)</label>
                        <input type="number" class="form-control" name="percentage" placeholder="0-100"
                               value="{{$data->percentage}}" min="0">
                    </div>
                    <div id="amount"
                         class="form-group"
                         style="{{($data->is_percentage==true)?'display: none':''}}">
                        <label for="recipient-name" class=pho"control-label">Amount</label>
                        <input type="number" class="form-control" name="amount" placeholder="10000"
                               value="{{$data->amount}}" min="0">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Status</label>
                        <select name="is_active" class="form-control" required>
                            <option value="">choose</option>
                            <option value="true" {{($data->is_active==true and !is_null($data->is_active))?'selected':''}}>
                                Active
                            </option>
                            <option value="false" {{($data->is_active==false and !is_null($data->is_active))?'selected':''}}>
                                deactive
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                    @csrf
                    <input type="hidden" name="iv_admin_fee_uuid" value="{{$data->iv_admin_fee_uuid}}">
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
    $('form').on('submit', function (e) {
        e.preventDefault();
        form = $(this)[0];
        var formData = new FormData(form);
        $.ajax({
            contentType: false,
            processData: false,
            type: 'post',
            url: url + '/save/admin-fee',
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

    $(".select2").select2(
        {
            placeholder: "City Name",
            allowClear: true,
            width: '100%',
            ajax: {
                type: "GET",
                url: '{{url('/open/city')}}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        }
    );
</script>
<!-- /.modal -->
