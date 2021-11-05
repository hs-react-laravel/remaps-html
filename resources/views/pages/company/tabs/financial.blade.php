<div class="tab-pane @if($tab == 'finance') active @endif" id="finance-fill" role="tabpanel" aria-labelledby="finance-tab-fill">
    <div class="row mb-1">
      <div class="col-md-6 col-xl-4">
        <label class="form-label" for="bank_account">Bank account <small class="text-muted">(optional)</small></label>
        <input
          type="text"
          id="bank_account"
          class="form-control"
          placeholder=""
          name="bank_account"
          value="{{ $entry->bank_account }}" />
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-md-6 col-xl-4">
        <label class="form-label" for="bank_identification_code">Bank identification code (BIC) <small class="text-muted">(optional)</small></label>
        <input
          type="text"
          id="bank_identification_code"
          class="form-control"
          placeholder=""
          name="bank_identification_code"
          value="{{ $entry->bank_identification_code }}" />
      </div>
    </div>

    <div class="row mb-1">
      <div class="col-md-6 col-xl-4">
        <label class="form-label" for="vat_number">Vat number</label>
        <input
          type="text"
          id="vat_number"
          class="form-control"
          placeholder=""
          name="vat_number"
          value="{{ $entry->vat_number }}" />
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-md-6 col-xl-4">
        <label class="form-label" for="vat_percentage">Vat percentage</label>
        <input
          type="text"
          id="vat_percentage"
          class="form-control"
          placeholder="%"
          name="vat_percentage"
          value="{{ $entry->vat_percentage }}" />
      </div>
    </div>

    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
    </div>
  </form>
</div>
