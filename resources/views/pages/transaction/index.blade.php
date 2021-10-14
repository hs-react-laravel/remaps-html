
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
              <th width="20%">Description</th>
              <th width="10%">Credits</th>
              <th width="10%">Status</th>
              <th width="10%">Date</th>
              <th width="10%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries as $e)
              <tr>
                <td>{{ $e->description }}</td>
                <td>{{ $e->credits_with_type }}</td>
                <td>{{ $e->status }}</td>
                <td>{{ $e->created_at }}</td>
                <td>
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
    {{ $entries->links() }}
  </div>
</div>
<!-- Basic Tables end -->
@endsection
