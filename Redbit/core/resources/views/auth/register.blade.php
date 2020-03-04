<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $site_title }} | {{ $page_title }}</title>

    <!-- favicons -->
    <link rel="icon" type="image/png" href="{{ asset('assets/user1/images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/user1/images/apple-touch-icon.png') }}">

    <!-- ========================================================= -->
    <!-- All Styles -->
    <!-- ========================================================= -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/user1/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- font awesome -->
    <link rel="stylesheet" href="{{ asset('assets/user1/vendor/font-awesome/css/font-awesome.min.css') }}">

    <!-- tovvl main style -->
    <link rel="stylesheet" href="{{ asset('assets/user1/css/tovvl.css?v=1.0') }}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{asset('assets/user1/vendor/select2/css/select2.min.css') }}">
    <!-- boostrap datepicker-->
    <link rel="stylesheet" href="{{asset('assets/user1/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
</head>

<body>
    <!-- Page Loader -->
    <div class="page-loader">
        <div class="d-flex a-i-center j-c-center flex-direction-column h-100p">
            <div class="loader-bar">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="loader-text" data-text="BLUE FOREX LIMITED">
                BLUE FOREX LIMITED
            </div>
        </div>
    </div><!-- END / Page Loader -->

    <!-- auth -->
    <div class="auth-boxed">
        <div class="auth-wrapper1">
            <div class="auth-content1">
                <div class="auth-text">
                    <div class="logo logo-type"><a href="#" style="color:#3498DB">Blue Forex Limited</a></div>
                    <p class="mb-0">Please fill the form below <br>You can only join with your sponser link</p>
                </div>
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="px-3 py-2 alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {!!  $error !!}
                        </div>
                    @endforeach
                @endif
                <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-12 col-lg-6">
                          <label for="refid">Sponser Username</label>
                            <div class="position-relative">
                                <input type="text" name="refid" id="refid"  onkeypress="return false;" required class="form-control input-shadow" value="{{ app('request')->input('refid') }}">
                            </div>
                        </div>
                        <input type="hidden" value="{{ app('request')->input('p') }}" name="position" id="position" required>
                        <div class="form-group col-12 col-lg-6">
                          <label for="username">Username</label>
                            <div class="position-relative has-icon-right">
                                <input type="text" name="username" id="username" required class="form-control input-shadow" placeholder="Enter Your Username">
                                <div class="form-control-position">
                                  <i class="zmdi zmdi-account"></i>
                                </div>
                            </div>
                        </div>
                    </div>                 
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="name">Full Name</label>
                            <div class="position-relative has-icon-right">
                                <input type="text" value="{{ $name }}"  name="name" id="name" required class="form-control input-shadow" placeholder="Enter Your Full Name">
                                <div class="form-control-position">
                                  <i class="zmdi zmdi-account"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="email">Email</label>
                            <div class="position-relative has-icon-right">
                                <input type="email" value="{{ $email }}"  name="email" id="email" required class="form-control input-shadow" placeholder="Enter Your Email">
                                <div class="form-control-position">
                                  <i class="zmdi zmdi-email"></i>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12 ">
                        <label for="country">Country</label>
                            <div class="position-relative has-icon-right">
                                <select id="country" required name="country" class="form-control single-select"><option value="" disabled selected></option><option value="Afghanistan">Afghanistan</option><option value="Andorra">Andorra</option><option value="Antigua And Barbuda">Antigua And Barbuda</option><option value="Anguilla">Anguilla</option><option value="Albania">Albania</option><option value="Armenia">Armenia</option><option value="Angola">Angola</option><option value="Argentina">Argentina</option><option value="Austria">Austria</option><option value="Australia">Australia</option><option value="Aruba">Aruba</option><option value="Azerbaijan">Azerbaijan</option><option value="Bosnia And Herzegovina">Bosnia And Herzegovina</option><option value="Barbados">Barbados</option><option value="Bangladesh">Bangladesh</option><option value="Belgium">Belgium</option><option value="Burkina Faso">Burkina Faso</option><option value="Bulgaria">Bulgaria</option><option value="Bahrain">Bahrain</option><option value="Burundi">Burundi</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Brunei Darussalam">Brunei Darussalam</option><option value="Bolivia">Bolivia</option><option value="Brazil">Brazil</option><option value="Bahamas">Bahamas</option><option value="Bhutan">Bhutan</option><option value="Botswana">Botswana</option><option value="Belarus">Belarus</option><option value="Belize">Belize</option><option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option><option value="Congo, The Democratic Republic Of The">Congo, The Democratic Republic Of The</option><option value="Central African Republic">Central African Republic</option><option value="Congo">Congo</option><option value="Switzerland">Switzerland</option><option value="Cote D'Ivoire">Cote D'Ivoire</option><option value="Cook Islands">Cook Islands</option><option value="Chile">Chile</option><option value="Cameroon">Cameroon</option><option value="China">China</option><option value="Colombia">Colombia</option><option value="Costa Rica">Costa Rica</option><option value="Cuba">Cuba</option><option value="Cape Verde">Cape Verde</option><option value="Christmas Island">Christmas Island</option><option value="Cyprus">Cyprus</option><option value="Czech Republic">Czech Republic</option><option value="Germany">Germany</option><option value="Djibouti">Djibouti</option><option value="Denmark">Denmark</option><option value="Dominica">Dominica</option><option value="Dominican Republic">Dominican Republic</option><option value="Algeria">Algeria</option><option value="Ecuador">Ecuador</option><option value="Estonia">Estonia</option><option value="Egypt">Egypt</option><option value="Western Sahara">Western Sahara</option><option value="Eritrea">Eritrea</option><option value="Spain">Spain</option><option value="Ethiopia">Ethiopia</option><option value="Finland">Finland</option><option value="Fiji">Fiji</option><option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option><option value="Micronesia, Federated States Of">Micronesia, Federated States Of</option><option value="Faroe Islands">Faroe Islands</option><option value="France">France</option><option value="Gabon">Gabon</option><option value="Grenada">Grenada</option><option value="Georgia">Georgia</option><option value="French Guiana">French Guiana</option><option value="Guernsey">Guernsey</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Greenland">Greenland</option><option value="Gambia">Gambia</option><option value="Guinea">Guinea</option><option value="Guadeloupe">Guadeloupe</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Greece">Greece</option><option value="South Georgia And The South Sandwich Islands">South Georgia And The South Sandwich Islands</option><option value="Guatemala">Guatemala</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Hong Kong">Hong Kong</option><option value="Honduras">Honduras</option><option value="Croatia">Croatia</option><option value="Haiti">Haiti</option><option value="Hungary">Hungary</option><option value="Indonesia">Indonesia</option><option value="Ireland">Ireland</option><option value="Israel">Israel</option><option value="Isle Of Man">Isle Of Man</option><option value="India">India</option><option value="Iraq">Iraq</option><option value="Iran, Islamic Republic Of">Iran, Islamic Republic Of</option><option value="Iceland">Iceland</option><option value="Italy">Italy</option><option value="Jersey">Jersey</option><option value="Jamaica">Jamaica</option><option value="Jordan">Jordan</option><option value="Japan">Japan</option><option value="Kenya">Kenya</option><option value="Kyrgyzstan">Kyrgyzstan</option><option value="Cambodia">Cambodia</option><option value="Kiribati">Kiribati</option><option value="Comoros">Comoros</option><option value="Saint Kitts And Nevis">Saint Kitts And Nevis</option><option value="Korea, Democratic People'S Republic Of">Korea, Democratic People'S Republic Of</option><option value="Korea, Republic Of">Korea, Republic Of</option><option value="Kuwait">Kuwait</option><option value="Cayman Islands">Cayman Islands</option><option value="Kazakhstan">Kazakhstan</option><option value="Lao People'S Democratic Republic">Lao People'S Democratic Republic</option><option value="Lebanon">Lebanon</option><option value="Saint Lucia">Saint Lucia</option><option value="Liechtenstein">Liechtenstein</option><option value="Sri Lanka">Sri Lanka</option><option value="Liberia">Liberia</option><option value="Lesotho">Lesotho</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Latvia">Latvia</option><option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option><option value="Morocco">Morocco</option><option value="Monaco">Monaco</option><option value="Moldova, Republic Of">Moldova, Republic Of</option><option value="Montenegro">Montenegro</option><option value="Madagascar">Madagascar</option><option value="Marshall Islands">Marshall Islands</option><option value="Macedonia">Macedonia</option><option value="Mali">Mali</option><option value="Myanmar">Myanmar</option><option value="Mongolia">Mongolia</option><option value="Macao">Macao</option><option value="Northern Mariana Islands">Northern Mariana Islands</option><option value="Martinique">Martinique</option><option value="Mauritania">Mauritania</option><option value="Montserrat">Montserrat</option><option value="Malta">Malta</option><option value="Mauritius">Mauritius</option><option value="Maldives">Maldives</option><option value="Malawi">Malawi</option><option value="Mexico">Mexico</option><option value="Malaysia">Malaysia</option><option value="Mozambique">Mozambique</option><option  value="Namibia">Namibia</option><option value="New Caledonia">New Caledonia</option><option value="Niger">Niger</option><option value="Norfolk Island">Norfolk Island</option><option value="Nigeria">Nigeria</option><option value="Nicaragua">Nicaragua</option><option value="Netherlands">Netherlands</option><option value="Norway">Norway</option><option value="Nepal">Nepal</option><option value="Nauru">Nauru</option><option value="Niue">Niue</option><option value="New Zealand">New Zealand</option><option value="Oman">Oman</option><option value="Panama">Panama</option><option value="Peru">Peru</option><option value="French Polynesia">French Polynesia</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Philippines">Philippines</option><option value="Pakistan">Pakistan</option><option value="Poland">Poland</option><option value="Saint Pierre And Miquelon">Saint Pierre And Miquelon</option><option value="Pitcairn">Pitcairn</option><option value="Palestinian Territory">Palestinian Territory</option><option value="Portugal">Portugal</option><option value="Palau">Palau</option><option value="Paraguay">Paraguay</option><option value="Qatar">Qatar</option><option value="Reunion">Reunion</option><option value="Romania">Romania</option><option value="Serbia">Serbia</option><option value="Russian Federation">Russian Federation</option><option value="Rwanda">Rwanda</option><option value="Saudi Arabia">Saudi Arabia</option><option value="Solomon Islands">Solomon Islands</option><option value="Seychelles">Seychelles</option><option value="Sudan">Sudan</option><option value="Sweden">Sweden</option><option value="Singapore">Singapore</option><option value="Saint Helena">Saint Helena</option><option value="Slovenia">Slovenia</option><option value="Svalbard And Jan Mayen">Svalbard And Jan Mayen</option><option value="Slovakia">Slovakia</option><option value="Sierra Leone">Sierra Leone</option><option value="San Marino">San Marino</option><option value="Senegal">Senegal</option><option  value="Somalia">Somalia</option><option value="Suriname">Suriname</option><option value="Sao Tome And Principe">Sao Tome And Principe</option><option value="El Salvador">El Salvador</option><option value="Syrian Arab Republic">Syrian Arab Republic</option><option value="Swaziland">Swaziland</option><option value="Turks And Caicos Islands">Turks And Caicos Islands</option><option value="199" value="Chad">Chad</option><option value="French Southern Territories">French Southern Territories</option><option value="Togo">Togo</option><option value="Thailand">Thailand</option><option value="Tajikistan">Tajikistan</option><option value="Tokelau">Tokelau</option><option value="Turkmenistan">Turkmenistan</option><option value="Tunisia">Tunisia</option><option value="Tonga">Tonga</option><option value="Turkey">Turkey</option><option value="Trinidad And Tobago">Trinidad And Tobago</option><option value="Tuvalu">Tuvalu</option><option value="Taiwan">Taiwan</option><option value="Tanzania, United Republic Of">Tanzania, United Republic Of</option><option value="Ukraine">Ukraine</option><option value="Uganda">Uganda</option><option value="United State America">United State America</option><option value="United Kingdom">United Kingdom</option><option value="United Arab Emirates">United Arab Emirates</option><option value="Uruguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Saint Vincent And The Grenadines">Saint Vincent And The Grenadines</option><option value="Venezuela">Venezuela</option><option value="Virgin Islands, British">Virgin Islands, British</option><option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option><option value="Vietnam">Vietnam</option><option value="Vanuatu">Vanuatu</option><option value="Wallis And Futuna">Wallis And Futuna</option><option  value="Samoa">Samoa</option><option value="Yemen">Yemen</option><option value="Mayotte">Mayotte</option><option value="South Africa">South Africa</option><option value="Zambia">Zambia</option><option value="Zimbabwe">Zimbabwe</option><option value="Other">Other</option></select>
                                <div class="form-control-position">
                                  <i class="zmdi zmdi-globe"></i>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="docid">Document ID</label>
                            <div class="position-relative has-icon-right">
                                <input type="text" name="docid" id="docid" required class="form-control input-shadow" placeholder="Enter Your Document ID">
                                <div class="form-control-position">
                                  <i class="zmdi zmdi-file-text"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 col-lg-6">
                            <label for="phone">Phone Number</label>
                            <div class="position-relative has-icon-right">
                                <input type="text"  name="phone" id="phone" required class="form-control input-shadow" placeholder="Enter Your Phone Number">
                                <div class="form-control-position">
                                  <i class="zmdi zmdi-phone"></i>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12 col-lg-6">
                            <label for="gender">Gender</label>
                            <div class="position-relative ">
                                <select name="gender" id="gender" required class="form-control">
                                    <option value="" disabled selected></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div class="form-control-position">
                                  <i class="zmdi zmdi-male-female"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 col-lg-6">
                            <label for="DOB">Birthdate</label>
                            <div class="position-relative has-icon-right">
                                <input type="text" id="DOB" name="DOB" required class="default-datepicker form-control input-shadow">
                                <div class="form-control-position">
                                  <i class="zmdi zmdi-calendar"></i>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="form-row">
                    <div class="form-group col-12">
                            <label for="password">Password</label>
                            <div class="position-relative has-icon-right">
                                <input type="password"  name="password" id="password" required class="form-control input-shadow" placeholder="Enter Your Password">
                                <div class="form-control-position">
                                  <i class="zmdi zmdi-lock"></i>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="position-relative has-icon-right">
                                <input type="password"  name="password_confirmation" id="password_confirmation" required class="form-control input-shadow" placeholder="Confirm Your Password">
                                <div class="form-control-position">
                                  <i class="zmdi zmdi-lock"></i>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="form-row">
                        @if($basic->google_recap == 1)
                            <div class="form-group">
                                <div class="col-12">
                                    {!! app('captcha')->display() !!}
                                </div>
                            </div>
                        @endif
                    </div>       
               <button id="register" value="Register" type="submit" class="btn btn-primary shadow-primary btn-block waves-effect waves-light">Sign Up</button>  
               </form>
            </div>
        </div>
    </div>
    <!-- end / auth -->
    
    <!-- ========================================================= -->
    <!-- All Scripts -->
    <!-- ========================================================= -->
    <!-- jquery -->
    <script src="{{ asset('assets/user1/vendor/jquery/js/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{ asset('assets/user1/vendor/popper/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/user1/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- feather icons -->
    <script src="{{ asset('assets/user1/vendor/feather/js/feather.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/user1/js/main.js') }}"></script>
    <script src="{{asset('assets/user1/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{asset('assets/user1/vendor/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript">
      $('.single-select').select2();
      $('.default-datepicker').datepicker({
            format: "dd/mm/yyyy",
        });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        var input = document.getElementById('refid');
        if(input.value.length != 0){
            input.readOnly = true;
        }
    });
    </script>
    // <script type="text/javascript">
    // $(document).ready(function(){
    //     var input = document.getElementById('refid');
    //     if(input.value.length == 0){
    //         input.value = "redbitforex";
    //     }

    //     var pos = document.getElementById('position');
    //     if(pos.value.length == 0){
    //         pos.value = "Left";
    //     }
    // });
    // </script>   
    <script type="text/javascript">
        $("form").submit(function(event) {

       var recaptcha = $("#g-recaptcha-response").val();
       if (recaptcha === "") {
          event.preventDefault();
          swal("Please check the recaptcha");
       }
    });
    </script>
</body>
</html>