<div class="col-md-4 col-ms-8 col-xs-12">
    <div class="blog_articles_section">
      <div class="row">
        <div class="col-md-12">
            {!! Form::open(["url" => route('store-blog-slug', $data['blog_url']), "method"=>"GET"]) !!}
          <div class="input-group">
            <input type="text" class="form-control" value="{{ request()->keyword }}" name="keyword" placeholder="Search" />
            <div class="input-group-append">
              <span><button type="submit"><i class="fa fa-search"></i></button></span>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        @if(isset($data['category']) && $data['category']->cto_title)
        <div class="col-md-12 clear mb-3 p-0">
            <div class="cto" style="background-image:url({{ asset(config('thumbnails.blog_category.cto_image_path').$data['category']->cto_bg_image) }});')">
                <div class="cto_inner">
                    <h2>{!! $data['category']->cto_title !!}</h2>
                    <p>{!! $data['category']->cto_short_description !!}</p>
                    <a href="{{ $data['category']->cto_url }}">{{ $data['category']->cto_button_text }}</a>
                </div>
            </div>
        </div>
    @endif
        <div class="col-md-12">
          <div class="blog_articales">
            @if($data['popular_posts'])
            <span>Latest Articles</span>
            @foreach($data['popular_posts'] as $post)
            <div class="first_article">
                @php
                $title = explode('.' , $post->image);                     
                @endphp
              <div class="articl_img">
                {{ HTML::image(config('thumbnails.blog.path').'100x100/'.$post->image, $title[0], array('class' => '' , 'title' => $title[0])) }}
              </div>
              <div class="article_text">
                <span><h6 style="display: inline;"> By </h6> Websouls Content Team </span> <span>{{ $post->created_at->format('d M Y') }}</span>
                <a href="{{ route('store-blog-slug', $post->permalink->slug) }}"><h5>{{ $post->title }}</h5></a>
              </div>
            </div>
            @endforeach
            @endif
          </div>
        </div>
        {{-- <div class="col-md-12">
          <div class="advertise_img">
            <img src="images/advertise.jpg">
          </div>
        </div> --}}

        @if($data['tags']->count() > 0)
        <div class="col-md-12">
          <div class="popular_tags">
            <h6>popular_tags</h6>
            <ul>
                @foreach($data['tags'] as $tag)
              <li><a class="{{ request()->tag == $tag->tag->title ? "active" : ""}}" href="javascript:void(0)">{{ $tag->tag->title }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>