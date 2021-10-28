
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
              <th>Agreement Id</th>
              <th>Description</th>
              <th>Start At</th>
              <th>Next Billing Date</th>
              <th>Type</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $entry)
                <tr>
                  <td>{{ $entry->pay_agreement_id }}</td>
                  <td>{{ $entry->description }}</td>
                  <td>{{ $entry->created_at }}</td>
                  <td>{{ $entry->is_trial
                  ? \Carbon\Carbon::parse($entry->start_date)->addDays($entry->trial_days)->format('d M Y g:i A')
                  : $entry->next_billing_date }} </td>
                  <td>{{ $entry->is_trial ? 'Trial' : 'Paid' }}</td>
                  <td>{{ $entry->status }}</td>
                  <td class="td-actions">
                    <a class="btn btn-icon btn-success" title="Subscription payments" href="{{ route('subscriptions.payments', ['id' => $entry->id]) }}">
                      <i data-feather="dollar-sign"></i>
                    </a>
                    <a class="btn btn-icon btn-danger" title="Cancel this subscription">
                      <i data-feather="x"></i>
                    </a>
                    <a class="btn btn-icon btn-danger" title="Cancel this subscription immediately">
                      <i data-feather="shield-off"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="7">No matching records found</td>
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
