
@extends('layouts/contentLayoutMaster')

@section('title', 'Choose a package')

@section('content')
<section id="basic-input">
  <h4 class="card-title">Choose a subscription package</h4>
  <div class="row match-height">
    @foreach ($packages as $package)
      <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">{{ $package->name }}</h4>
          </div>
          <div class="card-body">
            <table class="table">
              <tr>
                <th>Billing Interval</th>
                <td>{{ $package->billing_interval }}</td>
              </tr>
              <tr>
                <th>Amount</th>
                <td>{{ $package->amount_with_current_sign }}</td>
              </tr>
              <tr>
                <th>Product Count</th>
                <td>{{ $package->product_count }}</td>
              </tr>
              <tr>
                <th>Description</th>
                <td>{!! $package->description !!}</td>
              </tr>
            </table>
          </div>
          <div class="card-footer">
            <a class="btn btn-primary me-1" href="{{ route('shop.subscribe.paypal', ['id' => $package->id]) }}">Subscribe Plan</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>
@endsection
