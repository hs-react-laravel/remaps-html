
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Orders'))

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{__('locale.menu_Orders')}}</h4>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="20%">{{__('locale.tb_header_OrderDate')}}</th>
              <th width="20%">{{__('locale.tb_header_Company')}}</th>
              <th width="10%">{{__('locale.tb_header_Amount')}}</th>
              <th width="20%">{{__('locale.tb_header_Status')}}</th>
              <th width="15%">{{__('locale.tb_header_InvoiceNo')}}</th>
              <th width="20%">{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @if (count($entries) > 0)
              @foreach ($entries as $e)
              <tr>
                <td>{{ $e->created_at }}</td>
                <td>{{ $e->customer_company }}</td>
                <td>{{ config('constants.currency_signs')[$company->paypal_currency_code].' '.$e->amount_with_sign }}</td>
                <td>{{ $e->status }}</td>
                <td>{{ $e->displayable_id }}</td>
                <td>
                @if ($company->is_bank_enabled && $e->payment_gateway == "Bank" && $e->status == "Pending")
                  <a class="btn btn-icon btn-primary" href="{{ route('order.complete', ['id' => $e->id]) }}" title="Complete payment">
                    <i data-feather="check"></i>
                  </a>
                @endif
                @if (!$company->is_invoice_pdf)
                  <a class="btn btn-icon btn-success" href="{{ route('order.invoice', ['id' => $e->id]) }}" title="Download Invoice">
                    <i data-feather="file"></i>
                  </a>
                @endif
                @if ($company->is_invoice_pdf)
                  <a class="btn btn-icon btn-success" id="download-link-{{ $e->id }}" href="{{ route('order.download', ['id' => $e->id]) }}" title="Download Invoice"
                    style="display: @if(!$e->document) none @endif">
                    <i data-feather="file"></i>
                  </a>
                @endif
                @if ($company->is_invoice_pdf)
                  <button class="btn btn-icon btn-success" title="Upload Invoice PDF" onclick="onUpload({{ $e->id }})">
                    <i data-feather="upload"></i>
                  </button>
                @endif
                <div class="progress progress-bar-{{ substr($styling['navbarColor'], 3) }}" style="margin-top: 3px; display:none" id="progress-{{ $e->id }}">
                  <div
                    class="progress-bar progress-bar-striped progress-bar-animated"
                    id="progress-bar-{{ $e->id }}"
                    role="progressbar"
                    aria-valuenow="0"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                </td>
              </tr>
              @endforeach
              @else
                <tr>
                  <td colspan="6">No matching records found</td>
                </tr>
              @endif
          </tbody>
        </table>
        {{ html()->form('POST')->route('api.order.upload')->attribute('id', 'uploadForm')->acceptsFiles()->open() }}
          <input type="file" name="file" id="hidden_upload" style="display: none" />
          <input type="hidden" name="order" id="order_id" />
        {{ html()->form()->close() }}
      </div>
    </div>
    {{ $entries->links() }}
  </div>
</div>
<!-- Basic Tables end -->
@endsection
@section('page-script')
<script>
    function onUpload(id) {
      $('#hidden_upload').trigger('click');
      $('#order_id').val(id);
      $('#hidden_upload').change(function (e) {
        $('#uploadForm').submit();
      })
    }
    $("#uploadForm").on('submit', function(e){
      var id = $('#order_id').val();
      e.preventDefault();
      $.ajax({
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = Math.round((evt.loaded / evt.total) * 100);
              $("#progress-bar-" + id).width(percentComplete + '%');
              $("#progress-bar-" + id).html(percentComplete+'%');
            }
          }, false);
          return xhr;
        },
        type: 'POST',
        url: "{{ route('api.order.upload') }}",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
          $("#progress-bar-" + id).width('0%');
          $("#progress-" + id).show();
        },
        error:function(){

        },
        success: function(resp){
          if(resp.status){
            $('#uploadForm')[0].reset();
            setTimeout(() => {
              $("#progress-" + id).hide();
              $("#download-link-" + id).show();
            }, 2000);
          }else{
          }
        }
      });
    })
</script>
@endsection
