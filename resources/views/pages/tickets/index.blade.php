
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_SupportTickets'))

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
        <h4 class="card-title">{{__('locale.menu_SupportTickets')}}</h4>
        <div>
          <div class="form-check form-check-inline">
            <input
              class="form-check-input"
              type="checkbox"
              name="unread_check"
              id="unread_check"
            />
            <label class="form-check-label" for="unread_check">Unread</label>
          </div>
          <div class="form-check form-check-inline">
            <input
              class="form-check-input"
              type="checkbox"
              name="open_check"
              id="open_check"
            />
            <label class="form-check-label" for="open_check">Open</label>
          </div>
          <a href="{{ route('tickets.read.all') }}" class="btn btn-icon btn-secondary">
            Mark All as Read
          </a>
          <a class="btn btn-icon btn-secondary" onclick="onDeleteClosed()">
            Delete Closed Tickets
          </a>
          <div class="btn-group">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
              Close Old TIckets
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="{{ route('tickets.close.days', ["days" => 30]) }}">30 Days</a>
              <a class="dropdown-item" href="{{ route('tickets.close.days', ["days" => 60]) }}">60 Days</a>
              <a class="dropdown-item" href="{{ route('tickets.close.days', ["days" => 90]) }}">90 Days</a>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive m-1 mt-0">
        <table class="table table-data">
          <thead>
            <tr>
              <th width="20%">{{__('locale.tb_header_Client')}}</th>
              <th width="20%">{{__('locale.tb_header_FileService')}}</th>
              <th width="10%">{{__('locale.tb_header_TicketStatus')}}</th>
              <th width="20%">{{__('locale.tb_header_Assign')}}</th>
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
  async function onDeleteClosed() {
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
      window.location = "{{ route('tickets.delete.closed') }}"
    }
  }

  $(window).on('load', function() {
    var dt_ajax_table = $('.table-data')
    var dt_ajax = dt_ajax_table.DataTable({
      processing: true,
      serverSide: true,
      dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end align-items-baseline"f<"dt-action-buttons text-end ms-1">>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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
          url: "{{ route('tickets.api') }}",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: function(data) {
            data.id = "{{ $user->id }}",
            data.open = $('#open_check').is(':checked')
            data.unread = $('#unread_check').is(':checked')
          },
          dataSrc: function (res) {
            return res.data;
          },
      },
      columns: [
        { data: 'client' },
        { data: 'file_service' },
        { data: 'is_closed' },
        { data: 'staff' },
        { data: 'created_at' },
        { data: 'actions' },
      ],
      columnDefs: [{
        targets: [0, 1, 3, 5],
        orderable: false,
        searchable: false,
      }],
      order: [[4, 'desc']],
      createdRow: function(row, data, index) {
        if (data['unread_message'] == 0) {
          $(row).addClass('ticket-open')
        }
        $('td', row).addClass('td-actions')
        $('td', row).eq(5).html(`
          <a class="btn btn-icon btn-primary" href="${data['route.edit']}" title="Edit">
            ${feather.icons['edit'].toSvg()}
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

    $('#unread_check').change(function (){
      dt_ajax.draw()
    })
    $('#open_check').change(function (){
      dt_ajax.draw()
    })
  })
</script>
@endsection
