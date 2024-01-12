@php
$customer_id=auth('customer')->id();
$sold_out=0;
if (($product->product_type== 'physical') && ($product->current_stock ==0)) {
    $sold_out=1;
}


@endphp
<div class="product-card">
    <div class="product-card-body">
        <div class="p-img">
            @if($sold_out==1)
            <div class="sold-out">
                <p>Sold Out</p>
            </div>
            @endif
        <img src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
             onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'" alt="product-image" class="product-image" >            
        </div>
        <h5 class="product-title">{{ Str::limit($product['name'], 50) }}</h5>
        <p class="product-brand">By {!! $product->brand->name ?? ''  !!}</p>
    </div>

    <div class="product-card-footer">
        <div class="price-without-offer">
            <p class="dis-p"> @if($product->discount > 0)
                    <strike>
                        {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                    </strike>
                @endif
            </p>
            
            <p class="main-p"> {{\App\CPU\Helpers::currency_converter(
                $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
            )}}</p>
            
           

        </div>
        
        <div class="price-with-offer">
             @if($product->discount > 0)
                <span>
                @if ($product->discount_type == 'percent')
                        {{round($product->discount,(!empty($decimal_point_settings) ? $decimal_point_settings: 0))}}%
                    @elseif($product->discount_type =='flat')                        
                        {{round((($product->discount*100)/$product->unit_price),(!empty($decimal_point_settings) ? $decimal_point_settings: 0))}}%
                    @endif
                    {{\App\CPU\translate('off')}}
                </span>
            @endif
            
            
            @php($discountPrice = $product->unit_price - \App\CPU\Helpers::get_product_discount($product,$product->unit_price))
            
            @if($product->discount > 0)
            <span class="save-p">
                You save {!!  \App\CPU\Helpers::currency_converter($product->unit_price - $discountPrice) !!}

            </span>
            
            @endif
            
            
        </div>
    </div>
    
    <div class="product-card-hover-content">
        <a href="{{route('frontend.product_details',$product->slug)}}">
            <div class="image-peek" style="background-image: url('{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}')">
            </div>
        </a>
        <div class="product-info">
            <a href="{{route('frontend.product_details',$product->slug)}}"> <h5 class="product-title"> {{ Str::limit($product['name'], 50) }}</h5></a>
            <p class="product-brand">By {!! $product->brand->name ?? ''  !!}</p>
        </div>
        <form id="add-to-cart-form-{{ $product->id }}" class="mb-2">
        @csrf
        <input type="hidden" name="id" value="{{ $product->id }}">
        <div class="count-and-price">
            <div class="spinbutton-wrapper">
                <div class="spinbutton">
                    <button class="minus" type="button" onclick="price_minus('{{ $product->minimum_order_qty}}', this)">-</button>
                    <input type="number" style="width: 50px;min-height: 15px;" class="val" name="quantity" id="quantity" value="{{ $product->minimum_order_qty }}" min="{{ $product->minimum_order_qty }}" oninput="this.value = !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null">
                    <button class="plus" type="button">+</button>
                </div>
            </div>
            <div class="price-with-offer">
                <p> {{\App\CPU\Helpers::currency_converter(
                    $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                )}}</p>
            </div>
        </div>
       
        @if($sold_out==1)
        <div class="action-wrapper d-grid">
            </br>
            <button class="btn btn-brand" type="button">Sold Out</button>
        </div>
        @else
            <div class="action-wrapper d-grid">
                <button type="button" class="btn btn-brand-secondary add-to-cart" onclick="addToCart({{ $product->id }})">ADD TO CART</button>
                <button class="btn btn-brand" onclick="buy_now({{ $product->id }})" type="button">{{\App\CPU\translate('buy_now')}}</button>
            </div>
        @endif
        </form>
    </div>
</div>
<script>
function price_minus(min,el)
    {
        var qty=parseInt($(el).closest('.spinbutton').find("input[name=quantity]").val());
        var new_qty=qty-1;
        if (min > new_qty) {
            toastr.error('{{ \App\CPU\translate('minimum_order_quantity_cannot_be_less_than_') }}' +
                min);
                var min=parseInt(min)+1;
                $(el).closest('.spinbutton').find("input[name=quantity]").val(min);
            return false;
        }  
    }
</script>