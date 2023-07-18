
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_MySubscriptions'))

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
        <h4 class="card-title">API Subscription</h4>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="15%">{{__('locale.tb_header_AggreeId')}}</th>
              <th width="10%">{{__('locale.tb_header_Description')}}</th>
              <th width="15%">{{__('locale.tb_header_StartedAt')}}</th>
              <th width="15%">{{__('locale.tb_header_NextBillingDate')}}</th>
              <th width="10%">{{__('locale.tb_header_Status')}}</th>
              <th width="20%">{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $entry)
                <tr>
                  <td>{{ $entry->pay_agreement_id }}</td>
                  <td>{{ $entry->description }}</td>
                  <td>{{ $entry->created_at }}</td>
                  <td>{{ $entry->next_billing_date }} </td>
                  <td>{{ $entry->status }}</td>
                  <td class="td-actions">
                    <a
                      class="btn btn-icon btn-success"
                      title="Subscription payments"
                      href="{{ route('api.subscriptions.payments', ['id' => $entry->id]) }}">
                      <i data-feather="dollar-sign"></i>
                    </a>
                    @if ($entry->status == 'ACTIVE')
                      <a
                        class="btn btn-icon btn-danger"
                        title="Cancel this subscription"
                        href="{{ route('api.subscriptions.cancel', ['id' => $entry->id]) }}" >
                        <i data-feather="x"></i>
                      </a>
                    @endif
                    @if ($entry->status == 'SUSPENDED')
                      <a
                        class="btn btn-icon btn-danger"
                        title="Reactivate this subscription immediately"
                        href="{{ route('api.subscriptions.reactive', ['id' => $entry->id]) }}" >
                        <i data-feather="play"></i>
                      </a>
                    @elseif ($entry->status == 'ACTIVE')
                      <a
                        class="btn btn-icon btn-danger"
                        title="Suspend this subscription immediately"
                        href="{{ route('api.subscriptions.suspend', ['id' => $entry->id]) }}" >
                        <i data-feather="pause"></i>
                      </a>
                    @endif
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
