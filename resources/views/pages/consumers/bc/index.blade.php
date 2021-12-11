
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
    <h3>Normal Credit</h3>
    <div class="row">
        @foreach ($groupCreditTires as $idx => $tire)
        @php
          $vat_percentage = $isVatCalculation ? $company->vat_percentage : 0;
          $tax = $tire->pivot->for_credit * $vat_percentage / 100;
          $total_amount = $tire->pivot->for_credit + $tax;
        @endphp
        <div class="payment-box">
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
              @if ($user->company->paypal_client_id && $user->company->paypal_secret)
              <button
                type="button"
                class="btn btn-outline-info me-1"
                onclick="onPaypalButton(this)">
                Paypal
              </button>
              @endif
              @if ($user->company->stripe_key && $user->company->stripe_secret)
              <button
                type="button"
                class="btn btn-outline-warning"
                data-bs-toggle="modal"
                data-bs-target="#addNewCard"
                data-group="{{ $tuningCreditGroup->id }}"
                data-tire="{{ $tire->id }}"
                onclick="onStripeButton(this)">
                Stripe
              </button>
              @endif
              <form action="{{ route('consumer.buy-credits.handle') }}" method="POST" class="paypal-form">
                @csrf
                <input type="hidden" name="group_id" value="{{ $tuningCreditGroup->id }}">
                <input type="hidden" name="tire_id" value="{{ $tire->id }}">
              </form>
            </div>
          </div>
        </div>
        @endforeach
    </div>
    @if($user->company->reseller_id && $user->reseller_id && count($groupEVCCreditTires) > 0)
    <h3>EVC Credit</h3>
    @endif
    <div class="row">
      @foreach ($groupEVCCreditTires as $idx => $tire)
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
              type="button"
              class="btn btn-outline-info me-2"
              onclick="onPaypalButton(this)">
              <i class="fab fa-cc-paypal" style="font-size: 30px"></i>
            </button>
            <button
              type="button"
              class="btn btn-outline-warning"
              data-bs-toggle="modal"
              data-bs-target="#addNewCard"
              data-group="{{ $tuningCreditGroup->id }}"
              data-tire="{{ $tire->id }}"
              onclick="onStripeButton(this)">
              <i class="fab fa-cc-stripe" style="font-size: 30px"></i>
            </button>
            <form action="{{ route('consumer.buy-credits.handle') }}" method="POST" class="paypal-form">
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
@include('content/_partials/_modals/modal-add-new-cc')
@endsection

@section('page-script')
{{-- Page js files --}}
<script src="{{asset('js/scripts/pages/page-pricing.js')}}"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
  var $form = $('#cardValidation');
  function onPaypalButton(obj) {
    var $paypal_form = $(obj).closest('.card-body').children('.paypal-form');
    console.log($paypal_form);
    $paypal_form.submit();
  }
  function onStripeButton(obj) {
    var group = $(obj).data('group');
    var tire = $(obj).data('tire');
    $('#cardValidation input[name=group_id]').val(group);
    $('#cardValidation input[name=tire_id]').val(tire);
  }
  $('#cardValidation').bind('submit', function(e) {
    var $form = $('#cardValidation');
    inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
    $inputs       = $form.find('.required').find(inputSelector),
    $errorMessage = $form.find('div.error'),
    valid         = true;
    $errorMessage.addClass('hide');
    $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry').val().split('/')[0],
        exp_year: $('.card-expiry').val().split('/')[1]
      }, stripeResponseHandler);
    }
  });
  function stripeResponseHandler(status, response) {
    if (response.error) {
        $('.error').removeClass('hide').find('.alert').text(response.error.message);
    } else {
      // token contains id, last4, and card type
      var token = response['id'];
      console.log(token)
      // insert the token into the form so it gets submitted to the server
      $form.find('input[type=text]').empty();
      $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
      $form.get(0).submit();
    }
  }
</script>
@endsection
