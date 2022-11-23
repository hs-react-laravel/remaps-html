
@extends('layouts/contentLayoutMaster')

@section('title', 'Choose a package')

@section('content')
<section id="basic-input">
  <h4 class="card-title">Ecommerce Plans</h4>
  <div class="d-flex plan-row">
    <div class="plan-card">
      <div class="card bg-white">
        <div class="plan-header">
          <div class="plan-name">Free Plan</div>
          <div class="plan-price">Free</div>
          <div class="plan-interval"></div>
        </div>
        <div class="plan-body free">
          <div class="plan-product-count">3 Products</div>
          <div class="plan-text">Enjoy free subscription plan.</div>
          <a
            class="plan-subscribe"
            href="{{ $sub ? route('shop.subscriptions.cancel', ['id' => $sub->id]) : '#' }}">
            {{ $sub ? 'GET PLAN' : 'MY PLAN' }}
          </a>
        </div>
      </div>
    </div>
    @foreach ($packages as $package)
    @if ($package->mode === 1)
      <div class="plan-card">
        <div class="card bg-{{ $package->color }}">
          <div class="plan-header">
            <div class="plan-name">{{ $package->name }}</div>
            <div class="plan-price">{{ $package->amount_with_current_sign }}</div>
            <div class="plan-interval">Per {{ $package->billing_interval }}</div>
          </div>
          <div class="plan-body @if (!$package->color) free @endif">
            <div class="plan-product-count">{{ $package->product_count }} Products</div>
            <div class="plan-text">{!! $package->description !!}</div>
            <a
              class="plan-subscribe color-{{ $package->color }}"
              href="{{ $sub && $sub->package->id == $package->id ? '#' : route('shop.subscribe.paypal', ['id' => $package->id]) }}">
              {{ $sub && $sub->package->id == $package->id ? 'MY PLAN' : 'GET PLAN' }}
            </a>
          </div>
        </div>
      </div>
    @endif
    @endforeach
  </div>
  <h4 class="card-title">Ecommerce Plans (Digital Products)</h4>
  <div class="d-flex plan-row">
    @foreach ($packages as $package)
    @if ($package->mode === 2)
      <div class="plan-card">
        <div class="card bg-{{ $package->color }}">
          <div class="plan-header">
            <div class="plan-name">{{ $package->name }}</div>
            <div class="plan-price">{{ $package->amount_with_current_sign }}</div>
            <div class="plan-interval">Per {{ $package->billing_interval }}</div>
          </div>
          <div class="plan-body @if (!$package->color) free @endif">
            <div class="plan-product-count">{{ $package->product_count }} Products</div>
            <div class="plan-text">{!! $package->description !!}</div>
            <a
              class="plan-subscribe color-{{ $package->color }}"
              href="{{ $sub && $sub->package->id == $package->id ? '#' : route('shop.subscribe.paypal', ['id' => $package->id]) }}">
              {{ $sub && $sub->package->id == $package->id ? 'MY PLAN' : 'GET PLAN' }}
            </a>
          </div>
        </div>
      </div>
    @endif
    @endforeach
  </div>
</section>
@endsection
