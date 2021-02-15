<script>
    var base_url = "{{ url('/') }}";
    var auto_fill = '{{ route('store-product-autofill') }}';
    var add_to_cart = "{{ route('store-cart-add') }}";
    var wish_list_update = "{{ route('store-product-favourite') }}";
    var add_to_cart_single = "{{ route('store-cart-add-single') }}";
    var coupon_apply = "{{ route('store-coupon-apply') }}";
    var csrf_token = "{{ csrf_token() }}";
    var newsletterSubscription = '{{ route('store-newsletter-subscribe') }}/';
</script>
