<div id="myModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" onsubmit="return false;"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{($data->cooperative_uuid)?'Edit':'Add'}} Koperasi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="messages"></div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Cooperative Code</label>
                        <input type="text" class="form-control" name="cooperative_code" required
                               value="{{$data->cooperative_code}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Cooperative Name</label>
                        <input type="text" class="form-control" name="cooperative_name" required
                               value="{{$data->cooperative_name}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Address</label>
                        <textarea type="text" class="form-control" name="cooperative_address"
                                  required>{{$data->cooperative_address}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">City</label>
                        <select name="city_id" class="form-control select2" required>
                            @if($data->city)
                                <option selected value="{{$data->city->city_id}}">{{$data->city->city_name}}
                                    ({{$data->city->tipe_dati2}})
                                </option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class=pho"control-label">Phone</label>
                        <input type="text" class="form-control" name="phone"
                               required value="{{$data->phone}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class=pho"control-label">Email</label>
                        <input type="text" class="form-control" name="email"
                               required value="{{$data->email}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class=pho"control-label">Website</label>
                        <input type="text" class="form-control" name="website"
                               value="{{$data->email}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class=pho"control-label">Additional Limit</label>
                        <input type="number" class="form-control" name="additional_limit"
                               value="{{$data->additional_limit}}" min="0">
                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                    @csrf
                    <input type="hidden" name="cooperative_uuid" value="{{$data->cooperative_uuid}}">
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
        ajaxModalSave(url + '/save', formData, 'post')
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
