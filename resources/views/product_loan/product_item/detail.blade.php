<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" onsubmit="return false;"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Detail Product Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="messages"></div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Product Category</label>
                        <input type="text" class="form-control" readonly
                               value="{{$data->product->productCategory->product_category_name}}">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Product</label>
                        <input type="text" class="form-control" readonly value="{{$data->product->product_name}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">SKU</label>
                        <input type="text" class="form-control" name="sku" readonly
                               value="{{$data->sku}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Product Item Name (title)</label>
                        <input type="text" class="form-control" name="product_item_name" readonly
                               value="{{$data->product_item_name}}">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Quantity</label>
                        <div class="row">
                            <div class="col-8">
                                <input type="number" class="form-control" name="quantity" readonly
                                       value="{{$data->quantity}}" min="0">
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" name="quantity" readonly
                                       value="{{$data->quantityType->quantity_type_name}}" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Price</label>
                        <div class="row">
                            <div class="col-3">
                                <input type="text" class="form-control" name="price" readonly
                                       value="{{$data->currency->currency_symbol}}" min="0">
                            </div>
                            <div class="col-9">
                                <input type="number" class="form-control" name="price" readonly
                                       value="{{$data->price}}" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Description</label>
                        <div>{!!$data->product_item_description  !!}</div>
                    </div>
                    <div class="form-group">
                        <div id="image_preview" class="row">
                            @foreach($data->productItemImages as $i)
                                <div class="col-md-4">
                                    <img class="img-thumbnail"
                                         src="{{\Illuminate\Support\Facades\Storage::url($i->file_path)}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
