
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Shop_categories'))

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{__('locale.menu_Shop_categories')}}</h4>
        <a href="{{ route('shopcategories.create') }}" class="btn btn-icon btn-primary">
          New Category
        </a>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="20%">{{__('locale.tb_header_Name')}}</th>
              <th width="5%">{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
            @foreach ($entries as $entry)
              <tr>
                  <td>{{ $entry->name }}</td>
                  <td class="td-actions">
                    <a class="btn btn-icon btn-primary" href="{{ route('shopcategories.edit', ['shopcategory' => $entry->id]) }}" title="Edit">
                      <i data-feather="edit"></i>
                    </a>
                    <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $entry->id }}" title="Delete"><i data-feather="trash-2"></i></a>
                    <form action="{{ route('shopcategories.destroy', $entry->id) }}" class="delete-form" method="POST" style="display:none">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                  </td>
              </tr>
            @endforeach
            @else
              <tr>
                <td colspan="2">No matching records found</td>
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
    window.onload = checkSwal;
    async function checkSwal() {
        @if (!$company->is_first_shop && !$company->owner->is_master)
        var swalRes = await Swal.fire({
            icon: 'info',
            title: '{{ $shopGuide->title }}',
            text: '{{ $shopGuide->content }}',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: "Don't show again",
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        })
        if (swalRes.isDismissed && swalRes.dismiss == 'cancel') {
            $.ajax({
                type: 'POST',
                url: "{{ route('api.shop.readguide') }}",
                data: {
                    id: '{{ $company->id }}'
                },
                success: function(result) {
                    console.log(result);
                }
            })
        }
        @endif
    }
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
