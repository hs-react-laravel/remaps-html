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
          <a  class="btn btn-primary my-4" href="/">Back</a>
          {!! html()->form('POST')->route('pay.with.paypal.main')->acceptsFiles()->autocomplete(false)->open() !!}

          <div class="form-group">
            {!! html()->label('Company Name', 'name') !!}
            {!! html()->text('name')->class(['form-control'])->placeholder('Company Name') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Email Address', 'main_email_address') !!}
            {!! html()->text('main_email_address')->class(['form-control'])->placeholder('Email Address') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Password', 'password') !!}
            {!! html()->password('password')->class(['form-control'])->placeholder('Password') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Confirm Password', 'password_confirmation') !!}
            {!! html()->password('password_confirmation')->class(['form-control'])->placeholder('Confirm Password') !!}
          </div>

          @if($_GET['domain'] == 'regular')
          <div class="form-group">
            {!! html()->label('Choose your preferred subdomain (yourname.remapdash.com)', 'domain_prefix') !!}
            <div style="display: flex">
            {!! html()->text('domain_prefix')->attribute('id', 'domain_prefix')->class(['form-control'])->placeholder('Eg: yourname') !!}
            {!! html()->text('domain_suffix', '.remapdash.com')->class(['form-control', 'domain-suffix'])->isReadonly(true) !!}
            </div>
          </div>
          @endif

          @if($_GET['domain'] == 'own')
          <div class="form-group">
            {!! html()->label('Choose your own domain', 'own_domain') !!}
            {!! html()->text('own_domain')->class(['form-control'])->placeholder('Full FQDN inc https://') !!}
            {!! html()->label('This allows you to have the portal service appear on your own domain name. for example. https://yourdomain.com (or) subdomain,', 'domain') !!}
            {!! html()->label('example https://portal.yourdomain.com, if you already have a company website a subdomain is the best option.', 'own_domain') !!}
            {!! html()->label('In order for this to work our support team will ask for you to make some changes to your DNS records
            to be pointed to our servers', 'own_domain') !!}
          </div>
          @endif

          <div class="form-group">
            {!! html()->label('Address line 1', 'address_line_1') !!}
            {!! html()->text('address_line_1')->class(['form-control'])->placeholder('Address line 1') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Address line 2', 'address_line_2') !!}
            {!! html()->text('address_line_2')->class(['form-control'])->placeholder('Address line 2') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Town', 'town') !!}
            {!! html()->text('town')->class(['form-control'])->placeholder('Town') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Country', 'country') !!}
            {!! html()->text('country')->class(['form-control'])->placeholder('Country') !!}
          </div>

          <div class="form-group">
            {!! html()->hidden('v2_domain_link', '')->attribute('id', 'v2_domain_link') !!}
          </div>

          <div class="form-group">
            {!! html()->label('Company Logo', 'logo') !!}
            <!-- <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            <div id="logo-preview-wrapper" style="margin-top:10px; display:none;">
              <img id="logo-preview" src="#" alt="Logo Preview" style="max-width: 200px; max-height: 120px; border:1px solid #ddd; padding:4px; background:#fff;" />
            </div> -->

            <div class="border rounded p-1">
              <div class="d-flex flex-column flex-md-row">
                <img
                  src="/images/logo/company_logo_250x110.png"
                  id="logo"
                  class="rounded me-2 mb-1 mb-md-0"
                  width="250"
                  height="110"
                  alt="Blog Featured Image"
                  style="width: 250px; height: 110px;"
                />
                <div class="featured-info d-flex align-items-center">
                  <div class="d-inline-block">
                    <input class="form-control" type="file" id="imageLogo" name="upload_file" accept="image/*" style="width: 430px;" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="g-recaptcha" data-sitekey="{{env('SITE_KEY')}}" ></div>
          </div>

          <div class="form-group">
            <div id="error"></div>
          </div>
          <button id="btnSubmit" class="btn btn-success view-btn" style="margin-bottom: 10px; margin-top: 20px;" type="submit">Submit</button>

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
  var owl = $('.banner-silder');
  owl.owlCarousel({
      items:1,
      loop:true,
      autoplayTimeout:1000,
      autoplayHoverPause:true,
      margin:0,
      autoPlay:true,
      responsive: {
          0: {
              items: 1
          },
          600: {
              items: 1
          },
          1000: {
              items: 1
          }
      }
  });
  $(function() {
      $('body').scrollTop(1);
  });
  $('#domain_prefix').change(function (){
      $('#v2_domain_link').val($(this).val() + ".remapdash.com");
  });
  $('#own_domain').change(function () {
      $('#v2_domain_link').val($(this).val());
  })

  // Logo image preview
  document.getElementById('imageLogo').addEventListener('change', function(event) {
    const [file] = event.target.files;
    const logo = document.getElementById('logo');
    if (file) {
      logo.src = URL.createObjectURL(file);
    } else {
      logo.src = '#';
    }
  });

</script>
@endsection
