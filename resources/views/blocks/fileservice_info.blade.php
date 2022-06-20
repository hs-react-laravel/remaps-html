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
          <td>{{ $fileService->tuningType ? $fileService->tuningType->label : '' }}</td>
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
            <td>
              @if ($user->is_admin)
                <a href="{{ route('fileservice.download.original', ['id' => $fileService->id]) }}">download</a>
              @else
                <a href="{{ route('stafffs.download.original', ['id' => $fileService->id]) }}">download</a>
              @endif
            </td>
        </tr>
        @if((($fileService->status == 'Completed') || ($fileService->status == 'Waiting')) && ($fileService->modified_file != ""))
          <tr>
            <th>Modified file</th>
            @if($user->is_admin)
            <td>
              <a href="{{ route('fileservice.download.modified', ['id' => $fileService->id]) }}">download</a>
              @if($fileService->status == 'Waiting')
                &nbsp;&nbsp;<a href="{{ route('fileservice.delete.modified', ['id' => $fileService->id]) }}">delete</a>
              @endif
            </td>
            @else
            <td>
              <a href="{{ route('stafffs.download.modified', ['id' => $fileService->id]) }}">download</a>
              @if($fileService->status == 'Waiting')
                &nbsp;&nbsp;<a href="{{ route('stafffs.delete.modified', ['id' => $fileService->id]) }}">delete</a>
              @endif
            </td>
            @endif
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
@endif
