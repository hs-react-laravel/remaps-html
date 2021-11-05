<div class="tab-pane @if($tab == 'domain') active @endif" id="domain-fill" role="tabpanel" aria-labelledby="domain-tab-fill">
    <input type="hidden" name="tab" value="domain" />
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="mb-1">
          <label class="form-label" for="domain_link">Domain Link <span class="text-danger">*</span></label>
          <input
            type="text"
            id="domain_link"
            class="form-control"
            placeholder="xxx.myremaps.com"
            name="domain_link"
            value="{{ $entry->domain_link }}" />
        </div>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary me-1">Submit</button>
      </div>
    </div>
</div>
