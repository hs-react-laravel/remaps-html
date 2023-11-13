@php
  $configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/pages/authentication.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-cover">
  <div class="auth-inner row m-0">
    <!-- Brand logo-->
    <a class="brand-logo" href="#">
      <h2 class="brand-text ms-1"
        style="-webkit-text-stroke: 1px {{$company->theme_color ? 'white' : 'black'}}">
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
                env('AZURE_STORAGE_URL').'uploads/'.$company->logo :
                'https://via.placeholder.com/250x110.png?text=Logo+Here'
            }}"
            id="logo"
            class="rounded me-2 mb-1 mb-md-0 w-100"
            alt="Logo Image"
          />
        </div>
        <h2 class="card-title fw-bold mb-1">Reset Password 🔒</h2>
        <p class="card-text mb-2">Your new password must be different from previously used passwords</p>
        <form class="auth-reset-password-form mt-2" action="{{route('password.update')}}" method="POST">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">
          <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
          <div class="mb-1">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="reset-password-new">New Password</label>
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input
                class="form-control form-control-merge"
                id="reset-password-new"
                type="password"
                name="password"
                placeholder="············"
                aria-describedby="reset-password-new"
                autofocus=""
                tabindex="1"
                autocomplete="new-password" />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
          </div>
          <div class="mb-1">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="reset-password-confirm">Confirm Password</label>
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input
                class="form-control form-control-merge"
                id="reset-password-confirm"
                type="password"
                name="password_confirmation"
                placeholder="············"
                aria-describedby="reset-password-confirm"
                tabindex="2"
                autocomplete="new-password" />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
          </div>
          <button class="btn {{ 'btn-'.substr($configData['navbarColor'], 3) }} w-100" tabindex="3">Set New Password</button>
        </form>
        <p class="text-center mt-2">
          <a href="{{url('login')}}">
            <i data-feather="chevron-left"></i> Back to login
          </a>
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
