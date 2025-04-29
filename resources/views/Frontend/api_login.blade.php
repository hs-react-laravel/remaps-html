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
          <h4 class="wow fadeInDown animated" style="color: #fec400">Login to API User Dashboard</h4>
          {!! html()->form('POST')->route('frontend.api.login.post')->autocomplete(false)->open() !!}
            <div class="form-group">
                {!! html()->label('Email', 'email') !!}
                {!! html()->text('email')->class(['form-control'])->placeholder('Email') !!}
            </div>
            <div class="form-group">
                {!! html()->label('Password', 'new_password') !!}
                {!! html()->password('new_password')->class(['form-control'])->placeholder('Password') !!}
            </div>
            <div class="form-group">
              <div id="error"></div>
            </div>
            <p><a class="custom-link" href="{{ route('frontend.api.forgot') }}">Forgot password?</a></p>
            <button id="btnSubmit" class="btn btn-success view-btn" type="submit">Sign in</button>
            {!! html()->form()->close() !!}
          </div>
        </div>
        <p>New on our API? <a class="custom-link" href="{{ route('frontend.api.reg') }}">Create an account</a></p>
        <p>If you need any help, please contact to <a class="custom-link" href="mailto:support@remapdash.com">support@remapdash.com</a></p>
      </div>
    </div>
  </div>
</section>
@endsection


