
@extends('layouts/contentLayoutMaster')

@section('title', 'Transactions')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
  <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
  <style>
      .theme-show {
          width: 20px;
          height: 20px;
          border-radius: 100%;
      }
  </style>
@endsection

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Updates</h4>
        <div>
            <a href="{{ route('adminupdates.bottom') }}" class="btn btn-icon btn-primary">
                Bottom History
            </a>
            <a href="{{ route('adminupdates.create') }}" class="btn btn-icon btn-primary">
                <i data-feather="plus"></i>
            </a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="2%">Theme</th>
              <th width="40%">Message</th>
              <th width="15%">{{__('locale.tb_header_Date')}}</th>
              <th width="20%">{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $e)
                <tr>
                  <td>
                      <div class="theme-show bg-{{ $e->theme }}"></div>
                  </td>
                  <td>{{ $e->message }}</td>
                  <td>{{ $e->created_at }}</td>
                  <td class="td-actions">
                    <a class="btn btn-icon btn-primary" href="{{ route('adminupdates.edit', ['adminupdate' => $e->id]) }}" title="Edit">
                      <i data-feather="edit"></i>
                    </a>
                    @if(!$e->closed)
                    <a class="btn btn-icon btn-primary" href="{{ route('adminupdates.close', ['id' => $e->id]) }}" title="Close">
                      <i data-feather="eye-off"></i>
                    </a>
                    @else
                    <a class="btn btn-icon btn-primary" href="{{ route('adminupdates.open', ['id' => $e->id]) }}" title="Open">
                      <i data-feather="eye"></i>
                    </a>
                    @endif
                    <a class="btn btn-icon btn-danger" onclick="onDelete(this)" title="Delete">
                      <i data-feather="trash-2"></i>
                    </a>
                    <form action="{{ route('adminupdates.destroy', $e->id) }}" class="delete-form" method="POST" style="display:none">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
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
