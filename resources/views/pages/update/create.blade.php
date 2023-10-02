
@extends('layouts/contentLayoutMaster')

@section('title', 'Create')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <form action="{{ route('adminupdates.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Add a new update</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-6 col-md-8 col-12">
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
                <label class="form-label" for="message">Theme</label>
                <ul class="list-inline unstyled-list" id="update-themes">
                    <li class="color-box bg-primary selected" data-navbar-color="bg-primary"></li>
                    <li class="color-box bg-secondary" data-navbar-color="bg-secondary"></li>
                    <li class="color-box bg-success" data-navbar-color="bg-success"></li>
                    <li class="color-box bg-danger" data-navbar-color="bg-danger"></li>
                    <li class="color-box bg-info" data-navbar-color="bg-info"></li>
                    <li class="color-box bg-warning" data-navbar-color="bg-warning"></li>
                    <li class="color-box bg-dark" data-navbar-color="bg-dark"></li>
                    <li class="color-box bg-dblue" data-navbar-color="bg-dblue"></li>
                    <li class="color-box bg-dgreen" data-navbar-color="bg-dgreen"></li>
                    <li class="color-box bg-soil" data-navbar-color="bg-soil"></li>
                    <li class="color-box bg-dred" data-navbar-color="bg-dred"></li>
                    <li class="color-box bg-tred" data-navbar-color="bg-tred"></li>
                </ul>
                <input id="theme-input" type="hidden" name="theme" value="primary" />
            </div>
            <button type="submit" class="btn btn-primary me-1">Submit</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </form>
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
      $(document).ready(function(){
        $('#update-themes li').click(function(){
          var color = $(this).data('navbar-color').substring(3);
          $('#theme-input').val(color);
          $('#update-themes li').removeClass('selected');
          $(this).addClass('selected');
        });
      });
  </script>
@endsection
