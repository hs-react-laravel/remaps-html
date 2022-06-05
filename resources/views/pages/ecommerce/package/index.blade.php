
@extends('layouts/contentLayoutMaster')

@section('title', 'Packages')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Packages</h4>
        <a href="{{ route('shoppackages.create') }}" class="btn btn-icon btn-primary">
          <i data-feather="plus"></i>
        </a>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="30%">Name</th>
              <th width="15%">Billing Interval</th>
              <th width="15%">Amount</th>
              <th width="15%">Product Count</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $e)
                <tr>
                  <td>{{ $e->name }}</td>
                  <td>{{ $e->billing_interval }}</td>
                  <td>{{ $e->amount_with_current_sign }}</td>
                  <td>{{ $e->product_count }}</td>
                  <td class="td-actions">
                    <a class="btn btn-icon btn-primary" href="{{ route('shoppackages.edit', ['shoppackage' => $e->id]) }}">
                      <i data-feather="edit"></i>
                    </a>
                    <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $e->id }}" title="Delete">
                      <i data-feather="trash-2"></i>
                    </a>
                    <form action="{{ route('shoppackages.destroy', $e->id) }}" class="delete-form" method="POST" style="display:none">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="4">No matching records found</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Basic Tables end -->
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
        text: 'Are you sure to delete this package?',
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
