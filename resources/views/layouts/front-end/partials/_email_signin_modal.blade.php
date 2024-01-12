
<style>
  
    #identity{
        height: 43px!important;
        border-color: #6C6C6C!important;
    }
    
    .j-close{
    background: none!important;
}

.separator {
    margin: 8px!important;
}

.j-opt-center{
    padding-bottom: 20px!important;
    padding: 15px 76px!important;
}

.j-opt-modal{
    max-width: 462px!important;
}
.j-google{
    background:#fff!important;
}

.j-span{
        padding: 10px 16px!important;
}


</style>
<!-- Modal -->
<div class="modal fade" id="emailSignInModal" tabindex="-1" aria-labelledby="emailSignInModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
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
                            <span>Login</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" style="display: none;"></button>
                            <button type="button" class="close j-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-content1 text-center">
                            <img class="vector" src="{{ asset('/assets/frontend/img/illustration-signin.svg') }}"
                                alt="siginin-illustration">
                            <form class="needs-validation mt-2" autocomplete="off" action="{{route('customer.auth.login')}}" method="post" id="email-signin-form-id">
                                @csrf
                                <div class="input-group">
                                  <input class="form-control" type="text" onkeyup="ValidateEmail();" name="user_id" id="si-email" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                    value="{{old('user_id')}}" placeholder="{{\App\CPU\translate('Enter_email_address')}}" aria-label="email" aria-describedby="email-address" required>
                                </div>
                                <span id="lblError" style="color: red"></span>
                                <div class="input-group" style="display:none" id="password_fild">
                                    <div class="password-toggle" style="width: 100%;">
                                        <input class="form-control" name="password" type="password" id="si-password" placeholder="{{\App\CPU\translate('Enter_password')}}"
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
                                  <button class="btn btn-brand" type="submit" style="display:none" id="sign-in-btn">{{\App\CPU\translate('sign_in')}}</button>
                                  
                                  <button type="button" onclick="email_verify()" class="btn btn-brand" id="continue_button" >Continue</button>

                                  <span class="separator">Or sign up with</span>
                                  <button class="btn btn-google" type="button" style="1px solid #1212df!important;">
                                    <a href="{{route('customer.auth.service-login', 'google')}}" style="color: #6C6C6C !important;display: block!important;padding: 6px!important;"><img src="{{ asset('/assets/front-end/img/google-btn.svg') }}" alt="google-icon"> Google </a>
                                  </button>
                                  <button class="btn btn-facebook" type="button">
                                   <a href="{{route('customer.auth.service-login', 'facebook')}}" style="color: #fff !important;"> <i class="fa-brands fa-facebook-f"></i> Facebook </a>
                                  </button>
                                  <button class="btn btn-email email_signup_required" type="button" style="color: #EB7F11 !important;display: block!important;padding: 6px!important;">
                                    <i class="fa-solid fa-envelope"></i> OTP Login
                                  </button>
                                </div>
                                <p class="copyright">
                                  By continuing you agree to Malamal’s <a href="{{url('/terms')}}">Terms of use</a> and <a href="{{url('/privacy-policy')}}">Privacy policy</a>
                                </p>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function ValidateEmail() {
            var email = document.getElementById("si-email").value;
            var lblError = document.getElementById("lblError");
            lblError.innerHTML = "";
            var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (!expr.test(email)) {
                lblError.innerHTML = "Invalid email address.";
                $('#continue_button').attr('disabled', 'disabled');
            }
            else{
                $('#continue_button').removeAttr('disabled');
            }
        }
        //send otp
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        function email_verify() {
            var user_id = $("input[name=user_id]").val();
            var _token = "{{ csrf_token() }}";
            //alert(identity);      
            $.ajax({
                type: 'POST',
                url: "{{ route('customer.auth.email-verify') }}",
                data: {
                    identity: user_id,
                    _token: _token
                },
                success: function(data) {
                    console.log(data.response);
                    if (data.response == "success") {
                        $('#password_fild').show();
                        $('#sign-in-btn').show();
                        $('#continue_button').hide();
                        
                    }
                    else{
                        toastr.error('{{ \App\CPU\translate('email_id_not_found') }}');
                        $('#emailSignInModal').modal('toggle');
                        $('#customer_email').val(user_id);
                         $("#customer_email").attr("disabled", "disabled");
                        $('#signUpModal').modal('show');
                    }

                }
            });
        }
    </script>  
    
</div>