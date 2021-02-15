var $star_rating = $('.star-rating .fa');

var SetRatingStar = function() {
    return $star_rating.each(function() {
        if (parseInt($(this).parent('.star-rating').find('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
            return $(this).removeClass('fa-star-o').addClass('fa-star');
        } else {
            return $(this).removeClass('fa-star').addClass('fa-star-o');
        }
    });
};

$star_rating.on('click', function() {
    $(this).parent('.star-rating').find('input.rating-value').val($(this).data('rating'));
    return SetRatingStar();
});

SetRatingStar();


$('drpdn').on('click', function(){
    $('drpdn').next('.megadrop').slideToggle(100);
});

$(document).ready(function() {
    $(".bg").fadeOut('slow');

    $(document).on('click', '.card_add_to_cart', function(){
        var product_id = $(this).data('product-id');
        var token = csrf_token;
        var url = add_to_cart_single;
        if(product_id){
            $(".bg").show();
            $.ajax({
                type: "POST",
                url: url,
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
        }else{
            error_alert('Some parameters are missing...');
        }
    });

    $(document).on('click', '.trigger_wish_list', function(){
       // alert('asd');
        var product_id = $(this).data('product-id');
        var token = csrf_token;
        var url = wish_list_update;
        var type = 1;
        var _this = $(this).find('i.fa');
        if(_this.hasClass('fa-heart-o')){
            type = 1;
        }else{
            type = 0;
        }
        if(product_id){
            $(".bg").show();
            $.ajax({
                type: "POST",
                url: url,
                data: { product_id: product_id, type: type,  _token: token },
                success: function (data) {
                    $(".bg").fadeOut('slow');
                    var obj = JSON.parse(data);
                    if(obj.status){
                        if(type == 1){
                            _this.removeClass('fa-heart-o').addClass('fa-heart');
                        }else{
                            _this.removeClass('fa-heart').addClass('fa-heart-o');
                        }
                        success_alert(obj.message);
                    }else{
                        error_alert(obj.message);
                    }

                },
                error: function (data) {
                    $(".bg").fadeOut('slow');
                    var obj = JSON.parse(data);
                    error_alert(obj.message);
                }
            });
        }
    });

    $(document).on('submit', '#newsletter_subscribe', function(e){
        e.preventDefault();
        var email = $('#newsletter_subscribe input[name=email]').val();
        if(email){
            $(".bg").show();
            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json"
            })
            .done(function(result) {
                $(".bg").fadeOut('slow');
                //var obj = JSON.parse(result);
                if(result.status){
                    success_alert(result.message);
                    $('#newsletter_subscribe input[name=email]').val('');
                }else{
                    error_alert(result.message);
                }
            })
            .fail(function(result) {
                $(".bg").fadeOut('slow');
                //var obj = JSON.parse(data);
                error_alert(result.message);
            });
        }
    });
});