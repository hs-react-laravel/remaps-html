
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
        <h4 class="card-title">Shop Subscription</h4>
        <a href="{{ route('shop.packages.choose') }}" class="btn btn-icon btn-primary">
          Choose Package
        </a>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="15%">{{__('locale.tb_header_AggreeId')}}</th>
              <th width="10%">{{__('locale.tb_header_Package_Name')}}</th>
              <th width="5%">{{__('locale.tb_header_Product_Count')}}</th>
              <th width="10%">{{__('locale.tb_header_Description')}}</th>
              <th width="15%">{{__('locale.tb_header_StartedAt')}}</th>
              <th width="15%">{{__('locale.tb_header_NextBillingDate')}}</th>
              <th width="5%">{{__('locale.tb_header_Type')}}</th>
              <th width="10%">{{__('locale.tb_header_Status')}}</th>
              <th width="20%">{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $entry)
                <tr>
                  <td>{{ $entry->pay_agreement_id }}</td>
                  @if (isset($entry->package))
                  <td>{{ $entry->package->name }}</td>
                  <td>{{ $entry->package->product_count }}</td>
                  @endif
                  <td>{{ $entry->description }}</td>
                  <td>{{ $entry->created_at }}</td>
                  <td>{{ $entry->is_trial
                  ? \Carbon\Carbon::parse($entry->start_date)->addDays($entry->trial_days)->format('d M Y g:i A')
                  : $entry->next_billing_date }} </td>
                  <td>{{ $entry->is_trial ? 'Trial' : 'Paid' }}</td>
                  <td>{{ $entry->status }}</td>
                  <td class="td-actions">
                    <a
                      class="btn btn-icon btn-success"
                      title="Subscription payments"
                      href="{{ route('shop.subscriptions.payments', ['id' => $entry->id]) }}">
                      <i data-feather="dollar-sign"></i>
                    </a>
                    @if ($entry->status == 'ACTIVE')
                      <a
                        class="btn btn-icon btn-danger"
                        title="Cancel this subscription"
                        href="{{ route('shop.subscriptions.cancel', ['id' => $entry->id]) }}" >
                        <i data-feather="x"></i>
                      </a>
                    @endif
                    @if ($entry->status == 'SUSPENDED')
                      <a
                        class="btn btn-icon btn-danger"
                        title="Reactivate this subscription immediately"
                        href="{{ route('shop.subscriptions.reactive', ['id' => $entry->id]) }}" >
                        <i data-feather="play"></i>
                      </a>
                    @elseif ($entry->status == 'ACTIVE')
                      <a
                        class="btn btn-icon btn-danger"
                        title="Suspend this subscription immediately"
                        href="{{ route('shop.subscriptions.suspend', ['id' => $entry->id]) }}" >
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
