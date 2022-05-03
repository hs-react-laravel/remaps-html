
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Orders'))

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{__('locale.menu_Orders')}}</h4>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="20%">{{__('locale.tb_header_OrderDate')}}</th>
              <th width="20%">{{__('locale.tb_header_Company')}}</th>
              <th width="20%">{{__('locale.tb_header_Amount')}}</th>
              <th width="20%">{{__('locale.tb_header_Status')}}</th>
              <th width="20%">{{__('locale.tb_header_InvoiceNo')}}</th>
              <th>{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $e)
              <tr>
                  <td>{{ $e->created_at }}</td>
                  <td>{{ $e->customer_company }}</td>
                  <td>{{ config('constants.currency_signs')[$company->paypal_currency_code].' '.$e->amount_with_sign }}</td>
                  <td>{{ $e->status }}</td>
                  <td>{{ $e->displayable_id }}</td>
                  <td>
                  <a class="btn btn-icon btn-success" href="{{ route('customer.order.invoice', ['id' => $e->id]) }}" title="Download Invoice">
                      <i data-feather="file"></i>
                  </a>
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
