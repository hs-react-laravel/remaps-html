
@extends('layouts/contentLayoutMaster')

@section('title', 'Support Tickets')

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
              <th width="20%">Client</th>
              <th width="20%">File Service</th>
              <th width="20%">Ticket Status</th>
              <th width="20%">Created At</th>
              <th width="20%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries as $e)
              <tr>
                <td>{{ $e->client }}</td>
                <td>{{ $e->file_service_name }}</td>
                <td>{{ $e->closed ? 'Closed' : 'Open' }}</td>
                <td>{{ $e->created_at }}</td>
                <td>
                  <a class="btn btn-icon btn-primary">
                    <i data-feather="edit"></i>
                  </a>
                  <a class="btn btn-icon btn-danger">
                    <i data-feather="trash-2"></i>
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
