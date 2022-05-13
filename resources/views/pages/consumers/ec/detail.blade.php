@extends('layouts/contentLayoutMaster')

@section('title', 'Product Details')

@section('vendor-style')
  {{-- Vendor Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/swiper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-ecommerce-details.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-number-input.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">

@endsection

@section('content')
<div class="ecommerce-application">
  <!-- app e-commerce details start -->
  <section class="app-ecommerce-details">
    <form action="{{ route('customer.shop.cart.add') }}" method="POST">
    @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <div class="card">
        <!-- Product Details starts -->
        <div class="card-body">
          <div class="row my-2">
            <div class="col-12 col-md-5 d-flex justify-content-center mb-2 mb-md-0">
              <div class="d-flex align-items-start justify-content-center">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                  @php
                    $images = explode(',', $product->image);
                  @endphp
                  <div class="carousel-indicators">
                    @foreach ($images as $i => $image)
                      <button
                        type="button"
                        data-bs-target="#carouselExampleIndicators"
                        data-bs-slide-to="{{ $i }}"
                        class="{{ $i == 0 ? 'active' : '' }}"
                        aria-current="true"
                        aria-label="Slide"
                      ></button>
                    @endforeach
                  </div>
                  <div class="carousel-inner">
                    @foreach ($images as $i => $image)
                      <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                        <img src="{{asset('storage/uploads/products/'.$image)}}" class="d-block w-100" alt="Slide" />
                      </div>
                    @endforeach
                  </div>
                  <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev"
                  >
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next"
                  >
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-7">
              <h4>{{ $product->title }}</h4>
              @if ($product->brand)
              <span class="card-text item-company">By <a href="#" class="company-name">{{ $product->brand }}</a></span>
              @endif
              <div class="ecommerce-details-price d-flex flex-wrap mt-1">
                <h4 class="item-price me-1">{{ $currencyCode.number_format($product->price, 2) }}</h4>
                @php $avgRating = round($product->avgRating()); @endphp
                @include('pages.consumers.ec.rating')
              </div>
              <p class="card-text">Available - <span class="text-success">In stock</span></p>
              <p class="card-text">
                @if ($product->details)
                  {!! $product->details !!}
                @else
                  {{ $product->description }}
                @endif
              </p>
              {{-- <ul class="product-features list-unstyled">
                <li><i data-feather="shopping-cart"></i> <span>Free Shipping</span></li>
                <li>
                  <i data-feather="dollar-sign"></i>
                  <span>EMI options available</span>
                </li>
              </ul> --}}
              @foreach ($product->sku as $i => $sku)
                <hr/>
                <div class="sku-wrapper">
                  <h5>{{ $sku->title }}</h5>
                  @if ($sku->type == 'option')
                    @foreach ($sku->items as $j => $skuItem)
                    <div class="form-check form-check-inline mb-1">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="sku_selection[{{ $i }}][]"
                        id="sku_selection-{{ $i }}-{{ $j }}"
                        value="{{ $skuItem->id }}"
                        @if ($company->notify_check == 1) checked @endif
                      />
                      <label class="form-check-label" for="sku_selection-{{ $i }}-{{ $j }}">
                        {{ $skuItem->title }}
                        <b>(+{{ $currencyCode.number_format($skuItem->price, 2) }})</b>
                      </label>
                    </div>
                    @endforeach
                  @elseif ($sku->type == 'check')
                    @foreach ($sku->items as $j => $skuItem)
                    <div class="form-check form-check-inline mb-1">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="sku_selection-{{ $i }}-{{ $j }}"
                        name="sku_selection[{{ $i }}][]"
                        value="{{ $skuItem->id }}"/>
                      <label class="form-check-label" for="sku_selection-{{ $i }}-{{ $j }}">
                        {{ $skuItem->title }}
                        <b>(+{{ $currencyCode.number_format($skuItem->price, 2) }})</b>
                      </label>
                    </div>
                    @endforeach
                  @endif
                </div>
              @endforeach
              <hr />
              <div class="d-flex flex-column flex-sm-row pt-1">
                <button class="btn btn-primary me-0 me-sm-1 mb-1 mb-sm-0" @if($product->stock <= 0) disabled @endif>
                  <i data-feather="shopping-cart" class="me-50"></i>
                  <span class="add-to-cart">Add to cart</span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- Product Details ends -->
      </div>
    </form>
  </section>
  <!-- app e-commerce details end -->
</div>
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/swiper.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-ecommerce-details.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-number-input.js')) }}"></script>
@endsection
