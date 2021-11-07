@extends('layouts/contentLayoutMaster')

@section('title', 'Change Password')

@section('content')
<section>
  <form action="{{ $post_link }}" method="post">
  @csrf
  <input type="hidden" name="user_id" value="{{ $user->id }}">
  <div class="row">
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Change Password</h4>
        </div>
        <div class="card-body">
          <div class="row mb-1">
            <div class="col-xl-6 col-md-6 col-12">
              <label class="form-label" for="new_password">New Password</label>
              <input type="password" class="form-control" id="new_password" name="new_password" />
            </div>
        </div>
        <div class="row mb-1">
          <div class="col-xl-6 col-md-6 col-12">
            <label class="form-label" for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" />
          </div>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary me-1">Submit</button>
        </div>
      </div>
    </div>
  </div>
  </form>
</section>
@endsection
@section('page-script')
  <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  <script>
    $(document).ready(function($) {
      CKEDITOR.replace('ckeditor-description');
    });
  </script>
@endsection
