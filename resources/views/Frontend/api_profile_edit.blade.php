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
          <h4 class="wow fadeInDown animated" style="color: #fec400">Edit your profile</h4>
          {!! html()->form('POST')->route('frontend.api.profile.save')->autocomplete(false)->open() !!}
          <div class="form-group">
              {!! html()->label('First Name', 'first_name') !!}
              {!! html()->text('first_name', $user->first_name)->class(['form-control'])->placeholder('First Name') !!}
          </div>

          <div class="form-group">
              {!! html()->label('Last Name', 'last_name') !!}
              {!! html()->text('last_name', $user->last_name)->class(['form-control'])->placeholder('Last Name') !!}
          </div>

          <div class="form-group">
              {!! html()->label('Phone', 'phone') !!}
              {!! html()->text('phone', $user->phone)->class(['form-control'])->placeholder('Phone') !!}
          </div>

          <div class="form-group">
              {!! html()->label('Company', 'company') !!}
              {!! html()->text('company', $user->company)->class(['form-control'])->placeholder('Company') !!}
          </div>

          <div class="form-group">
              {!! html()->label('Domain', 'domain') !!}
              {!! html()->text('domain', $user->domain)->class(['form-control'])->placeholder('https://abc.com') !!}
          </div>

          <div class="form-group">
            <div id="error"></div>
          </div>
          <button id="btnSubmit" class="btn btn-success view-btn" type="submit">Update</button>
          {!! html()->form()->close() !!}
        </div>
      </div>
      <p>If you need any help, please contact to <a class="custom-link" href="mailto:support@remapdash.com">support@remapdash.com</a></p>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
  $(function() {
      $('body').scrollTop(1);
  });
</script>
@endsection

