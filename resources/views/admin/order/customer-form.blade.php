<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Customer Contact Info</strong></h2>
            </div>

            <div class="form-group row">
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">Eamil<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.text-field',['name'=>'billing_email','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">Phone<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.text-field',['name'=>'billing_phone','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>                                
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Billing Address</strong></h2>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">Address<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.text-field',['name'=>'billing_address_1','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">City<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.text-field',['name'=>'billing_city','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">State<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.text-field',['name'=>'billing_state','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">Postal Code<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.text-field',['name'=>'billing_postal_code','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">Country<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.select',['name'=>'billing_country','class'=>"form-control",'value'=>null,'data'=>$countries])
                        {{--@include('admin.snippets.text-field',['name'=>'billing_country','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])--}}
                    </div>
                </div>                                  
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Shipping Address</strong></h2>
            </div>
            <div class="form-group row">

                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">Full Name<span class="required">*</span></label>
                    <div class="col-sm-12">
                        {{--<select name="ship_name" class="form-control" id="ship_name">
                            @if($isEdit)
                                @if($model->customer and $model->customer->shippingAddresses)
                                    {{$model->customer}}
                                    @foreach($model->customer->shippingAddresses as $shipAddr)
                                        <option {{ ($model->ship_full_name==$shipAddr->name)?'selected="selected"':'' }}  data-customer-id="{{ $model->customer->id }}" data-ship_address="{{ $shipAddr->ship_address }}" data-ship-city="{{ $shipAddr->ship_city }}" data-ship-state="{{ $shipAddr->ship_state }}" data-ship-postal-code="{{ $shipAddr->ship_postal_code }}" data-ship-country="{{ $shipAddr->ship_country }}" >{{ $shipAddr->name }}</option>
                                    @endforeach
                                @endif
                            @endif
                        </select>--}}
                        @include('admin.snippets.text-field',['name'=>'ship_full_name','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">Address<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.text-field',['name'=>'ship_address_1','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">City<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.text-field',['name'=>'ship_city','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">State<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.text-field',['name'=>'ship_state','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">Postal Code<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.text-field',['name'=>'ship_postal_code','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-sm-6 col-sm-6 control-label">Country<span class="required">*</span></label>
                    <div class="col-sm-12">
                        @include('admin.snippets.select',['name'=>'ship_country','class'=>"form-control",'value'=>null,'data'=>$countries])
                        {{--@include('admin.snippets.text-field',['name'=>'ship_country','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])--}}
                    </div>
                </div>                                  
            </div>
        </div>
    </div>
</div>