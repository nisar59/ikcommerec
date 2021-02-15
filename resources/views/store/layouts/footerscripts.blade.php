<!-- Go to Top -->
<a class="js-go-to u-go-to" href="#"
   data-position='{"bottom": 15, "right": 15 }'
   data-type="fixed"
   data-offset-top="400"
   data-compensation="#header"
   data-show-effect="slideInUp"
   data-hide-effect="slideOutDown">
    <span class="fas fa-arrow-up u-go-to__inner"></span>
</a>
<!-- End Go to Top -->

<!-- JS Global Compulsory -->
<script src="{{url('/public/assets/store/assets/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/bootstrap/bootstrap.min.js')}}"></script>

<!-- JS Implementing Plugins -->
<script src="{{url('/public/assets/store/assets/vendor/appear.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/jquery.countdown.min.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/hs-megamenu/src/hs.megamenu.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/svg-injector/dist/svg-injector.min.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/typed.js/lib/typed.min.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/slick-carousel/slick/slick.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/appear.js')}}"></script>
<script src="{{url('/public/assets/store/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>

<!-- JS Electro -->
<script src="{{url('/public/assets/store/assets/js/hs.core.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.countdown.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.header.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.hamburgers.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.unfold.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.focus-state.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.malihu-scrollbar.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.validation.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.fancybox.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.onscroll-animation.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.slick-carousel.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.quantity-counter.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.range-slider.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.show-animation.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.svg-injector.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.scroll-nav.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.go-to.js')}}"></script>
<script src="{{url('/public/assets/store/assets/js/components/hs.selectpicker.js')}}"></script>

<script>

    var add_to_cart_single = "{{ route('store-cart-add-single') }}";
    var wish_list_update = "{{route('store-product-favourite')}}"
    var csrf_token = "{{csrf_token()}}";
</script>

<script src="{{ url('/public/assets/store/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ url('public/assets/store/product/alerts.js')}}"></script>
<script src="{{ url('public/assets/store/product/common.js')}}"></script>
<!-- JS Plugins Init. -->
<script>
    $(window).on('load', function () {
        // initialization of HSMegaMenu component
        $('.js-mega-menu').HSMegaMenu({
            event: 'hover',
            direction: 'horizontal',
            pageContainer: $('.container'),
            breakpoint: 767.98,
            hideTimeOut: 0
        });
    });

    $(document).on('ready', function () {
        // initialization of header
        $.HSCore.components.HSHeader.init($('#header'));

        // initialization of animation
        $.HSCore.components.HSOnScrollAnimation.init('[data-animation]');

        // initialization of unfold component
        $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
            afterOpen: function () {
                $(this).find('input[type="search"]').focus();
            }
        });

        // initialization of HSScrollNav component
        $.HSCore.components.HSScrollNav.init($('.js-scroll-nav'), {
            duration: 700
        });

        // initialization of quantity counter
        $.HSCore.components.HSQantityCounter.init('.js-quantity');

        // initialization of popups
        $.HSCore.components.HSFancyBox.init('.js-fancybox');

        // initialization of countdowns
        var countdowns = $.HSCore.components.HSCountdown.init('.js-countdown', {
            yearsElSelector: '.js-cd-years',
            monthsElSelector: '.js-cd-months',
            daysElSelector: '.js-cd-days',
            hoursElSelector: '.js-cd-hours',
            minutesElSelector: '.js-cd-minutes',
            secondsElSelector: '.js-cd-seconds'
        });

        // initialization of malihu scrollbar
        $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));

        // initialization of forms
        $.HSCore.components.HSFocusState.init();

        // initialization of form validation
        $.HSCore.components.HSValidation.init('.js-validate', {
            rules: {
                confirmPassword: {
                    equalTo: '#signupPassword'
                }
            }
        });

        // initialization of forms
        $.HSCore.components.HSRangeSlider.init('.js-range-slider');

        // initialization of show animations
        $.HSCore.components.HSShowAnimation.init('.js-animation-link');

        // initialization of fancybox
        $.HSCore.components.HSFancyBox.init('.js-fancybox');

        // initialization of slick carousel
        $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');

        // initialization of go to
        $.HSCore.components.HSGoTo.init('.js-go-to');

        // initialization of hamburgers
        $.HSCore.components.HSHamburgers.init('#hamburgerTrigger');

        // initialization of unfold component
        $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
            beforeClose: function () {
                $('#hamburgerTrigger').removeClass('is-active');
            },
            afterClose: function() {
                $('#headerSidebarList .collapse.show').collapse('hide');
            }
        });

        $('#headerSidebarList [data-toggle="collapse"]').on('click', function (e) {
            e.preventDefault();

            var target = $(this).data('target');

            if($(this).attr('aria-expanded') === "true") {
                $(target).collapse('hide');
            } else {
                $(target).collapse('show');
            }
        });

        // initialization of unfold component
        $.HSCore.components.HSUnfold.init($('[data-unfold-target]'));

        // initialization of select picker
        $.HSCore.components.HSSelectPicker.init('.js-select');
    });







</script>

<script>
    $(document).ready(function(){
        $('#subscribeButton').on('click', function(){
     //alert('sda');
            $("#subform").submit(function(){
                $("#subform").preventDefault();
            });
            $.ajax({
                url:'subscription',
                type:'POST',
                data:$('#subform').serialize(),
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Congrates!',
                            'You have Successfully Subscribed',
                            'success'
                        )}
                    else{
                        Swal.fire(
                            'Oops!',
                            'You have already Subscribed',
                            'info'
                        )
                    }
                }
            });
        });
    });
</script>