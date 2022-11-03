/*=========================================================================================
    File Name: app-ecommerce.js
    Description: Ecommerce pages js
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

'use strict';

$(function () {
  // RTL Support
  var direction = 'ltr',
    isRTL = false;
  if ($('html').data('textdirection') == 'rtl') {
    direction = 'rtl';
  }

  if (direction === 'rtl') {
    isRTL = true;
  }
  var sidebarShop = $('.sidebar-shop'),
    btnCart = $('.btn-cart'),
    overlay = $('.body-content-overlay'),
    sidebarToggler = $('.shop-sidebar-toggler'),
    gridViewBtn = $('.grid-view-btn'),
    listViewBtn = $('.list-view-btn'),
    priceSlider = document.getElementById('price-slider'),
    ecommerceProducts = $('#ecommerce-products'),
    sortingDropdown = $('.dropdown-sort .dropdown-item'),
    sortingText = $('.dropdown-toggle .active-sorting'),
    wishlist = $('.btn-wishlist'),
    checkout = 'app-ecommerce-checkout.html';

  if ($('body').attr('data-framework') === 'laravel') {
    var url = $('body').attr('data-asset-path');
    checkout = url + 'app/ecommerce/checkout';
  }

  // On sorting dropdown change
  if (sortingDropdown.length) {
    sortingDropdown.on('click', function () {
      var $this = $(this);
      var selectedLang = $this.text();
      sortingText.text(selectedLang);
    });
  }

  // Show sidebar
  if (sidebarToggler.length) {
    sidebarToggler.on('click', function () {
      sidebarShop.toggleClass('show');
      overlay.toggleClass('show');
      $('body').addClass('modal-open');
    });
  }

  // Overlay Click
  if (overlay.length) {
    overlay.on('click', function (e) {
      sidebarShop.removeClass('show');
      overlay.removeClass('show');
      $('body').removeClass('modal-open');
    });
  }

  // Init Price slider
  if (typeof priceSlider !== undefined && priceSlider !== null) {
    var min = Number($('#min-price').val())
    var max = Number($('#max-price').val())
    var selectedMin = Number($('#min-price-select').val())
    var selectedMax = Number($('#max-price-select').val())
    if (selectedMin == 0) selectedMin = min
    if (selectedMax == 0) selectedMax = max
    const range = noUiSlider.create(priceSlider, {
      start: [selectedMin, selectedMax],
      direction: direction,
      connect: true,
      tooltips: [true, true],
      format: wNumb({
        decimals: 0
      }),
      range: {
        min: min,
        max: max
      }
    });
    range.on('update', function(values, handle) {
      $('#min-price-select').val(values[0])
      $('#max-price-select').val(values[1])
    })
  }

  // Grid View
  if (gridViewBtn.length) {
    gridViewBtn.on('click', function () {
      ecommerceProducts.removeClass('list-view').addClass('grid-view');
      listViewBtn.removeClass('active');
      gridViewBtn.addClass('active');
    });
  }

  // List View
  if (listViewBtn.length) {
    listViewBtn.on('click', function () {
      ecommerceProducts.removeClass('grid-view').addClass('list-view');
      gridViewBtn.removeClass('active');
      listViewBtn.addClass('active');
    });
  }

  // On cart & view cart btn click to cart
  if (btnCart.length) {
    btnCart.on('click', function (e) {
      var $this = $(this),
        addToCart = $this.find('.add-to-cart');
      if (addToCart.length > 0) {
        e.preventDefault();
      }
      addToCart.text('View In Cart').removeClass('add-to-cart').addClass('view-in-cart');
      $this.attr('href', checkout);
      toastr['success']('', 'Added Item In Your Cart 🛒', {
        closeButton: true,
        tapToDismiss: false,
        rtl: isRTL
      });
    });
  }

  // For Wishlist Icon
  if (wishlist.length) {
    wishlist.on('click', function () {
      var $this = $(this);
      $this.find('svg').toggleClass('text-danger');
      if ($this.find('svg').hasClass('text-danger')) {
        toastr['success']('', 'Added to wishlist ❤️', {
          closeButton: true,
          tapToDismiss: false,
          rtl: isRTL
        });
      }
    });
  }
});

// on window resize hide sidebar
$(window).on('resize', function () {
  if ($(window).outerWidth() >= 991) {
    $('.sidebar-shop').removeClass('show');
    $('.body-content-overlay').removeClass('show');
  }
});
