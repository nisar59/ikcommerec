@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Site Settings</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Site Settings </li>
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


                {!! Form::model($data['setting'], ['method' => 'POST','url' => ['admin/settings/update'], "enctype"=>"multipart/form-data"]) !!}
                <h4 class="card-title">Site Settings</h4>


                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">General</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#assessment" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">SEO</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pricing" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Email</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#categories" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Social Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#instructor" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Locations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#hompage" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Home Page Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#others" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Others Settings</span>
                        </a>
                    </li>

                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" data-toggle="tab" href="#curriculum" role="tab">--}}
                            {{--<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>--}}
                            {{--<span class="d-none d-sm-block">Curriculum </span>--}}
                        {{--</a>--}}
                    {{--</li>--}}

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="general" role="tabpanel">

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Site Title:</strong>
                                    {!! Form::text('config_site_title', (isset($data['setting']['config_site_title']) ? $data['setting']['config_site_title'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Site Slogan:</strong>
                                    {!! Form::text('config_site_slogan', (isset($data['setting']['config_site_slogan']) ? $data['setting']['config_site_slogan'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>


                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong> Site Logo:</strong>
                                    @if(isset($data['setting']['config_site_logo']))
                                    <img src="{{url(config('thumbnails.logo').$data['setting']['config_site_logo'])}}" width="128"  height="128">
                                    @endif
                                    {!! Form::hidden('config_site_logo', (isset($data['setting']['config_site_logo']) ? $data['setting']['config_site_logo'] : ''), array('class' => 'form-control')) !!}
                                    <input type='file' name="logo" id="upload_logo" class="form-control filestyle"/>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Footer Logo:</strong>
                                    @if(isset($data['setting']['config_footer_logo']))

                                        <img src="{{url(config('thumbnails.logo').$data['setting']['config_footer_logo'])}}" width="128"  height="128" >
                                    @endif
                                    {!! Form::hidden('config_footer_logo', (isset($data['setting']['config_footer_logo']) ? $data['setting']['config_footer_logo'] : ''), array('class' => 'form-control')) !!}
                                    <input type='file' name="footer_logo" id="footer_logo" class="form-control filestyle"/>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Favicon:</strong>
                                    @if(isset($data['setting']['config_favicon']))

                                        <img src="{{url(config('thumbnails.logo').$data['setting']['config_favicon'])}}" width="32"  height="32" >
                                    @endif
                                    {!! Form::hidden('config_favicon', (isset($data['setting']['config_favicon']) ? $data['setting']['config_favicon'] : ''), array('class' => 'form-control')) !!}
                                    <input type='file' name="favicon" id="favicon" class="form-control filestyle"/>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Header Mobile:</strong>
                                    {!! Form::text('config_header_mobile', (isset($data['setting']['config_header_mobile']) ? $data['setting']['config_header_mobile'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Footer Coupon Text:</strong>
                                    {!! Form::text('config_coupon_text', (isset($data['setting']['config_coupon_text']) ? $data['setting']['config_coupon_text'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>


                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Footer Got Question</strong>
                                    {!! Form::text('config_footer_got_question', (isset($data['setting']['config_footer_got_question']) ? $data['setting']['config_footer_got_question'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Footer Mobile</strong>
                                    {!! Form::text('config_footer_mobile', (isset($data['setting']['config_footer_mobile']) ? $data['setting']['config_footer_mobile'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Footer Landline</strong>
                                    {!! Form::text('config_footer_landline', (isset($data['setting']['config_footer_landline']) ? $data['setting']['config_footer_landline'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Footer Contact Info</strong>
                                    {!! Form::text('config_footer_contact_info', (isset($data['setting']['config_footer_contact_info']) ? $data['setting']['config_footer_contact_info'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Email</strong>
                                    {!! Form::text('config_site_email', (isset($data['setting']['config_site_email']) ? $data['setting']['config_site_email'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Coyright Text </strong>
                                    {!! Form::text('config_copyright_text', (isset($data['setting']['config_copyright_text']) ? $data['setting']['config_copyright_text'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            {{--<div class="col-xs-6 col-sm-6 col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<strong>About Us</strong>--}}
                                    {{--{!! Form::text('config_about_us', (isset($data['setting']['config_about_us']) ? $data['setting']['config_about_us'] : ''), array('class' => 'form-control')) !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="col-xs-6 col-sm-6 col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<strong>Chat Script </strong>--}}
                                    {{--{!! Form::text('config_chat_script', (isset($data['setting']['config_chat_script']) ? $data['setting']['config_chat_script'] : ''), array('class' => 'form-control')) !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}





                        </div>
                    </div>
                    <div class="tab-pane p-3" id="assessment" role="tabpanel">
                        <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Meta Title</strong>
                                {!! Form::text('config_meta_title', null, array('placeholder' => 'Meta Title','class' => 'form-control')) !!}
                            </div>
                        </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Meta Keywords</strong>
                                    {!! Form::text('config_meta_keywords', null, array('placeholder' => 'Meta keywords','class' => 'form-control')) !!}
                                </div>
                            </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Meta Description</strong>
                                {!! Form::textarea('config_meta_description', null, array('placeholder' => 'Meta Description','class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Schema</strong>
                                {!! Form::textarea('config_meta_schema', null, array('placeholder' => 'Schema','class' => 'form-control')) !!}
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="pricing" role="tabpanel">

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Query Email:</strong>
                                    {!! Form::text('config_query_email', (isset($data['setting']['config_query_email']) ? $data['setting']['config_query_email'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="categories" role="tabpanel">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Facebook Link :</strong>
                                    {!! Form::text('config_social_fb_url', (isset($data['setting']['config_social_fb_url']) ? $data['setting']['config_social_fb_url'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Twitter Link :</strong>
                                    {!! Form::text('config_social_twitter_url', (isset($data['setting']['config_social_twitter_url']) ? $data['setting']['config_social_twitter_url'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Instagram Link :</strong>
                                    {!! Form::text('config_social_instagram_url', (isset($data['setting']['config_social_instagram_url']) ? $data['setting']['config_social_instagram_url'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>LinkedIn Link :</strong>
                                    {!! Form::text('config_social_linkedin_url', (isset($data['setting']['config_social_linkedin_url']) ? $data['setting']['config_social_linkedin_url'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Behance Link :</strong>
                                    {!! Form::text('config_social_behance_url', (isset($data['setting']['config_social_behance_url']) ? $data['setting']['config_social_behance_url'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane p-3" id="instructor" role="tabpanel">
                        <div class="row">

                           <div class="col-xs-6 col-sm-6 col-md-12">
                            <div class="form-group">
                                <strong>Locations 1:</strong>

                            </div>
                        </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Location Main Heading :</strong>
                                    {!! Form::text('config_location_heading', (isset($data['setting']['config_location_heading']) ? $data['setting']['config_location_heading'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Title :</strong>
                                    {!! Form::text('config_location_address_1_heading', (isset($data['setting']['config_location_address_1_heading']) ? $data['setting']['config_location_address_1_heading'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Address:</strong>
                                    {!! Form::text('config_location_address_1', (isset($data['setting']['config_location_address_1']) ? $data['setting']['config_location_address_1'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Mobile :</strong>
                                    {!! Form::text('config_location_address_1_mobile', (isset($data['setting']['config_location_address_1_mobile']) ? $data['setting']['config_location_address_1_mobile'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>LandLine :</strong>
                                    {!! Form::text('config_location_address_1_phone', (isset($data['setting']['config_location_address_1_phone']) ? $data['setting']['config_location_address_1_phone'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Locations 2:</strong>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Title :</strong>
                                    {!! Form::text('config_location_address_2_heading', (isset($data['setting']['config_location_address_2_heading']) ? $data['setting']['config_location_address_2_heading'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Address :</strong>
                                    {!! Form::text('config_location_address_2', (isset($data['setting']['config_location_address_2']) ? $data['setting']['config_location_address_2'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Mobile :</strong>
                                    {!! Form::text('config_location_address_2_mobile', (isset($data['setting']['config_location_address_2_mobile']) ? $data['setting']['config_location_address_2_mobile'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>LandLine :</strong>
                                    {!! Form::text('config_location_address_2_phone', (isset($data['setting']['config_location_address_2_phone']) ? $data['setting']['config_location_address_2_phone'] : ''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="tab-pane p-3" id="hompage" role="tabpanel">
                        <div class="row">

                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Section 1:</strong>
                                    <hr>
                                </div>
                            </div>
                            @php
                            $products = ShowProducts();
                            @endphp
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Special Offer Product :</strong>
                                    {!! Form::select('config_home_page_special_offer', $products,isset($data['setting']['config_home_page_special_offer'])?$data['setting']['config_home_page_special_offer']:'', array('class' => 'form-control ')) !!}
                                </div>
                            </div>

                            @php
                            $tabs=array('featured'=>'Featured','on_sale'=>'On Sale','reviewed'=>'Top Reviewed','recent'=>'Recent','best_seller'=>'Best Seller','viewed'=>'Most Viewed');
                            @endphp
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Section 1 Tabs :</strong>
                                    {!! Form::select('config_home_page_section_1[]', $tabs,isset($data['setting']['config_home_page_section_1'])?$data['setting']['config_home_page_section_1']:'', array('class' => 'form-control ','multiple'=>'multiple')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Category Section:</strong>
<hr>
                                </div>
                            </div>
                            @php
                           // dd($data['setting']['config_home_page_categories']);
                            $ct =[];
                            if(isset($data['setting']['config_home_page_categories'])){
                            $ct =$data['setting']['config_home_page_categories'];
                            }
                            $cats =\Modules\Category\Entities\Category::where (['parent_id'=>0,'status'=>1])->orderBy('sort_order','desc')->get();
                            @endphp
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Select Categories :</strong>
                                    <select name="config_home_page_categories[]" class="form-control" multiple>
                                        <option> Select</option>
                                        @foreach($cats as $key=>$cat)

                                            <option value="{{$cat->id}}" @if(in_array($cat->id,$ct)) selected @endif>{{$cat->name}}</option>

                                          @if($cat->childs->count()>0)
                                                @foreach($cat->childs as $key=>$scat)
                                                    <option value="{{$scat->id}}" @if(in_array($scat->id,$ct)) selected @endif>&nbsp;&nbsp;|__{{$scat->name}}</option>
                                                @endforeach
                                                @endif

                                        @endforeach
                                    </select>



                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Section 2:</strong>
                                    <hr>
                                </div>
                            </div>
                            @php
                                $tabs=array(''=>'Select','featured'=>'Featured','on_sale'=>'On Sale','reviewed'=>'Top Reviewed','recent'=>'Recent','best_seller'=>'Best Seller','viewed'=>'Most Viewed');
                            @endphp
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Section 2 Tabs :</strong>
                                    {!! Form::select('config_home_page_section_2', $tabs,isset($data['setting']['config_home_page_section_2'])?$data['setting']['config_home_page_section_2']:'', array('class' => 'form-control ')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Section 3:</strong>
                                    <hr>
                                </div>
                            </div>
                            @php
                                $tabs=array(''=>'Select','featured'=>'Featured','on_sale'=>'On Sale','reviewed'=>'Top Reviewed','recent'=>'Recent','best_seller'=>'Best Seller','viewed'=>'Most Viewed');
                            @endphp
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Section 3 Tabs :</strong>
                                    {!! Form::select('config_home_page_section_3', $tabs,isset($data['setting']['config_home_page_section_3'])?$data['setting']['config_home_page_section_3']:'', array('class' => 'form-control ')) !!}
                                </div>
                            </div>
                            <hr />
                            <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <strong> </strong>

                                </div>


                            </div>
                        </div>
                            {{--<div class="col-xs-6 col-sm-6 col-md-6">--}}
                                {{--<div class="form-group">--}}
                                   {{--<div class="form-group">--}}
                                        {{--<strong>Home Bottom Horizantal Banner Text:</strong>--}}
                                        {{--{!! Form::text('config_home_horizantal_banner_text', (isset($data['setting']['config_home_horizantal_banner_text']) ? $data['setting']['config_home_horizantal_banner_text'] : ''), array('class' => 'form-control')) !!}--}}
                                    {{--</div>--}}


                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">


                                    <div class="form-group">
                                        <strong>Home Bottom Horizantal Banner Link:</strong>
                                        {!! Form::text('config_home_horizantal_banner_link', (isset($data['setting']['config_home_horizantal_banner_link']) ? $data['setting']['config_home_horizantal_banner_link'] : ''), array('class' => 'form-control')) !!}
                                    </div>


                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">


                                    <div class="form-group">
                                        <strong>Home Bottom Horizantal Banner (1400 * 200):</strong>

                                    </div>

                                    @if(isset($data['setting']['config_horizantal_banner']))

                                        <img src="{{url(config('thumbnails.logo').$data['setting']['config_horizantal_banner'])}}" width="700"  height="200" >
                                    @endif
                                    {!! Form::hidden('config_horizantal_banner', (isset($data['setting']['config_horizantal_banner']) ? $data['setting']['config_horizantal_banner'] : ''), array('class' => 'form-control')) !!}
                                    <input type='file' name="horizantal_banner" id="horizantal_banner" class="form-control filestyle"/>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">


                                    <div class="form-group">
                                        <strong>Home Footer  Banner Link:</strong>
                                        {!! Form::text('config_home_footer_banner_link', (isset($data['setting']['config_home_footer_banner_link']) ? $data['setting']['config_home_footer_banner_link'] : ''), array('class' => 'form-control')) !!}
                                    </div>


                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">


                                    <div class="form-group">
                                        <strong>Home Footer (330 * 360):</strong>

                                    </div>

                                    @if(isset($data['setting']['config_footer_banner']))

                                        <img src="{{url(config('thumbnails.logo').$data['setting']['config_footer_banner'])}}" width="330"  height="360" >
                                    @endif
                                    {!! Form::hidden('config_footer_banner', (isset($data['setting']['config_footer_banner']) ? $data['setting']['config_footer_banner'] : ''), array('class' => 'form-control')) !!}
                                    <input type='file' name="footer_banner" id="footer_banner" class="form-control filestyle"/>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane p-3" id="others" role="tabpanel">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Daily Voucher Code Pre-fix</strong>
                                    {!! Form::text('config_voucher_pre_fix', null, array('placeholder' => 'Daily Voucher Code Pre-fix','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Invoice Pre-fix</strong>
                                    {!! Form::text('config_invoice_pre_fix', null, array('placeholder' => 'Invoice Pre-fix','class' => 'form-control')) !!}
                                </div>
                            </div>

                        </div>
                    </div>


                    {{--<div class="tab-pane p-3" id="curriculum" role="tabpanel">--}}
                        {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                            {{--<div class="form-group">--}}
                                {{--<strong>Curriculum:</strong>--}}
                                {{--<br/>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
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
    <script src="{{ URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    {{--<script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>--}}
    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>

    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>

    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>

@endsection