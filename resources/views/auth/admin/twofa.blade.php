@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
  <style>
      .opt-input-box {
          width: 40px;
          height: 40px;
          margin-right: 10px;
      }
  </style>
@endsection

@php
  $configData = Helper::applClasses();
@endphp

@section('content')
<div class="auth-wrapper auth-basic px-2">
  <div class="auth-inner my-2">
    <!-- Login basic -->
    <div class="card mb-0">
      <div class="card-body">
        <a href="#" class="brand-logo">
          <img src="{{ Storage::disk('azure')->url($company->logo) }}" style="width: 100%; height: 100%; border-radius: 5px"></a>
        </a>

        <h4 class="card-title mb-1">2FA Verification</h4>

        <form id="twofa_form" class="auth-login-form mt-2" action="{{ route('admin.auth.login') }}" method="POST">
          @csrf
          <input type="hidden" name="email" value="{{ $email }}">
          <input type="hidden" name="password" value="{{ $password }}">
          <input type="hidden" name="user_id", value="{{ $user->id }}">
          <input type="hidden" name="code" id="code">
          <input type="hidden" name="uuid" id="uuid">
          @if(!empty($qrData))
          <div class="row">
            {{-- {!! $qrData !!} --}}
            <img src="{{ $qrData }}" alt="">
          </div>
          <p class="card-text mb-2" style="font-size: 13px !important;">
            Scan this QR ocde in to your chosen authenticator app. example Google Authenticator.<br/>
            Enter the code provided in the box below to confirm setup is working.
          </p>
          @endif
          {{-- <div class="mb-1 row">
            <div id="otp_target"></div>
          </div> --}}
          <div class="otp-input d-flex mb-1 justify-content-center">
            <input type="text" class="opt-input-box form-control">
            <input type="text" class="opt-input-box form-control">
            <input type="text" class="opt-input-box form-control">
            <input type="text" class="opt-input-box form-control">
            <input type="text" class="opt-input-box form-control">
            <input type="text" class="opt-input-box form-control">
          </div>
          <input type="hidden" id="result" name="code">
          <div class="alert alert-warning" id="alert-ticket" style="display: none">
            <div class="alert-body"><p>Wrong Code</p></div>
          </div>
          @if(empty($qrData))
          <div class="mb-1">
            <div class="form-check">
              <input type="hidden" name="remember_me" value="0" />
              <input class="form-check-input" type="checkbox" id="remember-me" value="1" name="remember_me" />
              <label class="form-check-label" for="remember-me"> Remember for 30 days </label>
            </div>
          </div>
          @endif
          <button type="submit" class="btn {{ 'btn-'.substr($configData['navbarColor'], 3) }} w-100" tabindex="4">Verify</button>
        </form>
      </div>
    </div>
    <!-- /Login basic -->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
@endsection

@section('page-script')
<script src="{{asset(mix('js/scripts/pages/auth-login.js'))}}"></script>
<script src="{{ asset('customjs/vanilla-otp.js') }}"></script>
<script src="{{ asset('customjs/device-uuid.js') }}"></script>
<script>
    $(document).ready(function() {
        let otp = new VanillaOTP('.otp-input', '#result');
    });
</script>
@endsection
