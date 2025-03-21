
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Customers'))

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
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
        <h4 class="card-title">{{__('locale.menu_Customers')}}</h4>
        <div>
            <div class="form-check form-check-inline my-1">
                <form id="aceept-form" class="form" action="{{ route('company.accept', ['id' => $company->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="is_accept_new_customer" value="0" />
                    <input class="form-check-input" type="checkbox" id="is_accept_new_customer" name="is_accept_new_customer" value="1" @if($company->is_accept_new_customer) checked @endif/>
                    <label class="form-check-label" for="is_accept_new_customer">Automatically accept registrations</label>
                </form>
            </div>
            <a href="{{ route('customers.create') }}" class="btn btn-icon btn-primary">
            <i data-feather="user-plus"></i>
            </a>
        </div>
      </div>
      <div class="table-responsive m-1 mt-0">
        <table class="table table-data">
          <thead>
            <tr>
              <th width="10%">{{__('locale.tb_header_Name')}}</th>
              <th width="10%">{{__('locale.tb_header_Company')}}</th>
              <th width="10%">{{__('locale.tb_header_Email')}}</th>
              <th width="5%">{{__('locale.tb_header_TuningCredits')}}</th>
              <th width="10%">{{__('locale.tb_header_TuningPriceGroup')}}</th>
              @if ($user->company->reseller_id)
              <th width="10%">{{__('locale.tb_header_EVCTuningPriceGroup')}}</th>
              @endif
              <th width="5%">{{__('locale.tb_header_FileService')}}</th>
              <th width="10%">{{__('locale.tb_header_Lastlogin')}}</th>
              <th width="30%">{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('vendor-script')
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
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
  async function onBlock(obj) {
    var block_form = $(obj).closest('.td-actions').children('.block-form')
    var swal_result = await Swal.fire({
      title: 'Warning!',
      text: 'Are you sure to block this customer?',
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
        block_form.submit();
    }
  }
  async function onAllow(obj) {
    var block_form = $(obj).closest('.td-actions').children('.unblock-form')
    var swal_result = await Swal.fire({
      title: 'Warning!',
      text: 'Are you sure to allow this customer?',
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
        block_form.submit();
    }
  }
  var dt_ajax;
  $(window).on('load', function() {
    var dt_ajax_table = $('.table-data')
    var urlParams = new URLSearchParams(window.location.search)
    var pageNum = urlParams.get('page') ? Number(urlParams.get('page')) : 0
    console.log(pageNum)
    dt_ajax = dt_ajax_table.DataTable({
      processing: true,
      serverSide: true,
      displayStart: 15 * pageNum,
      // bSort: false,
      dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end align-items-baseline"f<"dt-action-buttons text-end ms-1"B>>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-primary dropdown-toggle',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
          buttons: [
            {
              extend: 'print',
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
              extend: 'csv',
              text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            }
          ],
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function () {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          }
        }
      ],
      ajax: {
          url: "{{ route('staff.customer.api') }}",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: function(data) {
            data.id = "{{ $user->id }}"
          },
          dataSrc: function (res) {
            return res.data;
          },
      },
      columns: [
        { data: 'name'},
        { data: 'company' },
        { data: 'email' },
        { data: 'tuning_credits' },
        { data: 'tuning_price_group' },
        @if ($user->company->reseller_id) { data: 'evc_tuning_price_group' }, @endif
        { data: 'fileservice_ct' },
        { data: 'last_login' },
        { data: 'actions' },
      ],
      columnDefs: [{
        @if ($user->company->reseller_id)
        targets: [6, 8],
        @else
        targets: [5, 7],
        @endif
        orderable: false,
        searchable: false,
      }],
      lengthMenu: [[15, 25, 50, 1000], [15, 25, 50, 'All']],
      createdRow: function(row, data, index) {
        var blockEle = '';
        @if(!$company->is_accept_new_customer)
            blockEle = `
                <a class="btn btn-icon btn-danger" onclick="onBlock(this)" title="Block">
                    ${feather.icons['thumbs-down'].toSvg()}
                </a>
            `;
            if (!data['is_verified']) {
                blockEle = `
                    <a class="btn btn-icon btn-success" onclick="onAllow(this)" title="Allow">
                        ${feather.icons['thumbs-up'].toSvg()}
                    </a>
                    <a class="btn btn-icon btn-danger" onclick="onBlock(this)" title="Block">
                        ${feather.icons['thumbs-down'].toSvg()}
                    </a>
                `;
            }
        @endif
        $('td', row).addClass('td-actions')
        @if ($user->company->reseller_id) $('td', row).eq(8).html(`
        @else ($user->company->reseller_id) $('td', row).eq(7).html(`
        @endif
          <a class="btn btn-icon btn-primary" href="${data['route.edit']}" title="Edit">
            ${feather.icons['edit'].toSvg()}
          </a>
          <a class="btn btn-icon btn-success" href="${data['route.fs']}" title="File Services">
            ${feather.icons['file-text'].toSvg()}
          </a>
          <a class="btn btn-icon btn-success" target="_blank" href="${data['route.sa']}" title="Login as Customer">
            ${feather.icons['user'].toSvg()}
          </a>
          <a class="btn btn-icon btn-success" href="${data['route.tr']}" title="Transactions">
            ${feather.icons['credit-card'].toSvg()}
          </a>
          <a class="btn btn-icon btn-success" href="${data['route.rp']}" title="Send Password Reset Link">
            ${feather.icons['mail'].toSvg()}
          </a>`+ blockEle +`
          <a class="btn btn-icon btn-danger" onclick="onDelete(this)" title="Delete">
            ${feather.icons['trash-2'].toSvg()}
          </a>
          <form action="${data['route.destroy']}" class="delete-form" method="POST" style="display:none">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
          <form action="${data['route.block']}" class="block-form" method="POST" style="display:none">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
          <form action="${data['route.allow']}" class="unblock-form" method="POST" style="display:none">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        `);
      },
      language: {
        paginate: {
          // remove previous & next text from pagination
          previous: '&nbsp;',
          next: '&nbsp;'
        }
      }
    });

    $('.table-data').on('page.dt', function() {
      var info = dt_ajax.page.info()
      window.history.replaceState(null, null, `?page=${info.page}`)
    })
    $('.table-data').on('init.dt', function() {
        console.log('init')
        dt_ajax.page(pageNum).draw('page')
    })
  })
  $('#is_accept_new_customer').on('change', function() {
      $('#aceept-form').submit();
  });
</script>
@endsection
