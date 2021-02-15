@extends('admin.layouts.core')
@section('content')
<!--main content start-->

<section class="content">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body block-header">
                        <div class="row">
                            <div class="col-lg-6 col-md-8 col-sm-12">
                                <h2>{{ ($isEdit) ? "Edit":"New" }} Order</h2>
                                <ul class="breadcrumb p-l-0 p-b-0 ">
                                    <li class="breadcrumb-item"><a href="{{ URL::to('/'.Core::getAdminURI().'dashboard') }}"><i class="icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ URL::to('/'.Core::getAdminURI().'order/list') }}">Orders</a></li>
                                    <li class="breadcrumb-item active">{{ ($isEdit) ? "Edit":"Create New" }}</li>
                                </ul>
                            </div>            
                            <div class="col-lg-6 col-md-4 col-sm-12 text-right">
                                @if($isEdit)
                                <a href="{{ URL::to('/'.Core::getAdminURI().'order/delete/'.$model->id) }}" class="btn confirmation btn-danger btn-round btn-simple float-right hidden-xs m-l-10">Delete</a>
                                <a href="{{ URL::to('/'.Core::getAdminURI().'order/new') }}" class="btn btn-primary btn-round btn-simple float-right hidden-xs m-l-10">Create New</a>
                                @endif
                                <a href="{{ URL::to('/'.Core::getAdminURI().'order/list') }}" class="btn btn-primary btn-round btn-simple float-right hidden-xs m-l-10">Orders</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Examples -->

        {!! Form::model($model,["url"=>$action,"class"=>"form-horizontal", "id"=>"model-form", "method"=>"POST"]) !!}
        <div class="row clearfix">
            <div class="col-lg-9">
                <div class="card">
                    <div class="body"> 
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#general" aria-expanded="true">General</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product-content" aria-expanded="true">Products</a></li>
                            @if($isEdit)
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#shipment-content" aria-expanded="true">Shipments</a></li>
                            @endif
                        </ul>                        
                        <!-- Tab panes -->
                        <div class="tab-content">
                            @include('admin.snippets.messages',['errors'=>$errors])
                            <div id="order-messages"></div>
                            <!-- General -->
                            <div role="tabpanel" class="tab-pane in active" id="general" aria-expanded="true"> 

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        @if($isEdit)
                                        @include('admin.snippets.hidden-field',['name'=>'old_id','value'=>$model->id])
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-6 col-sm-6 control-label">Sale ID<span class="required">*</span></label>
                                        <div class="col-sm-12">
                                            @include('admin.snippets.text-field',['name'=>'order_no','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-6 col-sm-6 control-label">Customer<span class="required">*</span></label>
                                        <div class="col-sm-12">
                                            @include('admin.snippets.text-field',['name'=>'customer_name','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                                            @include('admin.snippets.hidden-field',['name'=>'customer_id','value'=>null,'required'=>true, 'class'=>'validate[required,maxSize[100]]','placeholder'=>''])
                                        </div>
                                    </div>                                   
                                </div>
                                @include('admin.order.customer-form')
                            </div>
                            <div role="tabpanel" class="tab-pane" id="product-content" aria-expanded="false">
                                @include('admin.order.product-form')
                            </div>
                            @if($isEdit)
                            <div role="tabpanel" class="tab-pane" id="shipment-content" aria-expanded="false">
                                <div id="shipment-list-container"></div>
                            </div>
                            @endif
                        </div>
                    </div>  
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card activities">
                    <div class="header">
                        <h2><strong>Status</strong></h2>
                    </div>
                    <div class="body">
                        <div class="form-group">
                            @include('admin.snippets.select',['name'=>'status','class'=>"form-control",'value'=>null,'data'=>GConstant::getOrderStatuses()])
                        </div>
                        @include('admin.snippets.submit-button',['value'=>$actionTxt,'id'=>'order-submit-btn'])<br>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <input type="hidden" id="is-edit" value="{{ ($isEdit)?1:0 }}">
        <!-- #END# Basic Examples --> 
    </div>
</section>
@section('script')
<script>
    $(function () {
        orderId = $('input[name="old_id"]').val();
        var form = $("#model-form");
        form.validationEngine();


        var dateFormat = "yy-mm-dd";
        var nowDate = new Date();


        $("body").delegate("#ship_date, #delivery_date", "focusin", function () {
            from = $('#ship_date').datepicker({
                dateFormat: dateFormat,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                minDate: nowDate,
            }).on("change", function () {
                to.datepicker("option", "minDate", getDate(this));
            });

            to = $("#delivery_date").datepicker({
                dateFormat: dateFormat,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1
            })
                    .on("change", function () {
                        from.datepicker("option", "maxDate", getDate(this));
                    });
        });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }

            return date;
        }


        createRow(true);
        if (isEdit()) {
            getShipmentForm();
            getShipments();
        }

        $(document).on("click", ".shipment-submit-btn", function (e) {
            e.preventDefault();
            var form = $('#shipment-form');
            var validator = form.validationEngine('validate');
            if (!validator) {
                return false;
            }
            uiBlocker();
            $.post(form.attr('action'), form.serialize(), function (response) {
                uiUnBlocker();
                if (response.Good) {
                    $('#createShipmentModal').modal('hide');
                    form[0].reset();
                    getShipments();
                    showMessage('#shipment-messages', RESPONSE_SUCCESS, response.success);
                } else {
                    showMessage('#shipment-messages', RESPONSE_ERROR, response.error);
                }
            });
        });

        $(document).on("click", ".edit-shipment-btn", function (e) {
            e.preventDefault();
            var _this = $(this);
            getShipmentForm(_this.attr('data-id'));
        });

        $(document).on("click", ".delete-shipment-btn", function (e) {
            e.preventDefault();
            var _this = $(this);
            uiBlocker();
            $.get(BASEPATH + 'shipment/delete/' + _this.attr('data-id'), {}, function (response) {
                uiUnBlocker();
                if (response.Good) {
                    getShipments();
                    showMessage('#shipment-messages', RESPONSE_SUCCESS, response.success);
                } else {
                    showMessage('#shipment-messages', RESPONSE_ERROR, response.error);
                }
            });
        });

        $(document).on("click", "#order-submit-btn", function (e) {
            e.preventDefault();

            var validator = form.validationEngine('validate');
            if (!validator) {
                return false;
            }
            uiBlocker();
            $.post(form.attr('action'), form.serialize(), function (response) {
                if (response.Good) {
                    window.location.href = response.redirectTo;
                } else {
                    uiUnBlocker();
                    showMessage('#order-messages', RESPONSE_ERROR, arrayToMessage(response.error));
                }
            });
        });


        $(document).on('click', '.add-new-row', function (e) {
            e.preventDefault();
            createRow(false);
        });

        $(document).on('click', '.remove-row', function (e) {
            e.preventDefault();
            var _this = $(this);
            _this.parent().parent().remove();
        });

        $(document).on('change', '#ship_name', function () {
            var _this = this.options[this.selectedIndex];
            $('#ship_address_1').val(_this.getAttribute('data-ship_address'));
            $('#ship_city').val(_this.getAttribute('data-ship-city'));
            $('#ship_state').val(_this.getAttribute('data-ship-state'));
            $('#ship_postal_code').val(_this.getAttribute('data-ship-postal-code'));
            $('#ship_country').val(_this.getAttribute('data-ship-country'));
        });



        $("#customer_name").autocomplete({
            source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                $.ajax({
                    url: BASEPATH + "customer/search",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    search: function (e, u) {
                        uiBlocker();
                    },
                    success: function (data) {
                        response($.map(data, function (v, i) {
                            var text = v.first_name + ' ' + v.last_name;
                            if (text && (!request.term || matcher.test(text))) {
                                return {
                                    label: text,
                                    value: v.id,
                                    billing_address: v.billing_address,
                                    billing_city: v.billing_city,
                                    billing_state: v.billing_state,
                                    billing_postal_code: v.billing_postal_code,
                                    billing_country: v.billing_country,
                                    email: v.email,
                                    mobile: v.mobile,
                                    ship_addresses: v.shipping_addresses
                                };
                            }
                        }));
                    }
                });
            },
            minLength: 2,
            focus: function (event, ui) {
                $("#customer_name").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                event.preventDefault();
                $('#customer_id').val(ui.item.value);
                $('#billing_email').val(ui.item.email);
                $('#billing_phone').val(ui.item.mobile);
                $('#billing_address_1').val(ui.item.billing_address);
                $('#billing_city').val(ui.item.billing_city);
                $('#billing_state').val(ui.item.billing_state);
                $('#billing_postal_code').val(ui.item.billing_postal_code);
                $('#billing_country').val(ui.item.billing_country);

                var addresses = ui.item.ship_addresses;
                var options = '';
                addresses.forEach(function (item, index) {
                    var selected = '';
                    if (index == 0) {
                        selected = 'selected="selected"';
                    }
                    options += '<option ' + selected + '  data-customer-id="' + item.customer_id + '" data-ship_address="' + item.ship_address + '" data-ship-city="' + item.ship_city + '" data-ship-state="' + item.ship_state + '" data-ship-postal-code="' + item.ship_postal_code + '" data-ship-country="' + item.ship_country + '" >' + item.name + '</option>';
                    if (index == 0) {
                        $('#ship_address_1').val(item.ship_address);
                        $('#ship_city').val(item.ship_city);
                        $('#ship_state').val(item.ship_state);
                        $('#ship_postal_code').val(item.ship_postal_code);
                        $('#ship_country').val(item.ship_country);
                    }
                });
                var shipNameSelector = $('#ship_name');
                shipNameSelector.html(options);
                shipNameSelector.selectpicker('refresh');
            }
        });
        $(document).on('change', '.price-list', function () {
            var _this = $(this);
            //$('#product-total-' + _this.attr('data-index')).text(_this.val());
            calRowTotal(_this.attr('data-index'));
        });

        $(document).on('keyup', '.product-qty', function () {
            var _this = $(this);
            if (_this.val() == '') {
                _this.val(1);
            }
            calRowTotal(_this.attr('data-index'));
        });

        $(document).on('keyup', '.product-discount', function () {
            var _this = $(this);
            if (_this.val() == '') {
                _this.val(0);
            }
            calRowTotal(_this.attr('data-index'));
            calDiscountTotal();
        });
    });
    function getProductIds() {
        var ids = [];
        $('.product-id').each(function () {
            if ($.trim($(this).val()) != '') {
                ids.push($(this).val());
            }
        });
        return ids;
    }
    function toCurrency(amount) {
        return parseFloat(amount).toFixed(2);
    }
    function calRowTotal(index) {
        var qty = parseInt($("#product-quantity-" + index).val());
        var price = toCurrency($('#product-price-' + index).val());
        var discount = toCurrency($('#product-discount-' + index).val());
        if (isNaN(price)) {
            price = parseFloat(0).toFixed(0);
        }
        var subTotal = qty * price;
        subTotal = subTotal - discount;
        $('#product-total-' + index).text(toCurrency(subTotal));
        calTotal();
    }
    function calTotal() {
        var total = 0;
        var gTotal = 0;
//        $('.row-total').each(function () {
//            total += parseFloat($(this).text());
//        });
        $('.price-list option:selected').each(function () {
            total += parseFloat($(this).val());
        });
        $('#product-total').text(toCurrency(total));
        calDiscountTotal();

        gTotal = total - parseInt($('#discount').val());
        gTotal = gTotal + parseInt($('#tax').val());

        $('#gTotal').text(toCurrency(gTotal));
    }
    function calDiscountTotal() {
        var total = 0;
        $('.product-discount').each(function () {
            total += parseFloat($(this).val());
        });
        $('#discount').val(total);

    }
    function createRow(isFirst) {
//    if (isEdit()) {
//        initProductAutoComplete();
//        calTotal();
//        return false;
//    }
        var row = getRowCount();
        var html = '<tr class="item-row">';
        html += '<td><input autocomplete="off" type="text" id="product-name-' + row + '" class="form-control validate[required] product-name" data-index="' + row + '" placeholder="Product Name" name="product[' + row + '][name]"> <input class="product-id" type="hidden" id="product-id-' + row + '" name="product[' + row + '][id]">';
        html += '<td><select data-index="' + row + '" class="form-control validate[required] price-list" id="product-price-' + row + '" name="product[' + row + '][price]"></select></td>';
        html += '<td><input autocomplete="off" data-index="' + row + '" type="text" id="product-quantity-' + row + '" value="1" class="form-control validate[required,custom[number]] product-qty" name="product[' + row + '][quantity]"></td>';
        html += '<td><input autocomplete="off" data-index="' + row + '" type="text" id="product-quantity-unit-' + row + '" value="" class="form-control product-qty-unit" name="product[' + row + '][quantity_unit]"></td>';
        html += '<td><input autocomplete="off" data-index="' + row + '" type="text" id="product-discount-' + row + '" value="0" class="form-control validate[required] product-discount" name="product[' + row + '][discount]"></td>';
        html += '<td class="row-total" id="product-total-' + row + '">0</td>';
        html += '<td><a href="javascript:void(0);" class="add-new-row" title="more"><i class="material-icons">expand_more</i></a>';
        if (!isFirst || isEdit()) {
            html += ' <a href="javascript:void(0);" class="remove-row" title="Delete"><i class="material-icons">delete</i></a></td>';
        }
        html += '</tr>';
        $('#item-rows').append(html);
        //$('.product-name').autocomplete('dispose');
        initProductAutoComplete();
    }
    function getRowCount() {
        return $('.item-row').length;
    }
    function isEdit() {
        return ($('#is-edit').val() == 1) ? true : false;
    }
    function getShipmentForm(id) {
        uiBlocker();
        var selector = $('#shipment-form-container');
        selector.html();
        var url = BASEPATH + 'shipment/new/' + orderId;
        var isNew = true;
        if (typeof id != 'undefined') {
            url = BASEPATH + 'shipment/edit/' + orderId + '/' + id;
            isNew = false;
        }
        $.get(url, {}, function (response) {
            selector.html(response);
            uiUnBlocker();
            $('#ship_date').attr('autocomplete', 'off');
            $('#delivery_date').attr('autocomplete', 'off');
            if (!isNew) {
                $('#createShipmentModal').modal('show');
            }
            //console.log(response);
        });

    }
    function getShipments() {
        var selector = $('#shipment-list-container');
        $.get(BASEPATH + 'shipment/list/' + orderId, {}, function (response) {
            selector.html(response);
        });
    }



    function initProductAutoComplete() {
        $(".product-name").autocomplete({
            source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                var ids = getProductIds();
                $.ajax({
                    url: BASEPATH + "product/search",
                    dataType: "json",
                    data: {
                        term: request.term,
                        id: ids,
                    },
                    search: function (e, u) {
                        uiBlocker();
                    },
                    success: function (data) {
                        response($.map(data, function (v, i) {
                            var text = v.title;
                            if (text && (!request.term || matcher.test(text))) {
                                return {
                                    label: text,
                                    value: v.id,
                                    prices: v.prices
                                };
                            }
                        }));
                    }
                });
            },
            minLength: 2,
            focus: function (event, ui) {
                $(this).val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                event.preventDefault();
                var gIndex = $(this).attr('data-index');
                $('#product-id-' + gIndex).val(ui.item.value);
                var prices = ui.item.prices;
                var options = '';
                prices.forEach(function (item, index) {
                    var selected = '';
                    if (index == 0) {
                        selected = 'selected="selected"';
                    }
                    options += '<option ' + selected + ' value="' + item.price + '">' + item.rate.code + ' ' + item.price + '</option>';
                    if (index == 0) {
                        $('#product-total-' + gIndex).text(item.price);
                    }
                });
                var shipNameSelector = $('#product-price-' + gIndex);
                shipNameSelector.html(options);
                shipNameSelector.selectpicker('refresh');
                calRowTotal(gIndex);
            }
        });
    }
</script>
@stop
<!--main content end-->
@endsection
<div id="shipment-form-container"></div>