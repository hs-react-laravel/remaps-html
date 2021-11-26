
@extends('layouts/contentLayoutMaster')

@section('title', 'File Services')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">File Services</h4>
        <a href="{{ route('fs.create') }}" class="btn btn-icon btn-primary">
          Create New
        </a>
      </div>
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
            @if (count($entries) > 0)
              @foreach ($entries as $entry)
                <tr>
                    <td>{{ $entry->displayable_id }}</td>
                    <td>{{ $entry->car }}</td>
                    <td>{{ $entry->license_plate }}</td>
                    <td>{{ $entry->created_at }}</td>
                    <td>
                      <a class="btn btn-icon btn-success" href="{{ route('fs.tickets.create', ['id' => $entry->id]) }}">
                        <i data-feather="message-circle"></i>
                      </a>
                      <a class="btn btn-icon btn-success" href="{{ route('fs.download.original', ['id' => $entry->id]) }}">
                        <i data-feather="download"></i>
                      </a>
                      <a class="btn btn-icon btn-success" href="{{ route('fs.download.modified', ['id' => $entry->id]) }}">
                        <i data-feather="download-cloud"></i>
                      </a>
                      <a class="btn btn-icon btn-primary" href="{{ route('fs.edit', ['f' => $entry->id]) }}">
                        <i data-feather="edit"></i>
                      </a>
                    </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="5">No matching records found</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    {{ $entries->links() }}
  </div>
</div>
<!-- Basic Tables end -->
@endsection
