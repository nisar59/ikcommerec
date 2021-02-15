@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Order Management</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Order Management </li>
                </ol>
            </div>
        </div>
        @if (count($errors) > 0)
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div></div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">

                {!! Form::model($data['user'], ['method' => 'POST','url' => ['admin/ordered/update/'.$data['user']->id],"enctype"=>"multipart/form-data"]) !!}
                <h4 class="card-title">Order Management</h4>


                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">General</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#categories" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Prodcuts</span>
                        </a>
                    </li>


                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="general" role="tabpanel">

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>First Name:</strong>
                                    {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Last Name:</strong>
                                    {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    {!! Form::text('billing_email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Phone:</strong>
                                    {!! Form::text('billing_phone', null, array('placeholder' => 'Phone','class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Order Status:</strong>
                                    {!! Form::select('order_status', $data['order_status'],[], array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Order Note:</strong>
                                    {!! Form::text('order_note', null, array('placeholder' => 'Order Note','class' => 'form-control')) !!}

                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Billing Address:</strong>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Address:</strong>
                                    {!! Form::text('billing_address_1', null, array('placeholder' => 'Address','class' => 'form-control')) !!}
                                </div>
                            </div>
                            @php
                                $cities =getLeopordCities();
                            @endphp
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>City:</strong>
                                    {{--{!! Form::text('billing_city', null, array('placeholder' => 'Billing City','class' => 'form-control')) !!}--}}

                                    <select name="billing_city" class="form-control "  required="" >
                                        <option value="">Select City</option>
                                        @foreach($cities->city_list as $key=>$city)
                                            @if($city->allow_as_destination==true)
                                                <option value="{{$city->id}}" @if($data['user']->billing_city==$city->id) selected @endif>{{$city->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>State:</strong>
                                    {!! Form::text('billing_state', null, array('placeholder' => 'Billing State','class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Post Code:</strong>
                                    {!! Form::text('billing_postal_code', null, array('placeholder' => 'Billing PostCode','class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Country:</strong>
                                    {!! Form::text('billing_country', null, array('placeholder' => 'Billing City','class' => 'form-control')) !!}

                                    {{--<select name="billing_country" class="form-control " required="">--}}
                                        {{--<option value="{{$user->billing_country}}" selected>Select country</option>--}}

                                        {{--<option value="AF">Afghanistan</option>--}}
                                        {{--<option value="AX">Åland Islands</option>--}}
                                        {{--<option value="AL">Albania</option>--}}
                                        {{--<option value="DZ">Algeria</option>--}}
                                        {{--<option value="AS">American Samoa</option>--}}
                                        {{--<option value="AD">Andorra</option>--}}
                                        {{--<option value="AO">Angola</option>--}}
                                        {{--<option value="AI">Anguilla</option>--}}
                                        {{--<option value="AQ">Antarctica</option>--}}
                                        {{--<option value="AG">Antigua and Barbuda</option>--}}
                                        {{--<option value="AR">Argentina</option>--}}
                                        {{--<option value="AM">Armenia</option>--}}
                                        {{--<option value="AW">Aruba</option>--}}
                                        {{--<option value="AU">Australia</option>--}}
                                        {{--<option value="AT">Austria</option>--}}
                                        {{--<option value="AZ">Azerbaijan</option>--}}
                                        {{--<option value="BS">Bahamas</option>--}}
                                        {{--<option value="BH">Bahrain</option>--}}
                                        {{--<option value="BD">Bangladesh</option>--}}
                                        {{--<option value="BB">Barbados</option>--}}
                                        {{--<option value="BY">Belarus</option>--}}
                                        {{--<option value="BE">Belgium</option>--}}
                                        {{--<option value="BZ">Belize</option>--}}
                                        {{--<option value="BJ">Benin</option>--}}
                                        {{--<option value="BM">Bermuda</option>--}}
                                        {{--<option value="BT">Bhutan</option>--}}
                                        {{--<option value="BO">Bolivia, Plurinational State of</option>--}}
                                        {{--<option value="BQ">Bonaire, Sint Eustatius and Saba</option>--}}
                                        {{--<option value="BA">Bosnia and Herzegovina</option>--}}
                                        {{--<option value="BW">Botswana</option>--}}
                                        {{--<option value="BV">Bouvet Island</option>--}}
                                        {{--<option value="BR">Brazil</option>--}}
                                        {{--<option value="IO">British Indian Ocean Territory</option>--}}
                                        {{--<option value="BN">Brunei Darussalam</option>--}}
                                        {{--<option value="BG">Bulgaria</option>--}}
                                        {{--<option value="BF">Burkina Faso</option>--}}
                                        {{--<option value="BI">Burundi</option>--}}
                                        {{--<option value="KH">Cambodia</option>--}}
                                        {{--<option value="CM">Cameroon</option>--}}
                                        {{--<option value="CA">Canada</option>--}}
                                        {{--<option value="CV">Cape Verde</option>--}}
                                        {{--<option value="KY">Cayman Islands</option>--}}
                                        {{--<option value="CF">Central African Republic</option>--}}
                                        {{--<option value="TD">Chad</option>--}}
                                        {{--<option value="CL">Chile</option>--}}
                                        {{--<option value="CN">China</option>--}}
                                        {{--<option value="CX">Christmas Island</option>--}}
                                        {{--<option value="CC">Cocos (Keeling) Islands</option>--}}
                                        {{--<option value="CO">Colombia</option>--}}
                                        {{--<option value="KM">Comoros</option>--}}
                                        {{--<option value="CG">Congo</option>--}}
                                        {{--<option value="CD">Congo, the Democratic Republic of the</option>--}}
                                        {{--<option value="CK">Cook Islands</option>--}}
                                        {{--<option value="CR">Costa Rica</option>--}}
                                        {{--<option value="CI">Côte d'Ivoire</option>--}}
                                        {{--<option value="HR">Croatia</option>--}}
                                        {{--<option value="CU">Cuba</option>--}}
                                        {{--<option value="CW">Curaçao</option>--}}
                                        {{--<option value="CY">Cyprus</option>--}}
                                        {{--<option value="CZ">Czech Republic</option>--}}
                                        {{--<option value="DK">Denmark</option>--}}
                                        {{--<option value="DJ">Djibouti</option>--}}
                                        {{--<option value="DM">Dominica</option>--}}
                                        {{--<option value="DO">Dominican Republic</option>--}}
                                        {{--<option value="EC">Ecuador</option>--}}
                                        {{--<option value="EG">Egypt</option>--}}
                                        {{--<option value="SV">El Salvador</option>--}}
                                        {{--<option value="GQ">Equatorial Guinea</option>--}}
                                        {{--<option value="ER">Eritrea</option>--}}
                                        {{--<option value="EE">Estonia</option>--}}
                                        {{--<option value="ET">Ethiopia</option>--}}
                                        {{--<option value="FK">Falkland Islands (Malvinas)</option>--}}
                                        {{--<option value="FO">Faroe Islands</option>--}}
                                        {{--<option value="FJ">Fiji</option>--}}
                                        {{--<option value="FI">Finland</option>--}}
                                        {{--<option value="FR">France</option>--}}
                                        {{--<option value="GF">French Guiana</option>--}}
                                        {{--<option value="PF">French Polynesia</option>--}}
                                        {{--<option value="TF">French Southern Territories</option>--}}
                                        {{--<option value="GA">Gabon</option>--}}
                                        {{--<option value="GM">Gambia</option>--}}
                                        {{--<option value="GE">Georgia</option>--}}
                                        {{--<option value="DE">Germany</option>--}}
                                        {{--<option value="GH">Ghana</option>--}}
                                        {{--<option value="GI">Gibraltar</option>--}}
                                        {{--<option value="GR">Greece</option>--}}
                                        {{--<option value="GL">Greenland</option>--}}
                                        {{--<option value="GD">Grenada</option>--}}
                                        {{--<option value="GP">Guadeloupe</option>--}}
                                        {{--<option value="GU">Guam</option>--}}
                                        {{--<option value="GT">Guatemala</option>--}}
                                        {{--<option value="GG">Guernsey</option>--}}
                                        {{--<option value="GN">Guinea</option>--}}
                                        {{--<option value="GW">Guinea-Bissau</option>--}}
                                        {{--<option value="GY">Guyana</option>--}}
                                        {{--<option value="HT">Haiti</option>--}}
                                        {{--<option value="HM">Heard Island and McDonald Islands</option>--}}
                                        {{--<option value="VA">Holy See (Vatican City State)</option>--}}
                                        {{--<option value="HN">Honduras</option>--}}
                                        {{--<option value="HK">Hong Kong</option>--}}
                                        {{--<option value="HU">Hungary</option>--}}
                                        {{--<option value="IS">Iceland</option>--}}
                                        {{--<option value="IN">India</option>--}}
                                        {{--<option value="ID">Indonesia</option>--}}
                                        {{--<option value="IR">Iran, Islamic Republic of</option>--}}
                                        {{--<option value="IQ">Iraq</option>--}}
                                        {{--<option value="IE">Ireland</option>--}}
                                        {{--<option value="IM">Isle of Man</option>--}}
                                        {{--<option value="IL">Israel</option>--}}
                                        {{--<option value="IT">Italy</option>--}}
                                        {{--<option value="JM">Jamaica</option>--}}
                                        {{--<option value="JP">Japan</option>--}}
                                        {{--<option value="JE">Jersey</option>--}}
                                        {{--<option value="JO">Jordan</option>--}}
                                        {{--<option value="KZ">Kazakhstan</option>--}}
                                        {{--<option value="KE">Kenya</option>--}}
                                        {{--<option value="KI">Kiribati</option>--}}
                                        {{--<option value="KP">Korea, Democratic People's Republic of</option>--}}
                                        {{--<option value="KR">Korea, Republic of</option>--}}
                                        {{--<option value="KW">Kuwait</option>--}}
                                        {{--<option value="KG">Kyrgyzstan</option>--}}
                                        {{--<option value="LA">Lao People's Democratic Republic</option>--}}
                                        {{--<option value="LV">Latvia</option>--}}
                                        {{--<option value="LB">Lebanon</option>--}}
                                        {{--<option value="LS">Lesotho</option>--}}
                                        {{--<option value="LR">Liberia</option>--}}
                                        {{--<option value="LY">Libya</option>--}}
                                        {{--<option value="LI">Liechtenstein</option>--}}
                                        {{--<option value="LT">Lithuania</option>--}}
                                        {{--<option value="LU">Luxembourg</option>--}}
                                        {{--<option value="MO">Macao</option>--}}
                                        {{--<option value="MK">Macedonia, the former Yugoslav Republic of</option>--}}
                                        {{--<option value="MG">Madagascar</option>--}}
                                        {{--<option value="MW">Malawi</option>--}}
                                        {{--<option value="MY">Malaysia</option>--}}
                                        {{--<option value="MV">Maldives</option>--}}
                                        {{--<option value="ML">Mali</option>--}}
                                        {{--<option value="MT">Malta</option>--}}
                                        {{--<option value="MH">Marshall Islands</option>--}}
                                        {{--<option value="MQ">Martinique</option>--}}
                                        {{--<option value="MR">Mauritania</option>--}}
                                        {{--<option value="MU">Mauritius</option>--}}
                                        {{--<option value="YT">Mayotte</option>--}}
                                        {{--<option value="MX">Mexico</option>--}}
                                        {{--<option value="FM">Micronesia, Federated States of</option>--}}
                                        {{--<option value="MD">Moldova, Republic of</option>--}}
                                        {{--<option value="MC">Monaco</option>--}}
                                        {{--<option value="MN">Mongolia</option>--}}
                                        {{--<option value="ME">Montenegro</option>--}}
                                        {{--<option value="MS">Montserrat</option>--}}
                                        {{--<option value="MA">Morocco</option>--}}
                                        {{--<option value="MZ">Mozambique</option>--}}
                                        {{--<option value="MM">Myanmar</option>--}}
                                        {{--<option value="NA">Namibia</option>--}}
                                        {{--<option value="NR">Nauru</option>--}}
                                        {{--<option value="NP">Nepal</option>--}}
                                        {{--<option value="NL">Netherlands</option>--}}
                                        {{--<option value="NC">New Caledonia</option>--}}
                                        {{--<option value="NZ">New Zealand</option>--}}
                                        {{--<option value="NI">Nicaragua</option>--}}
                                        {{--<option value="NE">Niger</option>--}}
                                        {{--<option value="NG">Nigeria</option>--}}
                                        {{--<option value="NU">Niue</option>--}}
                                        {{--<option value="NF">Norfolk Island</option>--}}
                                        {{--<option value="MP">Northern Mariana Islands</option>--}}
                                        {{--<option value="NO">Norway</option>--}}
                                        {{--<option value="OM">Oman</option>--}}
                                        {{--<option value="PK">Pakistan</option>--}}
                                        {{--<option value="PW">Palau</option>--}}
                                        {{--<option value="PS">Palestinian Territory, Occupied</option>--}}
                                        {{--<option value="PA">Panama</option>--}}
                                        {{--<option value="PG">Papua New Guinea</option>--}}
                                        {{--<option value="PY">Paraguay</option>--}}
                                        {{--<option value="PE">Peru</option>--}}
                                        {{--<option value="PH">Philippines</option>--}}
                                        {{--<option value="PN">Pitcairn</option>--}}
                                        {{--<option value="PL">Poland</option>--}}
                                        {{--<option value="PT">Portugal</option>--}}
                                        {{--<option value="PR">Puerto Rico</option>--}}
                                        {{--<option value="QA">Qatar</option>--}}
                                        {{--<option value="RE">Réunion</option>--}}
                                        {{--<option value="RO">Romania</option>--}}
                                        {{--<option value="RU">Russian Federation</option>--}}
                                        {{--<option value="RW">Rwanda</option>--}}
                                        {{--<option value="BL">Saint Barthélemy</option>--}}
                                        {{--<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>--}}
                                        {{--<option value="KN">Saint Kitts and Nevis</option>--}}
                                        {{--<option value="LC">Saint Lucia</option>--}}
                                        {{--<option value="MF">Saint Martin (French part)</option>--}}
                                        {{--<option value="PM">Saint Pierre and Miquelon</option>--}}
                                        {{--<option value="VC">Saint Vincent and the Grenadines</option>--}}
                                        {{--<option value="WS">Samoa</option>--}}
                                        {{--<option value="SM">San Marino</option>--}}
                                        {{--<option value="ST">Sao Tome and Principe</option>--}}
                                        {{--<option value="SA">Saudi Arabia</option>--}}
                                        {{--<option value="SN">Senegal</option>--}}
                                        {{--<option value="RS">Serbia</option>--}}
                                        {{--<option value="SC">Seychelles</option>--}}
                                        {{--<option value="SL">Sierra Leone</option>--}}
                                        {{--<option value="SG">Singapore</option>--}}
                                        {{--<option value="SX">Sint Maarten (Dutch part)</option>--}}
                                        {{--<option value="SK">Slovakia</option>--}}
                                        {{--<option value="SI">Slovenia</option>--}}
                                        {{--<option value="SB">Solomon Islands</option>--}}
                                        {{--<option value="SO">Somalia</option>--}}
                                        {{--<option value="ZA">South Africa</option>--}}
                                        {{--<option value="GS">South Georgia and the South Sandwich Islands</option>--}}
                                        {{--<option value="SS">South Sudan</option>--}}
                                        {{--<option value="ES">Spain</option>--}}
                                        {{--<option value="LK">Sri Lanka</option>--}}
                                        {{--<option value="SD">Sudan</option>--}}
                                        {{--<option value="SR">Suriname</option>--}}
                                        {{--<option value="SJ">Svalbard and Jan Mayen</option>--}}
                                        {{--<option value="SZ">Swaziland</option>--}}
                                        {{--<option value="SE">Sweden</option>--}}
                                        {{--<option value="CH">Switzerland</option>--}}
                                        {{--<option value="SY">Syrian Arab Republic</option>--}}
                                        {{--<option value="TW">Taiwan, Province of China</option>--}}
                                        {{--<option value="TJ">Tajikistan</option>--}}
                                        {{--<option value="TZ">Tanzania, United Republic of</option>--}}
                                        {{--<option value="TH">Thailand</option>--}}
                                        {{--<option value="TL">Timor-Leste</option>--}}
                                        {{--<option value="TG">Togo</option>--}}
                                        {{--<option value="TK">Tokelau</option>--}}
                                        {{--<option value="TO">Tonga</option>--}}
                                        {{--<option value="TT">Trinidad and Tobago</option>--}}
                                        {{--<option value="TN">Tunisia</option>--}}
                                        {{--<option value="TR">Turkey</option>--}}
                                        {{--<option value="TM">Turkmenistan</option>--}}
                                        {{--<option value="TC">Turks and Caicos Islands</option>--}}
                                        {{--<option value="TV">Tuvalu</option>--}}
                                        {{--<option value="UG">Uganda</option>--}}
                                        {{--<option value="UA">Ukraine</option>--}}
                                        {{--<option value="AE">United Arab Emirates</option>--}}
                                        {{--<option value="GB">United Kingdom</option>--}}
                                        {{--<option value="US">United States</option>--}}
                                        {{--<option value="UM">United States Minor Outlying Islands</option>--}}
                                        {{--<option value="UY">Uruguay</option>--}}
                                        {{--<option value="UZ">Uzbekistan</option>--}}
                                        {{--<option value="VU">Vanuatu</option>--}}
                                        {{--<option value="VE">Venezuela, Bolivarian Republic of</option>--}}
                                        {{--<option value="VN">Viet Nam</option>--}}
                                        {{--<option value="VG">Virgin Islands, British</option>--}}
                                        {{--<option value="VI">Virgin Islands, U.S.</option>--}}
                                        {{--<option value="WF">Wallis and Futuna</option>--}}
                                        {{--<option value="EH">Western Sahara</option>--}}
                                        {{--<option value="YE">Yemen</option>--}}
                                        {{--<option value="ZM">Zambia</option>--}}
                                        {{--<option value="ZW">Zimbabwe</option>--}}
                                    {{--</select>--}}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Shipping Address:</strong>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Ship Full Name:</strong>
                                    {!! Form::text('ship_full_name', null, array('placeholder' => 'Ship Full Name','class' => 'form-control')) !!}
                                </div>
                            </div>



                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Address:</strong>
                                    {!! Form::text('ship_address_1', null, array('placeholder' => 'Shipping Address','class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>City:</strong>
                                    {{--{!! Form::text('ship_city', null, array('placeholder' => 'Shipping City','class' => 'form-control')) !!}--}}
                                    <select name="ship_city" class="form-control "  required="" >
                                        <option value="">Select City</option>
                                        @foreach($cities->city_list as $key=>$city)
                                            @if($city->allow_as_destination==true)
                                                <option value="{{$city->id}}" @if($data['user']->ship_city==$city->id) selected @endif>{{$city->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>State:</strong>
                                    {!! Form::text('ship_state', null, array('placeholder' => 'Shipping State','class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Post Code:</strong>
                                    {!! Form::text('ship_postal_code', null, array('placeholder' => 'Shipping PostCode','class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Country:</strong>
                                    {!! Form::text('ship_country', null, array('placeholder' => 'Shipping City','class' => 'form-control')) !!}
                                </div>
                            </div>




                    </div>
                    </div>
                    <div class="tab-pane p-3" id="categories" role="tabpanel">
                        <div class="col-xs-12 col-sm-12 col-md-12">




                            <div class="form-group">
                                <table id="datatable" class="table table-striped ">
                                    <thead>
                                    <tr>

                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>

                                        {{--<th>Sub Categories</th>--}}




                                    </tr>
                                    </thead>


                                    <tbody>
                                    @php
                                        $i=0;
                                    @endphp
                                    @foreach ($data['user']->orderProducts as $key => $userPro)
                                        @php
                                           $i++;
                                        $pname=Modules\Products\Entities\Products::where('id',$userPro->product_id)->pluck('name')->first();

                                        @endphp
                                        <tr>
                                            <td>{{$pname}}</td>
                                            <td>{{$userPro->price}} </td>
                                            <td>{{$userPro->quantity}} </td>
                                            <td>{{$userPro->total_price}} </td>


                                            {{--<td>{{$user->first_name}} {{$user->last_name}}</td>--}}



                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>




                    </div>



                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>


    </div> <!-- end col -->
    </div> <!-- end row -->
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