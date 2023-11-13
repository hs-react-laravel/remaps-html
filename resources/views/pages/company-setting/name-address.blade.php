<div class="tab-pane @if($tab == 'name') active @endif" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
  <form class="form" action="{{ route('company.setting.store') }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="tab" value="name" />
    @csrf

    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="post-code">Timezone</label>
          <select class="select2 form-select" id="timezone-select" name="timezone">
            @foreach ($timezones as $tz)
              <option value="{{ $tz->id }}" @if($company->timezone == $tz->id) selected @endif>{{ $tz->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="name-column">Name</label>
          <input
            type="text"
            id="name-column"
            class="form-control"
            placeholder="Name"
            name="name"
            value="{{ $company->name }}" />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="address-line1">Address line 1</label>
          <input
            type="text"
            id="address-line1"
            class="form-control"
            placeholder="Address line 1"
            name="address_line_1"
            value="{{ $company->address_line_1 }}" />
        </div>
      </div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="address-line2">Address line 2</label>
          <input
            type="text"
            id="address-line2"
            class="form-control"
            placeholder="Address line 2"
            name="address_line_2"
            value="{{ $company->address_line_2 }}" />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="town">Town</label>
          <input
            type="text"
            id="town"
            class="form-control"
            placeholder="City/Town"
            name="town"
            value="{{ $company->town }}" />
        </div>
      </div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="state">State</label>
          <input
            type="text"
            id="state"
            class="form-control"
            placeholder="County/Province/Region"
            name="state"
            value="{{ $company->state }}" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="country">Country</label>
          <input
            type="text"
            id="country"
            class="form-control"
            placeholder="Country"
            name="country"
            value="{{ $company->country }}" />
        </div>
      </div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="post-code">Postal Code</label>
          <input
            type="text"
            id="post-code"
            class="form-control"
            placeholder="Postal Code"
            name="post_code"
            value="{{ $company->post_code }}" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-8 mb-1">
        <div class="border rounded p-1">
          <h4 class="mb-1">Logo Image</h4>
          <div class="d-flex flex-column flex-md-row">
            <img
              src="{{ $company->logo ?
                env('AZURE_STORAGE_URL').'uploads/'.$company->logo :
                'https://via.placeholder.com/250x110.png?text=Logo+Here'
              }}"
              id="logo"
              class="rounded me-2 mb-1 mb-md-0"
              width="250"
              height="110"
              alt="Logo Image"
            />
            <div class="featured-info">
              <div class="d-inline-block">
                <input class="form-control" type="file" id="imageLogo" name="upload_file" accept="image/*" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="copyright">Copy right text</label>
          <input
            type="text"
            id="copyright"
            class="form-control"
            placeholder="Copy right text"
            name="copy_right_text"
            value="{{ $company->copy_right_text }}" />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="link_name">Custom Link</label>
          <input
            type="text"
            id="link_name"
            class="form-control"
            placeholder="Custom link name"
            name="link_name"
            value="{{ $company->link_name }}" />
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="link_value">Custom Link URL</label>
          <input
            type="text"
            id="link_value"
            class="form-control"
            placeholder="Custom link URL"
            name="link_value"
            value="{{ $company->link_value }}" />
        </div>
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
    </div>
  </form>
</div>
