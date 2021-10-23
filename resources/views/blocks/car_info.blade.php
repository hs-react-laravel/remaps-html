@if (isset($fileService))
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Car information</h4>
  </div>
  <div class="table-responsive">
    <table class="table">
      <tbody>
        <tr>
          <th>Car</th>
          <td>{{ $fileService->car }}</td>
        </tr>
        <tr>
          <th>Engine</th>
          <td>{{ $fileService->engine }}</td>
        </tr>
        <tr>
          <th>ECU</th>
          <td>{{ $fileService->ecu }}</td>
        </tr>
        <tr>
          <th>Engine HP</th>
          <td>{{ $fileService->engine_hp }}</td>
        </tr>
        <tr>
          <th>Year of Manufacture</th>
          <td>{{ $fileService->year }}</td>
        </tr>
        <tr>
          <th>Gearbox</th>
          <td>{{ config('constants.file_service_gearbox')[$fileService->gearbox] }}</td>
        </tr>
        <tr>
          <th>Fuel Type</th>
          <td>{{ ($fileService->fuel_type)?config('constants.file_service_fuel_type')[$fileService->fuel_type]:'' }}</td>
        </tr>
        <tr>
          <th>Reading Tool</th>
          <td>{{ ($fileService->reading_tool)?config('constants.file_service_reading_tool')[$fileService->reading_tool]:'' }}</td>
        </tr>
        <tr>
          <th>License plate</th>
          <td>{{ $fileService->license_plate }}</td>
        </tr>
        <tr>
          <th>Miles / KM</th>
          <td>{{ $fileService->vin }}</td>
        </tr>
        <tr>
          <th>Note to engineer</th>
          <td>{{ $fileService->note_to_engineer }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endif
