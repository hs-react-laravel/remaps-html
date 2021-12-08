
@extends('layouts/contentLayoutMaster')

@section('title', 'Transactions')

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
        <h4 class="card-title">Transactions</h4>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="20%">{{__('locale.tb_header_Description')}}</th>
              <th width="10%">{{__('locale.tb_header_Credits')}}</th>
              <th width="10%">{{__('locale.tb_header_Status')}}</th>
              <th width="10%">{{__('locale.tb_header_Date')}}</th>
              @if($user->is_admin)
              <th width="10%">{{__('locale.tb_header_Actions')}}</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $e)
                <tr>
                  <td>{{ $e->description }}</td>
                  <td>{{ $e->credits_with_type }}</td>
                  <td>{{ $e->status }}</td>
                  <td>{{ $e->created_at }}</td>
                  @if($user->is_admin)
                  <td>
                    <a class="btn btn-icon btn-danger" onclick="onDelete(this)" title="Delete">
                      <i data-feather="trash-2"></i>
                    </a>
                    <form action="{{ route('transactions.destroy', $e->id) }}" class="delete-form" method="POST" style="display:none">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                  </td>
                  @endif
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
