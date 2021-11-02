
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Slide')

@section('content')
<section>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Edit slide</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('slidermanagers.update', ['slidermanager' => $entry->id]) }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <div class="row mb-1">
              <div class="col-xl-6 col-md-12">
                <label class="form-label" for="name">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $entry->title }}" required />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-6 col-md-12">
                <label class="form-label" for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ $entry->description }}" required />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-6 col-md-12">
                <div class="border rounded p-1">
                  <h4 class="mb-1">Logo Image</h4>
                  <div class="d-flex flex-column flex-md-row">
                    <img
                      src="{{ $entry->image ? '/storage/uploads/logo/'.$entry->image
                        : 'https://via.placeholder.com/250x110.png?text=Image+Here'}}"
                      id="logo"
                      class="rounded me-2 mb-1 mb-md-0"
                      width="320"
                      height="180"
                      alt="Slide Image"
                    />
                    <div class="featured-info">
                      <div class="d-inline-block">
                        <input class="form-control" type="file" id="imageLogo" name="upload_file" accept="image/*" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-6 col-md-12">
                <label class="form-label" for="button_text">Button Text</label>
                <input type="text" class="form-control" id="button_text" name="button_text" value="{{ $entry->button_text }}" />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-xl-6 col-md-12">
                <label class="form-label" for="button_link">Button Link</label>
                <input type="text" class="form-control" id="button_link" name="button_link" value="{{ $entry->button_link }}" />
              </div>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary me-1">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('page-script')
<script>
  imageLogo.onchange = evt => {
    const [file] = imageLogo.files
    if (file) {
      logo.src = URL.createObjectURL(file)
    }
  }
</script>
@endsection
