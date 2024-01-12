<!-- Modal -->
<div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-sm modal-dialog-centered jn-modal">
        <div class="modal-content">

            <div class="modal-body">
                <div class="auth-content-wrapper">
                    <div class="intro">
                        <h3>Welcome User!</h3>
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
                            <span>Login / Register</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" style="display: none;"></button>
                            <button type="button" class="close j-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-content1 text-center">
                            <img class="vector" src="{{ asset('/assets/frontend/img/illustration-signin.svg') }}"
                                alt="siginin-illustration">
                            <form>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text j-span" style="padding:20px;background-color: #fff;">+88</span>
                                    <input class="form-control" id="identity" type="text" onkeypress="return validateNumber(event)" name="phone"
                                        placeholder="{{ \App\CPU\translate('Enter_your_phone_number') }}" required>         
                                </div>
                                <span id="otp_sent_msg" style="color:green;display:none">Check your phone.Login OTP sent</span>
                                <div class="d-grid">
                                    <button type="button" onclick="login_otp_send()" class="btn btn--primary btn-block btn-shadow"
                                        id="otp_show_button">
                                        {{ \App\CPU\translate('SEND_OTP') }}
                                    </button>
                                    <span class="separator">Or sign up with</span>
                                    <button class="btn btn-google j-google" type="button"> 
                                        <a href="{{route('customer.auth.service-login', 'google')}}" style="color: #6C6C6C !important;"><img src="{{ asset('/assets/front-end/img/google-btn.svg') }}" alt="google-icon"> Google </a>
                                    </button>
                                    <button class="btn btn-facebook" type="button">
                                        <a href="{{route('customer.auth.service-login', 'facebook')}}" style="color: #fff !important;"> <i class="fa-brands fa-facebook-f"></i> Facebook </a>
                                    </button>
                                    <button class="btn btn-email email_signin_required" type="button">
                                        <i class="fa-solid fa-envelope"></i> Email
                                    </button>
                                </div>
                            </form>
                            <p class="copyright">
                                By continuing you agree to Malamal’s <a href="{{url('/terms')}}">Terms of use</a> and <a
                                    href="{{url('/privacy-policy')}}">Privacy policy</a>
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

        function login_otp_send() {
            var identity = $("input[name=phone]").val();
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
                        // $('#otp_show').css('display','block');
                        // $('#otp_show_button').css('display', 'none');
                        // $('#otp_sent_msg').css('display','block');
                        // $('#submit_show_btn').css('display', 'block');
                        $('#signInModal').modal('toggle');
                        var btnText = document.getElementById("otp_phone");
                        btnText.innerHTML = '+88'+identity; 
                        $('#OTPModal').modal('show');
                        var timeleft = 180;
                        var downloadTimer = setInterval(function(){
                        timeleft--;
                        document.getElementById("countdowntimer").textContent = timeleft;
                        if(timeleft <= 0)
                        {
                            clearInterval(downloadTimer);
                            console.log(timeleft);
                            $('#resend').show();
                            $('#countdown_show').css('display', 'none');
                        }   
                        },1000);
                    }

                }
            });
        }
    </script>
</div>
