
@extends('layouts/contentLayoutMaster')

@section('title', ($group_type == 'evc' ? 'EVC' : '').__('locale.menu_TuningCredit'))
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
        <h4 class="card-title">{{ ($group_type == 'evc' ? 'EVC ' : '').__('locale.menu_TuningCredit') }}</h4>
        <div>
          @if ($group_type == 'normal')
            <a href="{{ route('tuning-tires.create') }}" class="btn btn-icon btn-primary" style="float: right">
              <i data-feather="plus"></i> Tier
            </a>
            <a href="{{ route('tuning-credits.create') }}" class="btn btn-icon btn-primary" style="float: right; margin-right: 20px">
              <i data-feather="plus"></i> Group
            </a>
          @else
            <a href="{{ route('evc-tuning-tires.create') }}" class="btn btn-icon btn-primary" style="float: right">
              <i data-feather="plus"></i> Tier
            </a>
            <a href="{{ route('evc-tuning-credits.create') }}" class="btn btn-icon btn-primary" style="float: right; margin-right: 20px">
              <i data-feather="plus"></i> Group
            </a>
          @endif
        </div>

      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Group</th>
              @foreach ($tires as $tire)
              <th class="th-tires">{{ $tire->amount }} Credits <br>
                <a href="#" onclick="onDeleteTire(this)">remove {{ $tire->amount }} Credits</a>
                @if ($group_type == 'normal')
                <form action="{{ route('tuning-tires.destroy', $tire->id) }}" class="delete-tire-form" method="POST" style="display:none">
                @else
                <form action="{{ route('evc-tuning-tires.destroy', $tire->id) }}" class="delete-tire-form" method="POST" style="display:none">
                @endif
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
              </th>
              @endforeach
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $entry)
                <tr>
                  <td @if($entry->set_default_tier) style="font-weight: bold" @endif>{{ $entry->name }}</td>
                  @foreach ($tires as $tire)
                    @php
                      $groupCreditTire = $tire->tuningCreditGroups()->where('tuning_credit_group_id', $entry->id)->withPivot('from_credit', 'for_credit')->first();
                    @endphp
                    <td @if($entry->set_default_tier) style="font-weight: bold" @endif">
                      {{ config('constants.currency_signs')[$company->paypal_currency_code] }} {{ number_format(@$groupCreditTire->pivot->from_credit, 2) }}
                      ->
                      {{ config('constants.currency_signs')[$company->paypal_currency_code] }} {{ number_format(@$groupCreditTire->pivot->for_credit, 2) }}
                    </td>
                  @endforeach
                  <td class="td-actions" @if($entry->set_default_tier) style="font-weight: bold" @endif">
                    @if ($group_type == 'normal')
                      <a class="btn btn-icon btn-primary" href="{{ route('tuning-credits.edit', ['tuning_credit' => $entry->id]) }}" title="Edit">
                        <i data-feather="edit"></i>
                      </a>
                      <a
                        class="btn btn-icon @if($entry->set_default_tier) btn-dark @else btn-success @endif"
                        href="{{ route('tuning-credits.default', ['id' => $entry->id]) }}" title="Set Default">
                        <i data-feather="check-circle"></i>
                      </a>
                    @else
                      <a class="btn btn-icon btn-primary" href="{{ route('evc-tuning-credits.edit', ['evc_tuning_credit' => $entry->id]) }}" title="Edit">
                        <i data-feather="edit"></i>
                      </a>
                      <a
                        class="btn btn-icon @if($entry->set_default_tier) btn-dark @else btn-success @endif"
                        href="{{ route('evc-tuning-credits.default', ['id' => $entry->id]) }}" title="Set Default">
                        <i data-feather="check-circle"></i>
                      </a>
                    @endif
                    @if (!$entry->is_system_default)
                    <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $entry->id }}" title="Delete"><i data-feather="trash-2"></i></a>
                    @endif
                    <form action="{{ route('tuning-credits.destroy', $entry->id) }}" class="delete-form" method="POST" style="display:none">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="{{ count($tires) + 2 }}">No matching records found</td>
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
  async function onDeleteTire(obj) {
    var delete_form = $(obj).closest('.th-tires').children('.delete-tire-form')
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
