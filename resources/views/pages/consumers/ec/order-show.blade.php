
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_Orders'))

@section('vendor-style')
  <!-- Vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css'))}}">
@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-ecommerce.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-number-input.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-ratings.css')) }}">
@endsection

@section('content')
<a class="btn btn-flat-secondary" onclick="history.back(-1)">Back</a>
<div class="ecommerce-application">
  <div id="place-order" class="list-view product-checkout" method="POST" action="{{ route('customer.shop.order.place') }}">
    <div class="checkout-items">
      @foreach ($order->items as $item)
        <div class="card">
          <div class="ecommerce-card sc-cart-card">
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
          @if ($order->status == 8)
            <div class="card-footer">
              @if ($item->comment)
                <div class="product-readonly-ratings mb-1"></div>
                <input type="hidden" class="counter" name="rating" value="{{ $item->comment->rating }}">
                <span>{{ $item->comment->comment }}</span>
              @else
                <form action="{{ route('customer.shop.comment.save', ['id' => $item->id]) }}" method="POST">
                  @csrf
                  <div class="product-ratings mb-1"></div>
                  <input type="hidden" class="counter" name="rating">
                  <textarea class="form-control mb-1" name="comment" rows="3"></textarea>
                  <button type="submit" class="btn btn-primary">Leave Comment</button>
                </form>
              @endif
            </div>
          @endif
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
            @if ($order->status == 6)
              <ul class="list-unstyled">
                <li class="price-detail">
                  <div class="detail-title"><b>Estimate Dispatch Date</b></div>
                  <div style="text-transform: uppercase">
                    {{ $order->dispatch_date }}
                  </div>
                </li>
              </ul>
            @endif
            @if ($order->status == 7)
              <ul class="list-unstyled">
                <li class="price-detail">
                  <div class="detail-title"><b>Estimate Delivery Date</b></div>
                  <div style="text-transform: uppercase">
                    {{ $order->delivery_date }}
                  </div>
                </li>
                <li class="price-detail">
                  <div class="detail-title"><b>Tracking Number</b></div>
                  <div style="text-transform: uppercase">
                    {{ $order->tracking_number }}
                  </div>
                </li>
              </ul>
            @endif
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
  <script src="{{ asset(mix('vendors/js/extensions/jquery.rateyo.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-ratings.js')) }}"></script>
@endsection
