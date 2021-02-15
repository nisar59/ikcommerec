
<div class="mb-5">
    <div class="row">

       @foreach($data['home_banner_categories'] as $key => $cat)

            <div class="col-md-6 mb-4 mb-xl-0 col-xl-3">
            <a href="{{url($cat->permalink->slug)}}" class="d-black text-gray-90">
                <div class="min-height-132 py-1 d-flex bg-gray-1 align-items-center">
                    <div class="col-6 col-xl-5 col-wd-6 pr-0">
                       @if(isset($cat->image_id)) <img class="img-fluid" src="{{url('public/uploads/category/'.$cat->image_id)}}" alt="{{$cat->name}}">@endif
                    </div>
                    <div class="col-6 col-xl-7 col-wd-6">
                        <div class="mb-2 pb-1 font-size-18 font-weight-light text-ls-n1 text-lh-23">
                            {{$cat->name}}{{--<strong>DEALS</strong> ON THE CAMERAS--}}
                        </div>
                        <div class="link text-gray-90 font-weight-bold font-size-15" href="#">
                            Shop now
                            <span class="link__icon ml-1">
                                                <span class="link__icon-inner"><i class="ec ec-arrow-right-categproes"></i></span>
                                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

    </div>
</div>