
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_TuningTypes'))

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
  <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection
@php
  $route_prefix = "";
  if ($user->is_semi_admin) {
    $route_prefix = "staff.";
  }
@endphp
@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{__('locale.menu_TuningTypes')}}</h4>
        <div>
          <a href="{{ route($route_prefix.'tuning-types.group.create') }}" class="btn btn-icon btn-primary">
            New Tuning Type Group<i data-feather="plus"></i>
          </a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Group</th>
              <th>Tuning Types</th>
              <th>{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $entry)
                <tr>
                  <td @if($entry->is_default) style="font-weight: bold" @endif>{{ $entry->name }}</td>
                  <td>{{ $entry->tuningTypes()->count() }} Types</td>
                  <td class="td-actions">
                    @if (!$entry->is_system_default)
                      <a class="btn btn-icon btn-primary" href="{{ route($route_prefix.'tuning-types.group.edit', ['id' => $entry->id]) }}" title="Edit">
                        <i data-feather="edit"></i>
                      </a>
                    @endif
                    @if ($entry->is_default)
                      <a
                        class="btn btn-icon btn-dark"
                        title="Set Default" >
                        <i data-feather="check-circle"></i>
                      </a>
                    @else
                      <a
                        class="btn btn-icon btn-success"
                        href="{{ route($route_prefix.'tuning-types.group.default', ['id' => $entry->id]) }}" title="Set Default" >
                        <i data-feather="check-circle"></i>
                      </a>
                    @endif
                    @if (!$entry->is_system_default)
                      <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $entry->id }}" title="Delete"><i data-feather="trash-2"></i></a>
                    @endif
                  <form action="{{ route($route_prefix.'tuning-types.group.destroy', $entry->id) }}" class="delete-form" method="POST" style="display:none">
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
