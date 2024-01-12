@php($decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings'))
@foreach($products as $product)
    <div class="col-6 col-lg-3 mb-2 mr-1" style="height: auto;">
        @include('web-views.partials._single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
    </div>
@endforeach

<div class="col-12">
    <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation"
         id="paginator-ajax">
        {!! $products->links() !!}
    </nav>
</div>
