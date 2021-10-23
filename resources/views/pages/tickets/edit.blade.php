@extends('layouts/contentLayoutMaster')

@section('title', 'File Service')

@section('content')
<!-- Basic Vertical form layout section start -->
<section id="basic-vertical-layouts">
  <div class="row">
    <div class="col-md-6 col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Support</h4>
        </div>
        <div class="card-body">
          <hr>
          {{ Form::model($entry, array('route' => array('tickets.update', $entry->id), 'method' => 'PUT')) }}
            <div class="message-wrapper">
              <div class="message-{{ $entry->sender_id == $user->id ? 'right' : 'left' }}">
                <div class="avatar bg-light-{{$entry->sender_id == $user->id ? 'primary' : 'danger'}}">
                  <div class="avatar-content">{{$entry->sender_id == $user->id ? 'ME' : 'AD'}}</div>
                </div> <br>
                <p class="badge bg-{{$entry->sender_id == $user->id ? 'primary' : 'danger'}} badge-custom">
                  {{ $entry->message }} <br>
                  @if ($entry->document)
                    <a href="{{ route('tickets.download', ['id' => $entry->id]) }}"><i data-feather="file"></i> {{ $entry->document }}</a>
                  @endif
                </p>
                @php
                  $prev_id = $entry->sender_id;
                @endphp
              </div>
              @foreach ($messages as $msg)
                <div class="message-{{ $msg->sender_id == $user->id ? 'right' : 'left' }}">
                  @if ($msg->sender_id != $prev_id)
                    <div class="avatar bg-light-{{$msg->sender_id == $user->id ? 'primary' : 'danger'}}">
                      <div class="avatar-content">{{$msg->sender_id == $user->id ? 'ME' : 'AD'}}</div>
                    </div> <br>
                  @endif
                  <p class="badge bg-{{$msg->sender_id == $user->id ? 'primary' : 'danger'}} badge-custom">
                    {{ $msg->message }} <br>
                    @if ($msg->document)
                      <a href=""><i data-feather="file"></i> {{ $msg->document }}</a>
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
                <label for="file" class="form-label">File</label>
                <input class="form-control" type="file" id="file" name="upload_file" />
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary me-1">Send</button>
            </div>
          {{ Form::close() }}
        </div>
      </div>
      @include('blocks.customer_info')
    </div>
    <div class="col-md-6 col-12">
      @include('blocks.fileservice_info')
      @include('blocks.car_info')
    </div>
  </div>
</section>
<!-- Basic Vertical form layout section end -->
@endsection
