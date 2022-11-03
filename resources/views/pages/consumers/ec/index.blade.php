
@extends('layouts/contentLayoutMaster')

@section('title', 'Shop')

@section('vendor-style')
<!-- Vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/nouislider.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css'))}}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-sliders.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
@endsection

@section('content-sidebar')
@include('pages.consumers.ec.sidebar')
@endsection
@php
  $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tool';
@endphp
<style>
    .jstree .jstree-container-ul .jstree-anchor.jstree-clicked {
        background: transparent !important;
        color: #6e6b7b !important;
    }
</style>
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
      </div>
    </div>
  </div>
</section>
<!-- E-commerce Content Section Starts -->

<!-- background Overlay when sidebar is shown  starts-->
<div class="body-content-overlay"></div>
<!-- background Overlay when sidebar is shown  ends-->

<!-- E-commerce Search Bar Starts -->
<form action="{{ route('customer.shop') }}">
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
          name="keyword"
          value="{{ $keyword }}"
        />
        <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
      </div>
    </div>
  </div>
</section>
</form>
<!-- E-commerce Search Bar Ends -->

<!-- E-commerce Products Starts -->
<section id="ecommerce-products" class="grid-view">
  @foreach ($products as $product)
    @include('pages.consumers.ec.product-tool-thumb')
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
<script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
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
  var treeBasic = $('#jstree-checkbox')
  var data = @json($tree);
  var treeObj;
  var selectedNode;
  var selectedArray = []
  if (treeBasic.length) {
    initTree(data)
  }
  function initTree(data) {
    treeObj = treeBasic.jstree({
      core: {
        check_callback: true,
        data: data
      },
      checkbox: {
        tie_selection: false
      },
      plugins: ['checkbox'],
      types: {
        default: {
          icon: 'far fa-folder'
        },
        html: {
          icon: 'fab fa-html5 text-danger'
        },
        css: {
          icon: 'fab fa-css3-alt text-info'
        },
        img: {
          icon: 'far fa-file-image text-success'
        },
        js: {
          icon: 'fab fa-node-js text-warning'
        }
      }
    });
  }
  $('#jstree-checkbox').on('check_node.jstree', function (e, data) {
    const selectedIDs = treeBasic.jstree().get_checked()
    $('#category_filter').val(selectedIDs.join(','));
  })
  $('#jstree-checkbox').on('uncheck_node.jstree', function (e, data) {
    const selectedIDs = treeBasic.jstree().get_checked()
    $('#category_filter').val(selectedIDs.join(','));
  })
</script>
@endsection

