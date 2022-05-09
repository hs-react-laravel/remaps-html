<a class="nav-link" href="javascript:void(0);" data-bs-toggle="dropdown">
  <i class="ficon" data-feather="shopping-cart"></i>
  <span class="badge rounded-pill bg-danger badge-up cart-item-count" style="display: {{ count($cartProducts) > 0 ? 'block' : 'none' }};">{{ count($cartProducts) }}</span>
</a>
<ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
  <li class="dropdown-menu-header">
    <div class="dropdown-header d-flex">
      <h4 class="notification-title mb-0 me-auto">My Cart</h4>
      <div class="badge rounded-pill badge-light-primary">{{ count($cartProducts) }} Items</div>
    </div>
  </li>
  <li class="scrollable-container media-list">
    @foreach ($cartProducts as $item)
    <div class="list-item align-items-center">
      <img
        class="d-block rounded me-1"
        src="{{ $item->product->thumb
          ? asset('storage/uploads/products/thumbnails/'.$item->product->thumb)
          : 'https://via.placeholder.com/350x250.png?text=Product'}}"
        alt="donuts"
        width="62">
      <div class="list-item-body flex-grow-1">
        <i class="ficon cart-item-remove" data-feather="x" data-cartid="{{ $item->id }}" onclick="onRemoveCart(this)"></i>
        <div class="media-heading">
          <h6 class="cart-item-title">
            <a class="text-body" href="{{ url('app/ecommerce/details') }}">
              {{ $item->product->title }}
            </a>
          </h6>
          {{-- <small class="cart-item-by">By Apple</small> --}}
        </div>
        <div class="cart-item-qty">
          <div class="input-group">
            <input class="touchspin-cart" type="number" value="{{ $item->amount }}" data-cartid="{{ $item->id }}" onchange="onChangeCart(this)">
          </div>
        </div>
        <h5 class="cart-item-price">
          {{ $currencyCode.number_format($item->price * $item->amount, 2) }}
        </h5>
      </div>
    </div>
    @endforeach
  </li>
  <li class="dropdown-menu-footer">
    <div class="d-flex justify-content-between mb-1">
      <h6 class="fw-bolder mb-0">Total:</h6>
      <h6 class="text-primary fw-bolder mb-0 cart-total-price">
        {{ $currencyCode.number_format($totalCartAmount, 2) }}
      </h6>
    </div>
    <a class="btn btn-primary w-100" href="{{ route('customer.shop.checkout') }}">Checkout</a>
  </li>
</ul>
