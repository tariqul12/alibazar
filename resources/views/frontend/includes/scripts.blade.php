<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
<script src="{!! asset('public/assets/frontend/lib/jquery/jquery-3.6.1.min.js') !!}"></script>
<script src="{!! asset('public/assets/frontend/lib/owlcarousel/owl.carousel.min.js') !!}"></script>
<script type="text/javascript">
    $(document).ready(function () {

        // hamburger menu control functions
        $('#burger-menu').on('click', function() {
            $(this).closest('div').find('.nav-drawer-wrapper').css({ right: '0'});
            $('body').css({ overflow: 'hidden' })
        });
        $('.nav-drawer-wrapper').on('click', function() {
            $(this).css({ right: '100%'});
            $('body').css({ overflow: 'auto' })
        });
        $('.nav-drawer').on('click', function(event) {
            event.stopPropagation();
        });
        // hamburger menu control functions end

        $(".brand-carousel").owlCarousel({
            nav: true,
            navText: ['', ''],
            // navElement: [],
            dots: false,
            loop: true,
            items: 3,
            margin: 40,
            stagePadding: 40,
            responsive: {
                0: {
                    items: 1,
                },
                991: {
                    items: 3,
                },
            }
        });
        $(".main-banner").owlCarousel({
            nav: true,
            navText: ['', ''],
            // navElement: [],
            dots: false,
            loop: true,
            items: 1,
        });
        // handles product plus minus spinbutton
        $('.spinbutton-wrapper').find('button').on('click', function() {
            let elem = $(this).closest('.spinbutton').find('.val')[0];
            let elemType = $(this).closest('.spinbutton').find('.val')[0].tagName;
            let value = elemType === 'INPUT' ? elem.value : elem.innerText;
            if (elemType === 'INPUT') {
                $(elem).val(Number(value) + ($(this).hasClass('plus') ? 1 : Number(value) === 1 ? 0 : -1));
            }
            if (elemType === 'SPAN') {
                $(elem).text(Number(value) + ($(this).hasClass('plus') ? 1 : Number(value) === 1 ? 0 : -1));
            }
        });

        // add or remove items to header cart
        $('.add-to-cart').on('click', function () {
            const cartItemCountText = $('.cart-item-count').find('span')[0].innerText.split('');
            let itemCount = (cartItemCountText.length > 1 ? Number(cartItemCountText[1]) : 0) + 1
            const productName = $(this).closest('.product-card').find('.product-title')[0].innerText
            const productImagePath = $(this).closest('.product-card').find('img.product-image').attr('src')
            const cartItemDOM = `<div class="cart-item">
          <div class="cart-item-details">
            <img src="${productImagePath}" alt="">
            <p class="name">${productName}</p>
          </div>
          <p>is added to your cart</p>
          <p class="view"><a href="{!! route('frontend.shop_cart') !!}">View Cart</a></p>
        </div>`;
            $('.cart-item-list').html('').html(cartItemDOM).fadeIn();
            $('.cart-item-count').find('span').text(`(${itemCount})`);
            setTimeout(function() {
                $('.cart-item-list').fadeOut();
            }, 4000)
        });
    });
</script>
