@extends('layouts/contentLayoutMaster')

@section('title', 'Template')

@section('content')
<section>
  {{ html()->form('PUT')->route('email-templates.update', ['email_template' => $entry->id])->open() }}
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Edit Template</h4>
        </div>
        <div class="card-body">
          <div class="row mb-1">
            <div class="col-xl-6 col-md-6 col-12">
              <label class="form-label" for="label">Label</label>
              <input type="text" class="form-control" id="label" name="label" value="{{ $entry->label }}" />
            </div>
            <div class="col-xl-6 col-md-6 col-12">
              <label class="form-label" for="subject">Subject</label>
              <input type="text" class="form-control" id="subject" name="subject" value="{{ $entry->subject }}" />
            </div>
          </div>
          <div class="row mb-1">
            <div class="col-12">
              <label class="form-label" for="body">Body</label>
              <textarea
                class="form-control ckeditor"
                id="body"
                rows="20"
                name="body"
              >{{ $entry->body }}</textarea>
            </div>
          </div>
          <button type="submit" class="btn btn-primary me-1">Submit</button>
          <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  {{ html()->form()->close() }}
</section>
@endsection
@section('page-script')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    CKEDITOR.replace('body');
  });
</script>
@endsection
