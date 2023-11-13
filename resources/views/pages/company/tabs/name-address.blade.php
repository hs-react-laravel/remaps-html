<div class="tab-pane @if($tab == 'name') active @endif" id="name-fill" role="tabpanel" aria-labelledby="name-tab-fill">
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="name-column">Name <span class="text-danger">*</span></label>
          <input
            type="text"
            id="name-column"
            class="form-control"
            placeholder="Name"
            name="name"
            value="{{ $entry->name }}" />
        </div>
      </div>
      <div class="col-md-8 col-12"></div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="address-line1">Address line 1 <span class="text-danger">*</span></label>
          <input
            type="text"
            id="address-line1"
            class="form-control"
            placeholder="Address line 1"
            name="address_line_1"
            value="{{ $entry->address_line_1 }}" />
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
            value="{{ $entry->address_line_2 }}" />
        </div>
      </div>
      <div class="col-md-4 col-12"></div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="town">Town <span class="text-danger">*</span></label>
          <input
            type="text"
            id="town"
            class="form-control"
            placeholder="City/Town"
            name="town"
            value="{{ $entry->town }}" />
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
            value="{{ $entry->state }}" />
        </div>
      </div>
      <div class="col-md-4 col-12"></div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="country">Country <span class="text-danger">*</span></label>
          <input
            type="text"
            id="country"
            class="form-control"
            placeholder="Country"
            name="country"
            value="{{ $entry->country }}" />
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
            value="{{ $entry->post_code }}" />
        </div>
      </div>

      <div class="col-8 mb-1">
        <div class="border rounded p-1">
          <h4 class="mb-1">Logo Image</h4>
          <div class="d-flex flex-column flex-md-row">
            <img
              src="{{ $entry->logo ?
                env('AZURE_STORAGE_URL').'uploads/'.$entry->logo :
                'https://via.placeholder.com/250x110.png?text=Logo+Here'
              }}"
              id="logo"
              class="rounded me-2 mb-1 mb-md-0"
              width="250"
              height="110"
              alt="Blog Featured Image"
            />
            <div class="featured-info">
              <div class="d-inline-block">
                <input class="form-control" type="file" id="imageLogo" name="upload_file" accept="image/*" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-12"></div>

      <div class="col-md-8 col-12">
        <div class="mb-1">
          <label class="form-label" for="copyright">Copy right text</label>
          <input
            type="text"
            id="copyright"
            class="form-control"
            placeholder="Copy right text"
            name="copy_right_text"
            value="{{ $entry->copy_right_text }}" />
        </div>
      </div>
      <div class="col-12 mb-1">
        <div class="form-check form-check-inline">
          <input type="hidden" name="is_show_car_data" value="0" />
          <input class="form-check-input" type="checkbox" id="is_show_car_data" name="is_show_car_data" value="1" @if($entry->is_show_car_data) checked @endif/>
          <label class="form-check-label" for="is_show_car_data">Show Tuning Data</label>
        </div>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary me-1">Submit</button>
      </div>
    </div>
</div>
