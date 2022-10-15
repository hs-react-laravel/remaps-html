@extends('layouts/contentLayoutMaster')

@section('title', 'Checkout')

@section('vendor-style')
  <!-- Vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-ecommerce.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-number-input.css')) }}">
@endsection

@section('content')
  <div class="bs-stepper checkout-tab-steps ecommerce-application">
    <input type="hidden" id="order_status" value="{{ isset($order) ? $order->status : '' }}">
    <!-- Wizard starts -->
    <div class="bs-stepper-header">
      <div class="step" data-target="#step-cart" role="tab" id="step-cart-trigger" style="pointer-events: none !important">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="shopping-cart" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Cart</span>
            <span class="bs-stepper-subtitle">Your Cart Items</span>
          </span>
        </button>
      </div>
      <div class="line">
        <i data-feather="chevron-right" class="font-medium-2"></i>
      </div>
      <div class="step" data-target="#step-address" role="tab" id="step-address-trigger" style="pointer-events: none !important">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="home" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Address</span>
            <span class="bs-stepper-subtitle">Enter Your Address</span>
          </span>
        </button>
      </div>
      <div class="line">
        <i data-feather="chevron-right" class="font-medium-2"></i>
      </div>
      <div class="step" data-target="#step-shipping" role="tab" id="step-shipping-trigger" style="pointer-events: none !important">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="truck" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Shipping</span>
            <span class="bs-stepper-subtitle">Select shipping option</span>
          </span>
        </button>
      </div>
      <div class="line">
        <i data-feather="chevron-right" class="font-medium-2"></i>
      </div>
      <div class="step" data-target="#step-payment" role="tab" id="step-payment-trigger" style="pointer-events: none !important">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="credit-card" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Payment</span>
            <span class="bs-stepper-subtitle">Select Payment Method</span>
          </span>
        </button>
      </div>
    </div>
    <!-- Wizard ends -->

    <div class="bs-stepper-content">
      <div id="step-cart" class="content" role="tabpanel" aria-labelledby="step-cart-trigger">
        <form id="place-order" class="list-view product-checkout" method="POST" action="{{ route('customer.shop.order.place') }}">
          @csrf
          <div class="checkout-items">
            @if (count($cartProducts) > 0)
              @foreach ($cartProducts as $item)
                <div class="card ecommerce-card sc-cart-card">
                  <div class="item-img">
                    <a href="{{ route('customer.shop.detail', ['id' => $item->product->id]) }}">
                      <img src="{{ $item->product->thumb
                        ? asset('storage/uploads/products/thumbnails/'.$item->product->thumb)
                        : 'https://via.placeholder.com/350x250.png?text='.($item->product->digital_id ? 'Digital File' : 'Image')}}" />
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="item-name">
                      <h6 class="mb-0"><a href="{{ route('customer.shop.detail', ['id' => $item->product->id]) }}" class="text-body">{{ $item->product->title }}</a></h6>
                      @if ($item->product->brand)
                      <span class="item-company">By <a href="#" class="company-name">{{ $item->product->brand }}</a></span>
                      @endif
                      <div class="item-rating">
                        @php $avgRating = round($item->product->avgRating()); @endphp
                        @include('pages.consumers.ec.rating')
                      </div>
                    </div>
                    @if (!$item->product->digital_id)
                      @if ($item->product->stock > 0)
                      <span class="text-success mb-1">In Stock</span>
                      @else
                      <span class="text-danger mb-1">Out of Stock</span>
                      @endif
                    @endif
                    @if ($item->sku_detail)
                    <div>
                      <div class="text-warning">Options</div>
                      @php
                        $skuItems = json_decode($item->sku_detail);
                        // dd($skuItems);
                      @endphp
                      @foreach ($skuItems as $sku)
                        <span><b>{{ $sku->title }} :</b></span> <br>
                        @foreach ($sku->select as $select)
                          <span>{{ $select->title }}</span>
                          <span>({{ $currencyCode }}{{ $select->price }})</span> <br>
                        @endforeach
                      @endforeach
                    </div>
                    @endif
                    @if (!$item->product->digital_id)
                    <div class="item-quantity">
                      <span class="quantity-title">Qty:</span>
                      <div class="quantity-counter-wrapper">
                        <div class="input-group">
                          <input type="text" class="quantity-counter" value="{{ $item->amount }}" data-cartid="{{ $item->id }}" onchange="onChangeCart(this)" />
                        </div>
                      </div>
                    </div>
                    @endif
                    {{-- <span class="delivery-date text-muted">Delivery by, Wed Apr 25</span>
                    <span class="text-success">17% off 4 offers Available</span> --}}
                  </div>
                  <div class="item-options text-center">
                    <div class="item-wrapper">
                      <div class="item-cost">
                        <h4 class="item-price">
                          {{ $currencyCode }}{{ number_format($item->price * $item->amount, 2) }}
                        </h4>
                        <p class="card-text shipping">
                          {{-- <span class="badge rounded-pill badge-light-success">Free Shipping</span> --}}
                        </p>
                      </div>
                    </div>
                    <button type="button" class="btn btn-light mt-1" data-cartid="{{ $item->id }}" onclick="onRemoveCart(this)">
                      <i data-feather="x" class="align-middle me-25"></i>
                      <span>Remove</span>
                    </button>
                  </div>
                </div>
              @endforeach
            @else
              Your cart is currently empty
            @endif
          </div>
          <div class="checkout-options">
            <div class="card">
              <div class="card-body">
                <div class="price-details">
                  <h6 class="price-title">Price Details</h6>
                  <ul class="list-unstyled">
                    <li class="price-detail">
                      <div class="detail-title">Total MRP</div>
                      <div class="detail-amt amt-total">
                        {{ $currencyCode.number_format($totalCartAmount, 2) }}
                      </div>
                    </li>
                    <li class="price-detail">
                      <div class="detail-title">TAX / VAT</div>
                      <div class="detail-amt amt-tax">
                        {{ $currencyCode.number_format($isVatCalculation ? $totalCartAmount * ($company->vat_percentage ?? 0) / 100 : 0, 2) }}
                      </div>
                    </li>
                  </ul>
                  <hr />
                  <ul class="list-unstyled">
                    <li class="price-detail">
                      <div class="detail-title detail-total">Total</div>
                      <div class="detail-amt fw-bolder amt-order">
                        {{ $currencyCode.number_format($isVatCalculation ? $totalCartAmount * (($company->vat_percentage ?? 0) + 100) / 100 : $totalCartAmount, 2) }}
                      </div>
                    </li>
                  </ul>
                  <button type="submit" class="btn btn-primary w-100 place-order">Place Order</button>
                </div>
              </div>
            </div>

          </div>
        </form>
      </div>

      <div id="step-address" class="content" role="tabpanel" aria-labelledby="step-address-trigger">
        @if (isset($order))
          {{ Form::model($order, array('route' => array('customer.shop.order.address', $order ? $order->id : ''), 'method' => 'POST', 'id' => "checkout-address", 'class' => "list-view product-checkout")) }}
            <div class="card">
              <div class="card-header flex-column align-items-start">
                <h4 class="card-title">Ship Address</h4>
                <p class="card-text text-muted mt-25">Be sure to check "Deliver to this address" when you have finished</p>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 col-sm-12">
                    <div class="mb-2">
                      <label class="form-label" cfor="ship_name">Full Name:</label>
                      <input
                        type="text"
                        id="ship_name"
                        class="form-control address-input"
                        name="ship_name"
                        placeholder=""
                        required />
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="mb-2">
                      <label class="form-label" cfor="ship_phone">Mobile Number:</label>
                      <input
                        type="text"
                        id="ship_phone"
                        class="form-control address-input"
                        name="ship_phone"
                        placeholder=""
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="mb-2">
                      <label class="form-label" cfor="ship_address_1">Address Line 1</label>
                      <input
                        type="text"
                        id="ship_address_1"
                        class="form-control address-input"
                        name="ship_address_1"
                        placeholder=""
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="mb-2">
                      <label class="form-label" cfor="ship_address_2">Address Line 2</label>
                      <input
                        type="text"
                        id="ship_address_2"
                        class="form-control address-input"
                        name="ship_address_2"
                        placeholder=""
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="mb-2">
                      <label class="form-label" cfor="ship_town">Town/City:</label>
                      <input
                        type="text"
                        id="ship_town"
                        class="form-control address-input"
                        name="ship_town"
                        placeholder=""
                        required />
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="mb-2">
                      <label class="form-label" cfor="ship_zip">Postal Code:</label>
                      <input
                        type="text"
                        id="ship_zip"
                        class="form-control address-input"
                        name="ship_zip"
                        placeholder=""
                        required />
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="mb-2">
                      <label class="form-label" cfor="ship_state">State / Province:</label>
                      <input
                        type="text"
                        id="ship_state"
                        class="form-control address-input"
                        name="ship_state"
                        placeholder=""
                        required />
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="mb-2">
                      <label class="form-label" cfor="ship_country">Country:</label>
                      <input
                        type="text"
                        id="ship_country"
                        class="form-control address-input"
                        name="ship_country"
                        placeholder=""
                        required />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="customer-card">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title p-name"></h4>
                </div>
                <div class="card-body actions">
                  <p class="card-text mb-0 p-address-line-1"></p>
                  <p class="card-text p-address-line-2"></p>
                  <p class="card-text p-town"></p>
                  <p class="card-text p-county"></p>
                  <p class="card-text p-zipcode"></p>
                  <p class="card-text p-country"></p>
                  <p class="card-text p-phone-number"></p>
                  <button type="submit" class="btn btn-primary w-100 delivery-address mt-2">
                    Deliver To This Address
                  </button>
                </div>
              </div>
            </div>
          {{ Form::close() }}
        @endif

      </div>

      <div id="step-shipping" class="content" role="tabpanel" aria-labelledby="step-shipping-trigger">
        @if (isset($order))
        {{ Form::model($order, array('route' => array('customer.shop.order.ship', $order ? $order->id : ''), 'method' => 'POST', 'id' => "checkout-shipment", 'class' => "list-view product-checkout")) }}
          @csrf
          <div class="checkout-items">
            @foreach ($order->items as $item)
              <div class="card ecommerce-card sc-cart-card">
                <div class="item-img">
                  <a href="{{ route('customer.shop.detail', ['id' => $item->product->id]) }}">
                    <img src="{{ $item->product->thumb
                      ? asset('storage/uploads/products/thumbnails/'.$item->product->thumb)
                      : 'https://via.placeholder.com/350x250.png?text=Product'}}" />
                  </a>
                </div>
                <div class="card-body">
                  <div class="item-name">
                    <h6 class="mb-0"><a href="{{ route('customer.shop.detail', ['id' => $item->product->id]) }}" class="text-body">{{ $item->product->title }}</a></h6>
                  </div>
                  <input type="hidden" name="shipping_object_id[]" value="0" class="shipping_object_id">
                  <span class="text-muted mt-2">Shipping Option</span>
                  <select class="form-control shipping-option" style="width: 250px; margin-top: .7rem">
                    <option value="">--Select Shipping option--</option>
                    @foreach ($item->product->shipping as $shipping)
                      <option value="{{ $shipping->id }}:{{ $shipping->price }}">{{ $shipping->option }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="item-options text-center">
                  <div class="item-wrapper">
                    <div class="item-cost">
                      <h4 class="item-price">
                        {{ $currencyCode }}{{ number_format($item->price * $item->amount, 2) }}
                      </h4>
                      <p class="card-text shipping-price">
                        <span class="badge rounded-pill badge-light-success">Free Shipping</span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <div class="checkout-options">
            <div class="card">
              <div class="card-body">
                <div class="price-details">
                  <h6 class="price-title">Price Details</h6>
                  <ul class="list-unstyled">
                    <li class="price-detail">
                      <div class="detail-title">Total MRP</div>
                      <div class="detail-amt amt-total">
                        {{ $currencyCode.number_format($order->amount, 2) }}
                      </div>
                    </li>
                    <li class="price-detail">
                      <div class="detail-title">TAX / VAT</div>
                      <div class="detail-amt amt-tax">
                        {{ $currencyCode.number_format($order->tax, 2) }}
                      </div>
                    </li>
                    <li class="price-detail">
                      <div class="detail-title">Shipping</div>
                      <div class="detail-amt amt-shipping">
                        {{ $currencyCode.number_format(0, 2) }}
                      </div>
                    </li>
                  </ul>
                  <hr />
                  <ul class="list-unstyled">
                    <li class="price-detail">
                      <div class="detail-title detail-total">Total</div>
                      <div class="detail-amt fw-bolder amt-order">
                        {{ $currencyCode.number_format($order->amount + $order->tax, 2) }}
                      </div>
                    </li>
                  </ul>
                  <button type="submit" class="btn btn-primary w-100 place-order">Apply shipping options</button>
                </div>
              </div>
            </div>

          </div>
        {{ Form::close() }}
        @endif
      </div>

      <div id="step-payment" class="content" role="tabpanel" aria-labelledby="step-payment-trigger">
        @if (isset($order))
        <div id="checkout-payment" class="list-view product-checkout">
          <div class="payment-type">
            <div class="card">
              <div class="card-header flex-column align-items-start">
                <h4 class="card-title">Payment options</h4>
                <p class="card-text text-muted mt-25">Be sure to click on correct payment option</p>
              </div>
              <div class="card-body">
                <ul class="other-payment-options list-unstyled">
                  @if ($user->company->paypal_client_id && $user->company->paypal_secret)
                  <li class="py-50">
                    <div class="form-check">
                      <input type="radio" id="customColorRadio2" name="paymentOptions" class="form-check-input" value="paypal" checked />
                      <label class="form-check-label" for="customColorRadio2"> Paypal </label>
                    </div>
                    <form
                      id="paypalForm"
                      action="{{ route('customer.shop.order.pay.paypal', ['id' => $order->id]) }}"
                      method="POST">@csrf</form>
                  </li>
                  @endif
                  @if ($user->company->stripe_key && $user->company->stripe_secret)
                  <li class="py-50">
                    <div class="form-check">
                      <input type="radio" id="customColorRadio3" name="paymentOptions" class="form-check-input" value="stripe" />
                      <label class="form-check-label" for="customColorRadio3"> Stripe </label>
                    </div>
                    <form
                      id="cardValidation"
                      class="row gy-1 gx-2 mt-75"
                      data-cc-on-file="false"
                      data-stripe-publishable-key="{{ $company->stripe_key }}"
                      style="display: none"
                      action="{{ route('customer.shop.order.pay.stripe', ['id' => $order->id]) }}"
                      method="POST">
                      @csrf
                      <div class="col-md-12">
                        <label class="form-label" for="modalAddCardNumber">Card Number</label>
                        <input
                          id="modalAddCardNumber"
                          name="modalAddCard"
                          class="form-control add-credit-card-mask card-number"
                          type="text"
                          placeholder="1356 3215 6548 7898"
                          aria-describedby="modalAddCard2"
                          data-msg="Please enter your credit card number"
                          required
                        />
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="modalAddCardName">Name On Card</label>
                        <input type="text" id="modalAddCardName" class="form-control card-name" placeholder="John Doe" required />
                      </div>

                      <div class="col-6 col-md-3">
                        <label class="form-label" for="modalAddCardExpiryDate">Exp. Date</label>
                        <input
                          type="text"
                          id="modalAddCardExpiryDate"
                          class="form-control add-expiry-date-mask card-expiry"
                          placeholder="MM/YY"
                          required
                        />
                      </div>

                      <div class="col-6 col-md-3">
                        <label class="form-label" for="modalAddCardCvv">CVV</label>
                        <input
                          type="text"
                          id="modalAddCardCvv"
                          class="form-control add-cvv-code-mask card-cvc"
                          maxlength="3"
                          placeholder="654"
                          required
                        />
                      </div>
                    </form>
                  </li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
          <div class="amount-payable checkout-options">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Price Details</h4>
              </div>
              <div class="card-body">
                <ul class="list-unstyled price-details">
                  <li class="price-detail">
                    <div class="details-title">Price</div>
                    <div class="detail-amt amt-total">
                      {{ $currencyCode.number_format($order->amount, 2) }}
                    </div>
                  </li>
                  <li class="price-detail">
                    <div class="details-title">Tax</div>
                    <div class="detail-amt discount-amt text-success amt-tax">
                      {{ $currencyCode.number_format($order->tax, 2) }}
                    </div>
                  </li>
                  <li class="price-detail">
                    <div class="detail-title">Shipping</div>
                    <div class="detail-amt text-success amt-shipping">
                      {{ $currencyCode.number_format($order->shipPrice(), 2) }}
                    </div>
                  </li>
                </ul>
                <hr />
                <ul class="list-unstyled price-details">
                  <li class="price-detail">
                    <div class="details-title">Total Price</div>
                    <div class="detail-amt fw-bolder amt-order">
                      {{ $currencyCode.number_format($order->amount + $order->tax + $order->shipPrice(), 2) }}
                    </div>
                  </li>
                </ul>
                <button type="button" class="btn btn-primary w-100 pay-button mt-2">
                  Pay
                </button>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

@endsection

@section('vendor-script')
  <!-- Vendor js files -->
  <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/pages/app-ecommerce-checkout.js')) }}"></script>
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script>
    $('.address-input').change(function(){
      let name = $('#ship_name').val()
      let phone = $('#ship_phone').val()
      let address_line_1 = $('#ship_address_1').val()
      let address_line_2 = $('#ship_address_2').val()
      let town = $('#ship_town').val()
      let postal = $('#ship_zip').val()
      let state = $('#ship_state').val()
      let country = $('#ship_country').val()
      $('.p-name').html(name)
      $('.p-address-line-1').html(address_line_1)
      $('.p-address-line-2').html(address_line_2)
      $('.p-town').html(town)
      $('.p-county').html(state)
      $('.p-zipcode').html(postal)
      $('.p-country').html(country)
      $('.p-phone-number').html(phone)
    })
    let paymentOption = 'paypal';
    $('input[name=paymentOptions]').change(function() {
      paymentOption = $(this).val();
      if (paymentOption == 'stripe') {
        $('#cardValidation').show()
      } else {
        $('#cardValidation').hide()
      }
    })
    $('.pay-button').click(function() {
      console.log(paymentOption)
      if (paymentOption == 'stripe') {
        $('#cardValidation').submit()
      } else if (paymentOption == 'paypal') {
        $('#paypalForm').submit()
      }
    })
    var $form = $('#cardValidation');
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
      $.ajax({
        url: '{{ route("customer.shop.payment.card") }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          name: $('.card-name').val(),
          number: $('.card-number').val(),
          cvv: $('.card-cvc').val(),
          exp: $('.card-expiry').val()
        },
        dataType: 'JSON',
        success: function (data) {

        }
      });
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
    @if (isset($order))
    $('.shipping-option').change(function(){
      const id_price = $(this).val().split(':')
      if (id_price.length == 2) {
        const id = id_price[0]
        const price = id_price[1]
        $(this).closest('.ecommerce-card').find('.shipping-price span').html('{{ $currencyCode }}' + price)
        $(this).closest('.ecommerce-card').find('.shipping_object_id').val(id)
      } else {
        $(this).closest('.ecommerce-card').find('.shipping-price span').html('Free Shipping')
      }
      let totalShipping = 0;
      $('.shipping-option').each((idx, ele) => {
        const id_price = $(ele).val().split(':')
        if (id_price.length == 2) {
          totalShipping += Number(id_price[1])
        }
      })
      $('#step-shipping').find('.amt-shipping').html('{{ $currencyCode }}' + totalShipping.toFixed(2))
      $('#step-shipping').find('.amt-order').html('{{ $currencyCode }}' + (totalShipping + Number('{{ $order->amount + $order->tax }}')).toFixed(2))
    })
    @endif
  </script>
@endsection
