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

                {!! Form::model($data['user'], ['method' => 'POST','url' => ['admin/products/update/'.$data['user']->id],"enctype"=>"multipart/form-data"]) !!}
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
                        <a class="nav-link" data-toggle="tab" href="#instructor" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Related Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#seo" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">SEO</span>
                        </a>
                    </li>
                        <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#notes" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Internal Notes</span>
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
                                    <strong>Supplier:</strong>
                                    {!! Form::select('supplier_id', $data['suppliers'],$data['user']->supllier_id, array('class' => 'form-control')) !!}
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
                                    @if(isset($data['user']->product_doc))
                                        <a href="{{url('public/uploads/products_doc/'.$data['user']->product_doc)}}"    target="_blank"> View Document</a><br/><br/>
                                    @endif    
                                     
                                    <strong>Documents:</strong>
                                    {!! Form::file('product_doc', null, array('placeholder' => 'Size Chart','class' => 'form-control filestyle')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
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

                            <div class="col-xs-6 col-sm-6 col-md-6">
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
                            <div class="col-xs-6 col-sm-6 col-md-6">
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


                                    {!! Form::textarea('short_description', null, array('placeholder' => 'Short Description','class' => 'summernote')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Long Description:</strong>

                                    {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'summernote')) !!}
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

                                        <option value="{{$cat->id}}"  @if(in_array($cat->id,$data['pro_cats'])) selected @endif>{{$cat->name}}</option>

                                        @if($cat->childs->count()>0)
                                            @foreach($cat->childs as $key=>$scat)
                                                <option value="{{$scat->id}}"   @if(in_array($scat->id,$data['pro_cats'])) selected @endif>&nbsp;&nbsp;|__{{$scat->name}}</option>
                                            @endforeach
                                        @endif

                                    @endforeach

                                </select>


                                {{--{!! Form::select('categories[]', $data['categories'],$data['pro_cats'], array('class' => 'form-control ','multiple'=>'multiple')) !!}--}}


                            </div>
                        </div>




                    </div>

                    <div class="tab-pane p-3" id="assessment" role="tabpanel">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Purcahse Price</strong>
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
                     @if(count($data['color'])<1 AND count($data['size'])<1)
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
                         @foreach($data['pro_stocks'] as $stock)
                        <div data-repeater-item class="row">
                            
                            <div  class="form-group col-lg-4">
                                <label for="quantity">Quantity</label>
                            {!! Form::number('quantity',$stock['quantity'], array('class' => 'form-control','id'=>"quantity")) !!}
                            </div>

                            <div  class="form-group col-lg-4">
                                <label for="warehouse_id">Ware house</label>
                               <select name="warehouse_ids" id="warehouse_id" class="form-control">
                                @foreach($data['warehouses'] as $warehouse)

                                   <option value="{{$warehouse->id}}" @if($warehouse->id==$stock->ware_house_id) selected @endif>{{$warehouse->name}}</option>
                                @endforeach
                               </select>
                            </div>
                            <div class="col-lg-4 align-self-center">
                                <input data-repeater-delete type="button" class="btn btn-primary btn-block" value="Delete"/>
                             </div>
                           </div>
                           @endforeach
                           
                         </div>
                           <input data-repeater-create type="button" class="btn btn-success mo-mt-2" value="Add More"/>
                          </span>
                        </div>

                    </div>
                </div> @endif
                @if(count($data['color'])>0 AND count($data['size'])>0)
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
                         @foreach($data['pro_stocks'] as $stock)
                    <div data-repeater-item class="row" style="border-bottom: 1px solid; margin-bottom:10px; padding-bottom: 10px;">


                      @foreach($data['Variation'] as $val)
                        <div  class="form-group col-lg-3">
                            <label for="attribute">{{$val->name}}</label>
                            <select name="{{$val->name}}" id="" class="form-control">
                                <option value="">Select</option>
                          @foreach($data['VariationValues'] as $vval)
                          @php
                          $name=$val->name;
                          @endphp
                          @if($val->id==$vval->variation_id)
                               <option value="{{$vval->id}}" @if($vval->id==$stock->$name) selected @endif>{{$vval->value}}</option>
                            @endif
                            @endforeach
                            
                           </select>
                        </div>
                        @endforeach

                       <div  class="form-group col-lg-3">
                            <label for="quantity">Quantity</label>
                       {!! Form::number('quantity',$stock['quantity'], array('class' => 'form-control','id'=>"quantity")) !!}
                        </div>

                        <div  class="form-group col-lg-3">
                            <label for="warehouse_id">Ware house</label>
                                <select name="warehouse_ids" id="warehouse_id" class="form-control">
                                @foreach($data['warehouses'] as $warehouse)
                                   <option value="{{$warehouse->id}}" @if($warehouse->id==$stock->ware_house_id) selected @endif>{{$warehouse->name}}</option>
                                @endforeach
                               </select>
                        </div>
                        <div class="col-md-12 align-self-right">
                        <div class="row">
                         <div class="col-lg-1">
                        <input data-repeater-delete type="button" class="btn btn-primary btn-block" value="Delete"/>
                        </div>
                        </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                    <input data-repeater-create type="button" class="btn btn-success mo-mt-2" value="Add More"/>
                    </span>
                      </div>
                    </div>
                  </div>
                   @endif
                </div>
                </div>


                    <div class="tab-pane p-3" id="instructor" role="tabpanel">
                        <div class="col-xs-12 col-sm-12 col-md-12">




                            <div class="form-group">
                                <strong>Related Products:</strong>
                                {!! Form::select('rel_pro[]', $data['related_products'],$data['rel_pro'], array('class' => 'form-control ','multiple'=>'multiple')) !!}


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
                      <div class="tab-pane p-3" id="notes" role="tabpanel">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Internal Notes:</strong>
                                    {!! Form::textarea('internal_notes', null, array('placeholder' => 'Internal Notes','class' => 'form-control')) !!}

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
    <!-- form repeater -->
    <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>

    <!-- form repeater init js -->
    <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>
    <!-- Summernote js -->
    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js')}}"></script>

    <!-- demo js -->
    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>

@endsection