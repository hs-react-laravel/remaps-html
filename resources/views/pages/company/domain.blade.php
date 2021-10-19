<div class="tab-pane @if($tab == 'domain') active @endif" id="domain-fill" role="tabpanel" aria-labelledby="domain-tab-fill">
    {{ Form::model($entry, array('route' => array('companies.update', $entry->id), 'method' => 'PUT')) }}
      @csrf
      <input type="hidden" name="tab" value="email" />
      <div class="row">
        <div class="col-md-4 col-12">
          <div class="mb-1">
            <label class="form-label" for="main_email_address">Domain Link</label>
            <input
              type="text"
              id="main_email_address"
              class="form-control"
              placeholder="xxx@xxx.com"
              name="main_email_address"
              value="{{ $entry->domain_link }}" />
          </div>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary me-1">Submit</button>
        </div>
      </div>
    {{ Form::close() }}
  </div>
