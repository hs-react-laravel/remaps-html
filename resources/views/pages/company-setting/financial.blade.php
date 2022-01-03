<div class="tab-pane @if($tab == 'finance') active @endif" id="financial-fill" role="tabpanel" aria-labelledby="financial-tab-fill">
  <form class="form" action="{{ route('company.setting.store') }}" method="POST">
    @csrf
    <input type="hidden" name="tab" value="finance" />
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="bank_account">Bank account <small class="text-muted">(optional)</small></label>
          <input
            type="text"
            id="bank_account"
            class="form-control"
            placeholder=""
            name="bank_account"
            value="{{ $company->bank_account }}" />
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="bank_identification_code">Bank identification code (BIC) <small class="text-muted">(optional)</small></label>
          <input
            type="text"
            id="bank_identification_code"
            class="form-control"
            placeholder=""
            name="bank_identification_code"
            value="{{ $company->bank_identification_code }}" />
        </div>
      </div>
      <div class="col-md-4 col-12"></div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="vat_number">Vat number</label>
          <input
            type="text"
            id="vat_number"
            class="form-control"
            placeholder=""
            name="vat_number"
            value="{{ $company->vat_number }}" />
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="vat_percentage">Vat percentage</label>
          <input
            type="text"
            id="vat_percentage"
            class="form-control"
            placeholder="%"
            name="vat_percentage"
            value="{{ $company->vat_percentage }}" />
        </div>
      </div>
    </div>
    <hr>
    <p>
      <strong>Note: </strong>
      To generate your API credientials log in with your Paypal Account at:
      <a href="https://developer.paypal.com/developer/applications">https://developer.paypal.com/developer/applications</a>.
      Click on : MY APPS AND CREDENTIALS, Scroll down to REST API apps and click CREATE APP.
    </p>
    <div class="row">
      <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="paypal_client_id">Paypal client id</label>
          <input
            type="text"
            id="paypal_client_id"
            class="form-control"
            placeholder=""
            name="paypal_client_id"
            value="{{ $company->paypal_client_id }}" />
        </div>
      </div>
      <div class="col-md-6 col-12"></div>
      <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="paypal_secret">Paypal secret</label>
          <input
            type="text"
            id="paypal_secret"
            class="form-control"
            placeholder=""
            name="paypal_secret"
            value="{{ $company->paypal_secret }}" />
        </div>
      </div>
      <div class="col-md-3 col-12">
        <div class="mb-1">
          <label class="form-label" for="paypal_currency_code">Paypal currency code</label>
            <select name="paypal_currency_code" class="form-select">
              @foreach (config('constants.currencies') as $code)
                <option value="{{ $code }}" @if ($company->paypal_currency_code == $code) selected @endif>{{ $code }}</option>
              @endforeach
            </select>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="stripe_key">Stripe key</label>
          <input
            type="text"
            id="stripe_key"
            class="form-control"
            placeholder=""
            name="stripe_key"
            value="{{ $company->stripe_key }}" />
        </div>
      </div>
      <div class="col-md-6 col-12"></div>
      <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="stripe_secret">Stripe secret</label>
          <input
            type="text"
            id="stripe_secret"
            class="form-control"
            placeholder=""
            name="stripe_secret"
            value="{{ $company->stripe_secret }}" />
        </div>
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
    </div>
  </form>
</div>
