
@extends('layouts/contentLayoutMaster')

@section('title', 'Pricing')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/base/pages/page-pricing.css')}}">
@endsection

@section('content')
<section id="pricing-plan">
  <h1 class="mt-5 mb-3">Buy Tuning Credits</h1>

  <div class="row pricing-card">
    <div class="row">
        @foreach ($groupCreditTires as $idx => $tire)
        @php
          $vat_percentage = $isVatCalculation ? $this->company->vat_percentage : 0;
          $tax = $tire->pivot->for_credit * $vat_percentage / 100;
          $total_amount = $tire->pivot->for_credit + $tax;
        @endphp
        <div class="col-12 col-md-3 col-xl-3">
          <div class="card basic-pricing text-center">
            <div class="card-body">
              <h3>
                <i data-feather="credit-card" class="card-custom"></i>
                <i data-feather="x"></i>
                {{ $tire->amount }}
              </h3>
              <div class="annual-plan">
                <div class="plan-price mt-2">
                  <sup class="font-medium-1 fw-bold text-primary">£</sup>
                  <span class="pricing-basic-value fw-bolder text-primary">
                    {{ $total_amount }}
                  </span>
                </div>
                <small class="annual-pricing d-none text-muted"></small>
              </div>
              <button
                type="submit"
                class="btn btn-outline-success me-2">
                <i class="fab fa-cc-paypal" style="font-size: 30px"></i>
              </button>
              <button
                type="submit"
                class="btn btn-outline-warning mt-2">
                <i class="fab fa-cc-stripe" style="font-size: 30px"></i>
              </button>
              <form action="{{ route('consumer.buy-credits.handle') }}" method="POST">
                @csrf
                <input type="hidden" name="group_id" value="{{ $tuningCreditGroup->id }}">
                <input type="hidden" name="tire_id" value="{{ $tire->id }}">
              </form>
            </div>
          </div>
        </div>
        @endforeach
    </div>
  </div>

</section>
@endsection

@section('page-script')
{{-- Page js files --}}
<script src="{{asset('js/scripts/pages/page-pricing.js')}}"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
