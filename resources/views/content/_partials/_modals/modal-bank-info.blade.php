<!-- add new card modal  -->
<div class="modal fade" id="showBankInfo" tabindex="-1" aria-labelledby="showBankInfoTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-sm-5 mx-50 pb-5">
        <h1 class="text-center mb-1" id="showBankInfoTitle">Bank Transfer</h1>
        <p>
          <span name="tire_tireamt" class="text-success"></span>
          <span class="text-success">Credits</span>
          <span class="text-primary ms-1">{{ $currencyCode }}</span>
          <span name="tire_amount" class="pricing-basic-value fw-bolder text-primary"></span>
        </p>
        <hr />
        <form
          id="bankConfirmation"
          class="row gy-1 gx-2 mt-75"
          action="{{ route('consumer.buy-credits.bank-post') }}"
          method="POST">
          @csrf
          <input type="hidden" name="group_id" value="{{ $tuningCreditGroup->id }}">
          <input type="hidden" name="tire_id">
          <p style="white-space:pre-line">{{ $company->bank_info }}</p>
          <button class="btn btn-primary" type="submit">Buy</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ add new card modal  -->
