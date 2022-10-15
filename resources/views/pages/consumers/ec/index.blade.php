
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
@php
  $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tool';
@endphp
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
          <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="radio_options" id="radio_option1" autocomplete="off" @if($tab == 'tool') checked @endif />
            <label class="btn btn-icon btn-outline-primary view-btn grid-view-btn" for="radio_option1" onclick="onTool()">Tool</label>
            <input type="radio" class="btn-check" name="radio_options" id="radio_option2" autocomplete="off" @if($tab == 'digital') checked @endif />
            <label class="btn btn-icon btn-outline-primary view-btn list-view-btn" for="radio_option2" onclick="onDigital()">Digital</label>
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
    @if ($tab == 'tool')
    @include('pages.consumers.ec.product-tool-thumb')
    @elseif ($tab == 'digital')
    @include('pages.consumers.ec.product-digital-thumb')
    @endif
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
<script>
  function onTool() {
    window.location.href = "{{route('customer.shop', ['tab' => 'tool'])}}";
  }
  function onDigital() {
    window.location.href = "{{route('customer.shop', ['tab' => 'digital'])}}";
  }
</script>
@endsection

