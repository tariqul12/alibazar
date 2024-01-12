<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModal">{{ \App\CPU\translate('sign_in') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div align="center">
                        <img class="vector" src="{{ asset('/assets/frontend/img/illustration-signin.svg') }}">
                    </div>
                    <div class="form-group">
                        <label for="si-email">{{ \App\CPU\translate('phone_number') }}:</label>
                        <div class="col-md-12">
                            <input id="identity" type="text" class="form-control" name="identity"
                                value="{{ old('identity') }}"
                                placeholder="{{ \App\CPU\translate('Enter_your_phone_number') }}" required>
                        </div>
                        <div class="invalid-feedback">
                            {{ \App\CPU\translate('please_provide_valid_phone_number') }}
                            .
                        </div>
                    </div>
                    <div class="form-group" id="otp" style="display:none">
                        <label for="si-email">{{ \App\CPU\translate('OTP') }}:</label>
                        <div class="col-md-12">
                            <input id="user_otp" type="text" class="form-control" name="user_otp"
                                value="{{ old('user_otp') }}" placeholder="{{ \App\CPU\translate('Enter_your_OTP') }}"
                                required>
                        </div>
                        <div class="invalid-feedback">
                            {{ \App\CPU\translate('please_provide_valid_OTP') }}
                            .
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="col-md-12">
                            <button onclick="login_otp_send()" class="btn btn--primary btn-block btn-shadow"
                                id="otp_button">
                                {{ \App\CPU\translate('SEND_OTP') }}
                            </button>
                            <button class="btn btn--primary btn-block btn-shadow" id="submit_btn" style="display:none">
                                {{ \App\CPU\translate('SUMBIT') }}
                            </button>
                        </div>
                    </div>
                </form>
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
                var identity = $("input[name=identity]").val();
                var _token = "{{ csrf_token() }}";
                //alert(_token);      
                $.ajax({
                    type: 'POST',
                    url: "{{ route('customer.auth.login-otp') }}",
                    data: {
                        identity: identity,
                        _token: _token
                    },
                    success: function(data) {
                        if (data.response == "success") {
                            $('#otp').css('display', 'block');
                            $('#otp_button').css('display', 'none');
                            $('#submit_btn').css('display', 'block');
                        }

                    }
                });
            }
            //submit button
            $("#submit_btn").click(function(e) {
                e.preventDefault();
                var identity = $("input[name=identity]").val();
                var user_otp = $("input[name=user_otp]").val();
                var _token = "{{ csrf_token() }}";
                alert(user_otp);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('customer.auth.login_with_otp') }}",
                    data: {
                        identity: identity,
                        user_otp:user_otp,
                        _token: _token
                    },
                    success: function(data) {
                        console.log(data.response);
                        if (data.response == "success") {  
                            //location.reload(); 
                            
                        }

                    }
                });
            });
        </script>
    </div>
</div>
