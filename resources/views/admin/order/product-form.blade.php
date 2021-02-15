<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Add Products</strong></h2>
            </div>
            <div class="body">
                <table id="mainTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Quantity Unit</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="item-rows">
                        @set('discount',0)
                        @set('subTotal',0)
                        @if($isEdit && $model->orderProducts)
                        @foreach($model->orderProducts as $product)
                        @set('discount',$discount+$product->discount)
                        @set('subTotal',$subTotal+($product->price*$product->quantity))
                        <tr class="item-row">
                            <td>
                                <input autocomplete="off" type="text" value="{{ ($product->product) ? $product->product->title : null }}" id="product-name-{{ $loop->index }}" class="form-control validate[required] product-name" data-index="{{ $loop->index }}" placeholder="Product Name" name="product[{{ $loop->index }}][name]"> 
                                <input class="product-id" value="{{ $product->product_id }}" type="hidden" id="product-id-{{ $loop->index }}" name="product[{{ $loop->index }}][id]">
                            </td>
                            <td>
                                <select data-index="{{ $loop->index }}" class="form-control validate[required] price-list" id="product-price-{{ $loop->index }}" name="product[{{ $loop->index }}][price]">
                                    @if($product->product->prices)
                                    @foreach($product->product->prices as $price)
                                    <option {{ ($price->price==$product->price)? 'selected="selected"' : '' }} value="{{ $price->price }}">{{ ($price->rate)?$price->rate->code:'' }} {{ $price->price }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                            <td>
                                <input autocomplete="off" value="{{ $product->quantity }}" data-index="{{ $loop->index }}" type="text" id="product-quantity-{{ $loop->index }}" value="1" class="form-control validate[required,custom[number]] product-qty" name="product[{{ $loop->index }}][quantity]">
                            </td>
                            <td>
                                <input autocomplete="off" data-index="{{ $loop->index }}" type="text" id="product-quantity-unit-{{ $loop->index }}" value="{{ $product->quantity_unit }}" class="form-control product-qty-unit" name="product[{{ $loop->index }}][quantity_unit]">
                            </td>
                            <td>
                                <input autocomplete="off" data-index="{{ $loop->index }}" type="text" id="product-discount-{{ $loop->index }}" value="{{ $product->discount }}" class="form-control validate[required] product-discount" name="product[{{ $loop->index }}][discount]">
                            </td>
                            <td class="row-total" id="product-total-{{ $loop->index }}">{{ $product->getProductDiscountTotal() }}</td>
                            <td>
                                <a href="javascript:void(0);" class="remove-row" title="Delete"><i class="material-icons">delete</i></a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="form-group row">
                <label class="col-sm-9 col-sm-9 control-label" style="text-align: right;">Currency</label>
                <div class="col-sm-3">
                    @include('admin.snippets.select',['name'=>'currency','class'=>"form-control",'value'=>null,'data'=>$currencies])
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-9 col-sm-9 control-label" style="text-align: right;">Currency Rate</label>
                <div class="col-sm-3">
                    @include('admin.snippets.text-field',['name'=>'currency_rate','value'=>($isEdit)?$model->getCurrencyRate():0.00,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-9 col-sm-9 control-label" style="text-align: right;">SubTotal</label>
                <div class="col-sm-3" id="product-total">
                    {{ $model->getSubTotal() }}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-9 col-sm-9 control-label" style="text-align: right;">Discount</label>
                <div class="col-sm-3">
                    @include('admin.snippets.text-field',['name'=>'discount','value'=>($isEdit)?$model->getDiscount():0.00,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-9 col-sm-9 control-label" style="text-align: right;">Tax</label>
                <div class="col-sm-3">
                    @include('admin.snippets.text-field',['name'=>'tax','value'=>($isEdit)?$model->getTax():0.00,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-9 col-sm-9 control-label" style="text-align: right;">Total</label>
                <div id="gTotal" class="col-sm-3">
                    {{ $model->getTotal() }}
                </div>
            </div>
        </div>
    </div>
</div>