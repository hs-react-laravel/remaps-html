<div class="tab-pane @if($tab == 'smtp') active @endif" id="smtp-fill" role="tabpanel" aria-labelledby="smtp-tab-fill">
    <div class="row mb-1">
      <div class="col-xl-4 col-md-6">
        <label class="form-label" for="mail_driver">Mail Driver</label>
        <input type="text" id="mail_driver" class="form-control" value="smtp" name="mail_driver" readonly />
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-xl-4 col-md-6">
        <label class="form-label" for="mail_host">Mail Host</label>
        <input
          type="text"
          id="mail_host"
          class="form-control"
          placeholder="smtp.xxx.xxx"
          name="mail_host"
          value="{{ $entry->mail_host }}" />
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-xl-4 col-md-6">
        <label class="form-label" for="mail_port">Mail Port</label>
        <input
          type="text"
          id="mail_port"
          class="form-control"
          placeholder="25 / 465 / 587"
          name="mail_port"
          value="{{ $entry->mail_port }}" />
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-xl-4 col-md-6">
        <label class="form-label" for="mail_encryption">Mail Encryption</label>
        <select class="form-select" id="mail_encryption" name="mail_encryption">
          <option value="">None</option>
          <option value="ssl" @if($entry->mail_encryption =="ssl") selected @endif>SSL</option>
          <option value="tls" @if($entry->mail_encryption =="tls") selected @endif>TLS</option>
        </select>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-xl-4 col-md-6">
        <label class="form-label" for="mail_username">Mail Username</label>
        <input
          type="text"
          id="mail_username"
          class="form-control"
          placeholder="xxx@xxx.com"
          name="mail_username"
          value="{{ $entry->mail_username }}"
          autocomplete="new-name" />
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-xl-4 col-md-6">
        <label class="form-label" for="mail_password">Mail Password</label>
        <input
          type="password"
          id="mail_password"
          class="form-control"
          placeholder="*******"
          name="mail_password"
          value="{{ $entry->mail_password }}"
          autocomplete="new-password" />
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
    </div>
</div>
