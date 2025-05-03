@extends('Frontend.layouts.master')
@section('title')
  Welcome Remapdash
@endsection

@section('content')
<section class="section auth-section">
  <div style="height: 72px"></div>
    <div class="container">
      <div class="register-col">
        <div class="box box-default" style="display: flex; justify-content: center">

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

          <div class="box-body" style="width: 540px">
            <h4 style="text-align: center; margin-bottom: 32px; color: white">Confirm to subscription</h4>
            <p style="color: white">
                The tuning Data API is a monthly subscription service, that allows access though an API to the European car and LCV tuning database, Stage 1 and Stage 2.<br/>
                These are just esimated gains for customer guidance and point of sale use on your website. <br/>
                We will supply you with instructions to forward to your web developer how to integrate in to your website. <br/>
                The following page will take you to PayPal to start your subscription of £49 per month.
            </p>
            <div>
              <input type="checkbox" id="chktc">
              <label for="vehicle1">I agree to the <a href="{{ route('frontend.api.tc') }}"> API terms and Conditions</a></label><br>
            </div>
            <div style="display: flex; justify-content: center; margin-bottom: 36px">
              <a id="linkproceed" class="btn btn-default" href="{{ route('frontend.api.sub', ['token' => $token]) }}" disabled>Subscribe</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
  $(function() {
      $('body').scrollTop(1);
  });
  
  $('#chktc').change(function (){
      if ($(this).is(':checked')) {
          $('#linkproceed').removeAttr('disabled');
      } else {
          $('#linkproceed').attr('disabled','disabled');
      }

  })
</script>
@endsection

