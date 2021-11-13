
@extends('layouts/contentLayoutMaster')

@section('title', 'Companies')

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
        <h4 class="card-title">Manage Companies</h4>
        <a href="{{ route('companies.create') }}" class="btn btn-icon btn-primary">
          <i data-feather="user-plus"></i>
        </a>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="10%">Name</th>
              <th width="10%">Domain Link</th>
              <th width="10%">Total Customers</th>
              <th width="10%">Created At</th>
              <th width="25%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->v2_domain_link }}</td>
                    <td>{{ $u->total_customers }}</td>
                    <td>{{ $u->created_at }}</td>
                    <td class="td-actions">
                      <a
                        class="btn btn-icon btn-primary"
                        href="{{ route('companies.edit', ['company' => $u->id]) }}"
                        title="Edit" >
                        <i data-feather="edit"></i>
                      </a>
                      <a
                        class="btn btn-icon btn-success"
                        title="Subscriptions"
                        href="{{ route('subscriptions.index', ['company' => $u->id]) }}" >
                        <i data-feather="award"></i>
                      </a>
                      @if($u->owner)
                      <a
                        class="btn btn-icon btn-success"
                        title="Resend password reset link"
                        href="{{ route('companies.reset-password', ['id' => $u->id]) }}" >
                        <i data-feather="mail"></i>
                      </a>
                      <a
                        class="btn btn-icon btn-success"
                        title="Login as this company"
                        href="{{ route('companies.switch', ['id' => $u->id]) }}"
                        target="_blank" >
                        <i data-feather="user"></i>
                      </a>
                      @else
                      <a
                        class="btn btn-icon btn-secondary"
                        title="Resend password reset link" >
                        <i data-feather="mail"></i>
                      </a>
                      <a
                        class="btn btn-icon btn-secondary"
                        title="Login as this company" >
                        <i data-feather="user"></i>
                      </a>
                      @endif

                      @if($u->owner && !$u->owner->hasActiveSubscription())
                        <a
                          class="btn btn-icon btn-success"
                          title="Add trial subscription for this company"
                          href="{{ route('companies.trial', ['id' => $u->id]) }}" >
                          <i data-feather="pocket"></i>
                        </a>
                      @else
                        <a
                          class="btn btn-icon btn-secondary"
                          title="Add trial subscription for this company" >
                          <i data-feather="pocket"></i>
                        </a>
                      @endif
                      <a
                        class="btn btn-icon btn-success"
                        title="{{ $u->is_public ? 'Private' : 'Public' }}"
                        href="{{ route('companies.public', ['id' => $u->id]) }}" >
                        <i data-feather="{{ $u->is_public ? 'lock' : 'users'}}"></i>
                      </a>
                      <a
                        class="btn btn-icon btn-success"
                        title="{{ $u->owner && $u->owner->is_active == 1 ? 'Active' : 'Deactive' }}"
                        href="{{ route('companies.activate', ['id' => $u->id]) }}" >
                        <i data-feather="{{ $u->owner && $u->owner->is_active == 1 ? 'thumbs-down' : 'thumbs-up' }}"></i>
                      </a>
                      <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $u->id }}"><i data-feather="trash-2"></i></a>
                      <form action="{{ route('companies.destroy', $u->id) }}" class="delete-form" method="POST" style="display:none">
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
