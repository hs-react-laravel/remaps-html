
@extends('layouts/contentLayoutMaster')

@section('title', 'File Services')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
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
        <h4 class="card-title">{{ isset($_GET['status']) ? config('constants.file_service_staus')[$_GET['status']] : '' }} File Services</h4>
      </div>
      <div class="card-body p-1 pb-0">
        <form class="dt_adv_search" method="POST">
          <div class="row g-1 mb-md-1">
            <div class="col-md-4">
              <label class="form-label">Customer:</label>
              <select class="form-select" id="customer" name="customer" required>
                <option value="">-</option>
                @foreach ($customers as $customer)
                  <option value="{{ $customer->id }}" @if(isset($customer_id) && $customer->id == $customer_id) selected @endif>{{ $customer->full_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Status:</label>
              <select class="form-select" id="status" name="status">
                <option value="">-</option>
                @foreach (config('constants.file_service_staus') as $key => $value)
                  <option value="{{$key}}" @if(isset($_GET['status']) && $_GET['status'] == $key) selected @endif>{{$value}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Date:</label>
              <div class="mb-0">
                <div class="input-group mb-2">
                  <input
                    type="text"
                    class="form-control dt-date flatpickr-range dt-input"
                    data-column="5"
                    placeholder="StartDate to EndDate"
                    data-column-index="4"
                    name="dt_date"
                  />
                  <span class="input-group-text cursor-pointer" onclick="onClearDateRange()"><i data-feather="trash"></i></span>
                </div>
                <input
                  type="hidden"
                  class="form-control dt-date start_date dt-input"
                  data-column="5"
                  data-column-index="4"
                  name="value_from_start_date"
                  id="start_date"
                />
                <input
                  type="hidden"
                  class="form-control dt-date end_date dt-input"
                  name="value_from_end_date"
                  data-column="5"
                  data-column-index="4"
                  id="end_date"
                />
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="table-responsive m-1 mt-0">
        <table class="table table-data">
          <thead>
            <tr>
              <th width="10%">{{__('locale.tb_header_JobNo')}}</th>
              <th width="20%">{{__('locale.tb_header_Car')}}</th>
              <th width="20%">{{__('locale.tb_header_License')}}</th>
              <th>{{__('locale.tb_Customer')}}</th>
              <th width="15%">{{__('locale.tb_header_CreatedAt')}}</th>
              <th width="20%">{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
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
  var dt_ajax
  $(window).on('load', function() {
    var dt_ajax_table = $('.table-data')
    dt_ajax = dt_ajax_table.DataTable({
      processing: true,
      serverSide: true,
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
              exportOptions: { columns: [0, 1, 2, 3, 4] }
            },
            {
              extend: 'csv',
              text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2, 3, 4] }
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2, 3, 4] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2, 3, 4] }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2, 3, 4] }
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
          url: "{{ route('fileservices.api') }}",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: function(data) {
            data.id = "{{ $user->id }}",
            data.status = $('#status').val()
            data.customer = $('#customer').val()
            data.start_date = $('#start_date').val()
            data.end_date = $('#end_date').val()
          },
          dataSrc: function (res) {
            return res.data;
          },
      },
      columns: [
        { data: 'displayable_id' },
        { data: 'car' },
        { data: 'license_plate' },
        { data: 'customer' },
        { data: 'created_at' },
        { data: 'actions' },
      ],
      columnDefs: [{
        targets: [1, 3, 5],
        orderable: false,
        searchable: false,
      }],
      order: [[0, 'desc']],
      createdRow: function(row, data, index) {
        $('td', row).eq(5).addClass('td-actions')
        $('td', row).eq(5).html(`
          <a class="btn btn-icon btn-primary" href="${data['route.edit']}" title="Edit">
            ${feather.icons['edit'].toSvg()}
          </a>
          <a class="btn btn-icon btn-success"title="Ticket" href=${data['route.ticket']}>
            ${feather.icons['message-circle'].toSvg()}
          </a>
          <a class="btn btn-icon btn-danger" onclick="onDelete(this)">
            ${feather.icons['trash-2'].toSvg()}
          </a>
          <form action="${data['route.destroy']}" class="delete-form" method="POST" style="display:none">
            <input type="hidden" name="_method" value="DELETE">
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
    $('#status').change(function() {
        dt_ajax.draw();
    });
    $('#customer').change(function() {
        dt_ajax.draw();
    })
    var separator = ' - ',
      rangePickr = $('.flatpickr-range'),
      dateFormat = 'YYYY-MM-DD';
    var options = {
      autoUpdateInput: false,
      autoApply: true,
      locale: {
        format: dateFormat,
        separator: separator
      },
      opens: $('html').attr('data-textdirection') === 'rtl' ? 'left' : 'right'
    };
    rflatpickr = rangePickr.flatpickr({
      mode: 'range',
      dateFormat: 'Y-m-d',
      onClose: function (selectedDates, dateStr, instance) {
        var startDate = '',
          endDate = new Date();
        if (selectedDates[0] != undefined) {
          startDate = selectedDates[0].toISOString().split('T')[0];
          $('.start_date').val(startDate);
        }
        if (selectedDates[1] != undefined) {
            console.log(selectedDates[1].toISOString())
          endDate = selectedDates[1].toISOString().split('T')[0];
          $('.end_date').val(endDate);
        }
        $(rangePickr).trigger('change').trigger('keyup');
        dt_ajax.draw();
      }
    });
  })
  var rflatpickr;
  function onClearDateRange() {
    rflatpickr.clear();
    $('.start_date').val('');
    $('.end_date').val('');
    dt_ajax.draw();
  }
</script>
@endsection
