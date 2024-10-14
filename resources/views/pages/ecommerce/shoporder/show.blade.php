
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Orders'))

@section('vendor-style')
  <!-- Vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-ecommerce.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-number-input.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection
@php
  $route_prefix = "";
  if ($user->is_semi_admin) {
    $route_prefix = "staff.";
  }
@endphp
@section('content')
<div class="ecommerce-application">
  @if ($order->status == 7)
    <a class="btn btn-primary" href="{{ route($route_prefix.'shoporders.complete', ['id' => $order->id]) }}">Complete</a>
  @endif
  <a class="btn btn-flat-secondary" onclick="history.back(-1)">Back</a>
  @if ($order->status == 4)
    <form action="{{ route('shoporders.process', ['id' => $order->id]) }}" method="POST">
      @csrf
      <div class="col-md-12 col-xl-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Dispatch</h4>
          </div>
          <div class="card-body">
            <div class="col-12">
              <label class="form-label" for="fp-default">Estimated Dispatch Date</label>
              <input type="text" id="fp-default" class="form-control flatpickr-basic" name="dispatch_date" placeholder="YYYY-MM-DD" value="{{ $order->dispatch_date }}" />
            </div>
          </div>
          <div class="card-header">
            <button type="submit" class="btn btn-primary me-1">Submit</button>
          </div>
        </div>
      </div>
    </form>
  @endif
  @if ($order->status == 6)
    <form action="{{ route($route_prefix.'shoporders.dispatch', ['id' => $order->id]) }}" method="POST">
      @csrf
      <div class="col-md-12 col-xl-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Delivery</h4>
          </div>
          <div class="card-body">
            <div class="col-12">
              <label class="form-label" for="fp-default">Estimated Delivery Date</label>
              <input type="text" id="fp-default" class="form-control flatpickr-basic" name="delivery_date" placeholder="YYYY-MM-DD" value="{{ $order->delivery_date }}" />
            </div>
            <div class="col-12">
              <label class="form-label" for="fp-default">Tracking Number</label>
              <input type="text" class="form-control" name="tracking_number" value="{{ $order->tracking_number }}" />
            </div>
          </div>
          <div class="card-header">
            <button type="submit" class="btn btn-primary me-1">Submit</button>
          </div>
        </div>
      </div>
    </form>
  @endif
  <div id="place-order" class="list-view product-checkout" method="POST" action="{{ route('customer.shop.order.place') }}">
    <div class="checkout-items">
      @foreach ($order->items as $item)
        <div class="card ecommerce-card sc-cart-card">
          <div class="item-img">
            <a href="#">
              <img src="{{ $item->product->thumb
                ? asset('storage/uploads/products/thumbnails/'.$item->product->thumb)
                : 'https://via.placeholder.com/350x250.png?text=Product'}}" />
            </a>
          </div>
          <div class="card-body">
            <div class="item-name">
              <h6 class="mb-0"><a href="#" class="text-body">{{ $item->product->title }}</a></h6>
              @if ($item->product->brand)
                <span class="item-company">By <a href="#" class="company-name">{{ $item->product->brand }}</a></span>
              @endif
              <div class="item-rating">
                @php $avgRating = round($item->product->avgRating()); @endphp
                @include('pages.consumers.ec.rating')
              </div>
            </div>
            @if ($item->product->stock > 0)
              <span class="text-success mb-1">In Stock</span>
            @else
              <span class="text-danger mb-1">Out of Stock</span>
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
            <div class="item-quantity">
              <span class="quantity-title">Qty: <b>{{ $item->amount }}</b></span>
            </div>
            @php
              $shipObj = json_decode($item->shipping_detail);
            @endphp
            @if ($shipObj)
              <div>
                <span>Shipping: <b>{{ $shipObj->option }}({{ '+'.$currencyCode.$shipObj->price }})</b></span>
              </div>
            @endif
          </div>
          <div class="item-options text-center">
            <div class="item-wrapper">
              <div class="item-cost">
                <h4 class="item-price">
                  {{ $currencyCode }}{{ number_format($item->price * $item->amount, 2) }}
                </h4>
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
            <ul class="list-unstyled">
              <li class="price-detail">
                <div class="detail-title"><b>Status</b></div>
                <div style="text-transform: uppercase">
                  {{ $orderStatus[$order->status] }}
                </div>
              </li>
            </ul>
            <h6 class="price-title">Address</h6>
            <p class="card-text mb-0">{{ $order->user->full_name }}</p>
            <p class="card-text mb-0">{{ $order->ship_address_1 }}</p>
            <p class="card-text mb-0">{{ $order->ship_address_2 }}</p>
            <p class="card-text mb-0">{{ $order->ship_town }}</p>
            <p class="card-text mb-0">{{ $order->ship_state }}</p>
            <p class="card-text mb-0">{{ $order->ship_zip }}</p>
            <p class="card-text">{{$order->ship_country}}</p>
            <p class="card-text">{{$order->ship_phone}}</p>
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
                <div class="detail-amt amt-tax">
                  {{ $currencyCode.number_format($order->shipPrice(), 2) }}
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
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection
