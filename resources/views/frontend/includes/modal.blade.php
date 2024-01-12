<!-- Sign in Modal -->
<div class="modal fade authModal" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
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
                    <div class="auth-form sign-in">
                        <div class="form-header">
                            <span>Login/ Sign In</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="form-content text-center">
                            <img class="vector" src="{!! asset('public/assets/frontend/img/illustration-signin.svg') !!}" alt="siginin-illustration">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text">+880</span>
                                <input type="number" class="form-control" placeholder="Enter your phone number" aria-label="phone" aria-describedby="phone-number">
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-brand" type="button">Request OTP</button>
                                <span class="separator">Or sign up with</span>
                                <button class="btn btn-google" type="button">
                                    <img src="{!! asset('public/assets/frontend/img/icons/btn/google-btn.svg') !!}" alt="google-icon">
                                    Google
                                </button>
                                <button class="btn btn-facebook" type="button">
                                    <img src="{!! asset('public/assets/frontend/img/icons/btn/facebook-btn.svg') !!}" alt="facebook-icon">
                                    Facebook
                                </button>
                                <button class="btn btn-email" type="button">
                                    <img src="{!! asset('public/assets/frontend/img/icons/btn/email-btn.svg') !!}" alt="email-icon">
                                    Email
                                </button>
                            </div>
                            <p class="copyright">
                                By continuing you agree to Malamal’s <a href="#">Terms of use</a> and <a href="#">Privacy policy</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sign Up Modal -->
<div class="modal fade authModal" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="form-content text-center">
                            <img class="vector" src="{!! asset('public/assets/frontend/img/illustration-signin.svg') !!}" alt="siginin-illustration">
                            <div class="input-group">
                                <input type="email" class="form-control email" placeholder="Enter your email address" aria-label="email" aria-describedby="email-address">
                            </div>
                            <div class="input-group">
                                <input type="password" class="form-control password" placeholder="Create your password" aria-label="password" aria-describedby="password">
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control full-name" placeholder="Enter your full name" aria-label="full-name" aria-describedby="full-name">
                            </div>
                            <div class="input-group">
                                <input type="number" class="form-control phone" placeholder="Phone number" aria-label="phone" aria-describedby="phone-number">
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control company" placeholder="Company name (optional)" aria-label="company" aria-describedby="company-name">
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-brand" type="button">Continue</button>
                            </div>
                            <p class="copyright">
                                By continuing you agree to Malamal’s <a href="#">Terms of use</a> and <a href="#">Privacy policy</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- OTP verify Modal -->
<div class="modal fade authModal" id="OTPModal" tabindex="-1" aria-labelledby="OTPModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="auth-content-wrapper">
                    <div class="auth-form verify-otp">
                        <div class="form-header">
                            <span>Login/ Register</span>
                        </div>
                        <div class="form-content text-center">
                            <img class="vector" src="{!! asset('public/assets/frontend/img/illustration-signin.svg') !!}" alt="siginin-illustration">
                            <h5>OTP Verification</h5>
                            <p>Enter code sent to <span>+917994616825</span></p>
                            <div class="input-group">
                                <input type="number" class="form-control" aria-label="otp" aria-describedby="otp-code">
                            </div>
                            <div class="label">
                                <a href="#">Resend Code</a>
                                <a href="#">Change Number</a>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-brand" type="button">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Item removal modal -->
<div class="modal fade" id="itemRemoveModal" tabindex="-1" aria-labelledby="itemRemoveModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="item-remove-confirmation">
                    <h5>Remove item</h5>
                    <p>Are you sure you want to remove this item?</p>
                    <p class="action text-center">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Remove</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
