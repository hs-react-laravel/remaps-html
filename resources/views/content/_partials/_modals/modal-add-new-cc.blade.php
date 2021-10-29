<!-- add new card modal  -->
<div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-sm-5 mx-50 pb-5">
        <h1 class="text-center mb-1" id="addNewCardTitle">Card Information</h1>

        <!-- form -->
        <form
          id="cardValidation"
          class="row gy-1 gx-2 mt-75"
          data-cc-on-file="false"
          data-stripe-publishable-key="{{ $stripeKey }}"
          action="{{ route('consumer.buy-credits.stripe-post') }}"
          method="POST">
          @csrf
          <input type="hidden" name="group_id" value="{{ $tuningCreditGroup->id }}">
          <input type="hidden" name="tire_id" value="{{ $tire->id }}">
          <input type="hidden" name="stripe_credit_type" value="normal">
          <div class="col-12">
            <label class="form-label" for="modalAddCardNumber">Card Number</label>
            <div class="input-group input-group-merge">
              <input
                id="modalAddCardNumber"
                name="modalAddCard"
                class="form-control add-credit-card-mask card-number"
                type="text"
                placeholder="1356 3215 6548 7898"
                aria-describedby="modalAddCard2"
                data-msg="Please enter your credit card number"
                required
              />
              <span class="input-group-text cursor-pointer p-25" id="modalAddCard2">
                <span class="add-card-type"></span>
              </span>
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label" for="modalAddCardName">Name On Card</label>
            <input type="text" id="modalAddCardName" class="form-control" placeholder="John Doe" required />
          </div>

          <div class="col-6 col-md-3">
            <label class="form-label" for="modalAddCardExpiryDate">Exp. Date</label>
            <input
              type="text"
              id="modalAddCardExpiryDate"
              class="form-control add-expiry-date-mask card-expiry"
              placeholder="MM/YY"
              required
            />
          </div>

          <div class="col-6 col-md-3">
            <label class="form-label" for="modalAddCardCvv">CVV</label>
            <input
              type="text"
              id="modalAddCardCvv"
              class="form-control add-cvv-code-mask card-cvc"
              maxlength="3"
              placeholder="654"
              required
            />
          </div>

          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-1 mt-1">Submit</button>
            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ add new card modal  -->
