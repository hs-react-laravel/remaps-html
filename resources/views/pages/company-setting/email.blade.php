<div class="tab-pane @if($tab == 'email') active @endif" id="email-fill" role="tabpanel" aria-labelledby="email-tab-fill">
  <form class="form" action="{{ route('company.setting.store') }}" method="POST">
    @csrf
    <input type="hidden" name="tab" value="email" />
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="main_email_address">Main email address</label>
          <input
            type="text"
            id="main_email_address"
            class="form-control"
            placeholder="xxx@xxx.com"
            name="main_email_address"
            value="{{ $company->main_email_address }}" />
        </div>
      </div>
      <div class="col-md-8 col-12"></div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="support_email_address">Support email address</label>
          <input
            type="text"
            id="support_email_address"
            class="form-control"
            placeholder="xxx@xxx.com"
            name="support_email_address"
            value="{{ $company->support_email_address }}" />
        </div>
      </div>
      <div class="col-md-8 col-12"></div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="billing_email_address">Billing email address</label>
          <input
            type="text"
            id="billing_email_address"
            class="form-control"
            placeholder="xxx@xxx.com"
            name="billing_email_address"
            value="{{ $company->billing_email_address }}" />
        </div>
      </div>
      <div class="col-md-8 col-12"></div>

      <hr>
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="mail_driver">Mail Driver</label>
          <input type="text" id="mail_driver" class="form-control" value="smtp" name="mail_driver" readonly />
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="mail_host">Mail Host</label>
          <input
            type="text"
            id="mail_host"
            class="form-control"
            placeholder="smtp.xxx.xxx"
            name="mail_host"
            value="{{ $company->mail_host }}" />
        </div>
      </div>
      <div class="col-md-4 col-12"></div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="mail_port">Mail Port</label>
          <input
            type="text"
            id="mail_port"
            class="form-control"
            placeholder="25,465,587"
            name="mail_port"
            value="{{ $company->mail_port }}" />
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="mail_encryption">Mail Encryption</label>
          <select class="form-select" id="mail_encryption" name="mail_encryption">
            <option value="">None</option>
            <option value="ssl" @if($company->mail_encryption =="ssl") selected @endif>SSL</option>
            <option value="tls" @if($company->mail_encryption =="tls") selected @endif>TLS</option>
          </select>
        </div>
      </div>
      <div class="col-md-4 col-12"></div>

      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="mail_username">Mail Username</label>
          <input
            type="text"
            id="mail_username"
            class="form-control"
            placeholder="xxx@xxx.com"
            name="mail_username"
            value="{{ $company->mail_username }}" />
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="mail_password">Mail Password</label>
          <input
            type="password"
            id="mail_password"
            class="form-control"
            placeholder="*******"
            name="mail_password"
            value="{{ $company->mail_password }}" />
        </div>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary me-1">Submit</button>
      </div>
    </div>
  </form>
</div>
