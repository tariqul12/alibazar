<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('admin/business-settings/web-config') ?'active':'' }}"><a href="{{route('admin.business-settings.web-config.index')}}">{{\App\CPU\translate('general')}}</a></li>
        <li class="{{ Request::is('admin/product-settings/inhouse-shop') ?'active':'' }}"><a href="{{ route('admin.product-settings.inhouse-shop') }}">{{\App\CPU\translate('In-House_Shop')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/seller-settings') ?'active':'' }}"><a href="{{route('admin.business-settings.seller-settings.index')}}">{{\App\CPU\translate('Seller')}}</a></li>
        <li class="{{ Request::is('admin/customer/customer-settings') ?'active':'' }}"><a href="{{route('admin.customer.customer-settings')}}">{{\App\CPU\translate('Customer')}}</a></li>
        <li class="{{ Request::is('admin/refund-section/refund-index') ?'active':'' }}"><a href="{{route('admin.refund-section.refund-index')}}">{{\App\CPU\translate('Refund')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/shipping-method/setting') ?'active':'' }}"><a href="{{route('admin.business-settings.shipping-method.setting')}}">{{\App\CPU\translate('Shipping_Method')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/order-settings/index') ?'active':'' }}"><a href="{{route('admin.business-settings.order-settings.index')}}">{{\App\CPU\translate('Order')}}</a></li>
        <li class="{{ Request::is('admin/product-settings') ?'active':'' }}"><a href="{{ route('admin.product-settings.index') }}">{{\App\CPU\translate('Product')}}</a></li>
        <li class="{{ Request::is('admin/others-settings') ?'active':'' }}"><a href="{{ route('admin.others-settings.index') }}">{{\App\CPU\translate('Others Settings')}}</a></li>
    </ul>
</div>
