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
              <img
                class="img-fluid card-img-top"
                src="https://via.placeholder.com/500.png?text=Digital File"
                alt="img-placeholder"
              />
            </div>
            <div class="col-12 col-md-7">
              <h4>{{ $product->title }}</h4>
              <div class="ecommerce-details-price d-flex flex-wrap mt-1">
                <h4 class="item-price me-1">{{ $currencyCode.number_format($product->price, 2) }}</h4>
                @php $avgRating = round($product->avgRating()); @endphp
                @include('pages.consumers.ec.rating')
              </div>
              <hr/>
              <table class="table">
                <tr>
                  <th>Make</th>
                  <td>{{ $product->digital->make }}</td>
                </tr>
                <tr>
                  <th>Model</th>
                  <td>{{ $product->digital->model }}</td>
                </tr>
                <tr>
                  <th>Engine Code</th>
                  <td>{{ $product->digital->engine_code }}</td>
                </tr>
                <tr>
                  <th>Engine Displacement</th>
                  <td>{{ $product->digital->engine_displacement }}</td>
                </tr>
                <tr>
                  <th>Horsepower Stock</th>
                  <td>{{ $product->digital->hardware_stock }}</td>
                </tr>
                <tr>
                  <th>Software Version</th>
                  <td>{{ $product->digital->software_version }}</td>
                </tr>
                <tr>
                  <th>Software Number</th>
                  <td>{{ $product->digital->software_number }}</td>
                </tr>
                <tr>
                  <th>Hardware Version</th>
                  <td>{{ $product->digital->hardware_version }}</td>
                </tr>
                <tr>
                  <th>Checksum</th>
                  <td>{{ $product->digital->checksum }}</td>
                </tr>
                <tr>
                  <th>Tuning Tool</th>
                  <td>{{ $product->digital->tuning_tool }}</td>
                </tr>
              </table>
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
                <button class="btn btn-primary me-0 me-sm-1 mb-1 mb-sm-0">
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
