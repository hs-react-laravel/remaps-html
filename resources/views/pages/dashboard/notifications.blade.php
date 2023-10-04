@extends('layouts/contentLayoutMaster')

@section('title', 'Notifications')

@section('content')
<section id="alerts-closable">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Notifications</h4>
        </div>
        <div class="card-body">
          <div class="demo-spacing-0">
            @foreach ($notifies as $n)
            @php
                $theme = '';
                if ($n['icon'] == 0) $theme = 'danger';
                if ($n['icon'] == 1) $theme = 'warning';
                if ($n['icon'] == 2) $theme = 'info';
                if ($n['icon'] == 3) $theme = 'success';
            @endphp
            <div class="alert alert-{{ $theme }} alert-dismissible fade show" role="alert">
              <h4 class="alert-heading">
                {{ $n['subject'] }}
                <span style="float: right"><strong>{{ date('d/m/Y', strtotime($n['updated_at'])) }}</strong></span>
              </h4>
              <div class="alert-body">
                {!! $n['body'] !!}
              </div>
              {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="onRead({{ $n['id'] }})"></button> --}}
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('page-script')
<script src="{{asset(mix('js/scripts/components/components-alerts.js'))}}"></script>
<script>
  function onRead(id) {
    $.ajax({
      url: '{{ route("dashboard.notifications.read") }}',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        id: id
      },
      dataType: 'JSON',
      success: function (data) {

      }
    });
  }
</script>
@endsection
