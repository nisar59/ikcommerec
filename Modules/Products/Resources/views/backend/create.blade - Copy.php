@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Products Management</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Products Management </li>
                </ol>
            </div>
        </div>
        @if (count($errors) > 0)
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div></div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">



                {!! Form::open(array('url' => 'admin/products/store','method'=>'POST',"enctype"=>"multipart/form-data")) !!}
                <h4 class="card-title">Products Management</h4>


                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">General</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#categories" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#assessment" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Price</span>
                        </a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pricing" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Stocks</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#seo" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">SEO</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#instructor" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Relateds Products</span>
                        </a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#curriculum" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                    <span class="d-none d-sm-block">Internal Notes </span>
                    </a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="general" role="tabpanel">

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Slug:</strong>
                                    {!! Form::text('slug', null, array('placeholder' => 'Slug','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>SKU:</strong>
                                    {!! Form::text('sku', null, array('placeholder' => 'SKU','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Weight:</strong>
                                    {!! Form::text('weight', null, array('placeholder' => 'Weight','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Supllier:</strong>
                                    {!! Form::select('supplier_id', $data['suppliers'],[], array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Brand:</strong>
                                    {!! Form::select('brand_id', $data['brands'],[], array('class' => 'form-control')) !!}
                                </div>
                            </div>   
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Expiry:</strong>
                                   <input type="date" name="expiry" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Documents:</strong>
                                    {!! Form::file('product_doc', null, array('placeholder' => 'Size Chart','class' => 'form-control filestyle')) !!}
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>Stock Status:</strong><br>

                                    <label>  {{ Form::radio('stock_status','1', false, array('class' => 'name')) }}
                                        In Stock
                                    </label>
                                    <label>  {{ Form::radio('stock_status','0', false, array('class' => 'name')) }}
                                        Out Of Stock
                                    </label>
                                </div>
                            </div>

                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>Featured :</strong><br>

                                    <label>  {{ Form::radio('featured','1', false, array('class' => 'name')) }}
                                        Yes
                                    </label>
                                    <label>  {{ Form::radio('featured','0', false, array('class' => 'name')) }}
                                        No
                                    </label>

                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <strong>Enable reviews :</strong><br>

                                    <label>  {{ Form::radio('enable_reviews','1', false, array('class' => 'name')) }}
                                        Yes
                                    </label>
                                    <label>  {{ Form::radio('enable_reviews','0', false, array('class' => 'name')) }}
                                        No
                                    </label>

                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Short Description:</strong>
                                    <textarea class="summernote" name="short_description"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Long Description:</strong>
                                    <textarea class="summernote" name="description" ></textarea>
                                </div>
                            </div>





                        </div>
                    </div>
                    <div class="tab-pane p-3" id="categories" role="tabpanel">
                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">
                                <strong>Categories:</strong>
                              <select name="categories[]" class="form-control" multiple>
                                <option> Select</option>
                                @foreach($data['categories'] as $key=>$cat)

                                    <option value="{{$cat->id}}"  >{{$cat->name}}</option>

                                    @if($cat->childs->count()>0)
                                        @foreach($cat->childs as $key=>$scat)
                                            <option value="{{$scat->id}}"  >&nbsp;&nbsp;|__{{$scat->name}}</option>
                                        @endforeach
                                    @endif

                                @endforeach

                              </select>



                            </div>
                        </div>




                    </div>

                    <div class="tab-pane p-3" id="assessment" role="tabpanel">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Purchase Price</strong>
                                    {!! Form::text('purchase_price', null, array('placeholder' => 'Purchase price','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Price</strong>
                                    {!! Form::text('price', null, array('placeholder' => 'Price','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Sale Price</strong>
                                    {!! Form::text('sale_price', null, array('placeholder' => 'Sale Price','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Product Handling Charges</strong>
                                    {!! Form::text('product_handling_chrages', null, array('placeholder' => 'Handling Charges','class' => 'form-control')) !!}
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="tab-pane p-3" id="pricing" role="tabpanel">

                    <div id="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne">
                          <h5 class="mb-0">
                            <input type="radio" value="simple" name="protype" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" checked>
                              Simple Product
                          
                          </h5>
                        </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="card-body">
                       <span class="repeater">
                        <div data-repeater-list="groupstocks">
                        <div data-repeater-item class="row">
                            
                            <div  class="form-group col-lg-4">
                                <label for="quantity">Quantity</label>
                                {!! Form::number('quantity',null, array('class' => 'form-control','id'=>"quantity")) !!}
                            </div>

                            <div  class="form-group col-lg-4">
                                <label for="warehouse_id">Ware house</label>
                                {!! Form::select('warehouse_id', $data['warehouses'],[], array('class' => 'form-control' ,'id'=>"warehouse_id")) !!}
                            </div>
                            <div class="col-lg-4 align-self-center">
                                <input data-repeater-delete type="button" class="btn btn-primary btn-block" value="Delete"/>
                             </div>
                           </div>
                         </div>
                           <input data-repeater-create type="button" class="btn btn-success mo-mt-2" value="Add More"/>
                          </span>
                        </div>
                    </div>
                </div>
                  <div class="card">
                    <div class="card-header" id="headingTwo">
                      <h5 class="mb-0">
                        <input type="radio" name="protype" value="variable" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                         Variable Product
                        
                      </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                      <div class="card-body">
                       <span class="repeater">
                    <div data-repeater-list="groupstocks">
                    <div data-repeater-item class="row">
                        <div  class="form-group col-lg-3">
                            <label for="attribute">Attribute</label>
                            <select name="attribute" id="" class="form-control">
                                <option value="">Select</option>
                            @foreach($data['Variation'] as $val)
                               <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                           </select>
                        </div>
                          <div  class="form-group col-lg-3">
                            <label for="attribute_value">Attribute Value</label>
                          <select name="attribute_value" class="form-control" id="attribute_value">
                              @foreach($data['Variation'] as $val)
                            <optgroup label="{{$val->name}}">
                            @foreach($data['VariationValues'] as $vval)
                            @if($vval->variation_id==$val->id)
                              <option value="volvo">{{$vval['value']}}</option>
                            @endif
                            @endforeach
                            </optgroup>
                             @endforeach
                           </select>


                        </div>
                        <div  class="form-group col-lg-3">
                            <label for="quantity">Quantity</label>
                            {!! Form::number('quantity',null, array('class' => 'form-control','id'=>"quantity")) !!}
                        </div>

                        <div  class="form-group col-lg-3">
                            <label for="warehouse_id">Ware house</label>
                            {!! Form::select('warehouse_id', $data['warehouses'],[], array('class' => 'form-control' ,'id'=>"warehouse_id")) !!}
                        </div>
                        <div class="col-md-1 align-self-center">
                            <input data-repeater-delete type="button" class="btn btn-primary btn-block" value="Delete"/>
                        </div>
                    </div>
                    </div>
                    <input data-repeater-create type="button" class="btn btn-success mo-mt-2" value="Add More"/>
                    </span>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                    <div class="tab-pane p-3" id="seo" role="tabpanel">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Meta title:</strong>
                                    {!! Form::text('meta_title', null, array('placeholder' => 'Meta Title','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Meta Keywords:</strong>
                                    {!! Form::text('meta_keywords', null, array('placeholder' => 'Meta Keywords','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <div>
                                        <textarea  class="form-control" name="meta_description" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>Schema</label>
                                    <div>
                                        <textarea  class="form-control" name="meta_schema" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane p-3" id="instructor" role="tabpanel">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Related Products:</strong>
                                {!! Form::select('rel_pro[]', $data['related_products'],[], array('class' => 'form-control ','multiple'=>'multiple')) !!}
                            </div>
                        </div>
                    </div>
                    
                <div class="tab-pane p-3" id="curriculum" role="tabpanel">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Internal Notes:</strong>
                                    <textarea  rows="5" name="internal_notes" class="form-control"></textarea>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    
                    
                    
                    
                    
                    
                    
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>


    </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    {{--<script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>--}}
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>

    <!-- Summernote js -->
    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js')}}"></script>

    <!-- demo js -->
    <!-- form repeater -->
    <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>

    <!-- form repeater init js -->
    <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>

    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>

@endsection