
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Customer_Shop_Order'))

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{__('locale.menu_Customer_Shop_Order')}}</h4>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>{{__('locale.tb_header_OrderDate')}}</th>
              <th>{{__('locale.tb_Customer')}}</th>
              <th>{{__('locale.tb_header_Amount')}}</th>
              <th>{{__('locale.tb_header_Status')}}</th>
              <th>{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $e)
              <tr @if(!$e->is_checked) class="ticket-open" @endif>
                <td>{{ $e->created_at }}</td>
                <td>{{ $e->user->full_name }}</td>
                <td>{{ config('constants.currency_signs')[$company->paypal_currency_code].' '.($e->amount + $e->tax) }}</td>
                <td style="text-transform: uppercase">{{ $e->status }}</td>
                <td class="td-actions">
                  <a class="btn btn-icon btn-primary" href="{{ route('shoporders.show', ['shoporder' => $e->id]) }}">
                    <i data-feather="eye"></i>
                  </a>
                  @if ($e->status < 3)
                  <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $e->id }}" title="Delete">
                    <i data-feather="trash-2"></i>
                  </a>
                  <form action="{{ route('shoporders.destroy', $e->id) }}" class="delete-form" method="POST" style="display:none">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </form>
                  @endif
                </td>
              </tr>
              @endforeach
              @else
                <tr>
                  <td colspan="6">No matching records found</td>
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
      text: 'Are you sure to delete this order?',
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
