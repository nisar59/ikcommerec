$(document).ready(function(e) {
    $(document).on('click', ".remove", function(e){
        e.preventDefault();
        var product_id = $(this).data('product-id');
        var token = csrf_token;

        if(product_id){
            $(".bg").show();
            $.ajax({
                type: "POST",
                url: remove_from_cart,
                data: { product_id: product_id, _token: token },
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
        }
    });
    
    
    $(document).on('click', ".removewhishlist", function(e){
        e.preventDefault();
        var product_id = $(this).data('product-id');
        var token = csrf_token;

        if(product_id){
            $(".bg").show();
            $.ajax({
                type: "POST",
                url: 'removewishlist',
                data: { product_id: product_id, _token: token },
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
        }
    });
    
    
    
    
    
    
    
    
    
    
    
    $(document).on('click', ".cartupdate", function(e){
        e.preventDefault();
        var product_id = $(this).data('product-id');
        var quantity = $('.cart_quantity').val();
        var token = csrf_token;
        if(product_id && quantity){
            $(".bg").show();
            $.ajax({
                type: "POST",
                url: update_qty_cart,
                data: { product_id: product_id, quantity: quantity, _token: token },
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
        }
    });

    //Shipping method select
    $(document).on('click', "input[name=shipping_method]", function(e){
        //e.preventDefault();
        var method_id = $(this).val();
        var token = csrf_token;
        if($(this).is(':checked')){
            $('input[name=shipping_method]').removeAttr('checked');
            $(this).attr('checked','checked').prop('checked', true);
        }
        if(method_id){
            $(".bg").show();
            $.ajax({
                type: "POST",
                url: shipping_method,
                data: { method_id: method_id, _token: token },
                success: function (data) {
                    $(".bg").fadeOut('slow');
                    console.log(data);
                    var obj = JSON.parse(data);
                    if(obj.status){
                        $('div.cart_total').html(obj.html);
                        //success_alert(obj.message, true);
                    }else{
                        //error_alert(obj.message);
                    }

                },
                error: function (data) {
                    $(".bg").fadeOut('slow');
                    console.log('Error:', data);
                    var obj = JSON.parse(data);
                    error_alert(obj.message);
                }
            });
        }
    });

    //Shipping form submit
    $(document).on('click', ".shipping_form_submit", function(e){
        //e.preventDefault();
        var method_id = $('input[name=shipping_method]:checked').val();
        if(!method_id){
            error_alert('Please select shipping method.')
        }else{
            $('form.shipping_form').submit();
        }
    });
});