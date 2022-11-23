
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Shop_products'))

@section('content')
@php
  $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tool';
@endphp
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">
          @if ($user->is_master)
            {{__('locale.menu_Shop_products')}} <br>
          @else
            {{__('locale.menu_Shop_products')}} ( {{ $entries->total() }} / {{ $maxProductCt }} ) <br>
            @if ($entries->total() >= $maxProductCt)
              <span style="font-size: 1rem">Please activate or upgrade your subscription for shop. Click <a href="{{ route('shop.packages.choose') }}">Here.</a></span>
            @endif
          @endif
        </h4>
        <div class="btn-group" role="group" aria-label="Basic example">
          <button type="button" class="btn {{ $tab == 'tool' ? 'btn-primary' : 'btn-outline-secondary' }}" onclick="onTool()">Physical Products</button>
          <button type="button" class="btn {{ $tab == 'digital' ? 'btn-primary' : 'btn-outline-secondary' }}" onclick="onDigital()">Digital Products</button>
        </div>
        @if ($entries->total() < $maxProductCt || $user->is_master)
        <div>
          <a href="{{ $tab == 'tool' ? route('shopproducts.create') : route('shopproducts.digital.create') }}" class="btn btn-icon btn-primary">
            <i data-feather="plus"></i>
          </a>
        </div>
        @endif
      </div>
      @if ($tab == 'tool')
        @include('pages.ecommerce.shopproducts.tool')
      @else
      @include('pages.ecommerce.shopproducts.digital')
      @endif
    </div>
  </div>
</div>
@endsection
@section('vendor-script')
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection
@section('page-script')
<script>
  function onTool() {
    window.location.href = "{{route('shopproducts.index', ['tab' => 'tool'])}}";
  }
  function onDigital() {
    window.location.href = "{{route('shopproducts.index', ['tab' => 'digital'])}}";
  }
  async function onDelete(obj) {
    var delete_form = $(obj).closest('.td-actions').children('.delete-form')
    var swal_result = await Swal.fire({
      title: 'Warning!',
      text: 'Are you sure to delete?',
      icon: 'warning',
      customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-danger ms-1'
      },
      showCancelButton: true,
      confirmButtonText: 'OK',
      cancelButtonText: 'Cancel',
      buttonsStyling: false
    });
    if (swal_result.isConfirmed) {
      delete_form.submit();
    }
  }
  window.onload = checkSwal;
  async function checkSwal() {
    @if (!$company->is_first_shop && !$company->owner->is_master)
    var swalRes = await Swal.fire({
      icon: 'info',
      title: '{{ $shopGuide->title }}',
      text: '{{ $shopGuide->content }}',
      showCancelButton: true,
      confirmButtonText: 'OK',
      cancelButtonText: "Don't show again",
      customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-danger ms-1'
      },
      buttonsStyling: false
    })
    if (swalRes.isDismissed && swalRes.dismiss == 'cancel') {
      $.ajax({
        type: 'POST',
        url: "{{ route('api.shop.readguide') }}",
        data: {
          id: '{{ $company->id }}'
        },
        success: function(result) {
          console.log(result);
        }
      })
    }
    @endif
  }
</script>
@endsection
