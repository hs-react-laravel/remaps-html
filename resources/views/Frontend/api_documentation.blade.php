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

  .card {
    border: 1px solid #ffffff26;
    border-radius: 6px;
  }
  .card-header {
    padding: 8px 16px;
    border-radius: 5px 5px 0 0;
    border-bottom: 1px solid #ffffff26;
  }

  .card-header h5 {
    color: white;
  }
  .card-body {
    padding: 16px;
  }
</style>
@endsection

@section('content')
<section class="section auth-section">
  <div style="height: 72px"></div>
  <div class="container">
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
          <div class="footer_about">
            <h4 style="color:white" class="mt-md-5 mb-4"><i class="fa-solid fa-plug"></i></i>  Rest API</h4>
            <h5 style="color:white; padding-top: 12px">API Base URL</h5>
            <p>
              All api endpoints must be prefixed with the api base url.
              <pre>https://remapdash.com/api/*</pre>
            </p>
            <h5 style="color:white; padding-top: 12px">Authentication</h5>
            <p>
              When you make API calls, replace ACCESS-TOKEN with your access token in the authorization header
              <span class="badge">-H Authorization: Bearer ACCESS-TOKEN</span>.
            </p>
            <h5 style="color:white; padding-top: 12px">Standard API Calls</h5>

            <div class="card mb-4">
              <div class="card-header">
                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /makes</h5>
                <p>List All Makes</p>
              </div>
              <div class="card-body">
                <p>Request</p>
                <hr>
                <p>Response <span class="badge">application/json</span></p>
                <pre>
                [
                    {
                        "id": 1,
                        "make": "Alfa Romeo",
                        "logo": "http://localhost:8080/images/carlogo/alfa-romeo.jpg"
                    },
                    ...
                ]
                </pre>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-header">
                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /make/{makeid}</h5>
                <p>View a Make</p>
              </div>
              <div class="card-body">
                <p>Request</p>
                <p><span class="badge">makeid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                <hr>
                <p>Response <span class="badge">application/json</span></p>
                <pre>
                {
                    "id": 1,
                    "make": "Alfa Romeo",
                    "logo": "http://localhost:8080/images/carlogo/alfa-romeo.jpg"
                }
                </pre>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-header">
                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /make/{makeid}/models</h5>
                <p>List all Models of a Make</p>
              </div>
              <div class="card-body">
                <p>Request</p>
                <p><span class="badge">makeid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                <hr>
                <p>Response <span class="badge">application/json</span></p>
                <pre>
                [
                    {
                        "id": 1,
                        "make": "Alfa Romeo",
                        "model": "147"
                    },
                    ...
                ]
                </pre>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-header">
                  <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /model/{modelid}</h5>
                  <p>View a Model</p>
              </div>
              <div class="card-body">
                <p>Request</p>
                <p><span class="badge">modelid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                <hr>
                <p>Response <span class="badge">application/json</span></p>
                <pre>
                {
                    "id": 1,
                    "make": "Alfa Romeo",
                    "model": "147"
                }
                </pre>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-header">
                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /model/{modelid}/generations</h5>
                <p>List all generations of a Model</p>
              </div>
              <div class="card-body">
                <p>Request</p>
                <p><span class="badge">modelid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                <hr>
                <p>Response <span class="badge">application/json</span></p>
                <pre>
                [
                    {
                        "id": 1,
                        "make": "Alfa Romeo",
                        "model": "147",
                        "generation": "2001  2005"
                    },
                    ...
                ]
                </pre>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-header">
                <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /generation/{generationid}</h5>
                <p>View a Generation</p>
              </div>
              <div class="card-body">
                <p>Request</p>
                <p><span class="badge">generationid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                <hr>
                <p>Response <span class="badge">application/json</span></p>
                <pre>
                {
                    "id": 1,
                    "make": "Alfa Romeo",
                    "model": "147",
                    "generation": "2001  2005"
                }
                </pre>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-header">
                  <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /generation/{generationid}/engines</h5>
                  <p>List all Engine types of a Generation</p>
              </div>
              <div class="card-body">
                <p>Request</p>
                <p><span class="badge">generationid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                <hr>
                <p>Response <span class="badge">application/json</span></p>
                <pre>
                  [
                      {
                          "id": 1,
                          "make": "Alfa Romeo",
                          "model": "147",
                          "generation": "2001  2005",
                          "engine": "2.0  TS",
                          "std_bhp": "150 hp",
                          "tuned_bhp": "165 hp",
                          "tuned_bhp_2": null,
                          "std_torque": "172 Nm",
                          "tuned_torque": "192 Nm",
                          "tuned_torque_2": null
                      },
                      ...
                  ]
                  </pre>
                </div>
              </div>

              <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0" style="text-transform: none"><span class="badge text-info bg-info-subtle border border-info">GET</span> /engine/{engineid}</h5>
                    <p>View details of a Engine</p>
                </div>
                <div class="card-body">
                  <p>Request</p>
                  <p><span class="badge">engineid</span>&nbsp;: &nbsp;&nbsp;integer</p>
                  <hr>
                  <p>Response <span class="badge">application/json</span></p>
                  <pre>
                  {
                      "id": 1,
                      "make": "Alfa Romeo",
                      "model": "147",
                      "generation": "2001  2005",
                      "engine": "2.0  TS",
                      "std_bhp": "150 hp",
                      "tuned_bhp": "165 hp",
                      "tuned_bhp_2": null,
                      "std_torque": "172 Nm",
                      "tuned_torque": "192 Nm",
                      "tuned_torque_2": null,
                      "title": "Alfa Romeo 147 2001  2005 2.0  TS"
                  }
                  </pre>
                </div>
              </div>
            </div>
          </div>
        </div>
        <p>If you need any help, please contact to <a class="custom-link" href="mailto:support@remapdash.com">support@remapdash.com</a></p>
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')
<script>
  $(function() {
    $('body').scrollTop(1);
  });
</script>
@endsection


