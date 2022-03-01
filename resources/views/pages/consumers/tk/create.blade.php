
@extends('layouts/contentLayoutMaster')

@section('title', 'Create a Ticket')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <div class="row">
    <div class="col-md-6 col-12">
      <form action="{{ route('tk.store') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="fileservice_id" value="{{ isset($fileService) ? $fileService->id : "" }}">
        @csrf
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Contact Us</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="message">Message</label>
                <textarea
                  class="form-control"
                  id="message"
                  rows="5"
                  name="message"
                ></textarea>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-12">
                <div style="margin-bottom: 2px; cursor: pointer">
                  <label for="document" class="form-label">File</label>
                  <div class="input-group" onclick="onUpload()">
                    <span class="input-group-text">Choose File</span>
                    <input
                      type="text"
                      class="form-control"
                      id="file_name"
                      name="file_name"
                      readonly />
                    <input
                      type="hidden"
                      class="form-control"
                      id="document"
                      name="document"
                      readonly />
                    <input
                      type="hidden"
                      class="form-control"
                      id="remain_file"
                      name="remain_file"
                      readonly />
                  </div>
                </div>
                <div class="progress progress-bar-{{ substr($styling['navbarColor'], 3) }}" style="display: none">
                  <div
                    class="progress-bar progress-bar-striped progress-bar-animated"
                    role="progressbar"
                    aria-valuenow="0"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary me-1">Submit</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
          </div>
        </div>
      </form>
      @include('blocks.customer_info')
    </div>
    @include('blocks.fileservice_info')
    @include('blocks.car_info')
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
