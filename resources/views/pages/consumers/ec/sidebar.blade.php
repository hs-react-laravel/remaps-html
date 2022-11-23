<!-- Ecommerce Sidebar Starts -->
@php
  $maxRange = isset($_GET['max_selected_price']) ? $_GET['max_selected_price'] : $maxPrice;
  $minRange = isset($_GET['min_selected_price']) ? $_GET['min_selected_price'] : $minPrice;
  $sCategories = isset($_GET['category_filter']) ? $_GET['category_filter'] : [];
  $sBrands = isset($_GET['product_brands']) ? $_GET['product_brands'] : [];
@endphp
<div class="sidebar-shop">
  <div class="row">
    <div class="col-sm-12">
      <h6 class="filter-heading d-none d-lg-block">Filters</h6>
    </div>
  </div>
  <div class="card">
    <form action="{{ $mode == 'tool' ? route('customer.shop.physical') : route('customer.shop.digital') }}">
    <div class="card-body">
      <!-- Price Slider starts -->
      <div class="price-slider">
        <h6 class="filter-title">Price Range</h6>
        <input type="hidden" id="max-price" value="{{ $maxPrice }}">
        <input type="hidden" id="min-price" value="{{ $minPrice }}">
        <input type="hidden" name="min_selected_price" id="min-price-select" value="{{ $minRange }}">
        <input type="hidden" name="max_selected_price" id="max-price-select" value="{{ $maxRange }}">
        <div class="price-slider">
          <div class="range-slider mt-2" id="price-slider"></div>
        </div>
      </div>
      <!-- Price Range ends -->

      <!-- Categories Starts -->
      <div id="product-categories">
        <h6 class="filter-title">Categories</h6>
        <div class="card-body">
          <div id="jstree-checkbox"></div>
          <input type="hidden" name="category_filter" id="category_filter" value="{{ implode(',', $selected) }}">
        </div>
      </div>
      <!-- Categories Ends -->

      <!-- Brands starts -->
      <div class="brands">
        <h6 class="filter-title">Brands</h6>
        <ul class="list-unstyled brand-list">
          @foreach ($brands as $i => $brand)
            <li>
              <div class="form-check">
                <input
                  type="checkbox"
                  class="form-check-input"
                  id="productBrand-{{ $i }}"
                  name="product_brands[]"
                  value="{{ $brand['title'] }}"
                  @if (in_array($brand['title'], $sBrands)) checked @endif />
                <label class="form-check-label" for="productBrand-{{ $i }}">{{ $brand['title'] }}</label>
              </div>
              <span>{{ $brand['count'] }}</span>
            </li>
          @endforeach
        </ul>
      </div>
      <!-- Brand ends -->

      <!-- Rating starts -->
      <div id="ratings">
        <h6 class="filter-title">Ratings</h6>
        @foreach ($ratings as $rating)
          <div class="ratings-list">
            <a href="{{ route($mode == 'tool' ? 'customer.shop.physical' : 'customer.shop.digital', ['rating' => $rating['rating']]) }}">
              <ul class="unstyled-list list-inline">
                @for ($i = 0; $i < $rating['rating']; $i++)
                  <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                @endfor
                @for ($i = 0; $i < 5 - $rating['rating']; $i++)
                  <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                @endfor
                <li>& up</li>
              </ul>
            </a>
            <div class="stars-received">{{ $rating['count'] }}</div>
          </div>
        @endforeach
      </div>
      <!-- Rating ends -->

      <!-- Clear Filters Starts -->
      <div id="clear-filters">
        @if($mode == 'digital')
        <button type="button" class="btn w-100 btn-primary mb-1" onclick="onMore()">Search More</button>
        @endif
        <button type="submit" class="btn w-100 btn-primary">Search Products</button>
        <a href="{{ route('customer.shop.physical') }}" class="btn w-100 btn-primary mt-1">Clear Search Filter</a>
      </div>
      <!-- Clear Filters Ends -->
    </div>
  </form>
  </div>
</div>
<!-- Ecommerce Sidebar Ends -->
