
@extends('layouts/contentLayoutMaster')

@section('title', 'Create')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

<section>
  <form action="{{ route('shopproducts.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="d-flex justify-content-between">
      <h4 class="card-title">Add a Product</h4>
      <div class="mb-1">
        <button type="submit" class="btn btn-primary me-1">Save</button>
        <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Discard</button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-xl-7">
        <div class="card">
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="name">Title</label>
                <input type="text" class="form-control" id="name" name="name" required />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" required />
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-12 mb-1">
                <div class="border rounded p-1" id="thumbnail-wrapper">
                  <label class="form-label mb-1">Product Thumbnail</label>
                  <div class="d-flex flex-column flex-md-row">
                    <img
                      src="https://via.placeholder.com/250x110.png?text=Thumbnail"
                      id="img_thumbnail"
                      class="rounded me-2 mb-1 mb-md-0"
                      alt="Thumbnail"
                      style="max-width: 250px; max-height: 110px; width: auto; height: auto; border: 1px solid #00000020"
                    />
                    <div class="featured-info">
                      <div class="d-inline-block">
                        <input
                          class="form-control"
                          type="file"
                          id="file_thumbnail"
                          name="style_background_file"
                          accept="image/*"
                          style="display: none" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12 mb-1">
                <div class="border rounded p-1" id="product-images-wrapper">
                  <label class="form-label mb-1">Product Images</label>
                  <div class="d-flex flex-row flex-wrap" id="images-wrapper">

                  </div>
                  <div class="featured-info">
                    <div class="d-inline-block">
                      <input
                        class="form-control"
                        type="file"
                        id="file_images"
                        name="file_images"
                        accept="image/*"
                        multiple
                        style="display: none" />
                    </div>
                  </div>
                  <div class="progress progress-bar-{{ substr($styling['navbarColor'], 3) }} mt-1" style="display: none">
                    <div
                      class="progress-bar progress-bar-striped progress-bar-animated"
                      role="progressbar"
                      aria-valuenow="0"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                  <img
                    src=""
                    id="empty-image"
                    class="rounded me-2 my-1"
                    alt="Logo Image"
                    style="max-width: 250px; max-height: 110px; width: auto; height: auto; display: none; border: 1px solid #00000020"
                  />
                </div>
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="details">Long Description</label>
                <textarea
                  class="form-control"
                  id="details"
                  rows="3"
                  name="details"
                ></textarea>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-md-12 col-xl-5">
        <div class="card">
          <div class="card-header">
            <label class="form-label" for="name">Product Availability</label>
            <div class="form-check form-check-inline">
              <input type="hidden" name="open_check" value="0" />
              <input class="form-check-input" type="checkbox" id="open_check" name="open_check" value="1" @if($company->open_check) checked @endif/>
              <label class="form-check-label" for="open_check">Live</label>
            </div>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="category">Category</label>
                <select class="form-select" id="category" name="category">
                  <option value="">-Select Product Category-</option>
                  @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="price">Price({{ config('constants.currency_signs')[$company->paypal_currency_code] }})</label>
                <input type="number" class="form-control" id="price" name="price" required />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="documents" id="documents">
    <div class="mb-1">
      <button type="submit" class="btn btn-primary me-1">Save</button>
      <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Discard</button>
    </div>
  </form>
</section>

@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js'))}}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  <script type="text/javascript">
    let product_images = []
    $('#thumbnail-wrapper').click(function(ev) {
      $('#file_thumbnail').click();
    })
    $('#product-images-wrapper').click(function(ev) {
      $('#file_images').click();
    })
    $('#file_thumbnail').click(function(ev) {
      ev.stopPropagation();
    })
    $('#file_images').click(function(ev) {
      ev.stopPropagation();
    })
    file_thumbnail.onchange = evt => {
      const [file] = file_thumbnail.files
      if (file) {
        img_thumbnail.src = URL.createObjectURL(file)
      }
    }
    file_images.onchange = evt => {
      const formData = new FormData()
      const files = file_images.files
      formData.append( "_token", "{{ csrf_token() }}" );
      for (let i = 0; i < files.length; ++i) {
        var newImage = $('#empty-image').clone()
        $(newImage).attr('src', URL.createObjectURL(files[i]));
        $(newImage).attr('id', '');
        $(newImage).css('display', 'block');
        $('#images-wrapper').append(newImage);
        formData.append('files['+i+']', files[i])
      }
      $.ajax({
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = Math.round((evt.loaded / evt.total) * 100);
              $(".progress-bar").width(percentComplete + '%');
              $(".progress-bar").html(percentComplete+'%');
            }
          }, false);
          return xhr;
        },
        type: 'POST',
        url: "{{ route('shopproducts.files.api') }}",
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
          $(".progress-bar").width('0%');
          $(".progress").show();
        },
        error:function(){

        },
        success: function(resp){
          if(resp.status){
            product_images = product_images.concat(resp.files)
            console.log(product_images)
            setTimeout(() => {
              $(".progress").hide();
            }, 2000);
          }else{
          }
        }
      });
    }
    $(document).ready(function () {
      CKEDITOR.replace('details');
    });
  </script>
@endsection
