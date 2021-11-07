@extends('layouts/contentLayoutMaster')

@section('title', 'Companies')

@section('content')

<div class="col-md-12 col-xl-6">
  <div class="row">
    <div class="card">
      <div class="card-header">
        <h4 class="header-text">Add Trial Subscription</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('companies.trial.post', ['id' => $id]) }}" method="POST">
          @csrf
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label" for="description">Description</label>
              <input type="text" class="form-control" id="description" name="description" />
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label" for="description">Days (Trial Period)</label>
              <input type="number" class="form-control" id="days" name="trial_days" />
            </div>
          </div>
          <button type="submit" class="btn btn-primary me-1">Submit</button>
          <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="col-12">
  <div class="row">
    <div class="card">
      <div class="card-header">
        <h4 class="header-text">Subscription History</h4>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th>Description</th>
              <th>Trial Days</th>
              <th>Status</th>
              <th>Start Days</th>
            </tr>
          </thead>
          <tbody>
            @if (count($subscriptions) > 0)
              @foreach ($subscriptions as $entry)
                <tr>
                  <td>{{ $entry->description }}</td>
                  <td>{{ $entry->trial_days }}</td>
                  <td>{{ $entry->status }}</td>
                  <td>{{ $entry->start_date }}</td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="4">No matching records found</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
