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
                Storage::disk('azure')->url($company->logo) :
                'https://via.placeholder.com/250x110.png?text=Logo+Here'
            }}"
            id="logo"
            class="rounded me-2 mb-1 mb-md-0 w-100"
            alt="Logo Image"
          />
        </div>
        <h2 class="card-title fw-bold mb-1">Forgot Password? 🔒</h2>
        <p class="card-text mb-2">Enter your email and we'll send you instructions to reset your password</p>
        <form class="auth-forgot-password-form mt-2" action="{{route('password.email')}}" method="POST">
          @csrf
          <div class="mb-1">
            <label class="form-label" for="forgot-password-email">Email</label>
            <input class="form-control" id="forgot-password-email" type="text" name="email" placeholder="john@example.com" aria-describedby="forgot-password-email" autofocus="" tabindex="1" />
          </div>
          <button class="btn {{ 'btn-'.substr($configData['navbarColor'], 3) }} w-100" tabindex="2">Send reset link</button>
        </form>
        <p class="text-center mt-2">
          <a href="{{route('login')}}">
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
