<div class="tab-pane @if($tab == 'domain') active @endif" id="domain-fill" role="tabpanel" aria-labelledby="domain-tab-fill">
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="v2_domain_link">Domain Link <span class="text-danger">*</span></label>
          <input
            type="text"
            id="v2_domain_link"
            class="form-control"
            placeholder="xxx.remapdash.com"
            name="v2_domain_link"
            value="{{ $entry->v2_domain_link }}" />
        </div>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary me-1">Submit</button>
      </div>
    </div>
</div>
