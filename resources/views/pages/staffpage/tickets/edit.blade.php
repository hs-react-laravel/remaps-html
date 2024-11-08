@extends('layouts/contentLayoutMaster')

@section('title', 'Edit')

@section('content')
<!-- Basic Vertical form layout section start -->
<section id="basic-vertical-layouts">
  <div class="row">
    <div class="col-md-6 col-12">
      <div class="card" id="dropContainer">
        <div class="card-header">
          <h4 class="card-title">Support</h4>
          <a href="{{ route('stafftk.close', ['id' => $entry->id]) }}" class="btn btn-icon btn-primary">
            Close Ticket
          </a>
        </div>
        <div class="card-body">
          <hr>
          {{ html()->form('PUT')->route('stafftk.update', ['stafftk' => $entry->id])->acceptsFiles()->open() }}
            <div class="message-wrapper">
              <div class="message-{{ $entry->sender_id == $user->id ? 'right' : 'left' }}">
                <div class="avatar" style="background-color: #{{ \App\Helpers\Helper::generateAvatarColor($entry->sender_id) }}">
                  <div class="avatar-content">{{ \App\Helpers\Helper::getInitialName($entry->sender_id) }}</div>
                </div> <br>
                <p class="badge bg-dark badge-custom">
                  {{ $entry->message }} <br>
                  @if ($entry->document)
                    @if ($user->is_staff)
                    <a href="{{ route('stafftk.download', ['id' => $entry->id]) }}">
                      <i data-feather="file"></i> {{ $entry->sender->is_reserve_filename && !empty($entry->remain_file) ? $entry->remain_file : $entry->document }}
                    </a>
                    @else
                    <a href="{{ route('tickets.download', ['id' => $entry->id]) }}">
                      <i data-feather="file"></i> {{ $entry->sender->is_reserve_filename && !empty($entry->remain_file) ? $entry->remain_file : $entry->document }}
                    </a>
                    @endif
                  @endif
                </p>
                @php
                  $prev_id = $entry->sender_id;
                @endphp
              </div>
              @foreach ($messages as $msg)
                <div class="message-{{ $msg->sender_id == $user->id ? 'right' : 'left' }}">
                  @if ($msg->sender_id != $prev_id)
                    <div class="avatar" style="background-color: #{{ \App\Helpers\Helper::generateAvatarColor($msg->sender_id) }}">
                      <div class="avatar-content">{{ \App\Helpers\Helper::getInitialName($msg->sender_id) }}</div>
                    </div> <br>
                  @endif
                  <p class="badge bg-dark badge-custom">
                    {{ $msg->message }} <br>
                    @if ($msg->document)
                      @if ($user->is_staff)
                      <a href="{{ route('stafftk.download', ['id' => $msg->id]) }}">
                        <i data-feather="file"></i> {{ $msg->sender->is_reserve_filename && !empty($msg->remain_file) ? $msg->remain_file : $msg->document }}
                      </a>
                      @else
                      <a href="{{ route('tickets.download', ['id' => $msg->id]) }}">
                        <i data-feather="file"></i> {{ $msg->sender->is_reserve_filename && !empty($msg->remain_file) ? $msg->remain_file : $msg->document }}
                      </a>
                      @endif
                    @endif
                  </p>
                </div>
                @php
                  $prev_id = $msg->sender_id;
                @endphp
              @endforeach
            </div>
            <hr>
            <div class="row mt-1 mb-1">
              <div class="col-12">
                <label class="form-label" for="message">Your message</label>
                <textarea
                  class="form-control"
                  id="message"
                  rows="3"
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
                <span class="text-danger">Drag and drop file here</span>
              </div>
            </div>
            @if (!$user->is_staff)
            <div class="col-12">
              <div class="mb-1">
                <label class="form-label" for="assign">{{__('locale.tb_header_Assign')}}</label>
                <select class="form-select" id="assign" name="assign">
                  <option value=""></option>
                  @foreach ($company->staffs as $staff)
                    <option value="{{ $staff->id }}" @if($entry->assign_id == $staff->id) selected @endif>{{ $staff->fullname }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            @endif
            <button type="submit" class="btn btn-primary me-1">Send</button>
            <a type="button" class="btn btn-flat-secondary me-1" href="{{ route('stafftk.index') }}">Cancel</a>
          {{ html()->form()->close() }}
        </div>
      </div>
      @include('blocks.customer_info')
    </div>
    <div class="col-md-6 col-12">
      @include('blocks.fileservice_info')
      @include('blocks.car_info')
    </div>
    {{ html()->form('POST')->attribute('id', 'uploadForm')->acceptsFiles()->open() }}
      <input type="file" name="file" id="hidden_upload" style="display: none" />
    {{ html()->form()->close() }}
  </div>
</section>
<!-- Basic Vertical form layout section end -->
@endsection

@section('page-script')
  <script>
    function onUpload() {
      $('#hidden_upload').trigger('click');
    }
    function submitFile() {
      const [file] = hidden_upload.files
      if (file) {
        $('#file_name').val(file.name)
        $("#uploadForm").submit();
      }
    }
    dropContainer.ondragover = dropContainer.ondragenter = function(evt) {
      evt.preventDefault()
    }
    dropContainer.ondrop = function(evt) {
      const dT = new DataTransfer();
      dT.items.add(evt.dataTransfer.files[0]);
      hidden_upload.files = dT.files
      evt.preventDefault()
      submitFile()
    }
    hidden_upload.onchange = evt => {
      submitFile()
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
        url: "{{ route('tickets.api.upload') }}",
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
