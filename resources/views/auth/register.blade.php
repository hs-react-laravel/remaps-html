@extends('layouts/fullLayoutMaster')

@section('title', 'Register Multi Steps')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-cover">
  <div class="auth-inner row m-0">
    <!-- Brand logo-->
    <a class="brand-logo" href="#">
      <h2 class="brand-text text-primary ms-1">Remaps</h2>
    </a>
    <!-- /Brand logo-->

    <!-- Left Text-->
    <div class="col-lg-3 d-none d-lg-flex align-items-center p-0">
      <div class="w-100 d-lg-flex align-items-center justify-content-center">
        <img
          class="img-fluid w-100"
          src="{{asset('images/illustration/create-account.svg')}}"
          alt="multi-steps"
        />
      </div>
    </div>
    <!-- /Left Text-->

    <!-- Register-->
    <div class="col-lg-9 d-flex align-items-center auth-bg">
      <div class="mx-auto col-lg-9 mt-2">
        <form action="{{ route('register') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Add a new customer</h4>
                </div>
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-xl-6 col-md-6 col-12">
                      <label class="form-label" for="email">Email</label>
                      <input type="text" class="form-control" id="email" name="email" required autocomplete="email" />
                    </div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-xl-6 col-md-6 col-12">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password" />
                      @error('name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="col-xl-6 col-md-6 col-12">
                      <label class="form-label" for="password_confirmation">Confirm Password</label>
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" />
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-1">
                    <div class="col-xl-6 col-md-6 col-12">
                      <label class="form-label" for="lang">Language</label>
                      <select class="form-select" id="lang" name="lang">
                        @foreach ($langs as $abbr => $lang)
                          <option value="{{ $abbr }}">{{ $lang }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-xl-6 col-md-6 col-12">
                      <label class="form-label" for="private">Customer Type</label>
                      <select class="form-select" id="private" name="private">
                        <option value="0">Private Customer</option>
                        <option value="1">Business Customer</option>
                      </select>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12" id="vat-container" style="display: none">
                      <label class="form-label" for="vat_number">TAX/VAT Number</label>
                      <input type="text" class="form-control" id="vat_number" name="vat_number" />
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-1">
                    <div class="col-xl-4 col-md-6 col-12">
                      <label class="form-label" for="title">Title</label>
                      <select class="form-select" id="title" name="title">
                        <option value="Mr">Mr</option>
                        <option value="Ms">Ms</option>
                      </select>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                      <label class="form-label" for="first_name">First Name</label>
                      <input type="text" class="form-control" id="first_name" name="first_name" />

                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                      <label class="form-label" for="last_name">Last Name</label>
                      <input type="text" class="form-control" id="last_name" name="last_name" />
                    </div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-xl-6 col-md-6 col-12">
                      <label class="form-label" for="business_name">Business Name</label>
                      <input type="text" class="form-control" id="business_name" name="business_name" />
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-1">
                    <div class="col-xl-6 col-md-6 col-12">
                      <label class="form-label" for="address_line_1">Address Line 1</label>
                      <input type="text" class="form-control" id="address_line_1" name="address_line_1" />
                    </div>
                    <div class="col-xl-6 col-md-6 col-12">
                      <label class="form-label" for="address_line_2">Address Line 2</label>
                      <input type="text" class="form-control" id="address_line_2" name="address_line_2" />
                    </div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-xl-4 col-md-6 col-12">
                      <label class="form-label" for="town">Town</label>
                      <input type="text" class="form-control" id="town" name="town" />
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                      <label class="form-label" for="county">County</label>
                      <input type="text" class="form-control" id="county" name="county" />
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <label class="form-label" for="post_code">Postal Code</label>
                        <input type="text" class="form-control" id="post_code" name="post_code" />
                      </div>
                  </div>
                  <hr>
                  <div class="row mb-1">
                    <div class="col-xl-4 col-md-6 col-12">
                      <label class="form-label" for="phone">Phone</label>
                      <input type="text" class="form-control" id="phone" name="phone" />
                    </div>
                    <div class="col-xl-8 col-md-6 col-12">
                      <label class="form-label" for="tools">Tools</label>
                      <textarea
                        class="form-control"
                        id="tools"
                        rows="3"
                        name="tools"
                      ></textarea>
                    </div>
                  </div>
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <p class="text-center">
          <span>Already have an account?</span>
          <a href="{{route('login')}}">
            <span>Sign in instead</span>
          </a>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset(mix('vendors/js/forms/wizard/bs-stepper.min.js'))}}"></script>
<script src="{{asset(mix('vendors/js/forms/select/select2.full.min.js'))}}"></script>
<script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
<script src="{{asset(mix('vendors/js/forms/cleave/cleave.min.js'))}}"></script>
<script src="{{asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js'))}}"></script>
@endsection

@section('page-script')
<script src="{{asset(mix('js/scripts/pages/auth-register.js'))}}"></script>
<script>
    $('#private').change(function() {
      var customer_type = $(this).val();
      console.log(customer_type);
      if (customer_type == 1) {
        $('#vat-container').show();
      } else {
        $('#vat-container').hide();
      }
    })
</script>
@endsection

{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
