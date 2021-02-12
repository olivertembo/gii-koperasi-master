<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" onsubmit="return false;"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{($data->product_category_uuid)?'Edit':'Add'}}
                        App Version</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="messages"></div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Version</label>
                        <input type="text" class="form-control" name="version" required
                               value="{{$data->version}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Url</label>
                        <input type="text" class="form-control" name="url" required
                               value="{{$data->url}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Message</label>
                        <input type="text" class="form-control" name="message" required
                               value="{{$data->message}}">
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
                    <input type="hidden" name="app_version_uuid" value="{{$data->app_version_uuid}}">
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
