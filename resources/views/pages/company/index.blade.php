
@extends('layouts/contentLayoutMaster')

@section('title', 'Customers')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Manage Companies</h4>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="10%">Name</th>
              <th width="10%">Domain Link</th>
              <th width="10%">Total Customers</th>
              <th width="10%">Created At</th>
              <th width="25%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries as $u)
              <tr>
                  <td>{{ $u->name }}</td>
                  <td>{{ $u->domain_link }}</td>
                  <td>{{ $u->total_customers }}</td>
                  <td>{{ $u->created_at }}</td>
                  <td>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="award"></i>
                    </a>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="mail"></i>
                    </a>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="user"></i>
                    </a>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="dollar-sign"></i>
                    </a>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="lock"></i>
                    </a>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="thumbs-up"></i>
                    </a>
                    <a class="btn btn-icon btn-primary" href="{{ url('/companies/'.$u->id.'/edit') }}">
                      <i data-feather="edit"></i>
                    </a>
                    <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $u->id }}"><i data-feather="trash"></i></a>
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
