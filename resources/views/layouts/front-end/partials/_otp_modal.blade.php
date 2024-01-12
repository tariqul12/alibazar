<style>
    .bg-none{
        background: none!important;
    }
   
</style>
<!-- OTP verify Modal -->
<div class="modal fade authModal" id="OTPModal" tabindex="-1" aria-labelledby="OTPModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered opt-modal">
        <div class="modal-content">
            <div class="modal-body">
                <div class="auth-content-wrapper">
                    <div class="auth-form verify-otp">
                        <div class="form-header">
                            <span>Login/ Register</span>
                            <button type="button" class="btn-close bg-none" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <button type="button" class="close bg-none" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-content text-center">
                            <img class="vector" src="{{ asset('/assets/frontend/img/otp_login.gif') }}"
                                alt="siginin-illustration">
                            <h5>OTP Verification</h5>
                            <p>Enter code sent to <span id="otp_phone"></span></p>
                            <input type="hidden" name="phone" value="{{ session('login_identity') }}">
                            <div class="input-group">
                                <input type="number" class="form-control" aria-label="otp" aria-describedby="otp-code" name="otp_val" placeholder="Enter Your OTP">
                            </div>
                            <div class="label">
                              <a id="countdown_show"> Expired in <span id="countdowntimer">180 </span> Seconds</a>
                              <a href="javascript:void(0)" style="color:orange;display:none" id="resend" >Resend Code</a>
                              <a href="javascript:void(0)" onclick="change_number()">Change Number</a>
                            </div>
                            <span id="invalid_msg" style="color:red;display:none">OTP do not match or account has been
                                    suspended.</span>
                            <div class="d-grid">
                                <button type="button" onclick="login_otp_submit()" class="btn btn-brand"
                                    id="submit_show_btn">Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function login_otp_submit() {
        var identity = $("input[name=phone]").val();
        var user_otp = $("input[name=otp_val]").val();
        var _token = "{{ csrf_token() }}";
        $.ajax({
            type: 'POST',
            asnc: false,
            url: "{{ route('customer.auth.login_with_otp') }}",
            data: {
                identity: identity,
                user_otp: user_otp,
                _token: _token
            },
            success: function(data) {
                console.log(data);
                if (data.response == "success") {
                    setTimeout(function() { // wait for 1 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                    $('#OTPModal').modal('toggle');
                } else if (data.response == "signup") {
                    $('#OTPModal').modal('toggle');
                    $('#customer_phone').val(identity); 
                    $("#customer_phone").attr("disabled", "disabled");
                    $('#signUpModal').modal('show');
                } else{
                    $('#invalid_msg').css('display', 'block');
                }

            }
        });
    }
    function change_number()
    {
        $('#signInModal').modal('show');
        $('#OTPModal').modal('toggle');
    }
    $('#resend').on('click',function(){
        $('#resend').hide();
        var timeleft = 180;
        var resend_num = $("input[name=phone]").val();
        var _token = "{{ csrf_token() }}";
        $.ajax({
            type: 'POST',
            asnc: false,
            url: "{{ route('customer.auth.resend_otp') }}",
            data: {
                _token: _token
            },
            success: function(data) {
                if (data.response == "success") {
                    var btnText = document.getElementById("otp_phone");
                    btnText.innerHTML = '+88'+resend_num; 
                    $('#OTPModal').modal('show'); 
                    var downloadTimer = setInterval(function(){
                    $('#resend').hide();
                    timeleft--;
                    console.log(timeleft);
                    document.getElementById("countdowntimer").textContent = timeleft;
                    $('#countdown_show').show();
                    if(timeleft <= 0)
                        clearInterval(downloadTimer);
                    },1000);
                    $('#resend').show();
                    $('#countdown_show').css('display', 'none');
                }
            }
        });
    })
</script>