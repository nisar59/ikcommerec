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
									<td style="border:1px solid #e3e3e3; border-radius: 8px;">
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td>
													<table cellpadding="0" cellspacing="0" width="100%">
														<tr>
															<td class="heading" style="background: #a8d058; border-radius: 6px 6px 0 0; padding: 13px 30px; color:#fff; font-size: 15px; font-weight: bold;font-family:'Cairo', sans-serif;">
																@if($data['admin']) @lang('language.order_complaint_text_admin'){{' '.$data['complaint']['order_id']}} @endif
																@if(!$data['admin']) @lang('language.order_complaint_text_customer'){{$data['complaint']['order_id']}} @endif
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td style="padding:20px 30px;" class="p-holder">
													<table cellpadding="0" cellspacing="0" width="100%">

														<tr>
															<td class="row" style="padding:5px 20px;border: 1px solid #c00a26;border-radius: 4px; color: #000; direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
																<table cellpadding="0" cellspacing="0" width="100%">
																	<tr>
																		<td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" colspan="2" style="font-family:'Cairo', sans-serif;font-size: 13px; font-weight: 600;color: #c00a26;">
																			@if($data['admin']) @lang('language.order_complaint_message_admin') @endif
																			@if(!$data['admin']) {!!sprintf(trans('language.order_complaint_message_customer'), $data['order_info']['first_name']." ".$data['order_info']['last_name'])!!} @endif
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
														<tr><td style="height: 8px; line-height: 8px;"></td></tr>
													</table>
												</td>
											</tr>
											<tr>
												<td style="text-align: center; direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
													<table cellpadding="0" cellspacing="0" width="100%">
														<tr><td class="btn" style="background: #650a34; text-align: center;border-radius: 0 0 6px 6px; padding: 13px 30px; color:#fff; font-size: 15px; font-weight: bold;"></td></tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
                    		</table>
                    	</td>
                    </tr>
                    <tr>
                    	<td style="background:#650A34; padding:15px 20px;" class="tfoot">
							<table  border="0" cellpadding="0" cellspacing="0" width="100%" style="direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
								<tr class="tr">
									<td align="{{(app()->getLocale() == 2 ? 'left' : 'right')}}" class="col">
										<table  border="0" cellpadding="0" cellspacing="0" width="100%" style="direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}};">
											<tr class="tr">
												<td align="{{((app()->getLocale() == 2 ? 'right' : 'left'))}}" style="color:#fff; font-size:12px; line-height:14px; font-family: 'Cairo', sans-serif;" class="col">@lang('language.copyrights'), {{$carbon::now()->year}} | {{config('app.name')}}</td>
												<td align="{{(app()->getLocale() == 2 ? 'right' : 'left')}}" class="col">
													<table border="0" cellpadding="0" cellspacing="0" width="100%" style="direction: {{(app()->getLocale() == 2 ? 'rtl' : 'ltr')}}; text-align: center;" class="tble-social">
														<tr>
															<td><a href="{{config('settings.config_social_fb_url')}}" target="_blank" style="display:inline-block; height:auto; color: #fff; font-size: 10px; cursor: pointer;">{{ HTML::image('public/assets/store/themes/hemam/images/emails/ico-facebook.png',config('app.name'),array('width' => '8', 'height' => '15')) }}</a></td>
															<td><a href="{{config('settings.config_social_twitter_url')}}" target="_blank" style="display:inline-block; height:auto;color: #fff; font-size: 10px;cursor: pointer;">{{ HTML::image('public/assets/store/themes/hemam/images/emails/ico-twitter.png',config('app.name'),array('width' => '18', 'height' => '15')) }}</a></td>
															{{--<td><a href="#" style="display:inline-block; height:auto;color: #fff; font-size: 10px;cursor: pointer;">{{ HTML::image('public/assets/store/themes/hemam/images/emails/ico-linkedin.png',config('app.name'),array('width' => '16"', 'height' => '8')) }}</a></td>--}}
															<td><a href="{{config('settings.config_social_instagram_url')}}" target="_blank" style="display:inline-block; height:auto;color: #fff; font-size: 10px;cursor: pointer;">{{ HTML::image('public/assets/store/themes/hemam/images/emails/ico-instagram.png',config('app.name'),array('width' => '16', 'height' => '16')) }}</a></td>
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
