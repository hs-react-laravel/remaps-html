
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Orders'))

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{__('locale.menu_Orders')}}</h4>
      </div>
      <div class="table-responsive m-1 mt-0">
        <table class="table table-data">
          <thead>
            <tr>
              <th width="10%">{{__('locale.tb_header_InvoiceNo')}}</th>
              <th width="20%">{{__('locale.tb_header_Company')}}</th>
              <th width="10%">{{__('locale.tb_header_Amount')}}</th>
              <th width="10%">{{__('locale.tb_header_PaymentGateway')}}</th>
              <th width="10%">{{__('locale.tb_header_Status')}}</th>
              <th width="20%">{{__('locale.tb_header_OrderDate')}}</th>
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
            url: "{{ route('od.api') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: function(data) {
                data.id = "{{ $user->id }}",
                data.start_date = $('#start_date').val()
                data.end_date = $('#end_date').val()
            },
            dataSrc: function (res) {
                return res.data;
            },
        },
        columns: [
            { data: 'displayable_id' },
            { data: 'customer_company' },
            { data: 'amount' },
            { data: 'payment_gateway' },
            { data: 'status' },
            { data: 'created_at' },
            { data: 'actions' },
        ],
        // columnDefs: [{
        //     targets: [1, 3, 5],
        //     orderable: false,
        //     searchable: false,
        // }],
        order: [[0, 'desc']],
        createdRow: function(row, data, index) {
            $('td', row).eq(6).addClass('td-actions');
            var actionHtml = ''
            if (data.bank_pending) return;
            if (!data.invoice_pdf) {
                actionHtml += `<a class="btn btn-icon btn-success" href="${data['route.invoice']}" title="Download Invoice">${feather.icons['file'].toSvg()}</a> \n`;
            } else {
                actionHtml += `<a class="btn btn-icon ${data.invoice_pdf_exist ? 'btn-success' : 'btn-secondary'}" href="${data.invoice_pdf_exist ? data['route.download'] : '#'}" title="Download Invoice">${feather.icons['file'].toSvg()}</button>`;
            }
            $('td', row).eq(6).html(actionHtml);
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
  </script>
@endsection
