@if($section->clients() && $section->clients()->count())
    <section class="brands">
                 <div class="container">
                    <h2>{!! $section->title !!}</h2>
                    @if($section->sub_heading)
                    <h5>{!! $section->sub_heading !!}</h5>
                    @endif
                        <hr class="divider">
                        @if($section->description)
                        {!! $section->description !!}
                        @endif
                    <div class="row">
                      
                        <div class="customers_logo owl-carousel">
                            @foreach($section->clients() as $client)
                                <div class="item">
                                    @php
                                    $title = explode('.' , $client->image);                     
                                    @endphp
                                    <div class="slidrimg">
                                        {{ HTML::image(config('thumbnails.clients.original').$client->image, $title[0], array( 'class' => '' , 'title' => $title[0] )) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <a href="/clients">See More</a>
                </div>
    </section>
@endif
