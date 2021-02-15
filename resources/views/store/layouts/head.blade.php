
<meta name="csrf-token" content="{{ csrf_token() }}">

@stack('metaInfo')
    <!-- Title -->


    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../favicon.png">

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap" rel="stylesheet">

<!-- CSS Implementing Plugins -->
<link rel="stylesheet" href="{{url('/public/assets/store/assets/vendor/font-awesome/css/fontawesome-all.min.css')}}">
<link rel="stylesheet" href="{{url('/public/assets/store/assets/css/font-electro.css')}}">

<link rel="stylesheet" href="{{url('/public/assets/store/assets/vendor/animate.css/animate.min.css')}}">
<link rel="stylesheet" href="{{url('/public/assets/store/assets/vendor/hs-megamenu/src/hs.megamenu.css')}}">
<link rel="stylesheet" href="{{url('/public/assets/store/assets/vendor/ion-rangeslider/css/ion.rangeSlider.css')}}">
<link rel="stylesheet" href="{{url('/public/assets/store/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
<link rel="stylesheet" href="{{url('/public/assets/store/assets/vendor/fancybox/jquery.fancybox.css')}}">
<link rel="stylesheet" href="{{url('/public/assets/store/assets/vendor/slick-carousel/slick/slick.css')}}">
<link rel="stylesheet" href="{{url('/public/assets/store/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
<link media="all" type="text/css" rel="stylesheet" href="{{url('/public/assets/store/plugins/sweet-alert2/sweetalert2.min.css')}}">
<!-- CSS Electro Template -->
<link rel="stylesheet" href="{{url('/public/assets/store/assets/css/theme.css')}}">
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5fbe4936a1d54c18d8ed4160/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->






@if(config('settings.config_google_analytics'))
    {!! config('settings.config_google_analytics') !!}
@endif


@stack('css')
