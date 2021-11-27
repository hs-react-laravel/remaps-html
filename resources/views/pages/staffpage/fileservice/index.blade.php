
@extends('layouts/contentLayoutMaster')

@section('title', 'File Services')

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
        <h4 class="card-title">File Services</h4>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="10%">{{__('locale.tb_header_JobNo')}}</th>
              <th width="20%">{{__('locale.tb_header_Car')}}</th>
              <th width="20%">{{__('locale.tb_header_License')}}</th>
              <th>Working</th>
              <th width="15%">{{__('locale.tb_header_CreatedAt')}}</th>
              <th width="20%">{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $entry)
                <tr>
                    <td>{{ $entry->displayable_id }}</td>
                    <td>{{ $entry->car }}</td>
                    <td>{{ $entry->license_plate }}</td>
                    <td> @if ($entry->staff) {{ $entry->staff->fullname }} @endif</td>
                    <td>{{ $entry->created_at }}</td>
                    <td class="td-actions">
                      <a class="btn btn-icon btn-primary" href="{{ route('stafffs.edit', ['stafff' => $entry->id]) }}">
                        <i data-feather="edit"></i>
                      </a>
                      @if ($user->is_admin)
                      <a
                        class="btn btn-icon btn-success"
                        href="{{ $entry->tickets
                          ? route('tickets.edit', ['ticket' => $entry->tickets->id])
                          : route('fileservice.tickets.create', ['id' => $entry->id]) }}">
                        <i data-feather="message-circle"></i>
                      </a>
                      @endif
                      @if ($user->is_staff)
                      <a
                        class="btn btn-icon btn-success"
                        href="{{ $entry->tickets
                          ? route('stafftk.edit', ['stafftk' => $entry->tickets->id])
                          : route('stafffs.tickets.create', ['id' => $entry->id]) }}">
                        <i data-feather="message-circle"></i>
                      </a>
                      @endif
                      @if($user->is_admin)
                      <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $entry->id }}"><i data-feather="trash-2"></i></a>
                      <form action="{{ route('stafffs.destroy', $entry->id) }}" class="delete-form" method="POST" style="display:none">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </form>
                      @endif
                    </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="6">No matching records found</td>
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
