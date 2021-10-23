@if (isset($fileService))
<div class="card">
  <div class="card-header">
    <h4 class="card-title">File service information</h4>
  </div>
  <div class="table-responsive">
    <table class="table">
      <tbody>
        <tr>
          <th>No.</th>
          <td>{{ $fileService->displayable_id }}</td>
        </tr>
        <tr>
          <th>Status</th>
          <td>{{ $fileService->status }}</td>
        </tr>
        <tr>
          <th>Date submitted</th>
          <td>{{ $fileService->created_at }}</td>
        </tr>
        <tr>
          <th>Tuning type</th>
          <td>{{ $fileService->tuningType->label }}</td>
        </tr>
        <tr>
            <th>Tuning options</th>
            <td>{{ $fileService->tuningTypeOptions()->pluck('label')->implode(',') }}</td>
        </tr>
        <tr>
          <th>Credits</th>
            @php
              $tuningTypeCredits = $fileService->tuningType->credits;
              $tuningTypeOptionsCredits = $fileService->tuningTypeOptions()->sum('credits');
              $credits = ($tuningTypeCredits+$tuningTypeOptionsCredits);
            @endphp
            <td>{{ number_format($credits, 2) }}</td>
        </tr>
        <tr>
            <th>Original file</th>
            <td><a href="{{ url('file-service/'.$fileService->id.'/download-orginal') }}">download</a></td>
        </tr>
        @if((($fileService->status == 'Completed') || ($fileService->status == 'Waiting')) && ($fileService->modified_file != ""))
          <tr>
              <th>Modified file</th>
              <td>
                <a href="{{ url('file-service/'.$fileService->id.'/download-modified') }}">download</a>
                @if($fileService->status == 'Waiting')
                  &nbsp;&nbsp;<a href="{{ url('file-service/'.$fileService->id.'/delete-modified') }}">delete</a>
                @endif
              </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
@endif
