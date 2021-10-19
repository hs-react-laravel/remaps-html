
@extends('layouts/contentLayoutMaster')

@section('title', 'File Services')

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
              <th width="10%">Job No.</th>
              <th width="20%">Car</th>
              <th width="20%">License Plate</th>
              <th width="15%">Created At</th>
              <th width="20%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries as $e)
              <tr>
                  <td>{{ $e->displayable_id }}</td>
                  <td>{{ $e->car }}</td>
                  <td>{{ $e->license_plate }}</td>
                  <td>{{ $e->created_at }}</td>
                  <td>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="message-circle"></i>
                    </a>
                    <a class="btn btn-icon btn-primary" href="{{ url('/fileservices/'.$e->id.'/edit') }}">
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
