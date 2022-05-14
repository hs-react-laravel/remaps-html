
@extends('layouts/contentLayoutMaster')

@section('title', 'Packages')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Packages</h4>
        <a href="{{ route('shoppackages.create') }}" class="btn btn-icon btn-primary">
          <i data-feather="plus"></i>
        </a>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="30%">Name</th>
              <th width="15%">Billing Interval</th>
              <th width="15%">Amount</th>
              <th width="15%">Product Count</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $e)
                <tr>
                  <td>{{ $e->name }}</td>
                  <td>{{ $e->billing_interval }}</td>
                  <td>{{ $e->amount_with_current_sign }}</td>
                  <td>{{ $e->product_count }}</td>
                  <td>
                    <a class="btn btn-icon btn-primary" href="{{ route('shoppackages.edit', ['shoppackage' => $e->id]) }}">
                      <i data-feather="edit"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="4">No matching records found</td>
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
