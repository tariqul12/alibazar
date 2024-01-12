@extends('layouts.front-end.app')

@section('title', \App\CPU\translate('Compare List'))

@section('content')

<section class="pt-4 mb-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
            
                <h1 class="fw-600 h4">{{\App\CPU\translate('Specifications Compare')}}</h1>
            </div>
            <!-- <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ \App\CPU\translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('compare.reset') }}">"{{ \App\CPU\translate('Compare')}}"</a>
                    </li>
                </ul>
            </div> -->
        </div>
    </div>
</section>

<section class="mb-4">
    <div class="container text-left">
        <div class="bg-white shadow-sm rounded">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <div class="fs-15 fw-600">{{ \App\CPU\translate('Comparison')}}</div>
                <a href="{{ route('compare.reset') }}" style="text-decoration: none;" class="btn btn-brand btn-sm fw-600">{{ \App\CPU\translate('Reset Compare List')}}</a>
            </div>
            @if(Session::has('compare'))
                @if(count(Session::get('compare')) > 0)
                    <div class="p-3">
                        <table class="table table-responsive table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" style="width:16%" class="font-weight-bold">
                                        {{ \App\CPU\translate('Name')}}
                                    </th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        <th scope="col" style="width:28%" class="font-weight-bold">
                                            <a class="text-reset fs-15" href="{{ route('frontend.product_details', \App\Model\Product::find($item)->slug) }}">{{ \App\Model\Product::find($item)->name }}</a>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">{{ \App\CPU\translate('Image')}}</th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        <td>
                                            <div class="compaer-img">
                                                <img loading="lazy" src="{{asset("storage/app/public/product/thumbnail/".\App\Model\Product::find($item)->thumbnail)}}" alt="{{ \App\CPU\translate('Product Image') }}" class="img-fluid py-4">
                                            </div>
                                            
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th scope="row">{{ \App\CPU\translate('Price')}}</th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        @php
                                            $product = \App\Model\Product::find($item);
                                        @endphp
                                        <td>
                                            @if($product->discount > 0)
                                            <del class="fw-600 opacity-50 mr-1"> 
                                                {{$product->unit_price}}
                                            </del>
                                            @endif
                                            <span class="fw-700 text-primary">{{\App\CPU\Helpers::currency_converter(
                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                        )}}</span>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th scope="row">{{ \App\CPU\translate('Brand')}}</th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        <td>
                                            @if (\App\Model\Product::find($item)->brand != null)
                                                {{ \App\Model\Product::find($item)->brand->name }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th scope="row">{{ \App\CPU\translate('Category')}}</th>
                                    @foreach (Session::get('compare') as $key => $item)
                                    <?php 
                                        $category_name = '';
                                        $product = \App\Model\Product::find($item);
                                        $pcategory = !empty($product->category_ids) ? json_decode($product->category_ids, true) : [];

                                        if(sizeof($pcategory) > 0){
                                            $category = \App\Model\Category::where('id', $pcategory[0]['id'])->first();
                                            if($category){
                                                $category_name = $category->name;
                                            }
                                        }
                                    ?>
                                        <td>
                                                {{ !empty($category_name) ? $category_name : '--' }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    @foreach (Session::get('compare') as $key => $item)
                                        <td class="text-center py-4">
                                            <form id="add-to-cart-form-{{ $item }}" class="mb-2">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="button" class="btn btn-brand-secondary fw-600" onclick="addToCart({{ $item }})">
                                                {{ \App\CPU\translate('Add to cart')}}
                                            </button>
                                            </form>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @else
                <div class="text-center p-4">
                    <p class="fs-17">{{ \App\CPU\translate('Your comparison list is empty')}}</p>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
