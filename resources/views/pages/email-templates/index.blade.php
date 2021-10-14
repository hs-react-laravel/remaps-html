
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
              <th width="20%">Email Type</th>
              <th width="20%">Subject</th>
              <th width="20%">Modified At</th>
              <th width="5%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries as $u)
              <tr>
                  <td>{{ $u->email_type }}</td>
                  <td>{{ $u->subject }}</td>
                  <td>{{ $u->created_at }}</td>
                  <td>
                    <a class="btn btn-icon btn-primary">
                      <i data-feather="edit"></i>
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
