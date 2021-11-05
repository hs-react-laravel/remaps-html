<div class="tab-pane @if($tab == 'note') active @endif" id="note-fill" role="tabpanel" aria-labelledby="evc-tab-fill">
    <div class="row">
      <div class="col-6">
        <div class="mb-1">
          <label class="form-label" for="customer_note">Notes to customer<small class="text-muted">(optional)</small></label>
          <textarea
            class="form-control"
            id="customer_note"
            rows="5"
            placeholder=""
            name="customer_note"
          >{{ $entry->customer_note }}</textarea>
        </div>
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
    </div>
</div>
