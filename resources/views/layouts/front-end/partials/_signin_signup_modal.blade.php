
<!-- Modal -->
<div class="modal fade" id="signInSignUpModal" tabindex="-1" aria-labelledby="signInModal" aria-hidden="true">
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
                            <li>5. Rewards &amp; Benefits for buyers</li>
                        </ul>
                    </div>
                    <div class="auth-form sign-in">
                        <div class="form-header">
                            <span>Login/ Sign In</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-content text-center">
                            <img class="vector" src="{{ asset('/assets/frontend/img/illustration-signin.svg') }}"
                                alt="siginin-illustration">
                            <form>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" style="padding:20px">+880</span>
                                    <input class="form-control" id="identity" type="text" name="otp_phone"
                                        placeholder="{{ \App\CPU\translate('Enter_your_phone_number') }}" required>         
                                </div>
                                <span id="signup_otp_sent_msg" style="color:green;display:none">Check your phone.Login OTP sent</span>
                                <div class="form-group" id="signup_otp_show" style="display: none">
                                    <div class="col-md-12">
                                        <input class="form-control" id="user_otp" type="text" name="signup_otp_val"
                                            placeholder="{{ \App\CPU\translate('Enter_your_OTP') }}" required>
                                    </div>
                                    <div class="invalid-feedback">
                                        {{ \App\CPU\translate('please_provide_valid_OTP') }}
                                        .
                                    </div>
                                </div>
                                <span id="signup_error_msg" style="color:red;display:none">OTP do not match or account has been suspended.</span>
                                <div class="d-grid">
                                    <button type="button" onclick="login_signup_otp_send()" class="btn btn--primary btn-block btn-shadow"
                                        id="signup_otp_show_button">
                                        {{ \App\CPU\translate('SEND_OTP') }}
                                    </button>
                                    <button type="button" onclick="login_sign_up_otp_submit()" class="btn btn--primary btn-block btn-shadow"
                                        id="signup_submit_show_btn" style="display: none">
                                        {{ \App\CPU\translate('SUMBIT') }}
                                    </button>
                                    <span class="separator">Or sign up with</span>
                                    <button class="btn btn-google" type="button">
                                        <a href="{{route('customer.auth.service-login', 'google')}}" style="color: #6C6C6C !important;"><img src="{{ asset('/assets/front-end/img/google-btn.svg') }}" alt="google-icon"> Google </a>
                                    </button>
                                    <button class="btn btn-facebook" type="button">
                                        <i class="fa-brands fa-facebook-f"></i>
                                        Facebook
                                    </button>
                                    <button class="btn btn-email" type="button">
                                        <i class="fa-solid fa-envelope"></i>
                                        Email
                                    </button>
                                </div>
                            </form>
                            <p class="copyright">
                                By continuing you agree to Malamal’s <a href="#">Terms of use</a> and <a
                                    href="#">Privacy policy</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        //send otp
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        function login_signup_otp_send() {
            var identity = $("input[name=otp_phone]").val();
            var _token = "{{ csrf_token() }}";
            //alert(identity);      
            $.ajax({
                type: 'POST',
                url: "{{ route('customer.auth.login-otp') }}",
                data: {
                    identity: identity,
                    _token: _token
                },
                success: function(data) {
                    console.log(data.response);
                    if (data.response == "success") {
                        $('#signup_otp_show').css('display','block');
                        $('#signup_otp_show_button').css('display', 'none');
                        $('#signup_otp_sent_msg').css('display','block');
                        $('#signup_submit_show_btn').css('display', 'block');
                    }

                }
            });
        }
        //submit button
        function login_sign_up_otp_submit() {
            var identity = $("input[name=otp_phone]").val();
            var user_otp = $("input[name=signup_otp_val]").val();
            var _token = "{{ csrf_token() }}";
            $.ajax({
                type: 'POST',
                asnc: false,
                url: "{{route('customer.auth.login_for_signup_otp') }}",
                data: {
                    identity: identity,
                    user_otp: user_otp,
                    _token: _token
                },
                success: function(data) {
                    if (data.response == "success") {
                        setTimeout(function() { // wait for 1 secs(2)
                            location.replace(data.url)
                        }, 1000);
                        $('#signInSignUpModal').modal('toggle');
                    }
                    else
                    {
                        $('#signup_otp_sent_msg').css('display','none');
                        $('#signup_error_msg').css('display','block');
                    }

                }
            });
        }
    </script>
</div>
