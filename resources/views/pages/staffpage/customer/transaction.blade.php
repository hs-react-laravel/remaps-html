
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
<div class="row">
  <div class="col-md-12 col-xl-6">
    <div class="card">
      <div class="card-header">
        <h4 class="header-text">Add Transaction</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('customer.tr.post', ['id' => $id]) }}" method="POST">
          @csrf
          <input type="hidden" name="user_id" value="{{ $id }}">
          <input type="hidden" name="type" value="normal">
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label" for="description">Description</label>
              <input type="text" class="form-control" id="description" name="description" required />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label" for="credits">Credits</label>
              <input type="number" class="form-control" id="credits" name="credits" step="0.01" required />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label" for="type">Add / Take Credits</label>
              <select class="form-select" id="type" name="type" required>
                <option value="">Select Option</option>
                <option value="A">Give (+)</option>
                <option value="S">Take (-)</option>
              </select>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary me-1">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @if($company->reseller_id && $user->reseller_id)
  <div class="col-md-12 col-xl-6">
    <div class="card">
      <div class="card-header">
        <h4 class="header-text">Add Transaction(EVC)</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('customer.tr.evc.post', ['id' => $id]) }}" method="POST">
          @csrf
          <input type="hidden" name="user_id" value="{{ $id }}">
          <input type="hidden" name="type" value="evc">
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label" for="description">Description</label>
              <input type="text" class="form-control" id="description" name="description" required />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label" for="credits">Credits</label>
              <input type="number" class="form-control" id="credits" name="credits" required />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label" for="type">Customer Type</label>
              <select class="form-select" id="type" name="type" required>
                <option value="">Select Option</option>
                <option value="A">Give (+)</option>
                <option value="S">Take (-)</option>
              </select>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary me-1">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endif
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Transactions</h4>
      </div>
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
            @if (count($entries) > 0)
              @foreach ($entries as $e)
                <tr>
                  <td>{{ $e->description }}</td>
                  <td>{{ $e->credits_with_type }}</td>
                  <td>{{ $e->status }}</td>
                  <td>{{ $e->created_at }}</td>
                  <td>
                    <a class="btn btn-icon btn-danger" onclick="onDelete(this)">
                      <i data-feather="trash-2"></i>
                    </a>
                    <form action="{{ route('transactions.destroy', $e->id) }}" class="delete-form" method="POST" style="display:none">
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
