var THEMEMASCOT = {};
(function ($) {
  "use strict";
  var showSwitcher = true;
  var $body = $("body");
  var $style_switcher = $("#style-switcher");
  if (!$style_switcher.length && showSwitcher) {
    $.ajax({
      url: "color-switcher/style-switcher.html",
      success: function (data) {
        $body.append(data);
      },
      dataType: "html",
    });
  }
  THEMEMASCOT.isRTL = {
    check: function () {
      if ($("html").attr("dir") === "rtl") {
        return true;
      } else {
        return false;
      }
    },
  };
  THEMEMASCOT.isLTR = {
    check: function () {
      if ($("html").attr("dir") !== "rtl") {
        return true;
      } else {
        return false;
      }
    },
  };
  function handlePreloader() {
    if ($(".preloader").length) {
      $(".preloader").delay(200).fadeOut(500);
    }
  }
  function headerStyle() {
    if ($(".main-header").length) {
      var windowpos = $(window).scrollTop();
      var siteHeader = $(".header-style-one");
      var scrollLink = $(".scroll-to-top");
      var sticky_header = $(".main-header .sticky-header");
      if (windowpos > 100) {
        sticky_header.addClass("fixed-header animated slideInDown");
        scrollLink.fadeIn(300);
      } else {
        sticky_header.removeClass("fixed-header animated slideInDown");
        scrollLink.fadeOut(300);
      }
      if (windowpos > 1) {
        siteHeader.addClass("fixed-header");
      } else {
        siteHeader.removeClass("fixed-header");
      }
    }
  }
  headerStyle();
  if ($(".main-header li.dropdown ul").length) {
    $(".main-header .navigation li.dropdown").append(
      '<div class="dropdown-btn"><i class="fa fa-angle-down"></i></div>'
    );
  }
  if ($(".mobile-menu").length) {
    var mobileMenuContent = $(".main-header .main-menu .navigation").html();
    $(".mobile-menu .navigation").append(mobileMenuContent);
    $(".sticky-header .navigation").append(mobileMenuContent);
    $(".mobile-menu .close-btn").on("click", function () {
      $("body").removeClass("mobile-menu-visible");
    });
    $(".mobile-menu li.dropdown .dropdown-btn").on("click", function () {
      $(this).prev("ul").slideToggle(500);
      $(this).toggleClass("active");
    });
    $(".mobile-nav-toggler").on("click", function () {
      $("body").addClass("mobile-menu-visible");
    });
    $(".mobile-menu .menu-backdrop, .mobile-menu .close-btn").on(
      "click",
      function () {
        $("body").removeClass("mobile-menu-visible");
      }
    );
  }
  if ($(".search-btn").length) {
    $(".search-btn").on("click", function () {
      $(".main-header").addClass("moblie-search-active");
    });
    $(".close-search, .search-back-drop").on("click", function () {
      $(".main-header").removeClass("moblie-search-active");
    });
  }
  if ($(".banner-carousel").length) {
    $(".banner-carousel").owlCarousel({
      rtl: THEMEMASCOT.isRTL.check(),
      animateOut: "fadeOut",
      animateIn: "fadeIn",
      loop: true,
      margin: 0,
      nav: true,
      smartSpeed: 500,
      autoHeight: true,
      autoplay: true,
      autoplayTimeout: 10000,
      navText: [
        '<span class="fas fa-long-arrow-alt-left"></span>',
        '<span class="fas fa-long-arrow-alt-right"></span>',
      ],
      responsive: { 0: { items: 1 }, 600: { items: 1 }, 1024: { items: 1 } },
    });
  }
  if ($(".services-carousel").length) {
    $(".services-carousel").owlCarousel({
      rtl: THEMEMASCOT.isRTL.check(),
      loop: true,
      margin: 0,
      nav: true,
      items: 1,
      smartSpeed: 700,
      autoplay: false,
      navText: [
        '<span class="flaticon-left-chevron"></span>',
        '<span class="flaticon-right-chevron"></span>',
      ],
      responsive: {
        0: { items: 1 },
        768: { items: 2 },
        1024: { items: 3 },
        1200: { items: 4 },
        1400: { items: 5 },
      },
    });
  }
  if ($(".testimonial-carousel").length) {
    $(".testimonial-carousel").owlCarousel({
      rtl: THEMEMASCOT.isRTL.check(),
      loop: true,
      margin: 25,
      nav: false,
      items: 1,
      smartSpeed: 700,
      autoplay: 5000,
      navText: [
        '<span class="far fa-arrow-left-long"></span>',
        '<span class="far fa-arrow-right-long"></span>',
      ],
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        991: { items: 3 },
        1200: { items: 3 },
      },
    });
  }
  if ($(".testimonial-carousel-one").length) {
    $(".testimonial-carousel-one").owlCarousel({
      rtl: THEMEMASCOT.isRTL.check(),
      loop: true,
      margin: 0,
      nav: false,
      items: 1,
      smartSpeed: 700,
      autoplay: 5000,
      navText: [
        '<span class="far fa-arrow-left-long"></span>',
        '<span class="far fa-arrow-right-long"></span>',
      ],
      responsive: { 0: { items: 1 }, 1200: { items: 3 } },
    });
  }
  if ($(".testimonial-carousel-two").length) {
    $(".testimonial-carousel-two").owlCarousel({
      rtl: THEMEMASCOT.isRTL.check(),
      loop: true,
      margin: 30,
      nav: true,
      items: 1,
      smartSpeed: 700,
      autoplay: 5000,
      navText: [
        '<span class="far fa-arrow-left-long"></span>',
        '<span class="far fa-arrow-right-long"></span>',
      ],
      responsive: { 0: { items: 1 }, 768: { items: 2 }, 1200: { items: 3 } },
    });
  }
  if ($(".projects-carousel").length) {
    $(".projects-carousel").owlCarousel({
      loop: true,
      margin: 0,
      nav: true,
      smartSpeed: 400,
      autoplay: true,
      navText: [
        '<span class="fa fa-long-arrow-alt-left"></span>',
        '<span class="fa fa-long-arrow-alt-right"></span>',
      ],
      responsive: {
        0: { items: 1 },
        768: { items: 2 },
        1200: { items: 3 },
        1600: { items: 4 },
      },
    });
  }
  if ($(".projects-carousel-home4").length) {
    $(".projects-carousel-home4").owlCarousel({
      loop: true,
      margin: 30,
      nav: false,
      smartSpeed: 400,
      autoplay: true,
      navText: [
        '<span class="fa fa-long-arrow-alt-left"></span>',
        '<span class="fa fa-long-arrow-alt-right"></span>',
      ],
      responsive: {
        0: { items: 1 },
        768: { items: 2 },
        1200: { items: 3 },
        1600: { items: 4 },
      },
    });
  }
  if ($(".testimonial-content-home5").length) {
    var testimonial_thumbs = new Swiper(".testimonial-thumbs-home5", {
      spaceBetween: 10,
      loop: false,
      slidesPerView: 3,
      breakpoints: {
        320: { slidesPerView: 3 },
        600: { slidesPerView: 3 },
        600: { slidesPerView: 3 },
      },
    });
    var testimonial_content = new Swiper(".testimonial-content-home5", {
      spaceBetween: 0,
      effect: "fade",
      loop: true,
      thumbs: { swiper: testimonial_thumbs },
      navigation: {
        nextEl: ".testi-button-next",
        prevEl: ".testi-button-prev",
      },
      pagination: { el: ".testimonial-pagination" },
    });
  }
  if ($(".clients-carousel").length) {
    $(".clients-carousel").owlCarousel({
      loop: true,
      margin: 0,
      nav: false,
      smartSpeed: 400,
      autoplay: true,
      navText: [
        '<span class="fa fa-angle-left"></span>',
        '<span class="fa fa-angle-right"></span>',
      ],
      responsive: {
        0: { items: 1 },
        480: { items: 2 },
        600: { items: 3 },
        768: { items: 4 },
        1023: { items: 5 },
      },
    });
  }
  if ($(".dial").length) {
    $(".dial").appear(
      function () {
        var elm = $(this);
        var color = elm.attr("data-fgColor");
        var perc = elm.attr("value");
        elm.knob({
          value: 0,
          min: 0,
          max: 100,
          skin: "tron",
          readOnly: true,
          thickness: 0.05,
          dynamicDraw: true,
          displayInput: false,
        });
        $({ value: 0 }).animate(
          { value: perc },
          {
            duration: 2000,
            easing: "swing",
            progress: function () {
              elm.val(Math.ceil(this.value)).trigger("change");
            },
          }
        );
        $(this).append(function () {});
      },
      { accY: 20 }
    );
  }
  if ($(".accordion-box").length) {
    $(".accordion-box").on("click", ".acc-btn", function () {
      var outerBox = $(this).parents(".accordion-box");
      var target = $(this).parents(".accordion");
      if ($(this).hasClass("active") !== true) {
        $(outerBox).find(".accordion .acc-btn").removeClass("active ");
      }
      if ($(this).next(".acc-content").is(":visible")) {
        return false;
      } else {
        $(this).addClass("active");
        $(outerBox).children(".accordion").removeClass("active-block");
        $(outerBox).find(".accordion").children(".acc-content").slideUp(300);
        target.addClass("active-block");
        $(this).next(".acc-content").slideDown(300);
      }
    });
  }
  if ($(".count-box").length) {
    $(".count-box").appear(
      function () {
        var $t = $(this),
          n = $t.find(".count-text").attr("data-stop"),
          r = parseInt($t.find(".count-text").attr("data-speed"), 10);
        if (!$t.hasClass("counted")) {
          $t.addClass("counted");
          $({ countNum: $t.find(".count-text").text() }).animate(
            { countNum: n },
            {
              duration: r,
              easing: "linear",
              step: function () {
                $t.find(".count-text").text(Math.floor(this.countNum));
              },
              complete: function () {
                $t.find(".count-text").text(this.countNum);
              },
            }
          );
        }
      },
      { accY: 0 }
    );
  }
  if ($(".tabs-box").length) {
    $(".tabs-box .tab-buttons .tab-btn").on("click", function (e) {
      e.preventDefault();
      var target = $($(this).attr("data-tab"));
      if ($(target).is(":visible")) {
        return false;
      } else {
        target
          .parents(".tabs-box")
          .find(".tab-buttons")
          .find(".tab-btn")
          .removeClass("active-btn");
        $(this).addClass("active-btn");
        target
          .parents(".tabs-box")
          .find(".tabs-content")
          .find(".tab")
          .fadeOut(0);
        target
          .parents(".tabs-box")
          .find(".tabs-content")
          .find(".tab")
          .removeClass("active-tab animated fadeIn");
        $(target).fadeIn(300);
        $(target).addClass("active-tab animated fadeIn");
      }
    });
  }
  if ($(".product-details .bxslider").length) {
    $(".product-details .bxslider").bxSlider({
      nextSelector: ".product-details #slider-next",
      prevSelector: ".product-details #slider-prev",
      nextText: '<i class="fa fa-angle-right"></i>',
      prevText: '<i class="fa fa-angle-left"></i>',
      mode: "fade",
      auto: "true",
      speed: "700",
      pagerCustom: ".product-details .slider-pager .thumb-box",
    });
  }
  $(".quantity-box .add").on("click", function () {
    if ($(this).prev().val() < 999) {
      $(this)
        .prev()
        .val(+$(this).prev().val() + 1);
    }
  });
  $(".quantity-box .sub").on("click", function () {
    if ($(this).next().val() > 1) {
      if ($(this).next().val() > 1)
        $(this)
          .next()
          .val(+$(this).next().val() - 1);
    }
  });
  if ($(".price-range-slider").length) {
    $(".price-range-slider").slider({
      range: true,
      min: 10,
      max: 99,
      values: [10, 60],
      slide: function (event, ui) {
        $("input.property-amount").val(ui.values[0] + " - " + ui.values[1]);
      },
    });
    $("input.property-amount").val(
      $(".price-range-slider").slider("values", 0) +
        " - $" +
        $(".price-range-slider").slider("values", 1)
    );
  }
  if ($(".count-bar").length) {
    $(".count-bar").appear(
      function () {
        var el = $(this);
        var percent = el.data("percent");
        $(el).css("width", percent).addClass("counted");
      },
      { accY: -50 }
    );
  }
  if ($(".progress-line").length) {
    $(".progress-line").appear(
      function () {
        var el = $(this);
        var percent = el.data("width");
        $(el).css("width", percent + "%");
      },
      { accY: 0 }
    );
  }
  if ($(".lightbox-image").length) {
    $(".lightbox-image").fancybox({
      openEffect: "fade",
      closeEffect: "fade",
      helpers: { media: {} },
    });
  }
  if ($(".scroll-to-target").length) {
    $(".scroll-to-target").on("click", function () {
      var target = $(this).attr("data-target");
      $("html, body").animate({ scrollTop: $(target).offset().top }, 0);
    });
  }
  if ($(".wow").length) {
    var wow = new WOW({
      boxClass: "wow",
      animateClass: "animated",
      offset: 0,
      mobile: false,
      live: true,
    });
    wow.init();
  }
  $(".custom-select").select2({ minimumResultsForSearch: 7 });
  if ($(".filter-list").length) {
    $(".filter-list").mixItUp({});
  }
  if ($("[data-tm-bg-color]").length) {
    $("[data-tm-bg-color]").each(function () {
      $(this).css(
        "cssText",
        "background-color: " + $(this).data("tm-bg-color") + " !important;"
      );
    });
  }
  if ($("[data-tm-bg-img]").length) {
    $("[data-tm-bg-img]").each(function () {
      $(this).css("background-image", "url(" + $(this).data("tm-bg-img") + ")");
    });
  }
  if ($("[data-tm-text-color]").length) {
    $("[data-tm-text-color]").each(function () {
      $(this).css("color", $(this).data("tm-text-color"));
    });
  }
  if ($("[data-tm-font-size]").length) {
    $("[data-tm-font-size]").each(function () {
      $(this).css("font-size", $(this).data("tm-font-size"));
    });
  }
  if ($("[data-tm-opacity]").length) {
    $("[data-tm-opacity]").each(function () {
      $(this).css("opacity", $(this).data("tm-opacity"));
    });
  }
  if ($("[data-tm-height]").length) {
    $("[data-tm-height]").each(function () {
      $(this).css("height", $(this).data("tm-height"));
    });
  }
  if ($("[data-tm-width]").length) {
    $("[data-tm-width]").each(function () {
      $(this).css("width", $(this).data("tm-width"));
    });
  }
  if ($("[data-tm-border]").length) {
    $("[data-tm-border]").each(function () {
      $(this).css("border", $(this).data("tm-border"));
    });
  }
  if ($("[data-tm-border-top]").length) {
    $("[data-tm-border-top]").each(function () {
      $(this).css("border-top", $(this).data("tm-border-top"));
    });
  }
  if ($("[data-tm-border-bottom]").length) {
    $("[data-tm-border-bottom]").each(function () {
      $(this).css("border-bottom", $(this).data("tm-border-bottom"));
    });
  }
  if ($("[data-tm-border-radius]").length) {
    $("[data-tm-border-radius]").each(function () {
      $(this).css("border-radius", $(this).data("tm-border-radius"));
    });
  }
  if ($("[data-tm-z-index]").length) {
    $("[data-tm-z-index]").each(function () {
      $(this).css("z-index", $(this).data("tm-z-index"));
    });
  }
  if ($("[data-tm-padding]").length) {
    $("[data-tm-padding]").each(function () {
      $(this).css("padding", $(this).data("tm-padding"));
    });
  }
  if ($("[data-tm-padding-top]").length) {
    $("[data-tm-padding-top]").each(function () {
      $(this).css("padding-top", $(this).data("tm-padding-top"));
    });
  }
  if ($("[data-tm-padding-right]").length) {
    $("[data-tm-padding-right]").each(function () {
      $(this).css("padding-right", $(this).data("tm-padding-right"));
    });
  }
  if ($("[data-tm-padding-bottom]").length) {
    $("[data-tm-padding-bottom]").each(function () {
      $(this).css("padding-bottom", $(this).data("tm-padding-bottom"));
    });
  }
  if ($("[data-tm-padding-left]").length) {
    $("[data-tm-padding-left]").each(function () {
      $(this).css("padding-left", $(this).data("tm-padding-left"));
    });
  }
  if ($("[data-tm-margin]").length) {
    $("[data-tm-margin]").each(function () {
      $(this).css("margin", $(this).data("tm-margin"));
    });
  }
  if ($("[data-tm-margin-top]").length) {
    $("[data-tm-margin-top]").each(function () {
      $(this).css("margin-top", $(this).data("tm-margin-top"));
    });
  }
  if ($("[data-tm-margin-right]").length) {
    $("[data-tm-margin-right]").each(function () {
      $(this).css("margin-right", $(this).data("tm-margin-right"));
    });
  }
  if ($("[data-tm-margin-bottom]").length) {
    $("[data-tm-margin-bottom]").each(function () {
      $(this).css("margin-bottom", $(this).data("tm-margin-bottom"));
    });
  }
  if ($("[data-tm-margin-left]").length) {
    $("[data-tm-margin-left]").each(function () {
      $(this).css("margin-left", $(this).data("tm-margin-left"));
    });
  }
  if ($("[data-tm-top]").length) {
    $("[data-tm-top]").each(function () {
      $(this).css("top", $(this).data("tm-top"));
    });
  }
  if ($("[data-tm-right]").length) {
    $("[data-tm-right]").each(function () {
      $(this).css("right", $(this).data("tm-right"));
    });
  }
  if ($("[data-tm-bottom]").length) {
    $("[data-tm-bottom]").each(function () {
      $(this).css("bottom", $(this).data("tm-bottom"));
    });
  }
  if ($("[data-tm-left]").length) {
    $("[data-tm-left]").each(function () {
      $(this).css("left", $(this).data("tm-left"));
    });
  }
  var $onepage_nav = $(".onepage-nav");
  var $sections = $("section");
  var $window = $(window);
  function TM_activateMenuItemOnReach() {
    if ($onepage_nav.length > 0) {
      var cur_pos = $window.scrollTop() + 2;
      var nav_height = $onepage_nav.outerHeight();
      $sections.each(function () {
        var top = $(this).offset().top - nav_height - 80,
          bottom = top + $(this).outerHeight();
        if (cur_pos >= top && cur_pos <= bottom) {
          $onepage_nav
            .find("a")
            .parent()
            .removeClass("current")
            .removeClass("active");
          $sections.removeClass("current").removeClass("active");
          $onepage_nav
            .find('a[href="#' + $(this).attr("id") + '"]')
            .parent()
            .addClass("current")
            .addClass("active");
        }
        if (cur_pos <= nav_height && cur_pos >= 0) {
          $onepage_nav
            .find("a")
            .parent()
            .removeClass("current")
            .removeClass("active");
          $onepage_nav
            .find('a[href="#header"]')
            .parent()
            .addClass("current")
            .addClass("active");
        }
      });
    }
  }
  $(window).on("scroll", function () {
    headerStyle();
    TM_activateMenuItemOnReach();
  });
  $(window).on("load", function () {
    handlePreloader();
  });
})(window.jQuery);
