<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" onsubmit="return false;"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{($data->fine_uuid)?'Edit':'Add'}} Fine</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="messages"></div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Type</label>
                        <select name="fine_type_id" class="form-control">
                            @foreach(\App\Models\FineType::all() as $i)
                                <option value="{{$i->fine_type_id}}"{{($i->fine_type_id==$data->fine_type_id)?'selected':''}}>{{$i->fine_type_symbol}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Day Amount</label>
                        <input type="number" class="form-control" name="day_amount" required
                               value="{{$data->day_amount}}" min="0">
                    </div>
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
                                $('#percentage').attr('required', ''); ;
                                $('#amount').hide();
                                $('#amount').removeAttr('required');
                                $('#currency').hide();
                            } else if (this.value == 'false') {
                                $('#percentage').hide();
                                $('#percentage').removeAttr('required');
                                $('#amount').show();
                                $('#amount').attr('required', ''); ;
                                $('#currency').show();
                            }
                        })
                    </script>

                    <div class="form-group" id="percentage">
                        <label for="recipient-name" class="control-label">Fine Percentage (%)</label>
                        <input type="number" class="form-control" name="interest_percentage"
                               value="{{$data->interest_percentage}}" min="0">
                    </div>
                    <div class="form-group" id="currency">
                        <label for="message-text" class="control-label">Currency</label>
                        <select name="currency_id" class="form-control">
                            @foreach(\App\Models\Currency::all() as $i)
                                <option value="{{$i->currency_id}}"{{($i->currency_id==$data->currency_id)?'selected':''}}>{{$i->currency_name}}
                                    ({{$i->currency_symbol}} / {{$i->currency_iso_code}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="amount">
                        <label for="recipient-name" class="control-label">Fine Amount</label>
                        <input type="number" class="form-control" name="fine_amount" required
                               value="{{$data->fine_amount}}" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                    @csrf
                    <input type="hidden" name="fine_uuid" value="{{$data->fine_uuid}}">
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
