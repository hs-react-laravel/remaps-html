
@extends('layouts/contentLayoutMaster')

@section('title', 'Orders')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      {{-- <div class="card-header">
        <h4 class="card-title">Table Basic</h4>
      </div>
      <div class="card-body">
        <p class="card-text"></p>
      </div> --}}
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Group</th>
              @foreach ($tires as $tire)
                <th>{{ $tire->amount }} Credits</th>
              @endforeach
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries as $entry)
              <tr>
                <td>{{ $entry->name }}</td>
                @foreach ($tires as $tire)
                  @php
                    $groupCreditTire = $tire->tuningCreditGroups()->where('tuning_credit_group_id', $entry->id)->withPivot('from_credit', 'for_credit')->first();
                  @endphp
                  <td>
                    {{ config('constants.currency_sign') }} {{ number_format(@$groupCreditTire->pivot->from_credit, 2) }}
                    ->
                    {{ config('constants.currency_sign') }} {{ number_format(@$groupCreditTire->pivot->for_credit, 2) }}
                  </td>
                @endforeach
                <td>
                  <a class="btn btn-icon btn-success">
                    <i data-feather="check-circle"></i>
                  </a>
                  <a class="btn btn-icon btn-primary" href="{{ url('/tuning-credits/'.$entry->id.'/edit') }}">
                    <i data-feather="edit"></i>
                  </a>
                  <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $entry->id }}"><i data-feather="trash"></i></a>
                  <form action="{{ route('tuning-credits.destroy', $entry->id) }}" class="delete-form" method="POST" style="display:none">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Basic Tables end -->
@endsection
