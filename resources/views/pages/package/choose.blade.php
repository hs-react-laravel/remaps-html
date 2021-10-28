
@extends('layouts/contentLayoutMaster')

@section('title', 'Choose a package')

@section('content')
<section id="basic-input">
  <h4 class="card-title">Choose a subscription package</h4>
  <div class="row match-height">
    @foreach ($packages as $package)
      <div class="col-md-12 col-xl-6">
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
                <th>Description</th>
                <td>{!! $package->description !!}</td>
              </tr>
            </table>
          </div>
          <div class="card-footer">
            <a class="btn btn-primary me-1" href="{{ route('subscribe.paypal', ['id' => $package->id]) }}">Subscript Plan</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>
@endsection
