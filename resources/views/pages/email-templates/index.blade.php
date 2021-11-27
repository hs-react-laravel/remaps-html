
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu_EmailTemplates'))

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{__('locale.menu_EmailTemplates')}}</h4>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="20%">{{__('locale.tb_header_EmailType')}}</th>
              <th width="20%">{{__('locale.tb_header_Subject')}}</th>
              <th width="20%">{{__('locale.tb_header_ModifiedAt')}}</th>
              <th width="5%">{{__('locale.tb_header_Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries as $u)
              <tr>
                  <td>{{ $u->email_type }}</td>
                  <td>{{ $u->subject }}</td>
                  <td>{{ $u->created_at }}</td>
                  <td>
                    <a class="btn btn-icon btn-primary" href="{{ route('email-templates.edit', ['email_template' => $u->id]) }}" title="Edit">
                      <i data-feather="edit"></i>
                    </a>
                  </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    {{ $entries->links() }}
  </div>
</div>
<!-- Basic Tables end -->
@endsection
