
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Shop_products'))

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
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
        @if ($entries->total() < $maxProductCt || $user->is_master)
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
            @foreach ($entries as $i => $entry)
              <tr>
                <td>{{ $entry->title }}</td>
                <td>{{ $currencyCode.number_format($entry->price, 2) }}</td>
                <td class="td-actions">
                  @if ($i < $maxProductCt || $user->is_master)
                  <a class="btn btn-icon btn-primary" href="{{ route('shopproducts.edit', ['shopproduct' => $entry->id]) }}" title="Edit">
                    <i data-feather="edit"></i>
                  </a>
                  @endif
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
