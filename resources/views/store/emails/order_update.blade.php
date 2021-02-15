<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,900" rel="stylesheet">
    <style type="text/css">
        #outlook a{
            padding:0;
        }
        body{
            margin:0;
            padding:0;
            width:100% !important;
            -webkit-text-size-adjust:none;
        }
        img{
            border:none;
            font-size:14px;
            font-weight:bold;
            height:auto;
            line-height:100%;
            outline:none;
            text-decoration:none;
            text-transform:capitalize;
        }
        @media screen and (max-width: 600px) {
            body{ font-size:14px !important;}
            .responsive-table {
                display: block;
                width: 100% !important;
            }
            .main,
            .main-inner{
                padding:15px !important;
            }
            .tfoot .tr,
            .tfoot .col{
                display:block;
                text-align:center !important;
            }
            .tfoot .col{
                padding:0 0 10px;
            }
            .tfoot{ padding:10px 15px !important;}
            .tble-social{
                table-layout: fixed;
            }
            .p-holder{
                padding:10px !important;
            }
            .row{
                padding:3px 10px !important;
            }
            .heading,
            .btn{
                padding: 10px 12px !important;
            }
        }
    </style>
</head>
<body style="margin:0; padding:0; font-family:'Cairo', sans-serif; font-size:14px; font-weight:300; line-height:1.5; color:#666; background:#fff; direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center">
            <table border="0" cellpadding="0" cellspacing="0" style="width:600px;" class="responsive-table">
                <tr>
                    <td style="" class="thead">
                        {{ HTML::image('public/assets/store/themes/hemam/images/emails/banner.png',config('app.name'),array('style' => 'display:block;width: 100%')) }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px; background: url(bg1.png) no-repeat; background-position: 50% 100%; background-size: 100%;" class="main">
                        <table class="main-inner" cellpadding="0" cellspacing="0" width="100%" style="box-shadow: 0 0 10px rgba(0,0,0,0.2); padding: 40px; border-radius: 10px; border:1px solid #f1f1f1; background: #fff;">
                            <tr>
                                <td colspan="2" style="background: #50C0B1; padding: 20px; border-radius: 6px; color:#fff; direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td colspan="2" style="padding-right: 10px;">
                                                <p style="margin: 0;color:#fff;font-family:'Cairo', sans-serif;">
                                                    <strong style="display: block; font-weight: bold; font-size: 16px;"> @lang('language.order_email_order_number') {{$data['order_info']['order_id']}} </strong>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td colspan="2" style="height: 8px;"></td></tr>
                            <tr>
                                <td style="border:1px solid #e3e3e3; border-radius: 8px;">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td class="row" style="padding:5px 20px;border: 1px solid #e3e3e3;border-radius: 4px; color: #000; direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
                                                <table cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="width: 51px;">
                                                            @if($data['admin']) {!!sprintf(trans('language.order_cancelled_message_admin'), $data['order_info']['first_name']." ".$data['order_info']['last_name'])!!} @endif
                                                            @if($data['admin'] == false) {{ $data['message'] }} @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr><td style="height: 8px;"></td></tr>
                            <tr>
                                <td style="border:1px solid #e3e3e3; border-radius: 8px;">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td class="row" style="padding:5px 20px;border: 1px solid #e3e3e3;border-radius: 4px; color: #000; direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
                                                <table cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="width: 51px;">
                                                            @lang('language.account_name')
                                                        </td>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
                                                            {{$data['order_info']['shipping_first_name'].' '.$data['order_info']['shipping_last_name']}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="width: 51px;">
                                                            @lang('language.career_mobile_number_text')
                                                        </td>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
                                                            <span style="direction: ltr; text-align: {{(app()->getLocale() == 2 ? 'right' : 'left')}}; display: block;"> {{$data['order_info']['shipping_mobile']}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="width: 51px;">
                                                            @lang('language.career_country_text')
                                                        </td>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
                                                            {{(is_null($data['order_info']['shipping_country_other_name']) ? $data['order_info']['shipping_country_name'] : $data['order_info']['shipping_country_other_name'])}}
                                                        </td>
                                                    </tr>
                                                    @if(!empty($data['order_info']['shipping_state_name']))
                                                        <tr>
                                                            <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="width: 51px;">
                                                                @lang('language.career_city_text')
                                                            </td>
                                                            <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
                                                                {{$data['order_info']['shipping_state_name']}}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="width: 51px;">
                                                            @lang('language.address')
                                                        </td>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
                                                            {{$data['order_info']['shipping_default_address']}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="width: 51px;">
                                                            @lang('language.account_email')
                                                        </td>
                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
                                                            {{$data['order_info']['email']}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td style="height: 8px;"></td></tr>
                            @if(isset($data['products']))
                                <tr>
                                    <td style="border:1px solid #e3e3e3; border-radius: 8px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td>
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tr><td class="heading" style="background: #50C0B1; border-radius: 6px 6px 0 0; padding: 13px 30px; color:#fff; font-size: 15px; font-weight: bold;font-family:'Cairo', sans-serif;">@lang('language.order_email_order_total_title_txt')</td></tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:20px 30px;" class="p-holder">
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        @foreach($data['products'] as $product)
                                                            <tr>
                                                                <td class="row" style="padding:5px 20px;border: 1px solid #e3e3e3;border-radius: 4px; color: #000; direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
                                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                                        <tr>
                                                                            <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="width: 51px;">
                                                                                {{HTML::image('public/assets/manage_store/images/product/140xauto/'.$product['image'], '', array('class' => 'mx-auto img-fluid'))}}
                                                                            </td>
                                                                            <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
                                                                                <h4 style="margin:0">
                                                                                    <a href="javascript:void(0)">{{$product['name']}}</a>
                                                                                    @foreach($product['option'] as $option)
                                                                                        @if($option['bulk_value'])
                                                                                            @php
                                                                                                $bulk_value = $option['bulk_value'];
                                                                                                $type = $option['type'];
                                                                                            @endphp
                                                                                        @endif
                                                                                        @if($option['type'] != "bulk")
                                                                                            @if($option['type'] != "file")
                                                                                                <small style="display: block;">{{ $option['value'] }} ({{$option['sku']}})</small>
                                                                                            @else
                                                                                                &nbsp;<small> - {{ $option['name'] }}: <a href="{{ $option['href'] }}">{{ $option['value'] }}</a></small>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endforeach
                                                                                </h4>
                                                                                <h6 style="margin:0">
                                                                                    @lang('language.checkout_quantity')
                                                                                    <strong>
                                                                                        {{(isset($bulk_value) ? round($product['quantity'] / $bulk_value) : round($product['quantity']))}}
                                                                                    </strong>
                                                                                </h6>
                                                                            </td>
                                                                            <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="font-size: 13px; font-weight: 600;font-family:'Cairo', sans-serif;">{{$product['total']}}</td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr><td style="height: 8px; line-height: 8px;">&nbsp;</td></tr>
                                                            @php unset($bulk_value);unset($type); @endphp
                                                        @endforeach
                                                        @foreach($data['totals'] as $total)
                                                            <tr>
                                                                <td class="row" style="padding:5px 20px;border: 1px solid #c00a26;border-radius: 4px; color: #000; direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
                                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                                        <tr>
                                                                            <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="font-family:'Cairo', sans-serif;font-size: 13px; font-weight: 600;color: #c00a26;">{{ $total['title'] }}</td>
                                                                            <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="width: 100px; direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
                                                                                <table cellpadding="0" cellspacing="0" width="100%">
                                                                                    <tr>
                                                                                        <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" style="font-family:'Cairo', sans-serif;color: #c00a26;font-size: 13px; font-weight: 600;">{{ $total['text'] }}</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr><td style="height: 8px; line-height: 8px;"></td></tr>
                                                        @endforeach
                                                        @if($data['order_info']['shipping_address'])
                                                            <tr>
                                                                <td style="font-family:'Cairo', sans-serif;padding:5px 20px;font-weight: 600;border: 1px solid #e3e3e3;border-radius: 4px; color: #000; font-size: 13px;">
                                                                    <p>
                                                                        <span style="font-family:'Cairo', sans-serif;color: #ea5522; font-weight: 600;">@lang('language.order_email_order_address_txt')</span>
                                                                        <br> {{$data['order_info']['shipping_first_name'].' '.$data['order_info']['shipping_last_name']}}
                                                                        <br> {{$data['order_info']['shipping_address']}}
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tr><td class="btn" style="background: #D8D8D8; text-align: center;border-radius: 0 0 6px 6px; padding: 13px 30px; color:#fff; font-size: 15px; font-weight: bold;"></td></tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="background:#D8D8D8; padding:15px 20px;" class="tfoot">
                        <table  border="0" cellpadding="0" cellspacing="0" width="100%" style="direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
                            <tr class="tr">
                                <td align="{{(app()->getLocale() == 2 ? 'left' : 'right')}}" class="col">
                                    <table  border="0" cellpadding="0" cellspacing="0" width="100%" style="direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
                                        <tr class="tr">
                                            <td align="{{((app()->getLocale() == 2 ? 'right' : 'left'))}}" style="color:#6C6D6D; font-size:12px; line-height:14px; font-family: 'Cairo', sans-serif;" class="col">@lang('language.copyrights'), {{$carbon::now()->year}} | {{config('app.name')}}</td>
                                            <td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" class="col">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}}; text-align: center;" class="tble-social">
                                                    <tr>
                                                        <td><a href="{{config('settings.config_social_fb_url')}}" target="_blank" style="display:inline-block; height:auto; color: #6C6D6D; font-size: 10px; cursor: pointer;">{{ HTML::image('public/assets/store/themes/hemam/images/emails/ico-facebook.png',config('app.name'),array('width' => '8', 'height' => '15')) }}</a></td>
                                                        <td><a href="{{config('settings.config_social_twitter_url')}}" target="_blank" style="display:inline-block; height:auto;color: #6C6D6D; font-size: 10px;cursor: pointer;">{{ HTML::image('public/assets/store/themes/hemam/images/emails/ico-twitter.png',config('app.name'),array('width' => '18', 'height' => '15')) }}</a></td>
                                                        {{--<td><a href="#" style="display:inline-block; height:auto;color: #fff; font-size: 10px;cursor: pointer;">{{ HTML::image('public/assets/store/themes/hemam/images/emails/ico-linkedin.png',config('app.name'),array('width' => '16"', 'height' => '8')) }}</a></td>--}}
                                                        <td><a href="{{config('settings.config_social_instagram_url')}}" target="_blank" style="display:inline-block; height:auto;color: #6C6D6D; font-size: 10px;cursor: pointer;">{{ HTML::image('public/assets/store/themes/hemam/images/emails/ico-instagram.png',config('app.name'),array('width' => '16', 'height' => '16')) }}</a></td>
                                                        {{--<td><a href="#" style="display:inline-block; height:auto;color: #fff; font-size: 10px;cursor: pointer;">{{ HTML::image('public/assets/store/themes/hemam/images/emails/ico-google.png',config('app.name'),array('width' => '22', 'height' => '14')) }}</a></td>--}}
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
