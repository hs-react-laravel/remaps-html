@extends('layouts/contentLayoutMaster')

@section('title', 'Browse Specs')

@section('content')
<style>
  .brand-link:hover {
    transform: scale(1.2, 1.2);
  }
  .brand-link {
    float: left;
    box-sizing: border-box;
    margin: 0 0 4% 4%;
    padding: 12px;
    position: relative;
    z-index: 1;
    overflow: hidden;
    display: block;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 0 4px rgba(0,0,0,.4);
    transform: scale(1, 1);
    transition: transform .3s ease;
  }
  .brand-link img {
    width: 100%; /* This if for the object-fit */
    height: 100%; /* This if for the object-fit */
    object-fit: cover; /* Equivalent of the background-size: cover; of a background-image */
    object-position: center;
  }
</style>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Please select the make of your car below.</h4>
      </div>
      <div class="card-body">
        <div class="row">
          @foreach($brands as $brand)
              <a class="col-sm-4 col-md-2 col-xl-1 brand-link" href="{{ (Auth::guard('admin')->check() ? route('admin.cars.category') : route('cars.category')).'?make='.$brand['brand'] }}">
                <img src="{{ $brand['logo'] }}">
              </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

