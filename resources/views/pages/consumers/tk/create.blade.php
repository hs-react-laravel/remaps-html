
@extends('layouts/contentLayoutMaster')

@section('title', 'Create File Service')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <form action="{{ route('tk.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Contact Us</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="make">Subject</label>
                <input type="text" class="form-control" id="make" name="make" />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-6 col-md-6 col-12">
                <label class="form-label" for="note_to_engineer">Message</label>
                <textarea
                  class="form-control"
                  id="note_to_engineer"
                  rows="5"
                  name="note_to_engineer"
                ></textarea>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-6 col-md-6 col-12">
                <label for="file" class="form-label">File</label>
                <input class="form-control" type="file" id="file" name="upload_file" />
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
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
@endsection
