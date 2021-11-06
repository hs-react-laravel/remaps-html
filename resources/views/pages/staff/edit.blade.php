
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <form action="{{ route('staffs.update', ['staff' => $entry->id]) }}" method="post">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit staff</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="lang">Language</label>
                <select class="form-select" id="lang" name="lang">
                  @foreach ($langs as $abbr => $lang)
                    <option value="{{ $abbr }}" @if($entry->lang == $abbr) selected @endif >{{ $lang }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-2 col-md-6 col-12">
                <label class="form-label" for="title">Title</label>
                <select class="form-select" id="title" name="title">
                  <option value="Mr" @if($entry->title == 'Mr') selected @endif>Mr</option>
                  <option value="Ms" @if($entry->title == 'Ms') selected @endif>Ms</option>
                </select>
              </div>
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $entry->first_name }}" />
              </div>
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $entry->last_name }}" />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $entry->email }}" />
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary me-1">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </form>
</section>

@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js'))}}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script>
    $('#private').on('change', function(){
      var val = $(this).val();
      console.log(val);
      if (val == 1)
        $('#vat_number_container').show()
      else
        $('#vat_number_container').hide()
    })
  </script>
@endsection
