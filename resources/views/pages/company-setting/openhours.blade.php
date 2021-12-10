@php
  $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
@endphp
<div class="tab-pane @if($tab == 'openhours') active @endif" id="opens-fill" role="tabpanel" aria-labelledby="opens-tab-fill">
  <form class="form" action="{{ route('company.setting.store') }}" method="POST">
    @csrf
    <input type="hidden" name="tab" value="openhours" />
    <div class="form-check form-check-inline">
      <input type="hidden" name="open_check" value="0" />
      <input class="form-check-input" type="checkbox" id="open_check" name="open_check" value="1" @if($company->open_check) checked @endif/>
      <label class="form-check-label" for="open_check">Activate Opening Hour Module</label>
    </div>
    <div id="oh_form">
    <div class="demo-inline-spacing">
      <div class="form-check form-check-inline">
        <input
          class="form-check-input"
          type="radio"
          name="notify_check"
          id="inlineRadio1"
          value="0"
          @if ($company->notify_check == 0) checked @endif
        />
        <label class="form-check-label" for="inlineRadio1">Allow file services when closed</label>
      </div>
      <div class="form-check form-check-inline">
        <input
          class="form-check-input"
          type="radio"
          name="notify_check"
          id="inlineRadio2"
          value="1"
          @if ($company->notify_check == 1) checked @endif
        />
        <label class="form-check-label" for="inlineRadio2">No file services when closed</label>
      </div>
    </div>
    @foreach ($days as $day)
      @php
        $daymark_close = substr($day, 0, 3).'_close';
        $daymark_from = substr($day, 0, 3).'_from';
        $daymark_to = substr($day, 0, 3).'_to';
        $timezone = Helper::companyTimeZone();
        $tz = \App\Models\Timezone::find($timezone ?? 1);
        $day_from = $company->$daymark_from ? \Carbon\Carbon::parse($company->$daymark_from)->tz($tz->name)->format('H:i') : $company->$daymark_from;
        $day_to = $company->$daymark_to ? \Carbon\Carbon::parse($company->$daymark_to)->tz($tz->name)->format('H:i') : $company->$daymark_to;
      @endphp
      <label class="form-label mt-1">{{ ucfirst($day) }}</label>
      <div class="row" style="align-items: center">
        <div class="col-3">
          <div class="input-group">
            <span class="input-group-text">From</span>
            <input
              type="time"
              class="form-control"
              id="{{ $daymark_from }}"
              name="{{ $daymark_from }}"
              value="{{ $day_from }}"
              @if ($company->$daymark_close) disabled @endif />
          </div>
        </div>
        <div class="col-3">
          <div class="input-group">
            <span class="input-group-text">To</span>
            <input
              type="time"
              class="form-control"
              id="{{ $daymark_to }}"
              name="{{ $daymark_to }}"
              value="{{ $day_to }}"
              @if ($company->$daymark_close) disabled @endif />
          </div>
        </div>
        <div class="col-3">
          <div class="form-check">
            <input type="hidden" name="{{ $daymark_close }}" value="0">
            <input
              class="form-check-input input-close"
              type="checkbox"
              id="{{$daymark_close}}"
              name="{{$daymark_close}}"
              value="1"
              @if ($company->$daymark_close) checked @endif />
            <label class="form-check-label" for="{{$day}}-close">Close</label>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="col-12 mt-1">
      <button type="submit" class="btn btn-primary me-1">Submit</button>
    </div>
  </form>
</div>
