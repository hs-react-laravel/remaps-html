
@extends('layouts/contentLayoutMaster')

@section('title', 'Create a Customer')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section id="basic-input">
  <form action="{{ route('customers.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Add a new customer</h4>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="private">Customer Type</label>
                <select class="form-select" id="private" name="private">
                  <option value="0">Private Customer</option>
                  <option value="1">Business Customer</option>
                </select>
              </div>
              <div class="col-xl-4 col-md-6 col-12" style="display: none" id="vat_number_container">
                <label class="form-label" for="vat_number">VAT/TAX Number</label>
                <input type="text" class="form-control" id="vat_number" name="vat_number" />
              </div>
            </div>
            @if(!empty($company->vat_number) && !empty($company->vat_percentage))
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <div class="form-check form-check-inline">
                  <input type="hidden" name="add_tax" value="0" />
                  <input class="form-check-input" type="checkbox" id="add_tax" name="add_tax" value="1" checked/>
                  <label class="form-check-label" for="add_tax">Add Tax</label>
                </div>
              </div>
            </div>
            @endif
            <div class="row mb-1">
              @if ($tuningGroups)
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="tuning_credit_group_id">Tuning price type</label>
                <select class="select form-select" id="tuning_credit_group_id" name="tuning_credit_group_id">
                  <option value=""> </option>
                  @foreach ($tuningGroups as $id => $name)
                    <option value="{{ $id }}" @if($id == $defaultGroup->id) selected @endif>{{ $name }}</option>
                  @endforeach
                </select>
              </div>
              @endif
              @if ($user->company->reseller_id && $evcdefaultGroup)
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="tuning_evc_credit_group_id">EVC Tuning price type</label>
                <select class="select form-select" id="tuning_evc_credit_group_id" name="tuning_evc_credit_group_id">
                  <option value=""> </option>
                  @foreach ($evcTuningGroups as $id => $name)
                    <option value="{{ $id }}" @if($id == $evcdefaultGroup->id) selected @endif>{{ $name }}</option>
                  @endforeach
                </select>
              </div>
              @endif
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="lang">Language</label>
                <select class="form-select" id="lang" name="lang">
                  @foreach ($langs as $abbr => $lang)
                    <option value="{{ $abbr }}">{{ $lang }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-2 col-md-6 col-12">
                <label class="form-label" for="title">Title</label>
                <select class="form-select" id="title" name="title">
                  <option value="Mr">Mr</option>
                  <option value="Ms">Ms</option>
                </select>
              </div>
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" />
              </div>
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="business_name">Business Name</label>
                <input type="text" class="form-control" id="business_name" name="business_name" />
              </div>
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="address_line_1">Address Line 1</label>
                <input type="text" class="form-control" id="address_line_1" name="address_line_1" />
              </div>
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="address_line_2">Address Line 2</label>
                <input type="text" class="form-control" id="address_line_2" name="address_line_2" />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="town">Town</label>
                <input type="text" class="form-control" id="town" name="town" />
              </div>
              <div class="col-xl-3 col-md-6 col-12">
                <label class="form-label" for="county">County</label>
                <input type="text" class="form-control" id="county" name="county" />
              </div>
              <div class="col-xl-2 col-md-6 col-12">
                  <label class="form-label" for="post_code">Postal Code</label>
                  <input type="text" class="form-control" id="post_code" name="post_code" />
                </div>
            </div>
            <div class="row mb-1">
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" />
              </div>
              <div class="col-xl-4 col-md-6 col-12">
                <label class="form-label" for="tools">Tools</label>
                <textarea
                  class="form-control"
                  id="tools"
                  rows="3"
                  name="tools"
                ></textarea>
              </div>
            </div>
            <button type="submit" class="btn btn-primary me-1">Submit</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
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
