@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
  <style>
      .fake-inputs {
          margin-top: 0 !important;
      }
      .otp-fake-input {
          margin: 0.5rem !important;
          text-transform: uppercase;
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
          <img src="{{ asset('storage/uploads/logo/'.$company->logo) }}" style="width: 100%; height: 100%; border-radius: 5px"></a>
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
          <div class="mb-1 row">
            <div id="otp_target"></div>
          </div>
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
<script src="{{ asset('customjs/otpdesigner.js') }}"></script>
<script src="{{ asset('customjs/device-uuid.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#otp_target').otpdesigner({
            typingDone: function (code) {
                $('#code').val(code);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('api.twofa.check') }}",
                    data: {
                        company_id: "{{ isset($company) ? $company->id : '' }}",
                        code: code
                    },
                    success: function(result) {
                        if (result.verified) {
                            $('#twofa_form').submit();
                        } else {
                            $('#alert-ticket').css('display', 'block');
                        }
                    }
                })
            },
        });

        var uuid = new DeviceUUID().get();
        $('#uuid').val(uuid);
    });
</script>
@endsection
