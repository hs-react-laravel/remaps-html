<div class="tab-pane @if($tab == 'stripe') active @endif" id="stripe-fill" role="tabpanel" aria-labelledby="stripe-tab-fill">
      <div class="row mb-1">
        <div class="col-xl-4 col-md-6">
          <label class="form-label" for="stripe_key">Stripe key<small class="text-muted">(optional)</small></label>
          <input
            type="text"
            id="stripe_key"
            class="form-control"
            placeholder=""
            name="stripe_key"
            value="{{ $entry->stripe_key }}" />
        </div>
      </div>
      <div class="row mb-1">
        <div class="col-xl-4 col-md-6">
          <label class="form-label" for="stripe_secret">Stripe secret<small class="text-muted">(optional)</small></label>
          <input
            type="text"
            id="stripe_secret"
            class="form-control"
            placeholder=""
            name="stripe_secret"
            value="{{ $entry->stripe_secret }}" />
        </div>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary me-1">Submit</button>
      </div>
  </div>
