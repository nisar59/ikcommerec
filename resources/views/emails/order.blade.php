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
			max-width:100%;
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
			.mbile{display:block; width:100%; float:left; padding:0px !important;}
			.mobile_text{width:100%; display:block; float:left; padding:0px !important; }
			.mbile_curency{width:100%; float:left; display:block; padding:0px !important;}
		}
	</style>
</head>
<body style="margin:0; padding:0; font-family:'Cairo', sans-serif; font-size:14px; font-weight:300; line-height:1.5; color:#666; background:#fff; direction: ltr;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" style="width:600px;" class="responsive-table">
                	<tr style="height:80px;">
                    	<td style="" class="thead">
                        	{{ HTML::image('public/assets/store/images/banners/emails/order.jpg',config('app.name'),array('style' => 'display:block;width: 100%')) }}
                        </td>
                    </tr>
                    <tr>
                    	<td style="padding: 30px;" class="main">
                    		<table class="main-inner" cellpadding="0" cellspacing="0" width="100%" style="box-shadow: 0 0 10px rgba(0,0,0,0.2); padding: 40px; border-radius: 10px; border:1px solid #f1f1f1; background: #fff;">
                    			<tr>
                    				<td colspan="2" style="background: #fdce36; padding: 20px; border-radius: 6px; color:#000; direction: ltr;">
                    					<table cellpadding="0" cellspacing="0" width="100%">
                    						<tr>
                    							<td style="padding-right: 10px; width:100%; text-align:center;">
                    								<p style="margin: 0;color:#000;font-family:'Cairo', sans-serif;">
														@if(!$data['admin'])
															Thanks for the order at {{ config('app.name') }}, the order has been successfully received
														@endif
														<strong style="display: block; font-weight: bold; font-size: 16px;"> Order # {{ $data['order']->id }} </strong>
													</p>
                    							</td>
                    							<td style="width: 40px;"></td>
                    						</tr>
                    					</table>
                    				</td>
                    			</tr>
                    			<tr><td style="height: 8px;"></td></tr>
								<tr>
									<td style="border:1px solid #FDCE36; border-radius: 8px;">
										<table cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td class="row" style="padding:5px 20px;border: 1px solid #FDCE36;border-radius: 4px; color: #000; direction: ltr;">
													<table cellpadding="0" cellspacing="0" width="100%">
														<tr>
															<td align="left" style="width: 100px;">
																Name
															</td>
															<td align="left" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
																{{ $data['order']->first_name.' '.$data['order']->last_name }}
															</td>
														</tr>
														<tr>
															<td align="left" style="width: 100px;">
																Phone Number
															</td>
															<td align="left" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
																<span style="direction: ltr; text-align: left; display: block;"> {{ $data['order']->billing_phone }}</span>
															</td>
														</tr>
														@if($data['order']->billing_country)
															<tr>
																<td align="left" style="width: 100px;">
																	Country
																</td>
																<td align="left" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
																	{{ $data['order']->country()->first()->getName() }}
																</td>
															</tr>
														@endif
														@if($data['order']->billing_state)
															<tr>
																<td align="left" style="width: 100px;">
																	State
																</td>
																<td align="left" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
																	{{ $data['order']->billing_state }}
																</td>
															</tr>
														@endif
														@if($data['order']->billing_city)
															<tr>
																<td align="left" style="width: 100px;">
																	City
																</td>
																<td align="left" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
																	{{ $data['order']->billing_city }}
																</td>
															</tr>
														@endif
														<tr>
															<td align="left" style="width: 100px;">
																Address
															</td>
															<td align="left" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
																{{ $data['order']->billing_address_1 . ' ' . $data['order']->billing_address_2 }}
															</td>
														</tr>
														<tr>
															<td align="left" style="width: 100px;">
																Postal Code
															</td>
															<td align="left" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
																{{ $data['order']->billing_postal_code }}
															</td>
														</tr>
														<tr>
															<td align="left" style="width: 100px;">
																Email
															</td>
															<td align="left" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
																{{ $data['order']->billing_email }}
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr><td style="height: 8px;"></td></tr>
								@if($data['items']->count())
									<tr>
										<td style="border:1px solid #FDCE36; border-radius: 8px;">
											<table border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" width="100%">
															<tr>
																<td class="heading" style="background: #FDCE36; text-align:center; border-radius: 6px 6px 0 0; padding: 13px 30px; color:#000; font-size: 15px; font-weight: bold;font-family:'Cairo', sans-serif;">
																	Order Details
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td style="padding:20px 30px;" class="p-holder">
														<table cellpadding="0" cellspacing="0" width="100%">
															@foreach($data['items'] as $item)
																@php
																	$item->product = $item->product()->first();
																@endphp
																<tr>
																	<td class="row" style="padding:5px 20px;border: 1px solid #FDCE36;border-radius: 4px; color: #000; direction: ltr;">
																		<table cellpadding="0" cellspacing="0" width="100%">
																			<tr>
																				<td class="mbile" align="left" style="width: 100px;">
																					{{HTML::image(config('image.product.small').$item->product->sku.'/'.$item->product->image, $item->product->title, array('class' => ''))}}
																				</td>
																				<td class="mobile_text" align="left" style="font-family:'Cairo', sans-serif;padding:0 10px; font-size: 13px; font-weight: 600;">
																					<h4 style="margin:0">
																						<a style="color: #000;text-decoration: none; font-size: 15px;" href="{{ route('store-url', $item->product->uri->slug) }}">{{ $item->product->title }}</a>
																					</h4>
																					<h6>{{ $item->color_name }}</h6>
																					<h6>
																						@include('store.checkout.blocks.item.detail', ['item', $item])
																					</h6>
																					<h6 style="margin:0">
																						Quantity
																						<strong>
																							{{ $item->quantity }}
																						</strong>
																					</h6>
																				</td>
																				<td class="mbile_curency" align="left" style="font-size: 13px; font-weight: 600;font-family:'Cairo', sans-serif;">
																					{{ formatCurrency($item->price, config('variable.DEFAULT_CURRENCY')) }}
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr><td style="height: 8px; line-height: 8px;">&nbsp;</td></tr>
															@endforeach
															<tr>
																<td class="row" style="padding:5px 20px;border: 1px solid #FDCE36;border-radius: 4px; color: #000; direction: ltr;">
																	<table cellpadding="0" cellspacing="0" width="100%">
																		<tr>
																			<td align="left" style="font-family:'Cairo', sans-serif;font-size: 13px; font-weight: 600;color: #000;">
																				Sub Total:
																			</td>
																			<td align="left" style="width: 100px; direction: ltr;">
																				<table cellpadding="0" cellspacing="0" width="100%">
																					<tr>
																						<td align="left" style="font-family:'Cairo', sans-serif;color: #000;font-size: 13px; font-weight: 600;">
																							{{ formatCurrency($data['order']->sub_total, config('variable.DEFAULT_CURRENCY')) }}
																						</td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
                                                            <tr><td style="height: 10px; line-height: 10px;">&nbsp;</td></tr>
															@if($data['order']->discount != 0)
																<tr>
																	<td class="row" style="padding:5px 20px;border: 1px solid #FDCE36;border-radius: 4px; color: #000; direction: ltr;">
																		<table cellpadding="0" cellspacing="0" width="100%">
																			<tr>
																				<td align="left" style="font-family:'Cairo', sans-serif;font-size: 13px; font-weight: 600;color: #000;">
																					Discount:
																				</td>
																				<td align="left" style="width: 100px; direction: ltr;">
																					<table cellpadding="0" cellspacing="0" width="100%">
																						<tr>
																							<td align="left" style="font-family:'Cairo', sans-serif;color: #000;font-size: 13px; font-weight: 600;">
																								{{ formatCurrency($data['order']->discount, config('variable.DEFAULT_CURRENCY')) }}
																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															@endif
															@if($data['order']->tax != 0)
																<tr>
																	<td class="row" style="padding:5px 20px;border: 1px solid #FDCE36;border-radius: 4px; color: #000; direction: ltr;">
																		<table cellpadding="0" cellspacing="0" width="100%">
																			<tr>
																				<td align="left" style="font-family:'Cairo', sans-serif;font-size: 13px; font-weight: 600;color: #000;">
																					Tax:
																				</td>
																				<td align="left" style="width: 100px; direction: ltr;">
																					<table cellpadding="0" cellspacing="0" width="100%">
																						<tr>
																							<td align="left" style="font-family:'Cairo', sans-serif;color: #000;font-size: 13px; font-weight: 600;">
																								{{ formatCurrency($data['order']->tax, config('variable.DEFAULT_CURRENCY')) }}
																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															@endif
															@if($data['order']->shipping != 0)
																<tr>
																	<td class="row" style="padding:5px 20px;border: 1px solid #FDCE36;border-radius: 4px; color: #000; direction: ltr;">
																		<table cellpadding="0" cellspacing="0" width="100%">
																			<tr>
																				<td align="left" style="font-family:'Cairo', sans-serif;font-size: 13px; font-weight: 600;color: #000;">
																					Shipping:
																				</td>
																				<td align="left" style="width: 100px; direction: ltr;">
																					<table cellpadding="0" cellspacing="0" width="100%">
																						<tr>
																							<td align="left" style="font-family:'Cairo', sans-serif;color: #000;font-size: 13px; font-weight: 600;">
																								{{ formatCurrency($data['order']->shipping, config('variable.DEFAULT_CURRENCY')) }}
																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
                                                                <tr><td style="height: 10px; line-height: 10px;">&nbsp;</td></tr>
															@endif
															<tr>
																<td class="row" style="padding:5px 20px;border: 1px solid #FDCE36;border-radius: 4px; color: #000; direction: ltr;">
																	<table cellpadding="0" cellspacing="0" width="100%">
																		<tr>
																			<td align="left" style="font-family:'Cairo', sans-serif; color:#000; font-size: 13px; font-weight: 600;">
																				Total:
																			</td>
																			<td align="left" style="width: 100px; direction: ltr;">
																				<table cellpadding="0" cellspacing="0" width="100%">
																					<tr>
																						<td align="left" style="font-family:'Cairo', sans-serif;color: #000;font-size: 13px; font-weight: 600;">
																							{{ formatCurrency($data['order']->total, config('variable.DEFAULT_CURRENCY')) }}
																						</td>
																					</tr>
																				</table>
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
													<td style="text-align: center; direction: ltr;">
														<table cellpadding="0" cellspacing="0" width="100%">
															<tr><td class="btn" style="background: #1e1e1e; text-align: center;border-radius: 0 0 6px 6px; padding: 13px 30px; color:#6C6D6D; font-size: 15px; font-weight: bold;"></td></tr>
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
                    	<td style="background:#FDCE36; padding:15px 20px;" class="tfoot">
                        	<table  border="0" cellpadding="0" cellspacing="0" width="100%" style="direction: ltr;">
                            	<tr class="tr">
                                   	<td align="left" style="color:#000; font-size:12px; line-height:14px; text-align:center; font-family: 'Cairo', sans-serif;" class="col">
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
