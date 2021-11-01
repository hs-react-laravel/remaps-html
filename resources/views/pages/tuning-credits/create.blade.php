
@extends('layouts/contentLayoutMaster')

@section('title', 'Input')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  @if (!$is_evc)
    <form action="{{ route('tuning-credits.store') }}" method="post">
  @else
    <form action="{{ route('evc-tuning-credits.store') }}" method="post">
  @endif
    @csrf
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Add a new tuning credit group</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="name">Group Name</label>
                <input type="text" class="form-control" id="name" name="name" />
              </div>
            </div>
            @foreach ($tires as $tire)
            <div class="row mb-1">
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label">{{ $tire->amount }} Credit From</label>
                <input type="text" class="form-control" name="credit_tires[{{ $tire->id }}][from_credit]" />
              </div>
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label">{{ $tire->amount }} Credit For</label>
                <input type="text" class="form-control" name="credit_tires[{{ $tire->id }}][for_credit]" />
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
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
@endsection
