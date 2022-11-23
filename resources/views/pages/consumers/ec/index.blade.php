
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
        <div class="view-options d-flex">
          <div class="btn-group" role="group">
            <input type="radio" class="btn-check" @if($mode == 'tool') checked @endif />
            <label class="btn btn-icon btn-outline-primary view-btn grid-view-btn" for="radio_option1" onclick="onTool()">Physical Product</label>
            <input type="radio" class="btn-check" @if($mode == 'digital') checked @endif />
            <label class="btn btn-icon btn-outline-primary view-btn list-view-btn" for="radio_option2" onclick="onDigital()">Digital Product</label>
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
<form action="{{ $mode == 'tool' ? route('customer.shop.physical') : route('customer.shop.digital') }}">
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
<form action="{{ $mode == 'tool' ? route('customer.shop.physical') : route('customer.shop.digital') }}" id="additional_search_form">
  <input type="hidden" name="d_make" id="d_make">
  <input type="hidden" name="d_model" id="d_model">
  <input type="hidden" name="d_engine_code" id="d_engine_code">
  <input type="hidden" name="d_engine_disp" id="d_engine_disp">
  <input type="hidden" name="d_hp" id="d_hp">
  <input type="hidden" name="d_ecu_make" id="d_ecu_make">
  <input type="hidden" name="d_ecu_model" id="d_ecu_model">
  <input type="hidden" name="d_soft_ver" id="d_soft_ver">
  <input type="hidden" name="d_soft_num" id="d_soft_num">
  <input type="hidden" name="d_hard_ver" id="d_hard_ver">
  <input type="hidden" name="d_checksum" id="d_checksum">
  <input type="hidden" name="d_tuning_tool" id="d_tuning_tool">
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
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset('js/scripts/pages/app-ecommerce.js') }}"></script>
<script>
  function onTool() {
    window.location.href = "{{route('customer.shop.physical')}}";
  }
  function onDigital() {
    window.location.href = "{{route('customer.shop.digital')}}";
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
  async function onMore() {
    const { value: formValues } = await Swal.fire({
      title: 'Search Parameters',
      html:
        `<div style="display: flex; align-items: center">
          <label for="swal-make" style="width: 240px; margin-right: 10px">Make</label>
          <input id="swal-make" type="text" class="form-control" value="{{ $d_make }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-model" style="width: 240px; margin-right: 10px">Model</label>
          <input id="swal-model" type="text" class="form-control" value="{{ $d_model }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-engine-code" style="width: 240px; margin-right: 10px">Engine Code</label>
          <input id="swal-engine-code" type="text" class="form-control" value="{{ $d_engine_code }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-engine-disp" style="width: 240px; margin-right: 10px">Engine Displacement</label>
          <input id="swal-engine-disp" type="text" class="form-control" value="{{ $d_engine_disp }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-hp" style="width: 240px; margin-right: 10px">Horsepower Stock</label>
          <input id="swal-hp" type="text" class="form-control" value="{{ $d_hp }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-ecu-make" style="width: 240px; margin-right: 10px">ECU Make</label>
          <input id="swal-ecu-make" type="text" class="form-control" value="{{ $d_ecu_make }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-ecu-model" style="width: 240px; margin-right: 10px">ECU Model</label>
          <input id="swal-ecu-model" type="text" class="form-control" value="{{ $d_ecu_model }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-soft-ver" style="width: 240px; margin-right: 10px">Software Version</label>
          <input id="swal-soft-ver" type="text" class="form-control" value="{{ $d_soft_ver }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-soft-num" style="width: 240px; margin-right: 10px">Software Number</label>
          <input id="swal-soft-num" type="text" class="form-control" value="{{ $d_soft_num }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-hard-ver" style="width: 240px; margin-right: 10px">Hardware Version</label>
          <input id="swal-hard-ver" type="text" class="form-control" value="{{ $d_hard_ver }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-checksum" style="width: 240px; margin-right: 10px">Checksum</label>
          <input id="swal-checksum" type="text" class="form-control" value="{{ $d_checksum }}">
        </div>
        <div style="display: flex; align-items: center; margin-top: 10px">
          <label for="swal-tuning-tool" style="width: 240px; margin-right: 10px">Tuning Tool</label>
          <input id="swal-tuning-tool" type="text" class="form-control" value="{{ $d_tuning_tool }}">
        </div>`,
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonText: 'Search',
      preConfirm: () => {
        return [
          document.getElementById('swal-make').value,
          document.getElementById('swal-model').value,
          document.getElementById('swal-engine-code').value,
          document.getElementById('swal-engine-disp').value,
          document.getElementById('swal-hp').value,
          document.getElementById('swal-ecu-make').value,
          document.getElementById('swal-ecu-model').value,
          document.getElementById('swal-soft-ver').value,
          document.getElementById('swal-soft-num').value,
          document.getElementById('swal-hard-ver').value,
          document.getElementById('swal-checksum').value,
          document.getElementById('swal-tuning-tool').value,
        ]
      }
    })

    if (formValues) {
      $('#d_make').val(formValues[0]);
      $('#d_model').val(formValues[1]);
      $('#d_engine_code').val(formValues[2]);
      $('#d_engine_disp').val(formValues[3]);
      $('#d_hp').val(formValues[4]);
      $('#d_ecu_make').val(formValues[5]);
      $('#d_ecu_model').val(formValues[6]);
      $('#d_soft_ver').val(formValues[7]);
      $('#d_soft_num').val(formValues[8]);
      $('#d_hard_ver').val(formValues[9]);
      $('#d_checksum').val(formValues[10]);
      $('#d_tuning_tool').val(formValues[11]);
      $('#additional_search_form').submit();
    }
  }
</script>
@endsection

