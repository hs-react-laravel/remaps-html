@extends('layouts/contentLayoutMaster')

@section('title', 'Edit')

@section('content')
<!-- Basic Vertical form layout section start -->
<section id="basic-vertical-layouts">
  <div class="row">
    <div class="col-md-6 col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Support</h4>
          <a href="{{ route('tickets.close', ['id' => $entry->id]) }}" class="btn btn-icon btn-primary">
            Close Ticket
          </a>
        </div>
        <div class="card-body">
          <hr>
          {{ Form::model($entry, array('route' => array('tickets.update', $entry->id), 'method' => 'PUT', 'enctype' => "multipart/form-data")) }}
            <div class="message-wrapper">
              <div class="message-{{ $entry->sender_id == $user->id ? 'right' : 'left' }}">
                <div class="avatar" style="background-color: #{{ \App\Helpers\Helper::generateAvatarColor($entry->sender_id) }}">
                  <div class="avatar-content">{{ \App\Helpers\Helper::getInitialName($entry->sender_id) }}</div>
                </div> <br>
                <p class="badge bg-dark badge-custom">
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
                    <div class="avatar" style="background-color: #{{ \App\Helpers\Helper::generateAvatarColor($msg->sender_id) }}">
                      <div class="avatar-content">{{ \App\Helpers\Helper::getInitialName($msg->sender_id) }}</div>
                    </div> <br>
                  @endif
                  <p class="badge bg-dark badge-custom">
                    {{ $msg->message }} <br>
                    @if ($msg->document)
                      <a href="{{ route('tickets.download', ['id' => $msg->id]) }}"><i data-feather="file"></i> {{ $msg->document }}</a>
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
            <a type="button" class="btn btn-flat-secondary me-1" href="{{ route('tickets.index') }}">Cancel</a>
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
