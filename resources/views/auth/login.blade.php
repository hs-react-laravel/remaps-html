@php
  $configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page '. $company->name .' Customer File service')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/pages/authentication.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-cover">
  <div class="auth-inner row m-0">
    <!-- Brand logo-->
    <a class="brand-logo" style="width: auto" href="#">
      <h2 class="brand-text ms-1" style="">
        {{ $company->name }}
      </h2>
    </a>
    <!-- /Brand logo-->

    <!-- Left Text-->
    <div class="d-none d-lg-flex col-lg-9 align-items-center" style="padding: 0">
      <div class="w-100 d-lg-flex align-items-center justify-content-center">
          @if($configData['theme'] === 'dark')
            <img class="img-fluid"
              src="{{$company->style_background ? asset('storage/uploads/styling/'.$company->style_background) : asset('images/pages/login-v2-dark.svg')}}"
              alt="Login V2"
              style="height: 100vh; width: 100vw" />
          @else
            <img class="img-fluid"
              src="{{$company->style_background ? asset('storage/uploads/styling/'.$company->style_background) : asset('images/pages/login-v2.svg')}}"
              alt="Login V2"
              style="height: 100vh; width: 100vw" />
          @endif
      </div>
    </div>
    <!-- /Left Text-->

    <!-- Login-->
    <div class="d-flex col-lg-3 align-items-center auth-bg px-2 p-lg-5">
      <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
        <div class="w-100 justify-content-center mb-2">
          <img
            src="{{ $company->logo ?
              asset('storage/uploads/logo/'.$company->logo) :
              'https://via.placeholder.com/250x110.png?text=Logo+Here'
            }}"
            id="logo"
            class="rounded me-2 mb-1 mb-md-0 w-100"
            alt="Logo Image"
          />
        </div>
        <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
        <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
          @csrf
          <div class="mb-1">
            <label class="form-label" for="login-email">Email</label>
            <input
              class="form-control"
              id="login-email"
              type="text"
              name="email"
              placeholder="john@example.com"
              aria-describedby="login-email"
              autofocus=""
              tabindex="1" required />
              @error('email')
                <p class="invalid-feedback" role="alert" style="display: block">
                  <strong>{{ $message }}</strong>
                </p>
              @enderror
          </div>
          <div class="mb-1">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="login-password">Password</label>
              <a href="{{ route('password.request') }}">
                <small>Forgot Password?</small>
              </a>
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input class="form-control form-control-merge"
                id="login-password"
                type="password"
                name="password"
                placeholder="············"
                aria-describedby="login-password"
                tabindex="2" required />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              @error('password')
                <p class="invalid-feedback" role="alert" style="display: block">
                  <strong>{{ $message }}</strong>
                </p>
              @enderror
            </div>
          </div>
          <div class="mb-1">
            <div class="form-check">
              <input class="form-check-input" id="remember" type="checkbox" tabindex="3" />
              <label class="form-check-label" for="remember-me"> Remember Me</label>
            </div>
          </div>
          <button class="btn {{ 'btn-'.substr($configData['navbarColor'], 3) }} w-100" tabindex="4">Sign in</button>
        </form>
        <p class="text-center mt-2">
          <span>New on our platform?</span>
          <a href="{{ route('register') }}"><span>&nbsp;Create an account</span></a>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/auth-login.js')}}"></script>
@endsection
