@extends('Frontend.layouts.master')
@section('title')
  Welcome Remapdash
@endsection

@section('css')
<style type="text/css">
  .fancybox-margin{margin-right:17px;}

  .section.api-reg {
    background-color: #18191c;
  }

  .container-form{
    width: 750px;
  }
</style>
@endsection

@section('content')
<section class="section api-reg">
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
          <h4 class="wow fadeInDown animated" style="color: #fec400">Forgot Password</h4>
          {!! html()->form('POST')->route('frontend.api.password.email')->autocomplete('false')->open() !!}
          <div class="form-group">
              {!! html()->label('Email', 'email') !!}
              {!! html()->text('email')->class(['form-control'])->placeholder('Email') !!}
          </div>
          <div class="form-group">
            <div id="error"></div>
          </div>
          <button id="btnSubmit" class="btn btn-success view-btn" style="margin-bottom: 10px; margin-top: 20px;" type="submit">Send Reset Link</button>
					{!! html()->form()->close() !!}
        </div>
      </div>
      <p>If you need any help, please contact to <a class="custom-link" href="mailto:support@remapdash.com">support@remapdash.com</a></p>
    </div>
  </div>
</section>
@endsection


