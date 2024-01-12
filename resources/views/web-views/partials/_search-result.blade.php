<style>
    .list-group-item li, a {
        color: {{$web_config['primary_color']}};
    }

    .list-group-item li, a:hover {
        color: {{$web_config['secondary_color']}};
    }
    .list-group-item li, a {
        color: #0E2F56;
    }

    .list-group-item li, a:hover {
        color: #e9611e;
    }
</style>
@if(false)
<div class="card search-card trending-search-area" style="box-shadow: 0px 0px 4px #a6a6a6;position: absolute;background: white;z-index: 999;max-width: 408px;display: none;top: 33px;left: 133px;">
    <div class="card-body search-result-box" style="max-height:318px;overflow-x: hidden;width: 100%;float: left;border-right: 1px solid #ccc;">
        <div class="search-result-box-brand">
            @php($trend_searches=\App\Model\ProSearch::orderBy('count','desc')->get()->take(10))
            <h5>Trending Searches</h5>
            <ul>
                @foreach($trend_searches as $search)
                    <li><a href="javascript:void(0);" onclick="location.href='{{route('products',['name'=> $search->query,'data_from'=>'search','page'=>1])}}'">{{$search->query}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endif


<div class="search-result-box-sec">

    @if(isset($search_data) && count($search_data))
        @foreach($search_data as $key=>$items)

            <div class="search-result-box-brand">
                <h5>{!! $key !!}</h5>
                @if(count($items))
                    @foreach($items as $item)
                        <ul>
                            @if($key == 'suggestions')
                                <li><a  onmouseover="productSearch({!! "'".$key."'" !!},{!! $item->id !!}, {!!  "'".$item->query ."'" !!})" href="#">{!! $item->query ?? ' ' !!}</a></li>
                            @else
                                <li><a  onmouseover="productSearch({!! "'".$key."'" !!},{!! $item->id !!}, {!! "'".$item->name."'" !!})" href="#">{!! $item->name  !!}</a></li>
                            @endif

                        </ul>
                    @endforeach

                @endif
            </div>
        @endforeach

    @endif
</div>



<div class="search-all-img">
    <div class="search-all-img-head">
        <p>Recommended Products for</p>
        <a href="">{!! isset($search_item_name) ? $search_item_name : ''  !!}</a>
    </div>
    @if(isset($products) && count($products))
        <div class="search-all-img-cont">
            @foreach($products as $product)
                <a href="{!! route('frontend.product_details',$product->slug) !!}">
                    <div class="search-all-img-cont-item">
                        <div class="search-all-img-cont-item-img">
                            <img src="{{asset("storage/product/thumbnail/$product->thumbnail")}}" alt="Product image">
                        </div>
                        <div class="search-all-img-cont-item-text">
                            <p> {!! $product->name !!}</p>
                             @if($product->discount_type=='flat')
                            <p class="serch-price">Tk. {!! $product->unit_price -$product->discount!!}</p>
                            @else
                            <p class="serch-price">Tk. {!! $product->unit_price -($product->unit_price*($product->discount/100))!!}</p>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach


        </div>
    @endif
</div>