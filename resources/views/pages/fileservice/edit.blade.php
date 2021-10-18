@extends('layouts/contentLayoutMaster')

@section('title', 'File Service')

@section('content')
<!-- Basic Vertical form layout section start -->
<section id="basic-vertical-layouts">
  <div class="row">
    <div class="col-md-6 col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Process the file service</h4>
        </div>
        <div class="card-body">
          {{ Form::model($fileService, array('route' => array('fileservices.update', $fileService->id), 'method' => 'PUT')) }}
            <div class="row">
              <div class="col-12">
                <div class="mb-1">
                  <label class="form-label" for="status">Status</label>
                  <select class="form-select" id="status" name="status">
                    @foreach (config('constants.file_service_staus') as $key => $value)
                      <option value="{{$key}}" @if($fileService->status == $value) selected @endif>{{$value}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-1">
                  <label for="modified_file" class="form-label">Modified file</label>
                  <input class="form-control" type="file" id="modified_file" name="modified_file" />
                </div>
              </div>
              <div class="col-12">
                <div class="mb-1">
                  <label class="form-label" for="notes_by_engineer">Notes by engineer</label>
                  <textarea
                    class="form-control"
                    id="notes_by_engineer"
                    rows="3"
                    name="notes_by_engineer"
                  >{{ $fileService->notes_by_engineer }}</textarea>
                </div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary me-1">Save</button>
              </div>
            </div>
          {{ Form::close() }}
        </div>
      </div>
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
    </div>
    <div class="col-md-6 col-12">
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
    </div>
  </div>
</section>
<!-- Basic Vertical form layout section end -->
@endsection
