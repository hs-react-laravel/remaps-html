@extends('layouts/contentLayoutMaster')

@section('title', 'Edit File Service')

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
          {{ Form::model($fileService, array('route' => array('fileservices.update', $fileService->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
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
                  <input class="form-control" type="file" id="modified_file" name="upload_file" />
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
              @if (!$user->is_staff)
              <div class="col-12">
                <div class="mb-1">
                  <label class="form-label" for="assign">Assign</label>
                  <select class="form-select" id="assign" name="assign">
                    <option value=""></option>
                    @foreach ($company->staffs as $staff)
                      <option value="{{ $staff->id }}" @if($fileService->assign_id == $staff->id) selected @endif>{{ $staff->fullname }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              @endif
            </div>
            <button type="submit" class="btn btn-primary me-1">Save</button>
            <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Cancel</button>
          {{ Form::close() }}
        </div>
      </div>
      @include('blocks.customer_info')
    </div>
    <div class="col-md-6 col-12">
      @include('blocks.fileservice_info')
      @include('blocks.car_info')
    </div>
  </div>
</section>
<!-- Basic Vertical form layout section end -->
@endsection
