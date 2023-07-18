
@extends('layouts/contentLayoutMaster')

@section('title', 'My Subscriptions')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Subscriptions</h4>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Next Billing Date</th>
              <th>Last Payment Date</th>
              <th>Last Payment Amount</th>
              <th>Failed Payment Count</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $entry)
                <tr>
                  <td>{{ $entry->next_billing_date }}</td>
                  <td>{{ $entry->last_payment_date }}</td>
                  <td>{{ $entry->last_payment_amount }}</td>
                  <td>{{ $entry->failed_payment_count }} </td>
                  <td class="td-actions">
                    <a class="btn btn-icon btn-success" title="Subscription payments" href="{{ route('shop.subscriptions.invoice', ['id' => $entry->id]) }}">
                      <i data-feather="file"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="5">No matching records found</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Basic Tables end -->
@endsection

@section('vendor-script')
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection

@section('page-script')
@endsection
