@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')



<style type="text/css">
    /* Base ------------------------------ */
    
    body {
      width: 100% !important;
      height: 100%;
      margin: 0;
      -webkit-text-size-adjust: none;
    }
    
    a {
      color: #3869D4;
    }
    
    a img {
      border: none;
    }
    
    td {
      word-break: break-word;
    }
    
    .preheader {
      display: none !important;
      visibility: hidden;
      mso-hide: all;
      font-size: 1px;
      line-height: 1px;
      max-height: 0;
      max-width: 0;
      opacity: 0;
      overflow: hidden;
    }
    /* Type ------------------------------ */
    

    
    h1 {
      margin-top: 0;
      color: #333333;
      font-size: 22px;
      font-weight: bold;
      text-align: left;
    }
    
    h2 {
      margin-top: 0;
      color: #333333;
      font-size: 16px;
      font-weight: bold;
      text-align: left;
    }
    
    h3 {
      margin-top: 0;
      color: #333333;
      font-size: 14px;
      font-weight: bold;
      text-align: left;
    }
    
    td,
    th {
      font-size: 16px;
    }
    
    p,
    ul,
    ol,
    blockquote {
      margin: .4em 0 1.1875em;
      font-size: 16px;
      line-height: 1.625;
    }
    
    p.sub {
      font-size: 13px;
    }
    /* Utilities ------------------------------ */
    
    .align-right {
      text-align: right;
    }
    
    .align-left {
      text-align: left;
    }
    
    .align-center {
      text-align: center;
    }
    /* Buttons ------------------------------ */
    
    .button {
      background-color: #3869D4;
      border-top: 10px solid #3869D4;
      border-right: 18px solid #3869D4;
      border-bottom: 10px solid #3869D4;
      border-left: 18px solid #3869D4;
      display: inline-block;
      color: #FFF;
      text-decoration: none;
      border-radius: 3px;
      box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
      -webkit-text-size-adjust: none;
      box-sizing: border-box;
    }
    
    .button--green {
      background-color: #22BC66;
      border-top: 10px solid #22BC66;
      border-right: 18px solid #22BC66;
      border-bottom: 10px solid #22BC66;
      border-left: 18px solid #22BC66;
    }
    
    .button--red {
      background-color: #FF6136;
      border-top: 10px solid #FF6136;
      border-right: 18px solid #FF6136;
      border-bottom: 10px solid #FF6136;
      border-left: 18px solid #FF6136;
    }
    
    @media only screen and (max-width: 500px) {
      .button {
        width: 100% !important;
        text-align: center !important;
      }
    }
    /* Attribute list ------------------------------ */
    
    .attributes {
      margin: 0 0 21px;
    }
    
    .attributes_content {
      background-color: #F4F4F7;
      padding: 16px;
    }
    
    .attributes_item {
      padding: 0;
    }
    /* Related Items ------------------------------ */
    
    .related {
      width: 100%;
      margin: 0;
      padding: 25px 0 0 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .related_item {
      padding: 10px 0;
      color: #CBCCCF;
      font-size: 15px;
      line-height: 18px;
    }
    
    .related_item-title {
      display: block;
      margin: .5em 0 0;
    }
    
    .related_item-thumb {
      display: block;
      padding-bottom: 10px;
    }
    
    .related_heading {
      border-top: 1px solid #CBCCCF;
      text-align: center;
      padding: 25px 0 10px;
    }
    /* Discount Code ------------------------------ */
    
    .discount {
      width: 100%;
      margin: 0;
      padding: 24px;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #F4F4F7;
      border: 2px dashed #CBCCCF;
    }
    
    .discount_heading {
      text-align: center;
    }
    
    .discount_body {
      text-align: center;
      font-size: 15px;
    }
    /* Social Icons ------------------------------ */
    
    .social {
      width: auto;
    }
    
    .social td {
      padding: 0;
      width: auto;
    }
    
    .social_icon {
      height: 20px;
      margin: 0 8px 10px 8px;
      padding: 0;
    }
    /* Data table ------------------------------ */
    
    .purchase {
      width: 100%;
      margin: 0;
      padding: 35px 0;
      padding-top: 0px;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .purchase_content {
      width: 100%;
      margin: 0;
      padding: 25px 0 0 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
        border-collapse: collapse;
    }
    
    .purchase_item {
      padding: 10px;
      color: #51545E;
      font-size: 15px;
      line-height: 18px;
      border: 1px solid #eaeaec;
      background-color: #f7f7f7;
    }
    
    .purchase_heading {
      padding: 10px;
      border: 1px solid #EAEAEC;

      background-color: #f7f7f7;
    }
    
    .purchase_heading p {
      margin: 0;
      color: #85878E;
      font-size: 14px;
      font-weight: 400;
    }
    
    .purchase_footer {
      padding: 10px;
      border: 1px solid #eaeaec;
    }
    
    .purchase_total {
      margin: 0;
      font-weight: 500;
      color: #85878e;
      font-size: 15px;
    }
    
    .purchase_total--label {
      padding: 0 15px 0 0;
    }
    
  
    
    p {
      color: #51545E;
    }
    
    p.sub {
      color: #6B6E76;
    }
    
    .email-wrapper {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #F4F4F7;
    }
    
    .email-content {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    /* Masthead ----------------------- */
    
    .email-masthead {
      padding: 10px 0;
      text-align: center;
      background-color: #626ed4;
    }
    .email-masthead h1{color: #fff;}
    
    .email-masthead_logo {
      width: 94px;
    }
    
    .email-masthead_name {
      font-size: 16px;
      font-weight: bold;
      color: #A8AAAF;
      text-decoration: none;
      text-shadow: 0 1px 0 white;
    }
    /* Body ------------------------------ */
    
    .email-body {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #FFFFFF;
      padding-top: 100px;
    }
    
    .email-body_inner {
      width: 1140px;
      margin: 0 auto;
      padding: 0;
      -premailer-width: 570px;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #FFFFFF;
      border: 1px solid #626ed4;
    }
    
    .email-footer {
      width: 100%;
      margin: 0 auto;
      padding: 0;
      -premailer-width: 570px;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      text-align: center;
      background-color: #f7f7f7;
    }
    
    .email-footer p {
      color: #6B6E76;
    }
    
    .body-action {
      width: 100%;
      margin: 30px auto;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      text-align: center;
    }
    
    .body-sub {
      margin-top: 25px;
      padding-top: 25px;
      border-top: 1px solid #EAEAEC;
    }
    
    .content-cell {
      padding: 20px;
      padding-top: 0px;
    }
    /*Media Queries ------------------------------ */
    
    @media only screen and (max-width: 600px) {
      .email-body_inner,
      .email-footer {
        width: 100% !important;
      }
    }
    
    @media (prefers-color-scheme: dark) {
      body,
      .email-body,
      .email-body_inner,
      .email-content,
      .email-wrapper,
      .email-masthead,
      .email-footer {
        background-color: #333333 !important;
        color: #FFF !important;
      }
      h3{margin-bottom: 0px; padding: 10px;}
      p,
      ul,
      ol,
      blockquote,
      h1,
      h2,
      h3,
      span,
      .purchase_item {
        color: #FFF !important;
      }
      .attributes_content,
      .discount {
        background-color: #222 !important;
      }
      .email-masthead_name {
        text-shadow: none !important;
      }
    }
    table th, table td{    border-collapse: collapse;}
    td.purchase_footer:nth-child(1){border:none;}
    </style>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="1140px" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="email-masthead">
                      <h1 style="text-align: center; margin-bottom: 0px;">INVOICE</h1>
                    </td>
                  </tr>
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                        <table class="purchase" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td style="border-bottom: 1px solid #eaeaec;" width="50%">
                              <table style="margin: 10px 0;">
                                <tr>
                                  <td><a href=""><img src="{{ url('public/uploads/images/'.settingsValue('config_site_logo'))}}" alt="" height="22"></a></td>
                                </tr>
                              </table>
                            </td>
                            <td  class="align-right" width="50%" style="text-align: -webkit-right; border-bottom: 1px solid #eaeaec; ">
                              <table style="margin: 10px 0;">
                                <tr>
                                  <td><h2 class="align-right" style="margin-bottom: 0px; color: #777777; font-weight: normal;">{{settingsValue('config_site_title')}}</h2></td>
                                </tr>
                                <tr>
                                  <td><h2 class="align-right" style="margin-bottom: 0px; color: #777777; font-weight: normal;">455 Foggy Heights, AZ 85004, US</h2></td>
                                </tr>
                                <tr>
                                  <td><h5 class="align-right" style="margin-bottom: 0px; color: #777777; font-weight: normal;">(602) 519-0450</h5></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <table style="margin: 10px 0;">
                                <tr>
                                  <td><h2 style="margin-bottom: 0px; color: #777777; font-weight: normal;">INVOICE TO:</h2></td>
                                </tr>
                                <tr>
                                  <td><h2 style="margin-bottom: 0px; color: #777777; font-size: 16px;">John Doe</h2></td>
                                </tr>
                                <tr>
                                  <td><h5 style="margin-bottom: 0px; color: #777777; font-weight: normal;">{{$data['user']->billing_address_1}},{{$data['user']->billing_city}}, ,{{$data['user']->post_code}}</h5></td>
                                </tr>
                              </table>
                            </td>
                            <td  class="align-right" style="text-align: -webkit-right;">
                              <table style="margin: 10px 0;">
                                <tr>
                                  <td><h2 class="align-right" style="margin-bottom: 0px; color: #777777; font-weight: normal;">INVOICE TO:</h2></td>
                                </tr>
                                <tr>
                                  <td><h2 class="align-right" style="margin-bottom: 0px; color: #777777; font-size: 16px;">John Doe</h2></td>
                                </tr>
                                <tr>
                                  <td><h5 class="align-right" style="margin-bottom: 0px; color: #777777; font-weight: normal;">sahiwal,6, ,</h5></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <table class="purchase_content" style="margin-top: 30px;" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                  <th class="purchase_heading" align="center">
                                    <p class="f-fallback" align="center">#</p>
                                  </th>
                                  <th class="purchase_heading" align="left">
                                    <p class="f-fallback">DESCRIPTION</p>
                                  </th>
                                  <th class="purchase_heading" align="center">
                                    <p class="f-fallback" align="center">UNIT PRICE</p>
                                  </th>
                                  <th class="purchase_heading" align="center">
                                    <p class="f-fallback" align="center">QUANTITY</p>
                                  </th>
                                  <th class="purchase_heading" align="right">
                                    <p class="f-fallback" align="right">TOTAL</p>
                                  </th>
                                </tr>
                                <tr>
                                  <td width="10%" class="purchase_item" align="center"><span class="f-fallback">1</span></td>
                                  <td width="22.5%" class="purchase_item"><span class="f-fallback">Website Design</span></td>
                                  <td width="22.5%" class="purchase_item" align="center"><span class="f-fallback">$40.00</span></td>
                                  <td width="22.5%" class="purchase_item" align="center"><span class="f-fallback">30</span></td>
                                  <td class="align-right purchase_item" width="22.5%" class="purchase_item"><span class="f-fallback">$1,200.00</span></td>
                                </tr>
                                <tr>
                                  <td width="10%" colspan="3" class="purchase_footer" valign="middle"> 
                                  </td>
                                  <td width="22.5%" class="purchase_footer" valign="middle">
                                    <p class="f-fallback purchase_total purchase_total--label" align="center">SUBTOTAL</p>
                                  </td>
                                  <td width="22.5%" class="purchase_footer" valign="middle" align="right">
                                    <p class="f-fallback purchase_total">$5,200.00</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="22.5%" colspan="3" class="purchase_footer" valign="middle"> 
                                  </td>
                                  <td width="22.5%" class="purchase_footer" valign="middle">
                                    <p class="f-fallback purchase_total purchase_total--label" align="center">Delivery / Charges</p>
                                  </td>
                                  <td width="22.5%" class="purchase_footer" valign="middle" align="right">
                                    <p class="f-fallback purchase_total">$1,300.00</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="25%" colspan="3" class="purchase_footer" valign="middle"> 
                                  </td>
                                  <td width="25%" class="purchase_footer" valign="middle">
                                    <p class="f-fallback purchase_total purchase_total--label" align="center">GRAND TOTAL</p>
                                  </td>
                                  <td width="25%" class="purchase_footer" valign="middle" align="right">
                                    <p class="f-fallback purchase_total">$6,500.00</p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <!-- Action -->
                        
                        <!-- Sub copy -->
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td style="background-color: white;">
                <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <!-- Border based button
           https://litmus.com/blog/a-guide-to-bulletproof-buttons-in-email-design -->
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                <tr>
                                  <td align="center">
                                    <a href="#" class="f-fallback button button--blue" target="_blank">Download as PDF</a>
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





@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    {{--<script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>--}}
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
    <!-- form repeater -->
    <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>

    <!-- form repeater init js -->
    <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>
    <!-- Summernote js -->
    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js')}}"></script>

    <!-- demo js -->
    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>

@endsection