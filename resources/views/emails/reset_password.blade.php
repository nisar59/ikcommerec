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
<body style="margin:0; padding:0; font-family:'Cairo', sans-serif; font-size:14px; font-weight:300; line-height:1.5; color:#666; background:#fff; direction: ltr;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" style="width:600px;" class="responsive-table">
                	<tr>
                    	<td style="" class="thead">
                        	{{ HTML::image('public/assets/store/images/banners/emails/order.jpg',config('app.name'),array('style' => 'display:block;width: 100%')) }}
                        </td>
                    </tr>
                    <tr>
                    	<td style="padding: 30px;" class="main">
                    		<table class="main-inner" cellpadding="0" cellspacing="0" width="100%" style="box-shadow: 0 0 10px rgba(0,0,0,0.2); padding: 40px; border-radius: 10px; border:1px solid #f1f1f1; background: #fff;">
                    			<tr>
                    				<td colspan="2" style="background: #fdce36; padding: 20px; border-radius: 6px; color:#fff; direction: ltr;">
                    					<table cellpadding="0" cellspacing="0" width="100%">
                    						<tr>
                    							<td style="padding-right: 10px;">
                    								<p style="margin: 0;color:#fff;font-family:'Cairo', sans-serif;">
														<strong style="display: block; font-weight: bold; font-size: 16px;"> {{ $data['subject'] }} </strong>
													</p>
                    							</td>
                    							<td style="width: 40px;"></td>
                    						</tr>
                    					</table>
                    				</td>
                    			</tr>
                    			<tr><td style="height: 8px;"></td></tr>
								<tr>
									<td style="border:1px solid #e3e3e3; border-radius: 8px;">
										<table cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td class="row" style="padding:5px 20px;border: 1px solid #e3e3e3;border-radius: 4px; color: #000; direction: ltr;">
													<table cellpadding="0" cellspacing="0" width="100%">
														<tr>
															<td colspan="2">
																<b>Hello!</b><br>
																<p>You are receiving this email because we received a password reset request for your account.</p>
															</td>
														</tr>
														<tr>
															<td colspan="2">
																If you did not request a password reset, no further action is required.
															</td>
														</tr>
                                                        <tr>
                                                            <td colspan="2"><br>
                                                                <a href="{{ $data['link'] }}" style="box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1;border-right:18px solid #3097d1;border-bottom:10px solid #3097d1;border-left:18px solid #3097d1" target="_blank">Reset Password</a>
                                                            </td>
                                                        </tr>
														<tr>
															<td colspan="2"><br><br>
																Regards,<br>
																{{ config('app.name') }} Team
															</td>
														</tr>
														<tr>
															<td colspan="2"><br><br>
																If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: {{ $data['link'] }}
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="height: 8px;">

									</td>
								</tr>
                    		</table>
                    	</td>
                    </tr>
                    <tr>
                    	<td style="background:#D8D8D8; padding:15px 20px;" class="tfoot">
                        	<table  border="0" cellpadding="0" cellspacing="0" width="100%" style="direction: ltr;">
                            	<tr class="tr">
                                   	<td align="left" style="color:#6C6D6D; font-size:12px; line-height:14px; font-family: 'Cairo', sans-serif;" class="col">
										@if(config('settings.config_copyright_text'))
											<p>{!! config('settings.config_copyright_text') !!}</p>
										@endif
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
