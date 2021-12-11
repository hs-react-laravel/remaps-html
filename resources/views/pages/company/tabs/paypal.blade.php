<div class="tab-pane @if($tab == 'paypal') active @endif" id="paypal-fill" role="tabpanel" aria-labelledby="paypal-tab-fill">
    <p>
      <strong>Note: </strong>
      To generate your API credientials log in with your Paypal Account at:
      <a href="https://developer.paypal.com/developer/applications">https://developer.paypal.com/developer/applications</a>. <br>
      Click on : MY APPS AND CREDENTIALS, Scroll down to REST API apps and click CREATE APP.
    </p>
    <div class="row mb-1">
      <div class="col-xl-4 col-md-6">
        <label class="form-label" for="paypal_client_id">Paypal client id</label>
        <input
          type="text"
          id="paypal_client_id"
          class="form-control"
          placeholder=""
          name="paypal_client_id"
          value="{{ $entry->paypal_client_id }}" />
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-xl-4 col-md-6">
        <label class="form-label" for="paypal_secret">Paypal secret</label>
        <input
          type="text"
          id="paypal_secret"
          class="form-control"
          placeholder=""
          name="paypal_secret"
          value="{{ $entry->paypal_secret }}" />
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-xl-4 col-md-6">
        <label class="form-label" for="paypal_currency_code">Paypal currency code</label>
        <select name="paypal_currency_code" class="form-select">
          @foreach (config('constants.currencies') as $code)
            <option value="{{ $code }}" @if ($entry->paypal_currency_code == $code) selected @endif>{{ $code }}</option>
          @endforeach
        </select>
      </div>
    </div>
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
    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
    </div>
</div>
