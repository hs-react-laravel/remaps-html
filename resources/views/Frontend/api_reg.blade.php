@extends('Frontend.layouts.master')
@section('title')
  Welcome Remapdash
@endsection

@section('css')
<style type="text/css">
  .fancybox-margin{margin-right:17px;}

  .container-form{
    width: 750px;
  }
</style>
@endsection

@section('content')

<section class="section auth-section">
  <div style="height: 72px"></div>
  <div class="container container-form">
    <div class="register-col">
      <div class="box box-default">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{ $message }}</strong>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-block">
          @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
          @endforeach
        </div>
        @endif

        <div class="box-body">
          <h4 class="wow fadeInDown animated" style="color: #fec400">Tuning Data API</h4>
          {!! html()->form('POST')->route('frontend.api.register')->autocomplete('false')->open() !!}
          
          <div class="form-group">
            {!! html()->label('First Name', 'first_name') !!}
            {!! html()->text('first_name')->class(['form-control'])->placeholder('First Name') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Last Name', 'last_name') !!}
            {!! html()->text('last_name')->class(['form-control'])->placeholder('Last Name') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Email', 'email') !!}
            {!! html()->text('email')->class(['form-control'])->placeholder('Email') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Password', 'password') !!}
            {!! html()->password('password')->class(['form-control'])->placeholder('Password') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Password Confirmation', 'password_confirmation') !!}
            {!! html()->password('password_confirmation')->class(['form-control'])->placeholder('Password Confirmation') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Phone', 'phone') !!}
            {!! html()->text('phone')->class(['form-control'])->placeholder('Phone') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Company', 'company') !!}
            {!! html()->text('company')->class(['form-control'])->placeholder('Company') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Domain', 'domain') !!}
            {!! html()->text('domain')->class(['form-control'])->placeholder('https://abc.com') !!}
          </div>

          <div class="form-group">
            <div id="error"></div>
          </div>
          <button id="btnSubmit" class="btn btn-success view-btn" style="margin-bottom: 10px; margin-top: 20px;" type="submit">Submit</button>
          {!! html()->form()->close() !!}
        </div>
      </div>
      <p>Already have an account? <a class="custom-link" href="{{ route('frontend.api.login') }}">Click Here</a></p>
      <p>Looking for PORTAL registration? <a class="custom-link" href="{{ route('register-account.create', ['domain' => 'regular']) }}">Click Here</a></p>
      <p>If you need any help, please contact to <a class="custom-link" href="mailto:support@remapdash.com">support@remapdash.com</a></p>
    </div>
  </div>
</section>
@endsection

