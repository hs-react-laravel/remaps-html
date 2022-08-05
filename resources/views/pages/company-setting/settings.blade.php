@extends('layouts/contentLayoutMaster')

@section('title', 'Company Settings')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')
@php
  $tab = isset($_GET['tab']) ? $_GET['tab'] : 'name';
@endphp
<section id="nav-filled">
  <div class="row match-height">
    <!-- Filled Tabs starts -->
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Company Information</h4>
        </div>
        <div class="card-body">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item">
              <a
                class="nav-link @if($tab == 'name') active @endif"
                id="home-tab-fill"
                data-bs-toggle="tab"
                href="#home-fill"
                role="tab"
                aria-controls="home-fill"
                aria-selected="@if($tab == 'name') true @else false @endif"
                >Name & Address</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link @if($tab == 'email') active @endif"
                id="email-tab-fill"
                data-bs-toggle="tab"
                href="#email-fill"
                role="tab"
                aria-controls="email-fill"
                aria-selected="@if($tab == 'email') true @else false @endif"
                >Email</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link @if($tab == 'finance') active @endif"
                id="financial-tab-fill"
                data-bs-toggle="tab"
                href="#financial-fill"
                role="tab"
                aria-controls="financial-fill"
                aria-selected="@if($tab == 'finance') true @else false @endif"
                >Financial Information</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link @if($tab == 'note') active @endif"
                id="note-tab-fill"
                data-bs-toggle="tab"
                href="#note-fill"
                role="tab"
                aria-controls="note-fill"
                aria-selected="@if($tab == 'note') true @else false @endif"
                >Notes to Customers</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link @if($tab == 'evc') active @endif"
                id="evc-tab-fill"
                data-bs-toggle="tab"
                href="#evc-fill"
                role="tab"
                aria-controls="evc-fill"
                aria-selected="@if($tab == 'evc') true @else false @endif"
                >EVC Credits</a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link @if($tab == 'openhours') active @endif"
                id="opens-tab-fill"
                data-bs-toggle="tab"
                href="#opens-fill"
                role="tab"
                aria-controls="opens-fill"
                aria-selected="@if($tab == 'openhours') true @else false @endif"
                >Opening Hours</a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link @if($tab == 'styling') active @endif"
                id="styling-tab-fill"
                data-bs-toggle="tab"
                href="#styling-fill"
                role="tab"
                aria-controls="styling-fill"
                aria-selected="@if($tab == 'styling') true @else false @endif"
                >Styling</a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link @if($tab == 'tc') active @endif"
                id="tc-tab-fill"
                data-bs-toggle="tab"
                href="#tc-fill"
                role="tab"
                aria-controls="tc-fill"
                aria-selected="@if($tab == 'tc') true @else false @endif"
                >Terms &amp; Conditions</a>
            </li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content pt-1">
            @include('pages.company-setting.name-address')
            @include('pages.company-setting.email')
            @include('pages.company-setting.financial')
            @include('pages.company-setting.notes')
            @include('pages.company-setting.evc')
            @include('pages.company-setting.openhours')
            @include('pages.company-setting.styling')
            @include('pages.company-setting.tc')
          </div>
        </div>
      </div>
    </div>
    <!-- Filled Tabs ends -->
  </div>
</section>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
  <script src="{{asset('js/scripts/components/components-navs.js')}}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script>
    @if (!$company->open_check)
      $('#oh_form').hide();
    @endif
    $('#timezone-select').select2({
      dropdownAutoWidth: true,
      width: '100%',
      dropdownParent: $('#timezone-select').parent()
    });
    $('#open_check').on('change', function(){
      let val = $(this).is(":checked");
      if (val) {
        $('#oh_form').show();
      } else {
        $('#oh_form').hide();
      }
    })
    $('.input-close').on('change', function(){
      let val = $(this).is(":checked");
      let id = $(this).attr('id');
      let id_open = `${id.substring(0, 3)}_from`;
      let id_close = `${id.substring(0, 3)}_to`;
      console.log(id_open, id_close)
      if (val) {
        $(`#${id_open}`).prop('disabled', true)
        $(`#${id_close}`).prop('disabled', true)
      } else {
        $(`#${id_open}`).prop('disabled', false)
        $(`#${id_close}`).prop('disabled', false)
      }
    })
    imageLogo.onchange = evt => {
      const [file] = imageLogo.files
      if (file) {
        logo.src = URL.createObjectURL(file)
      }
    }
    style_background.onchange = evt => {
      const [file] = style_background.files
      if (file) {
        style_background_img.src = URL.createObjectURL(file)
      }
    }
  </script>
@endsection
