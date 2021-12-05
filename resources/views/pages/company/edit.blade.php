@extends('layouts/contentLayoutMaster')

@section('title', 'Company Information')

@section('content')
@php
  $tab = $_GET['tab'] ?? 'name';
  $tabs = [
    'name' => 'Name & Address',
    'domain' => 'Domain',
    'email' => "Email Addresses",
    'smtp' => "SMTP",
    'finance' => "Finance",
    'paypal' => "Paypal",
    'stripe' => "Stripe",
    'note' => "Notes to Customers"
  ];
@endphp
<section id="nav-filled">
  <div class="row match-height">
    <!-- Filled Tabs starts -->
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Companies</h4>
        </div>
        <div class="card-body">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            @foreach ($tabs as $tabName => $tabTitle)
              <li class="nav-item" onclick="onTabClick('{{$tabName}}')">
                <a
                  class="nav-link @if($tab == $tabName) active @endif"
                  id="{{$tabName}}-tab-fill"
                  data-bs-toggle="tab"
                  href="#{{$tabName}}-fill"
                  role="tab"
                  aria-controls="{{$tabName}}-fill"
                  aria-selected="@if($tab == $tabName) true @else false @endif"
                  >{{$tabTitle}}</a>
              </li>
            @endforeach
          </ul>

          {{ $entry->id
            ? Form::model($entry, array('route' => array('companies.update', $entry->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data'))
            : Form::model($entry, array('route' => array('companies.store', $entry->id), 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
            <input type="hidden" name="tab" value="{{$tab}}" />
            @csrf
          <!-- Tab panes -->
          <div class="tab-content pt-1">
            @include('pages.company.tabs.name-address')
            @include('pages.company.tabs.domain')
            @include('pages.company.tabs.email')
            @include('pages.company.tabs.financial')
            @include('pages.company.tabs.notes')
            @include('pages.company.tabs.smtp')
            @include('pages.company.tabs.paypal')
            @include('pages.company.tabs.stripe')
          </div>
          {{ Form::close() }}
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
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
  <script src="{{asset('js/scripts/components/components-navs.js')}}"></script>
  <script>
    @if (!$company->open_check)
      $('#oh_form').hide();
    @endif
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
    function onTabClick(tab) {
      $('input[name="tab"]').val(tab);
    }
  </script>
@endsection
