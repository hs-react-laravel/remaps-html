@extends('layouts/contentLayoutMaster')

@section('title', 'Browse Specs')

@section('content')
<style>
  .param-wrapper {
    padding: 2.5px;
  }
  .param-header {
    padding: 10px 20px;
    font-weight: bold;
    text-align: center;
  }
</style>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{ $car->title }}</h4>
      </div>
      <div class="card-body">
        <div class="row col-12" style="color: white; justify-content: center;">
          <div class="col-2"></div>
          <div class="col-3 param-wrapper">
            <div class="param-header bg-light-info">STANDARD</div>
          </div>
          <div class="col-3 param-wrapper">
            <div class="param-header bg-light-info">CHIPTUNING</div>
          </div>
          <div class="col-3 param-wrapper">
            <div class="param-header bg-light-info">DIFFERENCE</div>
          </div>
          <div class="col-2 param-wrapper">
            <div class="param-header bg-light-primary">BHP</div>
          </div>
          <div class="col-3 param-wrapper">
            <div class="param-header bg-secondary">{{ $car->std_bhp }}</div>
          </div>
          <div class="col-3 param-wrapper">
            <div class="param-header bg-dark">{{ $car->tuned_bhp }}</div>
          </div>
          <div class="col-3 param-wrapper">
            <div class="param-header bg-black">{{ intval($car->tuned_bhp) - intval($car->std_bhp) }} hp</div>
          </div>
          <div class="col-2 param-wrapper">
            <div class="param-header bg-light-danger">TORQUE</div>
          </div>
          <div class="col-3 param-wrapper">
            <div class="param-header bg-secondary">{{ $car->std_torque }}</div>
          </div>
          <div class="col-3 param-wrapper">
            <div class="param-header bg-dark">{{ $car->tuned_torque }}</div>
          </div>
          <div class="col-3 param-wrapper">
            <div class="param-header bg-black">{{ intval($car->tuned_torque) - intval($car->std_torque) }} Nm</div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <canvas class="line-chart-ex chartjs" data-height="350"></canvas>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-2">
          <img src="{{ $logofile }}" style="width: 100px; height: 100px; margin:20px; padding:0" />
          <h4>
            Tuning file {{ $car->title }}
          </h4>
          <p>
            {{ $company->name }} is leading in the development of {{ $car->title }} tuning files. <br>
            The development of each {{ $car->title }} tuning file is the result of perfection and dedication by {{ $company->name }} programmers.
            The organization only uses the latest technologies and has many years experience in ECU remapping software.
            Many (chiptuning) organizations around the globe download their tuning files for {{ $car->title }} at {{ $company->name }} for the best possible result.
            All {{ $car->title }} tuning files deliver the best possible performance and results within the safety margins.
          </p>
          <ul class="ms-2">
            <li>100% custom made tuning file guarantee</li>
            <li>Tested and developed via a 4x4 Dynometer</li>
            <li>Best possible performance and results, within the safety margins</li>
            <li>Reduced fuel consumption</li>
          </ul>
        </div>
        <div class="row">
          @if(!empty($_GET['make']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ url('/cars/category') }}">Overview</a>
            </div>
          @endif
          @if(!empty($_GET['model']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ url('/cars/category'.'?make='.$_GET['make']) }}">
                Back to {{ $_GET['make'] }}
              </a>
            </div>
          @endif
          @if(!empty($_GET['generation']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ url('/cars/category'.'?make='.$_GET['make'].'&model='.$_GET['model']) }}">
                Back to {{ $_GET['model'] }}
              </a>
            </div>
          @endif
          @if(!empty($_GET['engine']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ url('/cars/category'.'?make='.$_GET['make'].'&model='.$_GET['model'].'&generation='.$_GET['generation']) }}">
                Back to {{ $_GET['generation'] }}
              </a>
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
@endsection
@section('page-script')
  <script src="{{ asset('customjs/car-chart.js') }}"></script>
@endsection
