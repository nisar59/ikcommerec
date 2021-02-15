@if(count($data['store_currencies']))
    <div class="languages">
        <ul>
            <li class="click_languages">
                <a href="javascript:void(0)"><i class="fa fa-globe"></i>{!! session()->get('default_currency') ? session()->get('default_currency')['code'] : 'PKR' !!}<i class="fa fa-caret-down"></i></a>

               @if(empty(session()->get('api_user')))
                <ul class="dropdown">
                    @foreach($data['store_currencies'] as $currency)

                        <li>
                            <a href="javascript:void(0)" class="currency_switcher" data-currency="{{ $currency['api_id'] }}">
                                {{ HTML::image(config('thumbnails.currency.path').strtolower($currency['code']).'.png', $currency['code'], array( 'class' => '' )) }}{!! $currency['code'] !!} ({!! $currency['prefix'] !!})
                            </a>
                        </li>


                    @endforeach

                </ul>
                   @endif
            </li>
        </ul>
    </div>
@endif

@push('js')
<script>
  $(document).ready(function(){

      // NAV TOGGLE ONCLICK WITH SLIDE
      $(".click_languages ul").hide();
      $(".click_languages").click(function(){
          $(this).children("ul").stop(true,true).slideToggle("fast"),
          $(this).toggleClass("dropdown-active");
      });

      // NAV TOGGLE ONCLICK WITH FADE
      $(".clickFade ul").hide();
      $(".clickFade").click(function(){
          $(this).children("ul").stop(true,true).fadeToggle("fast"),
          $(this).toggleClass("dropdown-active");
      });

      // NAV TOGGLE ONHOVER WITH SLIDE
      $(".hoverSlide ul").hide();
      $(".hoverSlide").hover(function(){
          $(this).children("ul").stop(true,true).slideToggle("fast"),
          $(this).toggleClass("dropdown-active");
      });

      // NAV TOGGLE ONHOVER WITH FADE
      $(".hoverFade ul").hide();
      $(".hoverFade").hover(function(){
          $(this).children("ul").stop(true,true).fadeToggle("fast"),
          $(this).toggleClass("dropdown-active");
      });

  });
</script>
<script>

    // this is the function caller for click into drop down menu
    $(document).ready(function(){
        // this to function call targets the drop down menu by elements
        $(".click_languages:has(ul)").click(function(){
            // (IMPORTANT) code to hide existing open drop down menu before displaying new drop down menu
            $(".dropdown").hide();
            // code to toggle menu from drop down ROOT
            $(this).find(".dropdown").toggle();
        });// END: .click
    });// END: .ready

    //this script closes menu when clicked outside of drop down menu.
    $(document).on("click", function(event){
        var $triggerOn = $(".click_languages");
        if($triggerOn !== event.target && !$triggerOn.has(event.target).length){
            $(".dropdown").hide();
        }// END: if statement
    });// END: .on

</script>
@endpush
