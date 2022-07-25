
@extends('layouts/contentLayoutMaster')

@section('title', 'Shop')

@section('vendor-style')
<!-- Vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/nouislider.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-sliders.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
@endsection

@section('content-sidebar')
@include('pages.consumers.ec.sidebar')
@endsection

@section('content')
<!-- E-commerce Content Section Starts -->
<section id="ecommerce-header">
  <div class="row">
    <div class="col-sm-12">
      <div class="ecommerce-header-items">
        <div class="result-toggler">
          <button class="navbar-toggler shop-sidebar-toggler" type="button" data-bs-toggle="collapse">
            <span class="navbar-toggler-icon d-block d-lg-none"><i data-feather="menu"></i></span>
          </button>
          <div class="search-results">{{ $products->total() }} results found</div>
        </div>
        <div class="view-options d-flex">
          <div class="btn-group dropdown-sort">
            <button
              type="button"
              class="btn btn-outline-primary dropdown-toggle me-1"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <span class="active-sorting">Featured</span>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Featured</a>
              <a class="dropdown-item" href="#">Lowest</a>
              <a class="dropdown-item" href="#">Highest</a>
            </div>
          </div>
          <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="radio_options" id="radio_option1" autocomplete="off" checked />
            <label class="btn btn-icon btn-outline-primary view-btn grid-view-btn" for="radio_option1"
              ><i data-feather="grid" class="font-medium-3"></i
            ></label>
            <input type="radio" class="btn-check" name="radio_options" id="radio_option2" autocomplete="off" />
            <label class="btn btn-icon btn-outline-primary view-btn list-view-btn" for="radio_option2"
              ><i data-feather="list" class="font-medium-3"></i
            ></label>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- E-commerce Content Section Starts -->

<!-- background Overlay when sidebar is shown  starts-->
<div class="body-content-overlay"></div>
<!-- background Overlay when sidebar is shown  ends-->

<!-- E-commerce Search Bar Starts -->
<section id="ecommerce-searchbar" class="ecommerce-searchbar">
  <div class="row mt-1">
    <div class="col-sm-12">
      <div class="input-group input-group-merge">
        <input
          type="text"
          class="form-control search-product"
          id="shop-search"
          placeholder="Search Product"
          aria-label="Search..."
          aria-describedby="shop-search"
        />
        <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
      </div>
    </div>
  </div>
</section>
<!-- E-commerce Search Bar Ends -->

<!-- E-commerce Products Starts -->
<section id="ecommerce-products" class="grid-view">
  @foreach ($products as $product)
  <div class="card ecommerce-card">
    <div class="item-img text-center justify-content-center">
      <a href="{{ route('customer.shop.detail', ['id' => $product->id]) }}">
        <img
          class="img-fluid card-img-top"
          src="{{$product->thumb ? asset('storage/uploads/products/thumbnails/'.$product->thumb) : 'https://via.placeholder.com/350x250.png?text=Product'}}"
          alt="img-placeholder"
          style="max-height: 250px"
      /></a>
    </div>
    <div class="card-body">
      <div class="item-wrapper">
        <div class="item-rating">
          @php $avgRating = round($product->avgRating()); @endphp
          @include('pages.consumers.ec.rating')
        </div>
        <div>
          <h6 class="item-price">{{ config('constants.currency_signs')[$company->paypal_currency_code] }}{{ $product->price }}</h6>
        </div>
      </div>
      <h6 class="item-name">
        <a class="text-body" href="{{ route('customer.shop.detail', ['id' => $product->id]) }}">{{ $product->title }}</a>
        @php
            // dd($product->brand)
        @endphp
        @if ($product->brand)
        <span class="card-text item-company">By <a href="#" class="company-name">{{ $product->brand }}</a></span>
        @endif
      </h6>
      <p class="card-text item-description">
        {{ $product->description }}
      </p>
    </div>
    <div class="item-options text-center">
      <div class="item-wrapper">
        <div class="item-cost">
          <h4 class="item-price">{{ config('constants.currency_signs')[$company->paypal_currency_code] }}{{ $product->price }}</h4>
        </div>
      </div>
      <button
        class="btn btn-primary"
        style="border-radius: 5px; width: 100%;"
        onclick="onAddCartInline(this)"
        data-link="{{ count($product->sku) > 0 ? 1 : 0 }}"
        data-proid="{{ $product->id }}"
        @if($product->stock <= 0) disabled @endif>
        <i data-feather="shopping-cart"></i>
        <span class="add-to-cart">
          @if ($product->stock <= 0)
            Out of stock
          @else
            {{ count($product->sku) > 0 ? 'Customize' : 'Add to cart' }}
          @endif
        </span>
      </button>
      <form class="add-cart-inline-form" action="{{ route('customer.shop.cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
      </form>
    </div>
  </div>
  @endforeach
</section>
<!-- E-commerce Products Ends -->

<!-- E-commerce Pagination Starts -->
<section id="ecommerce-pagination">
  {{ $products->appends($_GET)->links() }}
</section>
<!-- E-commerce Pagination Ends -->
@endsection

@section('vendor-script')
<!-- Vendor js files -->
<script src="{{ asset('vendors/js/extensions/wNumb.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/nouislider.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset('js/scripts/pages/app-ecommerce.js') }}"></script>
@endsection

