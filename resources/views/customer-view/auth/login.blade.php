@extends('layouts.front-end.app')
@section('title', \App\CPU\translate('Login'))
@push('css_or_js')
    <style>
        .password-toggle-btn .custom-control-input:checked ~ .password-toggle-indicator {
            color: {{$web_config['primary_color']}};
        }

        .for-no-account {
            margin: auto;
            text-align: center;
        }
    </style>
    
    <style>
        .input-icons i {
            /* position: absolute; */
            cursor: pointer;
        }

        .input-icons {
            width: 100%;
            margin-bottom: 10px;
        }

        .icon {
            padding: 9% 0 0 0;
            min-width: 40px;
        }

        .input-field {
            width: 94%;
            padding: 10px 0 10px 10px;
            text-align: center;
            border-right-style: none;
        }
        .auth-content-wrapper .auth-form .form-content .btn-google {
            background: #fff;
        }
    </style>
@endpush
@section('content')
    <div class="container py-4 py-lg-5 my-4"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        
                        
                        <div class="auth-content-wrapper">
                            <div class="intro">
                              <ul>
                                <li>1. Original and Quality Products.</li>
                                <li>2. Geniuine price for everyone</li>
                                <li>3. Exclusive deals and offers</li>
                                <li>4. Original and Quality Products.</li>
                                <li>5. Rewards &amp; Benefits for buyers</li>
                              </ul>
                            </div>
                            <div class="auth-form sign-in">
                              <div class="form-header">
                                <span>Login/ Registration</span>
                              </div>
                              <form class="needs-validation mt-2" autocomplete="off" action="{{route('customer.auth.login')}}" method="post" id="form-id">
                                @csrf
                              <div class="form-content text-center">
                                <img class="vector" src="{{asset('public/assets/frontend/img/illustration-signin.svg')}}" alt="siginin-illustration">
                                <div class="input-group">
                                  <!--<input type="email" class="form-control email" placeholder="Enter your email address" aria-label="email" aria-describedby="email-address">-->
                                  <input class="form-control" type="text" name="user_id" id="si-email" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                    value="{{old('user_id')}}" placeholder="{{\App\CPU\translate('Enter_email_address_or_phone_number')}}" aria-label="email" aria-describedby="email-address" required>
                                </div>
                                <div class="input-group">
                                  <!--<input type="email" class="form-control email" placeholder="Enter your email address" aria-label="email" aria-describedby="email-address">-->
                                    <div class="password-toggle" style="width: 100%;">
                                        <input class="form-control" name="password" type="password" id="si-password"
                                               style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                               required>
                                        <label class="password-toggle-btn">
                                            <input class="custom-control-input" type="checkbox"><i
                                                class="czi-eye password-toggle-indicator"></i><span
                                                class="sr-only">{{\App\CPU\translate('Show')}} {{\App\CPU\translate('password')}} </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between">

                                    <div class="form-group">
                                        <input type="checkbox"
                                               class="{{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"
                                               name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="" for="remember">{{\App\CPU\translate('remember_me')}}</label>
                                    </div>
                                    <a class="font-size-sm" href="{{route('customer.auth.recover-password')}}">
                                        {{\App\CPU\translate('forgot_password')}}?
                                    </a>
                                </div>
                                <div class="d-grid">
                                  <button class="btn btn-brand" type="submit">{{\App\CPU\translate('sign_in')}}</button>
                                  
                                  <span class="separator">Or sign up with</span>
                                  <button class="btn btn-google" type="button" style="1px solid #1212df!important;">
                                    <a href="{{route('customer.auth.service-login', 'google')}}" style="color: #6C6C6C !important;"><i class="fa-brands fa-google" style="color: #1212df;"></i> Google </a>
                                  </button>
                                  <button class="btn btn-facebook" type="button">
                                   <a href="{{route('customer.auth.service-login', 'facebook')}}" style="color: #fff !important;"> <i class="fa-brands fa-facebook-f"></i> Facebook </a>
                                  </button>
                                  <button class="btn btn-email" type="button" style="color: #EB7F11 !important">
                                    <i class="fa-solid fa-envelope"></i>
                                   <a href="{{route('customer.auth.sign-up')}}"> Email</a>
                                  </button>
                                </div>
                                <p class="copyright">
                                  By continuing you agree to Malamal’s <a href="#">Terms of use</a> and <a href="#">Privacy policy</a>
                                </p>
                              </div>
                              
                              </form>
                              
                            </div>
                          </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    
    {{-- recaptcha scripts start --}}
    @if(isset($recaptcha) && $recaptcha['status'] == 1)
        <script type="text/javascript">
            var onloadCallback = function () {
                grecaptcha.render('recaptcha_element', {
                    'sitekey': '{{ \App\CPU\Helpers::get_business_settings('recaptcha')['site_key'] }}'
                });
            };
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async
                defer></script>
        <script>
            $("#form-id").on('submit', function (e) {
                var response = grecaptcha.getResponse();

                if (response.length === 0) {
                    e.preventDefault();
                    toastr.error("{{\App\CPU\translate('Please check the recaptcha')}}");
                }
            });
        </script>
    @else
        <script type="text/javascript">
            function re_captcha() {
                $url = "{{ URL('/customer/auth/code/captcha') }}";
                $url = $url + "/" + Math.random();
                document.getElementById('default_recaptcha_id').src = $url;
                console.log('url: '+ $url);
            }
        </script>
    @endif
    {{-- recaptcha scripts end --}}
@endpush
