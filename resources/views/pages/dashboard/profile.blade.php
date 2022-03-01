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
            <label class="form-label" for="business_name">Business Name</label>
            <input type="text" class="form-control" id="business_name" name="business_name"
              value="{{ old('business_name') ?? $user->business_name }}" />
          </div>
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
        <div class="row mb-1">
          <div class="col-xl-6 col-md-6 col-12">
            <label class="form-label" for="address_line_1">Address Line 1</label>
            <input type="text" class="form-control" id="address_line_1" name="address_line_1"
            value="{{ old('address_line_1') ?? $user->address_line_1 }}" />
          </div>
          <div class="col-xl-6 col-md-6 col-12">
            <label class="form-label" for="address_line_2">Address Line 2</label>
            <input type="text" class="form-control" id="address_line_2" name="address_line_2"
            value="{{ old('address_line_2') ?? $user->address_line_2 }}" />
          </div>
        </div>
        <div class="row mb-1">
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="town">Town</label>
            <input type="text" class="form-control" id="town" name="town"
            value="{{ old('town') ?? $user->town }}" />
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="county">County</label>
            <input type="text" class="form-control" id="county" name="county"
            value="{{ old('county') ?? $user->county }}" />
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="post_code">Postal Code</label>
            <input type="text" class="form-control" id="post_code" name="post_code"
            value="{{ old('post_code') ?? $user->post_code }}" />
          </div>
        </div>
        <div class="row mb-1">
          <div class="col-12">
            <label class="form-label" for="tools">Tools</label>
            <textarea
              class="form-control"
              id="tools"
              rows="3"
              name="tools"
            >{{ $user->tools }}</textarea>
          </div>
        </div>
        @if ($user->is_admin)
        <div class="row mb-1">
          <div class="form-group col-md-12">
            <label>More info <small class="text-muted">(500 Charcters Max)</small></label>
            <textarea id="ckeditor-description" class="form-control" maxlength="255"  type="text" name="more_info" >
              {{ $user->more_info }}
            </textarea>
          </div>
        </div>
        @endif
        <div class="col-6 mb-1">
          <div class="form-check form-check-inline">
            <input type="hidden" name="is_reserve_filename" value="0" />
            <input class="form-check-input" type="checkbox" id="is_reserve_filename" name="is_reserve_filename" value="1" @if($user->is_reserve_filename) checked @endif/>
            <label class="form-check-label" for="is_reserve_filename">Retain file names</label>
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
