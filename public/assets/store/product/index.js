$(document).ready(function(e) {

    $(document).on('click', ".add_to_cart", function(e){
        e.preventDefault();
       //alert('asd');
        var product_id = $('#product_id').val();
        var product_color = $('#product_color_id').val();
        var product_size = $('#product_size_id').val();
        var product_price = $('#product_price').val();
        var product_name = $('#product_name').val();
        var product_quantity = $('input[name=product_quantity]').val();
        var token = csrf_token;
        var url = add_to_cart;
        if(product_price > 0){
            $(".bg").show();
            $.ajax({
                type: "POST",
                url: url,
                data: { product_color_id: product_color, product_size_id: product_size, product_id: product_id, product_name: product_name, product_price: product_price, product_quantity: product_quantity, _token: token },
                success: function (data) {
                    $(".bg").fadeOut('slow');
                    console.log(data);
                    var obj = JSON.parse(data);
                    if(obj.status){
                        $('span.cart_items').html(obj.items);
                        if(obj.items > 0){
                            $('span.cart_items').css('opacity', 1);
                        }else{
                            $('span.cart_items').css('opacity', 0);
                        }
                        success_alert(obj.message, true);
                    }else{
                        error_alert(obj.message);
                    }

                },
                error: function (data) {
                    $(".bg").fadeOut('slow');
                    console.log('Error:', data);
                    var obj = JSON.parse(data);
                    error_alert(obj.message);
                }
            });
        }else{
            error_alert('Size is missing!');
        }
    });

    $('.testimonials').owlCarousel({
        loop:false,
        margin:10,
        nav:false,
        dots:true,
        autoplay:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:3
            }
        }
    });
});





    
