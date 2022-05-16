
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Shop_products'))

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">
          {{__('locale.menu_Shop_products')}} ( {{ $entries->total() }} / {{ $maxProductCt }} ) <br>
          @if ($entries->total() >= $maxProductCt)
          <span style="font-size: 1rem">Please activate or upgrade your subscription for shop. Click <a href="{{ route('shop.packages.choose') }}">Here.</a></span>
          @endif
        </h4>
        @if ($entries->total() < $maxProductCt)
        <a href="{{ route('shopproducts.create') }}" class="btn btn-icon btn-primary">
          New Product
        </a>
        @endif
      </div>
      <div class="table-responsive p-1">
        <table class="table">
          <thead>
            <tr>
              <th width="20%">{{__('locale.tb_header_Name')}}</th>
              <th width="20%">{{__('locale.tb_header_Price')}}</th>
              <th width="5%">{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
            @foreach ($entries as $entry)
              <tr>
                <td>{{ $entry->title }}</td>
                <td>{{ $currencyCode.number_format($entry->price, 2) }}</td>
                <td class="td-actions">
                  <a class="btn btn-icon btn-primary" href="{{ route('shopproducts.edit', ['shopproduct' => $entry->id]) }}" title="Edit">
                    <i data-feather="edit"></i>
                  </a>
                  <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $entry->id }}" title="Delete"><i data-feather="trash-2"></i></a>
                  <form action="{{ route('shopproducts.destroy', $entry->id) }}" class="delete-form" method="POST" style="display:none">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </form>
                </td>
              </tr>
            @endforeach
            @else
              <tr>
                <td colspan="3">No matching records found</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    {{ $entries->links() }}
  </div>
</div>
<!-- Basic Tables end -->
@endsection
@section('vendor-script')
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection
@section('page-script')
<script>
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
</script>
@endsection
