
@extends('layouts/contentLayoutMaster')

@section('title', 'Open Shop')

@section('content')

@endsection
@section('vendor-script')
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection
@section('page-script')
<script>
window.onload = checkSwal;
async function checkSwal() {
    @if (!$company->is_open_shop && !$company->owner->is_master)
    var swalRes = await Swal.fire({
        icon: 'info',
        title: 'My Shop',
        text: 'Do you want open your store?',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: "Cancel",
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false
    })
    if (swalRes.isDismissed) {
        history.back(-1)
    }
    if (swalRes.isConfirmed) {
        $.ajax({
            type: 'POST',
            url: "{{ route('api.shop.open') }}",
            data: {
                id: '{{ $company->id }}'
            },
            success: function(result) {
                window.location.href = "{{ route('shop.packages.choose') }}"
            }
        })
    }
    console.log(swalRes)
    @endif
}
</script>
@endsection
