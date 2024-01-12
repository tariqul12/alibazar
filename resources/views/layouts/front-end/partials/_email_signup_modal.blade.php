<!-- Sign Up Modal -->
  <div class="modal fade authModal" id="emailSignUpModal" tabindex="-1" aria-labelledby="emailSignUpModalLabel" aria-hidden="true" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="auth-content-wrapper">
            <div class="intro">
              <ul>
                <li>1. Original and Quality Products.</li>
                <li>2. Geniuine price for everyone</li>
                <li>3. Exclusive deals and offers</li>
                <li>4. Original and Quality Products.</li>
                <li>5. Rewards & Benefits for buyers</li>
              </ul>
            </div>
            <div class="auth-form sign-up">
              <div class="form-header">
                <span>Sign Up/ Register</span>
                
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="form-content text-center">
                <img class="vector" src="{{asset('/assets/frontend/img/illustration-signin.svg')}}" alt="siginin-illustration">
                <form class="needs-validation_" action="{{route('customer.auth.sign-up')}}"
                              method="post" id="email-sign-up-form">
                            @csrf
                                    <div class="input-group">
                                      <input class="form-control" value="{{old('f_name')}}" type="text" name="f_name"
                                               style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                               required placeholder="{{\App\CPU\translate('first_name')}}">
                                        <div class="invalid-feedback">{{\App\CPU\translate('Please enter your first name')}}!</div>
                                    </div>
                                    <div class="input-group">
                                      <input class="form-control" type="text" value="{{old('l_name')}}" name="l_name"
                                               style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" placeholder="{{\App\CPU\translate('last_name')}}">
                                        <div class="invalid-feedback">{{\App\CPU\translate('Please enter your last name')}}!</div>
                                    </div>
                                    <div class="input-group">
                                      <input class="form-control" type="email" value="{{old('email')}}"  name="email"
                                               style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" placeholder="{{\App\CPU\translate('email_address')}}">
                                        <div class="invalid-feedback">{{\App\CPU\translate('Please enter valid email address')}}!</div>
                                    </div>
                                    <div class="input-group">
                                      <input class="form-control" type="number"  value="{{old('phone')}}"  name="phone"
                                               style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                               required placeholder="Phone Number (Ex: 8801xxxxxxxxx)">
                                        <div class="invalid-feedback">{{\App\CPU\translate('Please enter your phone number')}}!</div>
                                    </div>
                                    <div class="input-group">
                                      <div class="password-toggle" style="width: 100%">
                                            <input class="form-control" name="password" type="password" id="si-password"
                                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                                   placeholder="Password {{\App\CPU\translate('minimum_8_characters_long')}}"
                                                   required>
                                            <label class="password-toggle-btn">
                                                <input class="custom-control-input" type="checkbox"><i
                                                    class="czi-eye password-toggle-indicator"></i><span
                                                    class="sr-only">{{\App\CPU\translate('Show')}} {{\App\CPU\translate('password')}} </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                      <div class="password-toggle" style="width: 100%">
                                            <input class="form-control" name="con_password" type="password"
                                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                                   placeholder="Confirm Password"
                                                   id="si-password"
                                                   required>
                                            <label class="password-toggle-btn">
                                                <input class="custom-control-input" type="checkbox"
                                                       style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"><i
                                                    class="czi-eye password-toggle-indicator"></i><span
                                                    class="sr-only">{{\App\CPU\translate('Show')}} {{\App\CPU\translate('password')}} </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group d-flex flex-wrap justify-content-between" style="margin-bottom: 2px !important">

                                        <div class="form-group mb-1">
                                            <strong>
                                                <input type="checkbox" class="mr-1"
                                                       name="remember" id="inputCheckd">
                                            </strong>
                                            <label class="" for="remember">
                                                <p class="copyright">
                                                  I agree to Malamal’s <a href="#">Terms of use</a> and <a href="#">Privacy policy</a>
                                                </p>
                                            </label>
                                        </div>

                                    </div>

                                    <div class="d-grid">
                                      <button class="btn btn-brand" id="sign-up" type="submit" disabled>Signup</button>
                                    </div>

                                    <div class="d-grid" style="gap: 5px !important">
                                      <span class="separator">Or sign up with</span>
                                      <button class="btn btn-google" type="button">
                                        <a href="{{route('customer.auth.service-login', 'google')}}" style="color: #6C6C6C !important;"><i class="fa-brands fa-google"></i> Google </a>
                                      </button>
                                      <button class="btn btn-facebook" type="button">
                                       <a href="{{route('customer.auth.service-login', 'facebook')}}" style="color: #fff !important;"> <i class="fa-brands fa-facebook-f"></i> Facebook </a>
                                      </button>
                                      
                                      <button class="btn btn-email email_signin_required" type="button" style="color: #EB7F11 !important">
                                        <i class="fa-solid fa-envelope"></i> Already have an account?
                                      </button>
                                    </div>
                        </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script>
        $('#inputCheckd').change(function () {
            // console.log('jell');
            if ($(this).is(':checked')) {
                $('#sign-up').removeAttr('disabled');
            } else {
                $('#sign-up').attr('disabled', 'disabled');
            }

        });

    </script>