@extends('layouts.user-frontend.user-dashboard')

@section('style')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
    <style>
.btn-c{
      width: 100% !important;
      height: 100% !important;
      border-radius: 0px !important;
      border:0 !important;
      cursor: pointer;
      font-weight:700;
      color:#fff;
      outline: none !important;
      background-color: #3449BD !important; 
    }
    input{
      color:#000000 !important;
      border: 1px solid #3449BD !important;
    }
    input[readonly]{
      color:#ffffff !important;
      border: 1px solid #3449BD !important;
      background-color: #3A3A3A !important;
    }
    </style>
@endsection
@section('content')
<div class="main-content">
    <div class="main-body">
        <div class="profile">
            <div class="row row-md">
                <div class="col-md-5">
                    <div class="card overflow-hidden">
                        <!-- user profile -->
                        <div class="user-profile">
                          {!! Form::open(['method'=>'post','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}
                            <div class="col-12 text-center mt-10">
                              <div class="fileinput fileinput-new" data-provides="fileinput">
                                  <div class="fileinput-new rounded-circle thumbnail height-150 width-150" data-trigger="fileinput">
                                          <img src="{{ asset('assets/images') }}/{{ $user->image }}" class="width-150" alt="{{$user->username}}" />
                                      </div>
                                      <div class="fileinput-preview fileinput-exists rounded-circle thumbnail height-150 width-150"></div>
                                      <div class="img-input-div">
                                          <span class="btn btn-file btn-c my-1">
                                              <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select image</span>
                                              <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                              <input type="file" name="image" accept="image/*">
                                          </span>
                                          <a href="#" class="btn btn-c fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                      </div>
                                  </div>
                              </div>
                            <div class="card-body">
                                <!-- user detail -->
                                <div class="user-detail">
                                    <div class="top-detail">
                                        <div class="ln-20">
                                            <div class="user-name">{{ $user->name }}</div>
                                        </div>
                                        <div class="badge badge-success badge-pill">ONLINE</div>
                                    </div>
                                </div><!-- end / user detail -->
                                <!-- user activity -->
                                <div class="user-activity">
                                    <div class="title">Personal Information</div>
                                    <div class="card">
                                      <div class="card-body">
                                              <input type="text" readonly name="reference" class="form-control" value="{{ $reference1 }}" hidden required placeholder="Sponser username">
                                              <input type="text" name="username" readonly class="form-control" value="{{ $user->username }}" hidden required placeholder="Username">
                                              <div class="form-group">
                                                  <label>E-Mail Address</label>
                                                  <input type="email" name="email" class="form-control" value="{{ $user->email }}" required placeholder="Email" readonly>
                                              </div>
                                              <div class="form-group">
                                                  <label>Full Name</label>
                                                  <input type="text" name="name" class="form-control" value="{{ $user->name }}"  required placeholder="Name">
                                              </div>
                                              <div class="form-group">
                                                  <label>Phone Number</label>
                                                  <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required placeholder="Phone number">
                                              </div>
                                              <div class="form-group">
                                                  <label>Document ID</label>
                                                  <input type="text" name="docid" class="form-control" value="{{ $user->docid }}"  required placeholder="Document/ID">
                                              </div>
                                              <div class="form-group">
                                                  <label>Country</label>
                                                  <select class="form-control select2-multiple"><option style="display: none;" value="{{ $user->country }}" selected>{{ $user->country }}</option><option value="Afghanistan">Afghanistan</option><option value="Andorra">Andorra</option><option value="Antigua And Barbuda">Antigua And Barbuda</option><option value="Anguilla">Anguilla</option><option value="Albania">Albania</option><option value="Armenia">Armenia</option><option value="Angola">Angola</option><option value="Argentina">Argentina</option><option value="Austria">Austria</option><option value="Australia">Australia</option><option value="Aruba">Aruba</option><option value="Azerbaijan">Azerbaijan</option><option value="Bosnia And Herzegovina">Bosnia And Herzegovina</option><option value="Barbados">Barbados</option><option value="Bangladesh">Bangladesh</option><option value="Belgium">Belgium</option><option value="Burkina Faso">Burkina Faso</option><option value="Bulgaria">Bulgaria</option><option value="Bahrain">Bahrain</option><option value="Burundi">Burundi</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Brunei Darussalam">Brunei Darussalam</option><option value="Bolivia">Bolivia</option><option value="Brazil">Brazil</option><option value="Bahamas">Bahamas</option><option value="Bhutan">Bhutan</option><option value="Botswana">Botswana</option><option value="Belarus">Belarus</option><option value="Belize">Belize</option><option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option><option value="Congo, The Democratic Republic Of The">Congo, The Democratic Republic Of The</option><option value="Central African Republic">Central African Republic</option><option value="Congo">Congo</option><option value="Switzerland">Switzerland</option><option value="Cote D'Ivoire">Cote D'Ivoire</option><option value="Cook Islands">Cook Islands</option><option value="Chile">Chile</option><option value="Cameroon">Cameroon</option><option value="China">China</option><option value="Colombia">Colombia</option><option value="Costa Rica">Costa Rica</option><option value="Cuba">Cuba</option><option value="Cape Verde">Cape Verde</option><option value="Christmas Island">Christmas Island</option><option value="Cyprus">Cyprus</option><option value="Czech Republic">Czech Republic</option><option value="Germany">Germany</option><option value="Djibouti">Djibouti</option><option value="Denmark">Denmark</option><option value="Dominica">Dominica</option><option value="Dominican Republic">Dominican Republic</option><option value="Algeria">Algeria</option><option value="Ecuador">Ecuador</option><option value="Estonia">Estonia</option><option value="Egypt">Egypt</option><option value="Western Sahara">Western Sahara</option><option value="Eritrea">Eritrea</option><option value="Spain">Spain</option><option value="Ethiopia">Ethiopia</option><option value="Finland">Finland</option><option value="Fiji">Fiji</option><option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option><option value="Micronesia, Federated States Of">Micronesia, Federated States Of</option><option value="Faroe Islands">Faroe Islands</option><option value="France">France</option><option value="Gabon">Gabon</option><option value="Grenada">Grenada</option><option value="Georgia">Georgia</option><option value="French Guiana">French Guiana</option><option value="Guernsey">Guernsey</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Greenland">Greenland</option><option value="Gambia">Gambia</option><option value="Guinea">Guinea</option><option value="Guadeloupe">Guadeloupe</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Greece">Greece</option><option value="South Georgia And The South Sandwich Islands">South Georgia And The South Sandwich Islands</option><option value="Guatemala">Guatemala</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Hong Kong">Hong Kong</option><option value="Honduras">Honduras</option><option value="Croatia">Croatia</option><option value="Haiti">Haiti</option><option value="Hungary">Hungary</option><option value="Indonesia">Indonesia</option><option value="Ireland">Ireland</option><option value="Israel">Israel</option><option value="Isle Of Man">Isle Of Man</option><option value="India">India</option><option value="Iraq">Iraq</option><option value="Iran, Islamic Republic Of">Iran, Islamic Republic Of</option><option value="Iceland">Iceland</option><option value="Italy">Italy</option><option value="Jersey">Jersey</option><option value="Jamaica">Jamaica</option><option value="Jordan">Jordan</option><option value="Japan">Japan</option><option value="Kenya">Kenya</option><option value="Kyrgyzstan">Kyrgyzstan</option><option value="Cambodia">Cambodia</option><option value="Kiribati">Kiribati</option><option value="Comoros">Comoros</option><option value="Saint Kitts And Nevis">Saint Kitts And Nevis</option><option value="Korea, Democratic People'S Republic Of">Korea, Democratic People'S Republic Of</option><option value="Korea, Republic Of">Korea, Republic Of</option><option value="Kuwait">Kuwait</option><option value="Cayman Islands">Cayman Islands</option><option value="Kazakhstan">Kazakhstan</option><option value="Lao People'S Democratic Republic">Lao People'S Democratic Republic</option><option value="Lebanon">Lebanon</option><option value="Saint Lucia">Saint Lucia</option><option value="Liechtenstein">Liechtenstein</option><option value="Sri Lanka">Sri Lanka</option><option value="Liberia">Liberia</option><option value="Lesotho">Lesotho</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Latvia">Latvia</option><option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option><option value="Morocco">Morocco</option><option value="Monaco">Monaco</option><option value="Moldova, Republic Of">Moldova, Republic Of</option><option value="Montenegro">Montenegro</option><option value="Madagascar">Madagascar</option><option value="Marshall Islands">Marshall Islands</option><option value="Macedonia">Macedonia</option><option value="Mali">Mali</option><option value="Myanmar">Myanmar</option><option value="Mongolia">Mongolia</option><option value="Macao">Macao</option><option value="Northern Mariana Islands">Northern Mariana Islands</option><option value="Martinique">Martinique</option><option value="Mauritania">Mauritania</option><option value="Montserrat">Montserrat</option><option value="Malta">Malta</option><option value="Mauritius">Mauritius</option><option value="Maldives">Maldives</option><option value="Malawi">Malawi</option><option value="Mexico">Mexico</option><option value="Malaysia">Malaysia</option><option value="Mozambique">Mozambique</option><option  value="Namibia">Namibia</option><option value="New Caledonia">New Caledonia</option><option value="Niger">Niger</option><option value="Norfolk Island">Norfolk Island</option><option value="Nigeria">Nigeria</option><option value="Nicaragua">Nicaragua</option><option value="Netherlands">Netherlands</option><option value="Norway">Norway</option><option value="Nepal">Nepal</option><option value="Nauru">Nauru</option><option value="Niue">Niue</option><option value="New Zealand">New Zealand</option><option value="Oman">Oman</option><option value="Panama">Panama</option><option value="Peru">Peru</option><option value="French Polynesia">French Polynesia</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Philippines">Philippines</option><option value="Pakistan">Pakistan</option><option value="Poland">Poland</option><option value="Saint Pierre And Miquelon">Saint Pierre And Miquelon</option><option value="Pitcairn">Pitcairn</option><option value="Palestinian Territory">Palestinian Territory</option><option value="Portugal">Portugal</option><option value="Palau">Palau</option><option value="Paraguay">Paraguay</option><option value="Qatar">Qatar</option><option value="Reunion">Reunion</option><option value="Romania">Romania</option><option value="Serbia">Serbia</option><option value="Russian Federation">Russian Federation</option><option value="Rwanda">Rwanda</option><option value="Saudi Arabia">Saudi Arabia</option><option value="Solomon Islands">Solomon Islands</option><option value="Seychelles">Seychelles</option><option value="Sudan">Sudan</option><option value="Sweden">Sweden</option><option value="Singapore">Singapore</option><option value="Saint Helena">Saint Helena</option><option value="Slovenia">Slovenia</option><option value="Svalbard And Jan Mayen">Svalbard And Jan Mayen</option><option value="Slovakia">Slovakia</option><option value="Sierra Leone">Sierra Leone</option><option value="San Marino">San Marino</option><option value="Senegal">Senegal</option><option  value="Somalia">Somalia</option><option value="Suriname">Suriname</option><option value="Sao Tome And Principe">Sao Tome And Principe</option><option value="El Salvador">El Salvador</option><option value="Syrian Arab Republic">Syrian Arab Republic</option><option value="Swaziland">Swaziland</option><option value="Turks And Caicos Islands">Turks And Caicos Islands</option><option value="199" value="Chad">Chad</option><option value="French Southern Territories">French Southern Territories</option><option value="Togo">Togo</option><option value="Thailand">Thailand</option><option value="Tajikistan">Tajikistan</option><option value="Tokelau">Tokelau</option><option value="Turkmenistan">Turkmenistan</option><option value="Tunisia">Tunisia</option><option value="Tonga">Tonga</option><option value="Turkey">Turkey</option><option value="Trinidad And Tobago">Trinidad And Tobago</option><option value="Tuvalu">Tuvalu</option><option value="Taiwan">Taiwan</option><option value="Tanzania, United Republic Of">Tanzania, United Republic Of</option><option value="Ukraine">Ukraine</option><option value="Uganda">Uganda</option><option value="United Kingdom">United Kingdom</option><option value="United Arab Emirates">United Arab Emirates</option><option value="Uruguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Saint Vincent And The Grenadines">Saint Vincent And The Grenadines</option><option value="Venezuela">Venezuela</option><option value="Virgin Islands, British">Virgin Islands, British</option><option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option><option value="Vietnam">Vietnam</option><option value="Vanuatu">Vanuatu</option><option value="Wallis And Futuna">Wallis And Futuna</option><option  value="Samoa">Samoa</option><option value="Yemen">Yemen</option><option value="Mayotte">Mayotte</option><option value="South Africa">South Africa</option><option value="Zambia">Zambia</option><option value="Zimbabwe">Zimbabwe</option><option value="Other">Other</option></select>
                                              </div>
                                              <fieldset>
                                                  <div class="row row-md">     
                                                      <div class="col-md-12">
                                                          <div class="form-group">
                                                              <label>Date of birth</label>
                                                              <input type="text" name="DOB" class="form-control bs-datepicker" value="{{$user->DOB}}" required placeholder="YYYY/MM/DD" />
                                                          </div>
                                                      </div>
                                                      <div class="col-md-12">
                                                          <div class="form-group">
                                                              <label>Gender</label>
                                                              <select name="gender" class="form-control">
                                                                  <option style="display: none;" value="{{$user->gender}}" selected>{{$user->gender}}</option>
                                                                  <option value="Male">Male</option>
                                                                  <option value="Female">Female</option>
                                                              </select>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-12">
                                                          <div class="form-group mb-0">
                                                              <button class="btn btn-primary">Save Changes</button>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </fieldset>
                                          {!! Form::close() !!}
                                      </div>
                                  </div>
                                </div><!-- end / user activity -->
                            </div>
                        </div>
                    </div><!-- end / user profile -->
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                          <div class="user-profile">
                            <div class="user-activity">
                              <div class="title">Change Password</div>
                              <form action="{{route('change-password')}}" method="post" role="form">
                                  {!! csrf_field() !!}
                                  <div class="form-group">
                                      <label>Current Password</label>
                                      <input name="current_password" class="form-control mb-1" placeholder="Current Password" type="password">
                                  </div>
                                  <div class="form-group">
                                      <label>New Password</label>
                                      <input name="password" class="form-control mb-1" placeholder="New Password" type="password">
                                  </div>
                                  <div class="form-group">
                                      <label>Confirm Password</label>
                                      <input name="password_confirmation" class="form-control mb-1" placeholder="New Password Again" type="password">
                                  </div>                                                                 
                                  <div class="col-12 col-lg-4 px-0 mt-2">
                                      <button type="submit" class="btn-c py-2">Change Password</button>
                                  </div>  
                              </form>
                            </div>
                          </div> 
                          <div class="user-profile">
                            <div class="user-activity">
                              <div class="title">Withdraw Wallet</div>
                              <form action="{{route('wallet.update')}}" method="post" role="form">
                                  {!! csrf_field() !!}
                                  <div class="col-md-12 px-0">
                                      @if($passive)
                                          @foreach($passive as $user_data)
                                          <div class="form-group">
                                            <label>Bitcoin Wallet</label>
                                            <input type="text" class="form-control"  name="{{ $user_data->category_id }}" id="b" value="{{ $user_data->wallet }}" placeholder="BTC Wallet">
                                          </div>
                                      @endforeach
                                      @endif
                                      @if($binary)
                                          @foreach($binary as $user_data)
                                          <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $user_data->category_id }}" id="p" value="{{ $user_data->wallet }}" hidden placeholder="Perfect Money">
                                          </div>
                                      @endforeach
                                      @endif
                                  </div>
                                  <div class="col-lg-4 col-12 px-0 mt-2">
                                      <button type="submit" class="btn-c py-2">Save Wallet</button>
                                  </div>
                              </form>
                            </div>
                          </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
    $(document).ready(function(){
        var input = document.getElementById('b');
        if(input.value.length != 0){
            input.readOnly = true;
        }

        var pos = document.getElementById('p');
        if(pos.value.length != 0){
            pos.readOnly = true;
        }
    });
    </script>
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
    @if (session('message'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Success!", "{{ session('message') }}", "success");

            });

        </script>

    @endif

    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{!! session('alert') !!}", "error");

            });

        </script>

    @endif

@endsection
