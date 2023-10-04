
@extends('layouts/contentLayoutMaster')

@section('title', 'Create a Notification')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <form id="form-create" action="{{ route('adminupdates.bottom.save') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit Bottom History</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="body">Content</label>
                <textarea type="text" class="form-control ckeditor" id="body" name="body">{{ $entry->body }}</textarea>
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
