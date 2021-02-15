$(document).ready(function(e) {
    //remove selected option
    $(document).on('click','.remove',function(){
        var id = $(this).data('id');
        var type = $(this).data('type');

        $(this).closest('.filter_option').remove();
        $('input[name=refresh_sorting]').val(1);
        $('#btn-more').trigger('click');
    });

    //Sizes filter options
    $(document).on('click','.sizes a',function(){
        var id = $(this).data('id');
        var type = 'size';
        var text = $(this).text();

        $('.filter_active_option').append('<div class="filter_option"><button class="btn">'+text+'<i class="fa fa-close remove" data-type="'+type+'" data-id="'+id+'"></i></button><input type="hidden" name="'+type+'[]" value="'+id+'"/></div>');
        $('input[name=refresh_sorting]').val(1);
        $('#btn-more').trigger('click');
    });

    //Colors filter options
    $(document).on('click','.colors a',function(){
        var id = $(this).data('id');
        var type = 'color';
        var text = $(this).text();

        $('.filter_active_option').append('<div class="filter_option"><button class="btn">'+text+'<i class="fa fa-close remove" data-type="'+type+'" data-id="'+id+'"></i></button><input type="hidden" name="'+type+'[]" value="'+id+'"/></div>');
        $('input[name=refresh_sorting]').val(1);
        $('#btn-more').trigger('click');
    });

    //Styles filter options
    $(document).on('click','.styles a',function(){
        var id = $(this).data('id');
        var type = 'style';
        var text = $(this).text();

        $('.filter_active_option').append('<div class="filter_option"><button class="btn">'+text+'<i class="fa fa-close remove" data-type="'+type+'" data-id="'+id+'"></i></button><input type="hidden" name="'+type+'[]" value="'+id+'"/></div>');
        $('input[name=refresh_sorting]').val(1);
        $('#btn-more').trigger('click');
    });

    //Materials filter options
    $(document).on('click','.materials a',function(){
        var id = $(this).data('id');
        var type = 'material';
        var text = $(this).text();

        $('.filter_active_option').append('<div class="filter_option"><button class="btn">'+text+'<i class="fa fa-close remove" data-type="'+type+'" data-id="'+id+'"></i></button><input type="hidden" name="'+type+'[]" value="'+id+'"/></div>');
        $('input[name=refresh_sorting]').val(1);
        $('#btn-more').trigger('click');
    });

    //Weaves filter options
    $(document).on('click','.weaves a',function(){
        var id = $(this).data('id');
        var type = 'weave';
        var text = $(this).text();

        $('.filter_active_option').append('<div class="filter_option"><button class="btn">'+text+'<i class="fa fa-close remove" data-type="'+type+'" data-id="'+id+'"></i></button><input type="hidden" name="'+type+'[]" value="'+id+'"/></div>');
        $('input[name=refresh_sorting]').val(1);
        $('#btn-more').trigger('click');
    });

    //Prices filter options
    $(document).on('click','.prices a',function(){
        var id = $(this).data('id');
        var type = 'price';
        var text = $(this).text();
        $('.filter_option.single_price').remove();

        $('.filter_active_option').append('<div class="filter_option single_price"><button class="btn">'+text+'<i class="fa fa-close remove" data-type="'+type+'" data-id="'+id+'"></i></button><input type="hidden" name="'+type+'" value="'+id+'"/></div>');
        $('input[name=refresh_sorting]').val(1);

        $('#btn-more').trigger('click');
    });

    //Limit Paging
    $(document).on('click', '.rug_limits a', function(e){
        e.preventDefault();
        $('.rug_limits a').removeClass('active');
        $(this).addClass('active');
        $('#btn-more').trigger('click');
    });

    //Limit Paging
    $(document).on('change', 'select[name=rugs_sort_order]', function(e){
        $('input[name=refresh_sorting]').val(1);
        $('#btn-more').trigger('click');
    });

    //Load more
    $(document).on('click','#btn-more',function(){

        var sizes = $("input[name='size[]']").map(function(){return $(this).val();}).get();
        var colors = $("input[name='color[]']").map(function(){return $(this).val();}).get();
        var styles = $("input[name='style[]']").map(function(){return $(this).val();}).get();
        var materials = $("input[name='material[]']").map(function(){return $(this).val();}).get();
        var weaves = $("input[name='weave[]']").map(function(){return $(this).val();}).get();

        var price_range = $('input[name=price]').val();

        var limit = $('.rug_limits a.active').data('limit');
        var sorting_order = $('select[name=rugs_sort_order]').val();
        var offset = $('input[name=limit_offset]').val();
        var reload = $('input[name=refresh_sorting]').val();
        var sale = $('input[name=sale]').val();
        $('input[name=refresh_sorting]').val(0);

        //Category
        var category = $('input[name=category]').val();
        var keyword = $('input[name=keyword]').val();

        $(".bg").show();
        $("#btn-more").html("Loading....");
        $.ajax({
            url : load_more_rugs,
            method : "POST",
            data : {  _token: csrf_token, offset: offset, sizes: sizes, colors: colors, styles: styles, materials: materials, weaves: weaves, limit: limit, sorting_order: sorting_order, price_range: price_range, reload: reload, category: category, keyword: keyword, sale: sale},
            dataType : "text",
            success : function (data){
                $(".bg").fadeOut('slow');
                if(data){
                    var obj = JSON.parse(data);
                    var total_records = obj.total;
                    var displaying = obj.current;
                    $('span.total_records').text(total_records);
                    if(reload == 1){
                        $('span.total_displayed_records').text(obj.current);
                        $('input[name=limit_offset]').val(limit);
                        $('.pull-left .data').html(obj.data);
                    }else{
                        displaying = eval(offset) + eval(obj.current);
                        if(limit > total_records){
                            displaying = total_records;
                        }
                        $('span.total_displayed_records').text(displaying);
                        $('input[name=limit_offset]').val(displaying);
                        $('.pull-left .data').append(obj.data);
                    }

                    if(total_records > displaying){
                        $('#btn-more').show();
                        $('#btn-more').html("Load More");
                    }else{
                        $('#btn-more').hide();
                    }
                }else{
                    $('#btn-more').hide();
                }
            }
        });
    });
});