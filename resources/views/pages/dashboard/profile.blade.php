@extends('layouts/contentLayoutMaster')

@section('title', 'Profile')

@section('content')
<section>
  <form action="{{ Auth::guard('admin')->check() ? route('admin.dashboard.profile.post') : route('dashboard.profile.post') }}" method="post">
  @csrf
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
                <option value="Mr">Mr</option>
                <option value="Ms">Ms</option>
              </select>
            </div>
            <div class="col-xl-4 col-md-6 col-12">
              <label class="form-label" for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name"
                value="{{ $user->first_name }}" />
            </div>
            <div class="col-xl-4 col-md-6 col-12">
              <label class="form-label" for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name"
                value="{{ $user->last_name }}" />
            </div>
        </div>
        <div class="row mb-1">
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="business_name">Business Name</label>
            <input type="text" class="form-control" id="business_name" name="business_name"
              value="{{ $user->business_name }}" />
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email"
            value="{{ $user->email }}" />
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone"
            value="{{ $user->phone }}" />
          </div>
        </div>
        <div class="row mb-1">
          <div class="col-xl-6 col-md-6 col-12">
            <label class="form-label" for="address_line_1">Address Line 1</label>
            <input type="text" class="form-control" id="address_line_1" name="address_line_1"
            value="{{ $user->address_line_1 }}" />
          </div>
          <div class="col-xl-6 col-md-6 col-12">
            <label class="form-label" for="address_line_2">Address Line 2</label>
            <input type="text" class="form-control" id="address_line_2" name="address_line_2"
            value="{{ $user->address_line_2 }}" />
          </div>
        </div>
        <div class="row mb-1">
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="town">Town</label>
            <input type="text" class="form-control" id="town" name="town"
            value="{{ $user->town }}" />
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="county">County</label>
            <input type="text" class="form-control" id="county" name="county"
            value="{{ $user->county }}" />
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <label class="form-label" for="post_code">Postal Code</label>
            <input type="text" class="form-control" id="post_code" name="post_code"
            value="{{ $user->post_code }}" />
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
        <div class="row mb-1">
          <div class="form-group col-md-12">
            <label>More info <small class="text-muted">(500 Charcters Max)</small></label>
            <textarea id="ckeditor-description" class="form-control" maxlength="255"  type="text" name="more_info" >
              {{ $user->more_info }}
            </textarea>
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
