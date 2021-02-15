<!DOCTYPE html>
<html lang="en">
<head>
    @include('store.layouts.head')
</head>
<body>

<!-- ========== HEADER ========== -->
@include('store.layouts.inner_header')

<!-- ========== END HEADER ========== -->

<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main">
    @yield('content')
</main>
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== FOOTER ========== -->
@include('store.layouts.footer')

<!-- ========== END FOOTER ========== -->

<!-- ========== SECONDARY CONTENTS ========== -->
<!-- Account Sidebar Navigation -->
@include('store.layouts.aside')

<!-- End Account Sidebar Navigation -->
<!-- ========== END SECONDARY CONTENTS ========== -->

@include('store.layouts.footerscripts')

@stack('js')
</body>
</html>






