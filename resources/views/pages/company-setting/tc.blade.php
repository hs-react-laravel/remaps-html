<div class="tab-pane @if($tab == 'tc') active @endif" id="tc-fill" role="tabpanel" aria-labelledby="tc-tab-fill">
  <form class="form" action="{{ route('company.setting.store') }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="tab" value="tc" />
    @csrf
    <div class="form-check form-check-inline">
      <input type="hidden" name="is_tc" value="0" />
      <input class="form-check-input" type="checkbox" id="is_tc" name="is_tc" value="1" @if($company->is_tc) checked @endif/>
      <label class="form-check-label" for="is_tc">Activate Terms &amp; Conditions Check</label>
    </div>
    <div class="row mt-2 mb-2">
      <h4 class="mb-1">Terms &amp; Conditions PDF</h4>
      <span>{{ $company->tc_pdf }}</span>
      <div class="featured-info">
        <div class="d-inline-block">
          <input class="form-control" type="file" id="tc_pdf" name="tc_pdf_file" accept="application/pdf" />
        </div>
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
    </div>
  </form>
</div>
