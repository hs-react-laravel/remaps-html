
@extends('layouts/contentLayoutMaster')

@section('title', 'Customers')

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
              <th width="10%">Name</th>
              <th width="10%">Company</th>
              <th width="5%">Tuning Credits</th>
              <th width="10%">Tuning Price Group</th>
              <th width="5%">File Service</th>
              <th width="10%">Last Login</th>
              <th width="20%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $u)
              <tr>
                  <td>{{ $u->fullName }}</td>
                  <td>{{ $u->business_name }}</td>
                  <td>{{ number_format($u->tuning_credits, 2) }}</td>
                  <td>{{ $u->tuningPriceGroup }}</td>
                  <td>{{ $u->fileServicesCount }}</td>
                  <td>{{ $u->lastLoginDiff }}</td>
                  <td>
                    <a class="btn btn-icon btn-primary">
                      <i data-feather="edit"></i>
                    </a>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="file-text"></i>
                    </a>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="user"></i>
                    </a>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="credit-card"></i>
                    </a>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="mail"></i>
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
{{ $users->links() }}
<!-- Basic Tables end -->
@endsection
