@extends('layouts/contentLayoutMaster')

@section('title', 'Browse Specs')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">
          {{ $title }}
          @if($mode == 'make')
              Models
          @elseif($mode == 'model')
              Generations
          @elseif($mode == 'generation')
              Engine Types
          @endif
        </h4>
      </div>
      <div class="card-body">
        <div class="row mb-2">
          @foreach($subitems as $si)
            <div class="card col-md-6 col-lg-3">
              @if($mode == 'make')
                <a href="{{ (Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category')).'?make='.$title.'&model='.$si }}" class="btn btn-primary">
                  {{ $si }}
                </a>
              @elseif($mode == 'model')
                <a href="{{ (Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category')).'?make='.$brand.'&model='.$title.'&generation='.$si }}" class="btn btn-primary">
                  {{ $si }}
                </a>
              @elseif($mode == 'generation')
                <a href="{{ (Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category')).'?make='.$brand.'&model='.$model.'&generation='.$title.'&engine='.$si->id }}" class="btn btn-primary">
                  {{ $si->engine_type.' '.$si->std_bhp }}
                </a>
              @endif
            </div>
          @endforeach
        </div>
        <div class="row mb-2">
          <img src="{{ $logo }}" style="width: 100px; height: 100px; margin:20px; padding:0" />
          <h4>
            @if($mode == 'make')
              {{ $title }}
            @elseif($mode == 'model')
              {{ $brand.' '.$title }}
            @elseif($mode == 'generation')
              {{ $brand.' '.$model.'('.$title.')' }}
            @endif
          </h4>
          <p>
            The development of each {{ $title }} tuning file is the result of perfection and dedication by {{ $company->name }} programmers.
            The organization only uses the latest technologies and has many years experience in ECU remapping software.
            Many (chiptuning) organizations around the globe download their tuning files for {{ $title }} at {{ $company->name }} for the best possible result.
            All {{ $title }} tuning files deliver the best possible performance and results within the safety margins.
          </p>
          <ul class="ms-2">
            <li>100% custom made tuning file guarantee</li>
            <li>Tested and developed via a 4x4 Dynometer</li>
            <li>Best possible performance and results, within the safety margins</li>
            <li>Reduced fuel consumption</li>
          </ul>
        </div>
        <div class="row">
          @if(isset($make))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ (Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category')) }}">Overview</a>
            </div>
          @endif
          @if(!empty($_GET['model']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ (Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category')).'?make='.$_GET['make'] }}">
                Back to {{ $_GET['make'] }}
              </a>
            </div>
          @endif
          @if(!empty($_GET['generation']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ (Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category')).'?make='.$_GET['make'].'&model='.$_GET['model'] }}">
                Back to {{ $_GET['model'] }}
              </a>
            </div>
          @endif
          @if(!empty($_GET['engine']))
            <div class="card col-md-6 col-lg-3">
              <a class="btn btn-dark" href="{{ (Auth::guard('customer')->check() ? route('cars.category') : route('admin.cars.category')).'?make='.$_GET['make'].'&model='.$_GET['model'].'&generation='.$_GET['generation'] }}">
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
