
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
              <th width="30%">Name</th>
              <th width="20%">Billing Interval</th>
              <th width="20%">Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries as $e)
              <tr>
                <td>{{ $e->name }}</td>
                <td>{{ $e->billing_interval }}</td>
                <td>{{ $e->amount_with_current_sign }}</td>
                <td>
                  <a class="btn btn-icon btn-primary">
                    <i data-feather="edit"></i>
                  </a>
                  <a class="btn btn-icon btn-danger">
                    <i data-feather="trash"></i>
                  </a>
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
