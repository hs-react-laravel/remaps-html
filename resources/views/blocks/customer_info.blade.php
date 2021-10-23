<div class="card">
  <div class="card-header">
    <h4 class="card-title">Customer information</h4>
  </div>
  <div class="table-responsive">
    <table class="table">
      <tbody>
        <tr>
          <th>Business</th>
          <td>{{ $fileService->user->business_name }}</td>
        </tr>
        <tr>
          <th>Name</th>
          <td>{{ $fileService->user->full_name }}</td>
        </tr>
        <tr>
          <th>Email address</th>
          <td>{{ $fileService->user->email }}</td>
        </tr>
        <tr>
          <th>Phone</th>
          <td>{{ $fileService->user->phone }}</td>
        </tr>
        <tr>
          <th>County</th>
          <td>{{ $fileService->user->county }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
