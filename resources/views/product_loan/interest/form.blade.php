<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" onsubmit="return false;"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{($data->interest_uuid)?'Edit':'Add'}} Interest</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="messages"></div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Tenure</label>
                        <input type="number" class="form-control" name="tenure" required
                               value="{{$data->tenure}}" min="0">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Type</label>
                        <select name="interest_type_id" class="form-control">
                            @foreach(\App\Models\InterestType::all() as $i)
                                <option value="{{$i->interest_type_id}}"{{($i->interest_type_id==$data->interest_type_id)?'selected':''}}>{{$i->interest_type_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Day Amount</label>
                        <input type="number" class="form-control" name="day_amount" required
                               value="{{$data->day_amount}}" min="0">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Interst Percentage (%)</label>
                        <input type="number" class="form-control" name="interest_percentage" required
                               value="{{$data->interest_percentage}}" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                    @csrf
                    <input type="hidden" name="interest_uuid" value="{{$data->interest_uuid}}">
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
</script>
<!-- /.modal -->
