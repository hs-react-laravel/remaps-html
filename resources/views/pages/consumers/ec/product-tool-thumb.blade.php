<div class="card ecommerce-card">
  <div class="item-img text-center justify-content-center">
    <a href="{{ route('customer.shop.detail', ['id' => $product->id]) }}">
      <img
        class="img-fluid card-img-top"
        src="{{$product->thumb ? asset('storage/uploads/products/thumbnails/'.$product->thumb) : 'https://via.placeholder.com/350x250.png?text=Product'}}"
        alt="img-placeholder"
        style="max-height: 250px"
    /></a>
  </div>
  <div class="card-body">
    <div class="item-wrapper">
      <div class="item-rating">
        @php $avgRating = round($product->avgRating()); @endphp
        @include('pages.consumers.ec.rating')
      </div>
      <div>
        <h6 class="item-price">{{ config('constants.currency_signs')[$company->paypal_currency_code] }}{{ $product->price }}</h6>
      </div>
    </div>
    <h6 class="item-name">
      <a class="text-body" href="{{ route('customer.shop.detail', ['id' => $product->id]) }}">{{ $product->title }}</a>
      @if ($product->brand)
      <span class="card-text item-company">By <a href="#" class="company-name">{{ $product->brand }}</a></span>
      @endif
    </h6>
    <p class="card-text item-description">
      {{ $product->description }}
    </p>
  </div>
  <div class="item-options text-center">
    <div class="item-wrapper">
      <div class="item-cost">
        <h4 class="item-price">{{ config('constants.currency_signs')[$company->paypal_currency_code] }}{{ $product->price }}</h4>
      </div>
    </div>
    <button
      class="btn btn-primary"
      style="border-radius: 5px; width: 100%;"
      onclick="onAddCartInline(this)"
      data-link="{{ count($product->sku) > 0 ? 1 : 0 }}"
      data-proid="{{ $product->id }}"
      @if($product->stock <= 0) disabled @endif>
      <i data-feather="shopping-cart"></i>
      <span class="add-to-cart">
        @if ($product->stock <= 0)
          Out of stock
        @else
          {{ count($product->sku) > 0 ? 'Customize' : 'Add to cart' }}
        @endif
      </span>
    </button>
    <form class="add-cart-inline-form" action="{{ route('customer.shop.cart.add') }}" method="POST">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
    </form>
  </div>
</div>
