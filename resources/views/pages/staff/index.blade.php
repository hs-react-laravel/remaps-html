
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
        <a href="{{ route('staffs.create') }}" class="btn btn-icon btn-primary">
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
            @foreach ($entries as $entry)
              <tr>
                  <td>{{ $entry->fullName }}</td>
                  <td>{{ $entry->business_name }}</td>
                  <td>{{ number_format($entry->tuning_credits, 2) }}</td>
                  <td>{{ $entry->tuningPriceGroup }}</td>
                  <td>{{ $entry->fileServicesCount }}</td>
                  <td>{{ $entry->lastLoginDiff }}</td>
                  <td class="td-actions">
                    <a class="btn btn-icon btn-primary" href="{{ route('customers.edit', ['customer' => $entry->id]) }}">
                      <i data-feather="edit"></i>
                    </a>
                    <a class="btn btn-icon btn-success" target="_blank" href="{{ route('customer.sa', ['id' => $entry->id]) }}">
                      <i data-feather="user"></i>
                    </a>
                    <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $entry->id }}"><i data-feather="trash-2"></i></a>
                    <form action="{{ route('customers.destroy', $entry->id) }}" class="delete-form" method="POST" style="display:none">
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
    {{ $entries->links() }}
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
