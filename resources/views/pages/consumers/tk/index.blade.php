
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_SupportTickets'))

@section('vendor-style')
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
        <h4 class="card-title">Support Tickets</h4>
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
          <a href="{{ route('tk.read.all') }}" class="btn btn-icon btn-secondary">
            Mark All as Read
          </a>
          {{-- <a href="{{ route('tk.create') }}" class="btn btn-icon btn-primary">
            Create a ticket
          </a> --}}
        </div>
      </div>
      <div class="table-responsive m-1 mt-0">
        <table class="table table-data">
          <thead>
            <tr>
              <th width="20%">Client</th>
              <th width="20%">File Service</th>
              <th width="20%">Ticket Status</th>
              <th width="20%">Created At</th>
              <th width="20%">Actions</th>
            </tr>
          </thead>
          {{-- <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $e)
                <tr>
                  <td>{{ $e->client }}</td>
                  <td>{{ $e->file_service_name }}</td>
                  <td>{{ $e->closed ? 'Closed' : 'Open' }}</td>
                  <td>{{ $e->created_at }}</td>
                  <td>
                    <a class="btn btn-icon btn-primary" href="{{ route('tk.edit', ['tk' => $e->id]) }}" title="Edit">
                      <i data-feather="edit"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="5">No matching records found</td>
              </tr>
            @endif
          </tbody> --}}
        </table>
      </div>
    </div>
    {{-- {{ $entries->links() }} --}}
  </div>
</div>
<!-- Basic Tables end -->
@endsection

@section('vendor-script')
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
  $(window).on('load', function() {
    var dt_ajax_table = $('.table-data')
    var dt_ajax = dt_ajax_table.DataTable({
      processing: true,
      serverSide: true,
      dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end align-items-baseline"<"dt-action-buttons text-end ms-1">>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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
          url: "{{ route('tk.api') }}",
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
        { data: 'created_at' },
        { data: 'actions' },
      ],
      columnDefs: [{
        targets: [0, 1, 4],
        orderable: false,
        searchable: false,
      }],
      order: [[3, 'desc']],
      createdRow: function(row, data, index) {
        if (data['unread_message'] == 0) {
          $(row).addClass('ticket-open')
        }
        $('td', row).addClass('td-actions')
        $('td', row).eq(4).html(`
          <a class="btn btn-icon btn-primary" href="${data['route.edit']}" title="Edit">
            ${feather.icons['edit'].toSvg()}
          </a>
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
