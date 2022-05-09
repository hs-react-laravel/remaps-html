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
<form action="">
  <div class="bs-stepper checkout-tab-steps ecommerce-application">
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
      <!-- Checkout Place order starts -->
      <div id="step-cart" class="content" role="tabpanel" aria-labelledby="step-cart-trigger">
        <div id="place-order" class="list-view product-checkout">
          <!-- Checkout Place Order Left starts -->
          <div class="checkout-items">
            @if (count($cartProducts) > 0)
              @foreach ($cartProducts as $item)
                <div class="card ecommerce-card">
                  <div class="item-img">
                    <a href="{{url('app/ecommerce/details')}}">
                      <img src="{{ $item->product->thumb
                        ? asset('storage/uploads/products/thumbnails/'.$item->product->thumb)
                        : 'https://via.placeholder.com/350x250.png?text=Product'}}" />
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="item-name">
                      <h6 class="mb-0"><a href="{{url('app/ecommerce/details')}}" class="text-body">{{ $item->product->title }}</a></h6>
                      {{-- <span class="item-company">By <a href="#" class="company-name">Apple</a></span> --}}
                      <div class="item-rating">
                        <ul class="unstyled-list list-inline">
                          <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                          <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                          <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                          <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                          <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                        </ul>
                      </div>
                    </div>
                    @if ($item->product->stock > 0)
                    <span class="text-success mb-1">In Stock</span>
                    @else
                    <span class="text-danger mb-1">Out of Stock</span>
                    @endif
                    <div class="item-quantity">
                      <span class="quantity-title">Qty:</span>
                      <div class="quantity-counter-wrapper">
                        <div class="input-group">
                          <input type="text" class="quantity-counter" value="{{ $item->amount }}" data-cartid="{{ $item->id }}" onchange="onChangeCart(this)" />
                        </div>
                      </div>
                    </div>
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
          <!-- Checkout Place Order Left ends -->

          <!-- Checkout Place Order Right starts -->
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
                      <div class="detail-title">Estimated Tax</div>
                      <div class="detail-amt amt-tax">
                        {{ $currencyCode.number_format($totalCartAmount * ($company->vat_percentage ?? 0) / 100, 2) }}
                      </div>
                    </li>
                  </ul>
                  <hr />
                  <ul class="list-unstyled">
                    <li class="price-detail">
                      <div class="detail-title detail-total">Total</div>
                      <div class="detail-amt fw-bolder amt-order">
                        {{ $currencyCode.number_format($totalCartAmount * (($company->vat_percentage ?? 0) + 100) / 100, 2) }}
                      </div>
                    </li>
                  </ul>
                  <button type="button" class="btn btn-primary w-100 btn-next place-order">Place Order</button>
                </div>
              </div>
            </div>
            <!-- Checkout Place Order Right ends -->
          </div>
        </div>
        <!-- Checkout Place order Ends -->
      </div>
      <!-- Checkout Customer Address Starts -->
      <div id="step-address" class="content" role="tabpanel" aria-labelledby="step-address-trigger">
          <!-- Checkout Customer Address Left starts -->
          <div class="step-address-content" style="display: grid; column-gap: 2rem; grid-template-columns: 2fr 1fr;">
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
                        type="number"
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
                        type="number"
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
                  <div class="col-12">
                    <button type="button" class="btn btn-primary btn-next delivery-address">Deliver Here</button>
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
                  <p class="card-text p-phone-number"></p>
                  <button type="button" class="btn btn-primary w-100 btn-next delivery-address mt-2">
                    Deliver To This Address
                  </button>
                </div>
              </div>
            </div>
          </div>
      </div>
      <!-- Checkout Customer Address Ends -->
      <!-- Checkout Payment Starts -->
      <div id="step-payment" class="content" role="tabpanel" aria-labelledby="step-payment-trigger">
        <div id="checkout-payment" class="list-view product-checkout">
          <div class="payment-type">
            <div class="card">
              <div class="card-header flex-column align-items-start">
                <h4 class="card-title">Payment options</h4>
                <p class="card-text text-muted mt-25">Be sure to click on correct payment option</p>
              </div>
              <div class="card-body">
                <ul class="other-payment-options list-unstyled">
                  <li class="py-50">
                    <div class="form-check">
                      <input type="radio" id="customColorRadio2" name="paymentOptions" class="form-check-input" />
                      <label class="form-check-label" for="customColorRadio2"> Paypal </label>
                    </div>
                  </li>
                  <li class="py-50">
                    <div class="form-check">
                      <input type="radio" id="customColorRadio3" name="paymentOptions" class="form-check-input" />
                      <label class="form-check-label" for="customColorRadio3"> Stripe </label>
                    </div>
                  </li>
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
                      {{ $currencyCode.number_format($totalCartAmount, 2) }}
                    </div>
                  </li>
                  <li class="price-detail">
                    <div class="details-title">Tax</div>
                    <div class="detail-amt discount-amt text-success amt-tax">
                      {{ $currencyCode.number_format($totalCartAmount * ($company->vat_percentage ?? 0) / 100, 2) }}
                    </div>
                  </li>
                </ul>
                <hr />
                <ul class="list-unstyled price-details">
                  <li class="price-detail">
                    <div class="details-title">Total Price</div>
                    <div class="detail-amt fw-bolder amt-order">
                      {{ $currencyCode.number_format($totalCartAmount * (($company->vat_percentage ?? 0) + 100) / 100, 2) }}
                    </div>
                  </li>
                </ul>
                <button type="submit" class="btn btn-primary w-100 delivery-address mt-2">
                  Pay
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Checkout Payment Ends -->
      <!-- </div> -->
    </div>
  </div>
</form>

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
      $('.p-address-line-1').html(`${address_line_1} ${address_line_2}`)
      $('.p-address-line-2').html(`${town} ${state} ${postal}, ${country}`)
    })
  </script>
@endsection
