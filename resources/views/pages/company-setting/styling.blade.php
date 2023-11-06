<div class="tab-pane @if($tab == 'styling') active @endif" id="styling-fill" role="tabpanel" aria-labelledby="styling-tab-fill">
  <form class="form" action="{{ route('company.setting.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="tab" value="styling" />
    <div class="row">
      <div class="col-xl-8 col-lg-8 col-md-6 mb-1">
        <div class="border rounded p-1">
          <h4 class="mb-1">Login Background</h4>
          <div class="d-flex flex-column flex-md-row">
            <img
              src="{{ $company->style_background ?
                asset('storage/uploads/styling/'.$company->style_background) :
                'https://via.placeholder.com/250x110.png?text=Login+Background'
              }}"
              id="style_background_img"
              class="rounded me-2 mb-1 mb-md-0"
              alt="Logo Image"
              style="max-width: 250px; max-height: 110px; width: auto; height: auto"
            />
            <div class="featured-info">
              <div class="d-inline-block">
                <input class="form-control" type="file" id="style_background" name="style_background_file" accept="image/*" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="form-check form-check-inline my-1">
            <input type="hidden" name="is_invoice_pdf" value="0" />
            <input class="form-check-input" type="checkbox" id="is_invoice_pdf" name="is_invoice_pdf" value="1" @if($company->is_invoice_pdf) checked @endif/>
            <label class="form-check-label" for="is_invoice_pdf">Deactivates the normal system generated invoice PDF</label>
          </div>
      </div>
      <div class="col-12">
        <div class="form-check form-check-inline my-1">
            <input type="hidden" name="secret_2fa_enabled" value="0" />
            <input class="form-check-input" type="checkbox" id="secret_2fa_enabled" name="secret_2fa_enabled" value="1" @if($company->secret_2fa_enabled) checked @endif/>
            <label class="form-check-label" for="secret_2fa_enabled">2FA Security</label>
        </div>
      </div>
      <div class="col-12 mt-2">
        <button type="submit" class="btn btn-primary me-1">Submit</button>
      </div>
    </div>
  </form>
</div>
