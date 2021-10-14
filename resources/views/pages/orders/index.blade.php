
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
              <th width="20%">Order Date</th>
              <th width="20%">Company</th>
              <th width="20%">Amount</th>
              <th width="20%">Status</th>
              <th width="20%">Invoice No.</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries as $e)
              <tr>
                <td>{{ $e->created_at }}</td>
                <td>{{ $e->customer_company }}</td>
                <td>{{ $e->amount_with_sign }}</td>
                <td>{{ $e->status }}</td>
                <td>{{ $e->displayable_id }}</td>
                <td>
                  <a class="btn btn-icon btn-success">
                    <i data-feather="file"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    {{ $entries->links() }}
  </div>
</div>
<!-- Basic Tables end -->
@endsection
