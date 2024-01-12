@php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews))

<style>
    .quick-view{
        display: none;
        padding-bottom: 8px;
    }

    .quick-view , .single-product-details{
        background: #ffffff;
    }
    .product-single-hover:hover > .single-product-details {

        margin-top:-39px;
    }
    .product-single-hover:hover >  .quick-view{
        display: block;
    }
    

</style>

<div class="product-single-hover" >
    <div class=" inline_product clickable d-flex justify-content-center"
            style="cursor: pointer;background:{{$web_config['primary_color']}}10;">
        @if($product->discount > 0)
            <div class="d-flex" style="left:7px;top:2px;position: absolute">
                    <span class="for-discoutn-value p-1 pl-2 pr-2">
                    @if ($product->discount_type == 'percent')
                            {{round($product->discount,(!empty($decimal_point_settings) ? $decimal_point_settings: 0))}}%
                        @elseif($product->discount_type =='flat')
                            {{\App\CPU\Helpers::currency_converter($product->discount)}}
                        @endif
                        {{\App\CPU\translate('off')}}
                    </span>
            </div>
        @else
            <div class="d-flex justify-content-end for-dicount-div-null">
                <span class="for-discoutn-value-null"></span>
            </div>
        @endif
        <div class="d-flex d-block" style="cursor: pointer;">
            <a href="{{route('product',$product->slug)}}">
                <img src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                    onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'"
                    style="width: 100%;border-radius: 5px 5px 0px 0px;">
            </a>
        </div>
    </div>
    
    <div class="single-product-details">
        <div class="text-{{Session::get('direction') === "rtl" ? 'right pr-3' : 'left'}}">
            <a href="{{route('product',$product->slug)}}" class="j-product-title">
                {{ Str::limit($product['name']) }}
            </a>
            <p class="product-brand">BY VOLTAS</p>
        </div>
        
        <div class="product-card-footer">
            <div class="price-without-offer">
              <p>TK. 13980</p>
              <span>50% OFF !</span>
            </div>
            <div class="price-with-offer">
              <p>TK. 6000</p>
              <span>You save Rs 6000</span>
            </div>
        </div>
                  
        <div class="justify-content-between text-center">
            <div class="product-price text-center">
                @if($product->discount > 0)
                    <strike style="font-size: 12px!important;color: #E96A6A!important;">
                        {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                    </strike><br>
                @endif
                <span class="text-accent">
                    {{\App\CPU\Helpers::currency_converter(
                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                    )}}
                </span>
            </div>
        </div>

    </div>
    
    <div class="text-center quick-view" >
        @if(Request::is('product/*'))
            <a class="btn btn--primary btn-sm" href="{{route('product',$product->slug)}}">
                <i class="czi-forward align-middle {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                {{\App\CPU\translate('View')}}
            </a>
        @else
            <a class="btn btn--primary btn-sm"
            style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;" href="javascript:"
               onclick="quickView('{{$product->id}}')">
                <i class="czi-eye align-middle {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                {{\App\CPU\translate('Quick')}}   {{\App\CPU\translate('View')}}
            </a>
            <a class="btn btn--primary btn-sm"
            style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;" href="javascript:"
               onclick="quickView('{{$product->id}}')">
                <i class="czi-eye align-middle {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                {{\App\CPU\translate('Quick')}}   {{\App\CPU\translate('View')}}
            </a>
        @endif
    </div>
</div>

