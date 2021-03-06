@extends('layouts/contentLayoutMaster')

@section('title', 'Profile')

@section('content')
<section>
  <form action="{{ $post_link }}" method="post">
  @csrf
  <input type="hidden" name="user_id" value="{{ $user->id }}">
  <input type="hidden" name="_method" value="put" />
  <div class="row">
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">My Account</h4>
        </div>
        <div class="card-body">
          <div class="row mb-1">
            <div class="col-xl-4 col-md-6 col-sm-12">
              <label class="form-label" for="title">Title</label>
              <select class="form-select" id="title" name="title">
                <option value="Mr" @if($user->title == "Mr") selected @endif>Mr</option>
                <option value="Ms" @if($user->title == "Ms") selected @endif>Ms</option>
              </select>
            </div>
            <div class="col-xl-4 col-md-6 col-12">
              <label class="form-label" for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name"
                value="{{ old('first_name') ?? $user->first_name }}" />
            </div>
            <div class="col-xl-4 col-md-6 col-12">
              <label class="form-label" for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name"
                value="{{ old('last_name') ?? $user->last_name }}" />
            </div>
        </div>
        <div class="row mb-1">
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email"
            value="{{ old('email') ?? $user->email }}" />
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone"
            value="{{ old('phone') ?? $user->phone }}" />
          </div>
        </div>
        <button type="submit" class="btn btn-primary me-1">Submit</button>
        <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
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
