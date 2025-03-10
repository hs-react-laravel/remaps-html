
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_TuningTypes'))

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
        <h4 class="card-title">{{__('locale.menu_TuningTypes')}}</h4>
        <div>
          @if ($user->is_admin)
            <a href="{{ route('tuning-types.group.index') }}" class="btn btn-icon btn-primary">
              Groups
            </a>
            <a href="{{ route('tuning-types.create') }}" class="btn btn-icon btn-primary">
              New Tuning Type<i data-feather="plus"></i>
            </a>
          @elseif ($user->is_semi_admin)
            <a href="{{ route('staff.tuning-types.group.index') }}" class="btn btn-icon btn-primary">
              Groups
            </a>
            <a href="{{ route('staff.tuning-types.create') }}" class="btn btn-icon btn-primary">
              New Tuning Type<i data-feather="plus"></i>
            </a>
          @endif
        </div>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>{{__('locale.tb_header_Label')}}</th>
              <th>{{__('locale.tb_header_Credits')}}</th>
              <th>{{__('locale.tb_header_TuningOptions')}}</th>
              <th>{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $entry)
                <tr>
                  <td>{{ $entry->label }}</td>
                  <td>{{ $entry->credits }}</td>
                  <td>
                    @if ($user->is_admin)
                    <a href="{{ route('options.index', ['id' => $entry->id]) }}">
                      {{ $entry->tuningTypeOptions()->count() }} tuning options
                    </a>
                    @elseif ($user->is_semi_admin)
                    <a href="{{ route('staff.options.index', ['id' => $entry->id]) }}">
                      {{ $entry->tuningTypeOptions()->count() }} tuning options
                    </a>
                    @endif
                  </td>
                  @if ($user->is_admin)
                    <td class="td-actions">
                      <a class="btn btn-icon btn-primary" href="{{ route('tuning-types.edit', ['tuning_type' => $entry->id]) }}" title="Edit">
                        <i data-feather="edit"></i>
                      </a>
                      <a class="btn btn-icon btn-success" href="{{ route('tuning-types.sort-up', ['id' => $entry->id]) }}" title="Move Up">
                        <i data-feather="arrow-up"></i>
                      </a>
                      <a class="btn btn-icon btn-success" href="{{ route('tuning-types.sort-down', ['id' => $entry->id]) }}" title="Move Down">
                        <i data-feather="arrow-down"></i>
                      </a>
                      <a class="btn btn-icon btn-danger" onclick="onDelete(this)" title="Delete">
                        <i data-feather="trash-2"></i>
                      </a>
                      <form action="{{ route('tuning-types.destroy', $entry->id) }}" class="delete-form" method="POST" style="display:none">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </form>
                    </td>
                  @elseif ($user->is_semi_admin)
                    <td class="td-actions">
                      <a class="btn btn-icon btn-primary" href="{{ route('staff.tuning-types.edit', ['tuning_type' => $entry->id]) }}" title="Edit">
                        <i data-feather="edit"></i>
                      </a>
                      <a class="btn btn-icon btn-success" href="{{ route('staff.tuning-types.sort-up', ['id' => $entry->id]) }}" title="Move Up">
                        <i data-feather="arrow-up"></i>
                      </a>
                      <a class="btn btn-icon btn-success" href="{{ route('staff.tuning-types.sort-down', ['id' => $entry->id]) }}" title="Move Down">
                        <i data-feather="arrow-down"></i>
                      </a>
                      <a class="btn btn-icon btn-danger" onclick="onDelete(this)" title="Delete">
                        <i data-feather="trash-2"></i>
                      </a>
                      <form action="{{ route('staff.tuning-types.destroy', $entry->id) }}" class="delete-form" method="POST" style="display:none">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </form>
                    </td>
                  @endif
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
