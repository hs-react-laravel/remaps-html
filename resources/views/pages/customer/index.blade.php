
@extends('layouts/contentLayoutMaster')

@section('title', 'Customers')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Customers</h4>
        <a href="{{ route('customers.create') }}" class="btn btn-icon btn-primary">
          <i data-feather="user-plus"></i>
        </a>
      </div>
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
                  <td class="td-actions">
                    <a class="btn btn-icon btn-success" href="{{ url('/customers/'.$u->id.'/file-services') }}">
                      <i data-feather="file-text"></i>
                    </a>
                    <a class="btn btn-icon btn-success" href="{{ url('/customers/'.$u->id.'/switch-account') }}">
                      <i data-feather="user"></i>
                    </a>
                    <a class="btn btn-icon btn-success" href="{{ url('/customers/'.$u->id.'/transactions') }}">
                      <i data-feather="credit-card"></i>
                    </a>
                    <a class="btn btn-icon btn-success">
                      <i data-feather="mail"></i>
                    </a>
                    <a class="btn btn-icon btn-primary" href="{{ url('/customers/'.$u->id.'/edit') }}">
                      <i data-feather="edit"></i>
                    </a>
                    <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $u->id }}"><i data-feather="trash-2"></i></a>
                    <form action="{{ route('customers.destroy', $u->id) }}" class="delete-form" method="POST" style="display:none">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                  </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    {{ $users->links() }}
  </div>
</div>
@endsection
@section('vendor-script')
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection
@section('page-script')
<script>
  async function onDelete(obj) {
    var delete_form = $(obj).closest('.td-actions').children('.delete-form')
    var swal_result = await Swal.fire({
      title: 'Warning!',
      text: 'Are you sure to delete?',
      icon: 'warning',
      customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-danger ms-1'
      },
      showCancelButton: true,
      confirmButtonText: 'OK',
      cancelButtonText: 'Cancel',
      buttonsStyling: false
    });
    if (swal_result.isConfirmed) {
      delete_form.submit();
    }
  }
</script>
@endsection
