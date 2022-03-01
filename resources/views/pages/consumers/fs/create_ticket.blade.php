
@extends('layouts/contentLayoutMaster')

@section('title', 'Create File Service Ticket')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <div class="row">
    <div class="col-md-6 col-12">
      <form action="{{ route('fs.tickets.store', ['id' => $fileService->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('blocks.create_ticket_form_fs')
      </form>
      @include('blocks.customer_info')
    </div>
    <div class="col-md-6 col-12">
      @include('blocks.fileservice_info')
      @include('blocks.car_info')
    </div>
    {{ Form::open(array('id' => 'uploadForm', 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
      <input type="file" name="file" id="hidden_upload" style="display: none" />
    {{ Form::close() }}
  </div>
</section>

@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js'))}}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script>
    function onUpload() {
      $('#hidden_upload').trigger('click');
    }
    hidden_upload.onchange = evt => {
      const [file] = hidden_upload.files
      if (file) {
        $('#file_name').val(file.name)
        $("#uploadForm").submit();
      }
    }
    $("#uploadForm").on('submit', function(e){
      e.preventDefault();
      $.ajax({
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = Math.round((evt.loaded / evt.total) * 100);
              $(".progress-bar").width(percentComplete + '%');
              $(".progress-bar").html(percentComplete+'%');
            }
          }, false);
          return xhr;
        },
        type: 'POST',
        url: "{{ route('tk.api.upload') }}",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
          $(".progress-bar").width('0%');
          $(".progress").show();
        },
        error:function(){

        },
        success: function(resp){
          if(resp.status){
            $('#uploadForm')[0].reset();
            $('#document').val(resp.file);
            $('#remain_file').val(resp.remain);
          }else{
          }
        }
      });
    })
  </script>
@endsection
