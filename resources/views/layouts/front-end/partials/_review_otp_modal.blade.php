<style>
    .bg-none{
        background: none!important;
    }
   
</style>
<!-- OTP verify Modal -->
<div class="modal fade authModal" id="ReviewOtpModal" tabindex="-1" aria-labelledby="OTPModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered opt-modal" style="width: 353px;">
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
                            <p>Enter code sent to <span id="review_otp_phone"></span></p>
                            <input type="hidden" name="review_phone" value="{{ session('review_phone') }}">
                            <div class="input-group">
                                <input type="number" class="form-control" aria-label="otp" aria-describedby="otp-code" name="review_otp" placeholder="Enter Your OTP">
                            </div>
                            <div class="label">
                                <a id="review_countdown_show"> Expired in <span id="reviewcountdowntimer">180 </span> Seconds</a>
                                <a href="javascript:void(0)" style="color:orange;display:none" id="review_resend" >Resend Code</a>
                                <a href="javascript:void(0)" onclick="review_change_number()">Change Number</a>
                            </div>
                            <div class="invalid-feedback">
                                <span id="error_msg" style="color:red;display:none">OTP do not match or account has been
                                    suspended.</span>
                            </div>
                            <div class="d-grid">
                                <button type="button" onclick="review_otp_submit()" class="btn btn-brand"
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
    function review_otp_submit() {
        var identity = $("input[name=review_phone]").val();
        var user_otp = $("input[name=review_otp]").val();
        var _token = "{{ csrf_token() }}";
        $.ajax({
            type: 'POST',
            asnc: false,
            url: "{{ route('customer.auth.review_login_submit') }}",
            data: {
                identity: identity,
                user_otp: user_otp,
                _token: _token
            },
            success: function(data) {
                console.log(data);
                if (data.response == "success") {
                    setTimeout(function() { // wait for 1 secs(2)
                        location.replace(data.url)
                    }, 1000);
                    $('#ReviewOtpModal').modal('toggle');
                } 
            }
        });
    }
    function review_change_number()
    {
        $('#ReviewOtpModal').modal('toggle');
        $('#signInModal').modal('show');
        
    }
    $('#review_resend').on('click',function(){
        $('#review_resend').hide();
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
                    $('#ReviewOtpModal').modal('show'); 
                    var downloadTimer = setInterval(function(){
                    $('#review_resend').hide();
                    timeleft--;
                    console.log(timeleft);
                    document.getElementById("reviewcountdowntimer").textContent = timeleft;
                    $('#review_countdown_show').show();
                    if(timeleft <= 0)
                        clearInterval(downloadTimer);
                    },1000);
                    $('#review_resend').show();
                    $('#review_countdown_show').css('display', 'none');
                }
            }
        });
    })
</script>
