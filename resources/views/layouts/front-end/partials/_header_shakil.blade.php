<header>
    <div class="minimal-header">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-12 text-end">
                    <ul class="social">
                        <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/social/facebook.svg') !!}" alt="facebook-icon"></a></li>
                        <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/social/youtube.svg') !!}" alt="youtube-icon"></a></li>
                        <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/social/whatsapp.svg') !!}" alt="whatsapp-icon"></a></li>
                        <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/social/skype.svg') !!}" alt="skype-icon"></a></li>
                        <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/social/linkedin.svg') !!}" alt="linkedin-icon"></a></li>
                        <li><a href="#"><img src="{!! asset('public/assets/frontend/img/icons/social/twitter.svg') !!}" alt="twitter-icon"></a></li>
                    </ul>
                    <p class="query">
                        <span>For any query, email us at <a href="mailto:care info @malamal.xyz">care info @malamal.xyz</a> or</span>
                        call us on <a href="tel:+8801972525821">+8801972525821</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-3 burger-menu-container">
                    <button id="burger-menu">
                        <img src="{!! asset('public/assets/frontend/img/icons/burger-menu-icon.svg') !!}" alt="burger-menu-icon">
                    </button>
                    <div class="nav-drawer-wrapper">
                        <div class="nav-drawer">
                            <ul class="nav nav-tabs justify-content-center" id="drawerTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="category" aria-selected="true">Dashboard</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="product-category-tab" data-bs-toggle="tab" data-bs-target="#product-category" type="button" role="tab" aria-controls="brand" aria-selected="false">Category</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="drawerTabContent">
                                <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="category-tab">
                                    <ul class="nav">
                                        <li>
                                            <a href="#" class="active">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.6 7C8.2 6.9 7.8 6.7 7.5 6.4C7.2 6.3 7.1 6 7.1 5.8C7.1 5.6 7.2 5.3 7.4 5.2C7.7 5 8 4.8 8.3 4.9C8.9 4.9 9.4 5.2 9.7 5.6L10.6 4.4C10.3 4.1 10 3.9 9.7 3.7C9.4 3.5 9 3.4 8.6 3.4V2H7.4V3.4C6.9 3.5 6.4 3.8 6 4.2C5.6 4.7 5.3 5.3 5.4 5.9C5.4 6.5 5.6 7.1 6 7.5C6.5 8 7.2 8.3 7.8 8.6C8.1 8.7 8.5 8.9 8.8 9.1C9 9.3 9.1 9.6 9.1 9.9C9.1 10.2 9 10.5 8.8 10.8C8.5 11.1 8.1 11.2 7.8 11.2C7.4 11.2 6.9 11.1 6.6 10.8C6.3 10.6 6 10.3 5.8 10L4.8 11.1C5.1 11.5 5.4 11.8 5.8 12.1C6.3 12.4 6.9 12.7 7.5 12.7V14H8.6V12.5C9.2 12.4 9.7 12.1 10.1 11.7C10.6 11.2 10.9 10.4 10.9 9.7C10.9 9.1 10.7 8.4 10.2 8C9.7 7.5 9.2 7.2 8.6 7ZM8 0C3.6 0 0 3.6 0 8C0 12.4 3.6 16 8 16C12.4 16 16 12.4 16 8C16 3.6 12.4 0 8 0ZM8 14.9C4.2 14.9 1.1 11.8 1.1 8C1.1 4.2 4.2 1.1 8 1.1C11.8 1.1 14.9 4.2 14.9 8C14.9 11.8 11.8 14.9 8 14.9Z" fill="white"/>
                                                </svg> Quotation
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#signInModal">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.0003 1.6665C5.39783 1.6665 1.66699 5.39734 1.66699 9.99984C1.66699 14.6023 5.39783 18.3332 10.0003 18.3332C14.6028 18.3332 18.3337 14.6023 18.3337 9.99984C18.3337 5.39734 14.6028 1.6665 10.0003 1.6665Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M3.55957 15.2883C3.55957 15.2883 5.41707 12.9167 10.0004 12.9167C14.5837 12.9167 16.4421 15.2883 16.4421 15.2883M10.0004 10C10.6634 10 11.2993 9.73661 11.7682 9.26777C12.237 8.79893 12.5004 8.16304 12.5004 7.5C12.5004 6.83696 12.237 6.20107 11.7682 5.73223C11.2993 5.26339 10.6634 5 10.0004 5C9.33736 5 8.70148 5.26339 8.23264 5.73223C7.7638 6.20107 7.5004 6.83696 7.5004 7.5C7.5004 8.16304 7.7638 8.79893 8.23264 9.26777C8.70148 9.73661 9.33736 10 10.0004 10V10Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg> Sign in
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal">
                                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2.86951 2.8069C4.23029 1.44612 6.07591 0.681641 8.00034 0.681641C9.92478 0.681641 11.7704 1.44612 13.1312 2.8069C14.492 4.16768 15.2564 6.0133 15.2564 7.93773C15.2564 9.86217 14.492 11.7078 13.1312 13.0686L12.142 14.0469C11.4128 14.7619 10.467 15.6819 9.30368 16.8069C8.95403 17.145 8.4867 17.334 8.00034 17.334C7.51398 17.334 7.04665 17.145 6.69701 16.8069L3.78784 13.9769C3.42201 13.6177 3.11618 13.3152 2.86951 13.0686C2.19569 12.3948 1.66118 11.5949 1.29651 10.7145C0.931836 9.83419 0.744141 8.89063 0.744141 7.93773C0.744141 6.98484 0.931836 6.04128 1.29651 5.16093C1.66118 4.28057 2.19569 3.48067 2.86951 2.8069V2.8069ZM12.247 3.69023C11.1205 2.56395 9.59272 1.9313 7.99975 1.93145C6.40679 1.93161 4.87913 2.56456 3.75284 3.69107C2.62656 4.81757 1.9939 6.34536 1.99406 7.93832C1.99422 9.53129 2.62717 11.0589 3.75368 12.1852L4.99201 13.4086C5.84741 14.2443 6.70519 15.0777 7.56534 15.9086C7.6819 16.0213 7.83774 16.0844 7.99993 16.0844C8.16211 16.0844 8.31795 16.0213 8.43451 15.9086L11.2628 13.1586C11.6545 12.7744 11.982 12.4502 12.2462 12.1852C13.3724 11.0589 14.0051 9.53136 14.0051 7.93857C14.0051 6.34577 13.3724 4.81821 12.2462 3.6919L12.247 3.69023ZM8.00034 5.66607C8.32887 5.66607 8.65417 5.73078 8.95769 5.8565C9.26121 5.98222 9.53699 6.16649 9.76929 6.39879C10.0016 6.63109 10.1859 6.90687 10.3116 7.21039C10.4373 7.5139 10.502 7.83921 10.502 8.16773C10.502 8.49626 10.4373 8.82156 10.3116 9.12508C10.1859 9.4286 10.0016 9.70438 9.76929 9.93668C9.53699 10.169 9.26121 10.3533 8.95769 10.479C8.65417 10.6047 8.32887 10.6694 8.00034 10.6694C7.34488 10.6574 6.7203 10.3887 6.26099 9.92088C5.80167 9.45311 5.54433 8.82373 5.54433 8.16815C5.54433 7.51258 5.80167 6.88319 6.26099 6.41542C6.7203 5.94765 7.34488 5.67887 8.00034 5.6669V5.66607ZM8.00034 6.91607C7.83597 6.91607 7.67321 6.94844 7.52135 7.01134C7.36949 7.07425 7.23151 7.16644 7.11528 7.28267C6.99905 7.3989 6.90686 7.53688 6.84395 7.68874C6.78105 7.8406 6.74868 8.00336 6.74868 8.16773C6.74868 8.33211 6.78105 8.49487 6.84395 8.64673C6.90686 8.79859 6.99905 8.93657 7.11528 9.0528C7.23151 9.16902 7.36949 9.26122 7.52135 9.32412C7.67321 9.38703 7.83597 9.4194 8.00034 9.4194C8.3322 9.4194 8.65046 9.28757 8.88511 9.05292C9.11977 8.81826 9.25159 8.5 9.25159 8.16815C9.25159 7.8363 9.11977 7.51804 8.88511 7.28338C8.65046 7.04873 8.3322 6.9169 8.00034 6.9169V6.91607Z" fill="white"/>
                                                </svg> Track Order
                                            </a>
                                        </li>
                                        <li>
                                            

                                            <div id="cart_items">
                                                @include('layouts.front-end.partials.cart')
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="product-category" role="tabpanel" aria-labelledby="brand-tab">
                                    <div class="category-bar">
                                        <div class="category">
                                            <img src="{!! asset('public/assets/frontend/img/category-1.png') !!}" alt="category-image">
                                            <p class="category-title">Air Cooler</p>
                                        </div>
                                        <div class="category">
                                            <img src="{!! asset('public/assets/frontend/img/category-1.png') !!}" alt="category-image">
                                            <p class="category-title">Air Cooler</p>
                                        </div>
                                        <div class="category">
                                            <img src="{!! asset('public/assets/frontend/img/category-1.png') !!}" alt="category-image">
                                            <p class="category-title">Air Cooler</p>
                                        </div>
                                        <div class="category">
                                            <img src="{!! asset('public/assets/frontend/img/category-1.png') !!}" alt="category-image">
                                            <p class="category-title">Air Cooler</p>
                                        </div>
                                        <div class="category">
                                            <img src="{!! asset('public/assets/frontend/img/category-1.png') !!}" alt="category-image">
                                            <p class="category-title">Air Cooler</p>
                                        </div>
                                        <div class="category">
                                            <img src="{!! asset('public/assets/frontend/img/category-1.png') !!}" alt="category-image">
                                            <p class="category-title">Air Cooler</p>
                                        </div>
                                        <div class="category">
                                            <img src="{!! asset('public/assets/frontend/img/category-1.png') !!}" alt="category-image">
                                            <p class="category-title">Air Cooler</p>
                                        </div>
                                        <div class="category">
                                            <img src="{!! asset('public/assets/frontend/img/category-1.png') !!}" alt="category-image">
                                            <p class="category-title">Air Cooler</p>
                                        </div>
                                        <div class="category">
                                            <img src="{!! asset('public/assets/frontend/img/category-1.png') !!}" alt="category-image">
                                            <p class="category-title">Air Cooler</p>
                                        </div>
                                        <div class="category">
                                            <img src="{!! asset('public/assets/frontend/img/category-1.png') !!}" alt="category-image">
                                            <p class="category-title">Air Cooler</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 logo-wrapper">
                    <a href="index.html">
                        <img class="logo" src="{!! asset('public/assets/frontend/img/logo.svg') !!}" alt="logo">
                    </a>
                </div>
                <div class="col-5 search-bar">
                    <div class="input-group">
                        <button
                            class="btn btn-outline-secondary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            All Categories
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                        </ul>
                        <input
                            type="text"
                            class="form-control"
                            aria-label="Text input with dropdown button"
                            placeholder="Search for your product here">
                    </div>
                </div>
                <div class="col-4 desktop-nav text-end">
                    <ul class="nav">
                        <li>
                            <a href="#" class="active">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.6 7C8.2 6.9 7.8 6.7 7.5 6.4C7.2 6.3 7.1 6 7.1 5.8C7.1 5.6 7.2 5.3 7.4 5.2C7.7 5 8 4.8 8.3 4.9C8.9 4.9 9.4 5.2 9.7 5.6L10.6 4.4C10.3 4.1 10 3.9 9.7 3.7C9.4 3.5 9 3.4 8.6 3.4V2H7.4V3.4C6.9 3.5 6.4 3.8 6 4.2C5.6 4.7 5.3 5.3 5.4 5.9C5.4 6.5 5.6 7.1 6 7.5C6.5 8 7.2 8.3 7.8 8.6C8.1 8.7 8.5 8.9 8.8 9.1C9 9.3 9.1 9.6 9.1 9.9C9.1 10.2 9 10.5 8.8 10.8C8.5 11.1 8.1 11.2 7.8 11.2C7.4 11.2 6.9 11.1 6.6 10.8C6.3 10.6 6 10.3 5.8 10L4.8 11.1C5.1 11.5 5.4 11.8 5.8 12.1C6.3 12.4 6.9 12.7 7.5 12.7V14H8.6V12.5C9.2 12.4 9.7 12.1 10.1 11.7C10.6 11.2 10.9 10.4 10.9 9.7C10.9 9.1 10.7 8.4 10.2 8C9.7 7.5 9.2 7.2 8.6 7ZM8 0C3.6 0 0 3.6 0 8C0 12.4 3.6 16 8 16C12.4 16 16 12.4 16 8C16 3.6 12.4 0 8 0ZM8 14.9C4.2 14.9 1.1 11.8 1.1 8C1.1 4.2 4.2 1.1 8 1.1C11.8 1.1 14.9 4.2 14.9 8C14.9 11.8 11.8 14.9 8 14.9Z" fill="white"/>
                                </svg> Quotation
                            </a>
                        </li>
                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#signInModal">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.0003 1.6665C5.39783 1.6665 1.66699 5.39734 1.66699 9.99984C1.66699 14.6023 5.39783 18.3332 10.0003 18.3332C14.6028 18.3332 18.3337 14.6023 18.3337 9.99984C18.3337 5.39734 14.6028 1.6665 10.0003 1.6665Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3.55957 15.2883C3.55957 15.2883 5.41707 12.9167 10.0004 12.9167C14.5837 12.9167 16.4421 15.2883 16.4421 15.2883M10.0004 10C10.6634 10 11.2993 9.73661 11.7682 9.26777C12.237 8.79893 12.5004 8.16304 12.5004 7.5C12.5004 6.83696 12.237 6.20107 11.7682 5.73223C11.2993 5.26339 10.6634 5 10.0004 5C9.33736 5 8.70148 5.26339 8.23264 5.73223C7.7638 6.20107 7.5004 6.83696 7.5004 7.5C7.5004 8.16304 7.7638 8.79893 8.23264 9.26777C8.70148 9.73661 9.33736 10 10.0004 10V10Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg> Sign in
                            </a>
                        </li>
                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal">
                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.86951 2.8069C4.23029 1.44612 6.07591 0.681641 8.00034 0.681641C9.92478 0.681641 11.7704 1.44612 13.1312 2.8069C14.492 4.16768 15.2564 6.0133 15.2564 7.93773C15.2564 9.86217 14.492 11.7078 13.1312 13.0686L12.142 14.0469C11.4128 14.7619 10.467 15.6819 9.30368 16.8069C8.95403 17.145 8.4867 17.334 8.00034 17.334C7.51398 17.334 7.04665 17.145 6.69701 16.8069L3.78784 13.9769C3.42201 13.6177 3.11618 13.3152 2.86951 13.0686C2.19569 12.3948 1.66118 11.5949 1.29651 10.7145C0.931836 9.83419 0.744141 8.89063 0.744141 7.93773C0.744141 6.98484 0.931836 6.04128 1.29651 5.16093C1.66118 4.28057 2.19569 3.48067 2.86951 2.8069V2.8069ZM12.247 3.69023C11.1205 2.56395 9.59272 1.9313 7.99975 1.93145C6.40679 1.93161 4.87913 2.56456 3.75284 3.69107C2.62656 4.81757 1.9939 6.34536 1.99406 7.93832C1.99422 9.53129 2.62717 11.0589 3.75368 12.1852L4.99201 13.4086C5.84741 14.2443 6.70519 15.0777 7.56534 15.9086C7.6819 16.0213 7.83774 16.0844 7.99993 16.0844C8.16211 16.0844 8.31795 16.0213 8.43451 15.9086L11.2628 13.1586C11.6545 12.7744 11.982 12.4502 12.2462 12.1852C13.3724 11.0589 14.0051 9.53136 14.0051 7.93857C14.0051 6.34577 13.3724 4.81821 12.2462 3.6919L12.247 3.69023ZM8.00034 5.66607C8.32887 5.66607 8.65417 5.73078 8.95769 5.8565C9.26121 5.98222 9.53699 6.16649 9.76929 6.39879C10.0016 6.63109 10.1859 6.90687 10.3116 7.21039C10.4373 7.5139 10.502 7.83921 10.502 8.16773C10.502 8.49626 10.4373 8.82156 10.3116 9.12508C10.1859 9.4286 10.0016 9.70438 9.76929 9.93668C9.53699 10.169 9.26121 10.3533 8.95769 10.479C8.65417 10.6047 8.32887 10.6694 8.00034 10.6694C7.34488 10.6574 6.7203 10.3887 6.26099 9.92088C5.80167 9.45311 5.54433 8.82373 5.54433 8.16815C5.54433 7.51258 5.80167 6.88319 6.26099 6.41542C6.7203 5.94765 7.34488 5.67887 8.00034 5.6669V5.66607ZM8.00034 6.91607C7.83597 6.91607 7.67321 6.94844 7.52135 7.01134C7.36949 7.07425 7.23151 7.16644 7.11528 7.28267C6.99905 7.3989 6.90686 7.53688 6.84395 7.68874C6.78105 7.8406 6.74868 8.00336 6.74868 8.16773C6.74868 8.33211 6.78105 8.49487 6.84395 8.64673C6.90686 8.79859 6.99905 8.93657 7.11528 9.0528C7.23151 9.16902 7.36949 9.26122 7.52135 9.32412C7.67321 9.38703 7.83597 9.4194 8.00034 9.4194C8.3322 9.4194 8.65046 9.28757 8.88511 9.05292C9.11977 8.81826 9.25159 8.5 9.25159 8.16815C9.25159 7.8363 9.11977 7.51804 8.88511 7.28338C8.65046 7.04873 8.3322 6.9169 8.00034 6.9169V6.91607Z" fill="white"/>
                                </svg> Track Order
                            </a>
                        </li>
                        <li class="cart-menu">
                            <div id="cart_items">
                                @include('layouts.front-end.partials.cart')
                            </div>
                            <div class="cart-item-list">
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-3 mobile-search text-end">
                    <button>
                        <img src="{!! asset('public/assets/frontend/img/icons/mobile-search.svg') !!}" alt="mobile-search-icon">
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
function myFunction() {
  $('#anouncement').addClass('d-none').removeClass('d-flex')
}
</script>