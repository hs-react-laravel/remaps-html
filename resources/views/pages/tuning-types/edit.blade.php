
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  @if ($user->is_admin)
    {{ html()->form('PUT')->route('tuning-types.update', ['tuning_type' => $entry->id])->open() }}
  @elseif ($user->is_semi_admin)
    {{ html()->form('PUT')->route('staff.tuning-types.update', ['tuning_type' => $entry->id])->open() }}
  @endif
    @csrf
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit tuning type</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="label">Label</label>
                <input type="text" class="form-control" id="label" name="label" value="{{ $entry->label }}" />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="credits">Credits</label>
                <input type="number" class="form-control" id="credits" name="credits" value="{{ $entry->credits }}" step=".01" />
              </div>
            </div>
            <button type="submit" class="btn btn-primary me-1">Submit</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  {{ html()->form()->close() }}
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
