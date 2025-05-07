@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
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

        <h4 class="card-title mb-1">Forgot Password? 🔒</h4>
        <p class="card-text mb-2">Enter your email and we'll send you instructions to reset your password</p>

        <form class="auth-forgot-password-form mt-2" action="{{ route('admin.auth.password.email') }}" method="POST">
          @csrf
          <div class="mb-1">
            <label for="forgot-password-email" class="form-label">Email</label>
            <input
              type="text"
              class="form-control"
              id="forgot-password-email"
              name="email"
              placeholder="john@example.com"
              aria-describedby="forgot-password-email"
              tabindex="1"
              autofocus
            />
          </div>
          <button class="btn {{ 'btn-'.substr($configData['navbarColor'], 3) }} w-100" tabindex="2">Send reset link</button>
        </form>

        <p class="text-center mt-2">
          <a href="{{url('admin/login')}}"> <i data-feather="chevron-left"></i> Back to login </a>
        </p>

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
@endsection
