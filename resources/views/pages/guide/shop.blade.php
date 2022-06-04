
@extends('layouts/contentLayoutMaster')

@section('title', 'Create a Notification')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <form id="form-create" action="{{ route('shop.guide.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Message for Shop Guide</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="title" value="{{ $guide->title }}" />
              </div>
              <div class="col-12">
                <label class="form-label" for="body">Content</label>
                <textarea type="text" class="form-control" id="body" name="content">{{ $guide->content }}</textarea>
              </div>
            </div>
            <button type="submit" class="btn btn-primary me-1" id="btn-submit">Submit</button>
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

  </script>
@endsection
