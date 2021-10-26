
@extends('layouts/contentLayoutMaster')

@section('title', 'Pricing')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/base/pages/page-pricing.css')}}">
@endsection

@section('content')
<section id="pricing-plan">
  <h1 class="mt-5 mb-3">Buy Tuning Credits</h1>

  <!-- pricing plan cards -->
  <div class="row pricing-card">
    <div class="row">
      <!-- basic plan -->
        @foreach ($groupCreditTires as $idx => $tire)
        @php
          $vat_percentage = $isVatCalculation ? $this->company->vat_percentage : 0;
          $tax = $tire->pivot->for_credit * $vat_percentage / 100;
          $total_amount = $tire->pivot->for_credit + $tax;
        @endphp
        <div class="col-12 col-md-3 col-xl-3">
          <div class="card basic-pricing text-center">
            <form action="{{ route('consumer.buy-credits.handle') }}" method="POST">
              @csrf
              <input type="hidden" name="group_id" value="{{ $tuningCreditGroup->id }}">
              <input type="hidden" name="tire_id" value="{{ $tire->id }}">
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
                  class="btn w-100 {{$idx == count($groupCreditTires) - 1 ? 'btn-primary' : 'btn-outline-primary'}} mt-2">
                  Buy
                </button>
              </div>
            </form>
          </div>
        </div>
        @endforeach
      <!--/ basic plan -->
    </div>
  </div>

</section>
@endsection

@section('page-script')
{{-- Page js files --}}
<script src="{{asset('js/scripts/pages/page-pricing.js')}}"></script>
@endsection
