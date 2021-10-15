<div class="tab-pane @if($tab == 'evc') active @endif" id="evc-fill" role="tabpanel" aria-labelledby="evc-tab-fill">
  <p>To Activate the reseller function enter reseller credentials.</p>
  <form class="form" action="{{ route('company.setting.store') }}" method="POST">
    @csrf
    <input type="hidden" name="tab" value="evc" />
    <div class="col-md-4 col-12">
      <div class="mb-1">
        <label class="form-label" for="reseller_id">ID</label>
        <input
          type="text"
          id="reseller_id"
          class="form-control"
          placeholder=""
          name="reseller_id"
          value="{{ $company->reseller_id }}" />
      </div>
    </div>
    <div class="col-md-4 col-12">
      <div class="mb-1">
        <label class="form-label" for="reseller_password">Password</label>
        <input
          type="password"
          id="reseller_password"
          class="form-control"
          placeholder="*******"
          name="reseller_password"
          value="{{ $company->reseller_password }}" />
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
    </div>
  </form>
</div>
