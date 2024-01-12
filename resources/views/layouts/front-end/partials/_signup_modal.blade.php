<!-- Sign Up Modal -->
<script>  
var matchPassword = function() {
  if (document.getElementById('password').value != document.getElementById('confirm_password').value) 
    {
      document.getElementById('message').style.color = 'red';
      document.getElementById('message').innerHTML = 'Password not matching';
    }
    else {
      document.getElementById('message').style.color = 'green';
      document.getElementById('message').innerHTML = 'Password matching';
  } 
}
</script>  
<div class="modal fade authModal" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
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
              <li>5. Rewards & Benefits for buyers</li>
            </ul>
          </div>
          <div class="auth-form sign-up">
            <div class="form-header">
              <span>Sign Up/ Register</span>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background:none!important;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="form-content text-center">
              <img class="vector" src="{{asset('/assets/frontend/img/illustration-signin.svg')}}" alt="siginin-illustration">
              <form action="{{route('customer.auth.sign-up')}}"  method="post">
                @csrf

              <div class="input-group">
                <input type="number" class="form-control phone" id="customer_phone" name="phone" placeholder="Phone number" value="{{ session('login_identity') }}" aria-label="phone" aria-describedby="phone-number" onkeypress="return validateNumber(event)">
              </div>
              <div class="input-group">
                <input type="text" class="form-control full-name" name="f_name" placeholder="Enter your first name" aria-label="full-name" aria-describedby="full-name" required>
              </div>
              <div class="input-group">
                <input type="text" class="form-control full-name" name="l_name" placeholder="Enter your last name" aria-label="full-name" aria-describedby="full-name" required>
              </div>
              <div class="input-group">
                <input type="email" class="form-control email" name="email" id="customer_email" placeholder="Enter your email address" aria-label="email" aria-describedby="email-address" value="">
              </div>
              <div class="input-group">
                <input type="password" class="form-control password" id="password" name="password" placeholder="Create your password" minlength="8" aria-label="password" aria-describedby="password" title="Must contain at least 8 or more characters" required>
              </div>
              <div class="input-group">
                <input type="password" class="form-control password" id="confirm_password" name="confirm_password" onkeyup="matchPassword()" placeholder="Confirm password" aria-label="password" aria-describedby="password" title="Must contain at least 8 or more characters" required>
              </div>
              <span id='message'></span>
              <div class="d-grid">
                <button class="btn btn-brand" type="submit">Continue</button>
              </div>
            </form>
              <p class="copyright">
                By continuing you agree to Malamal’s <a href="{{url('/terms')}}">Terms of use</a> and <a href="{{url('/privacy-policy')}}">Privacy policy</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>