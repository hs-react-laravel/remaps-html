
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Notification')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')
@php
  $route_prefix = "";
  if ($user->is_semi_admin) {
    $route_prefix = "staff.";
  }
@endphp
<section id="basic-input">
    {{ html()->form($data, 'PUT')->route($route_prefix.'notifications.update', ['notification' => $data->id])->open() }}
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit new notification</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" value="{{ $data->subject }}" />
              </div>
              <div class="col-12">
                <label class="form-label" for="body">Content</label>
                <textarea type="text" class="form-control ckeditor" id="body" name="body">{{ $data->body }}</textarea>
              </div>
              <div class="col-12 mt-1">
                <div class="form-check form-check-inline">
                  <input type="hidden" name="to_all" value="0" />
                  <input class="form-check-input" type="checkbox" id="to_all" name="to_all" value="1" @if($is_sent_all) checked @endif>
                  <label class="form-check-label" for="to_all">Send Notification to all customers</label>
                </div>
              </div>
              <div class="col-12">
                <label class="form-label" for="to">To</label>
                <select class="select2 form-select" id="to" name="to[]" multiple @if($is_sent_all) disabled @endif>
                  @foreach ($users as $u)
                    <option value="{{ $u->id }}" @if(!$is_sent_all && in_array($u->id, $receivers)) selected @endif>{{ $u->full_name }}</option>
                  @endforeach
                </select>
                <input type="hidden" name="to_users" id="to_users" />
              </div>
              <div class="col-12">
                <label class="form-label" for="icon">Type</label>
                <select class="form-select" id="icon" name="icon">
                    <option value="0">Important News</option>
                    <option value="1">Updates</option>
                    <option value="2">News</option>
                    <option value="3">General Info</option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary me-1" id="btn-submit">Submit</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    {{ html()->form()->close() }}
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
    $('#to_all').on('change', function(){
      let val = $(this).is(":checked");
      if (val) {
        $('#to').attr('disabled', true)
      } else {
        $('#to').attr('disabled', false)
      }
    })
  </script>
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {
        CKEDITOR.replace('body');
      });
    </script>
@endsection
