<div class="table-responsive p-1">
  <table class="table">
    <thead>
      <tr>
        <th width="20%">{{__('locale.tb_header_Name')}}</th>
        <th width="20%">{{__('locale.tb_header_Price')}}</th>
        <th width="5%">{{__('locale.tb_header_Actions')}}</th>
      </tr>
    </thead>
    <tbody>
      @if (count($entries) > 0)
      @foreach ($entries as $i => $entry)
        <tr>
          <td>{{ $entry->title }}</td>
          <td>{{ $currencyCode.number_format($entry->price, 2) }}</td>
          <td class="td-actions">
            @if ($i < $maxProductCt || $user->is_master)
            <a class="btn btn-icon btn-primary" href="{{ route('shopproducts.edit', ['shopproduct' => $entry->id]) }}" title="Edit">
              <i data-feather="edit"></i>
            </a>
            @endif
            <a class="btn btn-icon btn-danger" onclick="onDelete(this)" data-id="{{ $entry->id }}" title="Delete"><i data-feather="trash-2"></i></a>
            <form action="{{ route('shopproducts.destroy', $entry->id) }}" class="delete-form" method="POST" style="display:none">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
          </td>
        </tr>
      @endforeach
      @else
        <tr>
          <td colspan="3">No matching records found</td>
        </tr>
      @endif
    </tbody>
  </table>
  {{ $entries->links() }}
</div>
