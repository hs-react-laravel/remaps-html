
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
              <th>{{__('locale.tb_header_Amount')}}</th>
              <th>{{__('locale.tb_header_Status')}}</th>
              <th>{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $e)
              <tr>
                  <td>{{ $e->created_at }}</td>
                  <td>{{ config('constants.currency_signs')[$company->paypal_currency_code].' '.($e->amount + $e->tax) }}</td>
                  <td style="text-transform: uppercase">{{ $e->status }}</td>
                  <td>
                    @if ($e->status != 'paid' && $e->status != 'delivered')
                    <a class="btn btn-icon btn-primary" href="{{ route('customer.shop.checkout', ['order' => $e->id]) }}">
                      <i data-feather="edit"></i>
                    </a>
                    @endif
                    <a class="btn btn-icon btn-success" href="{{ route('customer.shop.order.show', ['id' => $e->id]) }}">
                      <i data-feather="eye"></i>
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
