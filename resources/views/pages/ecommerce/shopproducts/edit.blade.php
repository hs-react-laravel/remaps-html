
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css'))}}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
@endsection

@section('content')
@php
  $route_prefix = "";
  if ($user->is_semi_admin) {
    $route_prefix = "staff.";
  }
@endphp
<section>
  {{ html()->form($entry, 'PUT', route('shopproducts.update', ['shopproduct' => $entry->id]))->acceptsFiles()->open() }}
    @csrf
    <div class="d-flex justify-content-between">
      <h4 class="card-title">Edit Product</h4>
      <div class="mb-1">
        <button type="submit" class="btn btn-primary me-1">Save</button>
        <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Discard</button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-xl-6">
        <div class="card">
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $entry->title }}" required />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="description">Description</label>
                <textarea type="text" class="form-control" id="description" name="description" required>{{ $entry->description }}</textarea>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col-12 mb-1">
                <div class="border rounded p-1" id="thumbnail-wrapper">
                  <label class="form-label mb-1">Product Thumbnail</label>
                  <div class="d-flex flex-column flex-md-row">
                    <img
                      src="{{
                        $entry->thumb ? asset('storage/uploads/products/thumbnails/'.$entry->thumb) : 'https://via.placeholder.com/250x110.png?text=Thumbnail'
                      }}"
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
                          name="thumb_image"
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
                <div class="border rounded p-1 product-images-wrapper" id="product-images-wrapper">
                  <label class="form-label mb-1">Product Images</label>
                  <div class="d-flex flex-row flex-wrap" id="images-wrapper">
                    @php
                      $images = explode(',', $entry->image)
                    @endphp
                    @foreach ($images as $image)
                      <div style="position: relative" class="empty-image-container">
                        <div style="position: absolute; top: 5px; right: 5px" class="remove-product-image">
                          <i data-feather='x'></i>
                        </div>
                        <img
                          src="{{ asset('storage/uploads/products/'.$image) }}"
                          class="rounded me-2 my-1"
                          alt="Logo Image"
                          style="max-width: 250px; max-height: 110px; width: auto; height: auto; border: 1px solid #00000020;"
                        />
                      </div>
                    @endforeach
                  </div>
                  <div class="d-flex justify-content-center">
                    <div type="button" class="btn btn-primary" id="btn-add-product-image">
                      Add Image
                    </div>
                  </div>
                  <div>
                    <input
                      class="form-control"
                      type="file"
                      id="file_images"
                      name="file_images"
                      accept="image/*"
                      multiple
                      style="display: none" />
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
                  <div id="empty-image-container" style="display: none; position: relative" class="empty-image-container">
                    <div style="position: absolute; top: 5px; right: 5px" class="remove-product-image">
                      <i data-feather='x'></i>
                    </div>
                    <img
                      src=""
                      class="rounded me-2 my-1"
                      alt="Logo Image"
                      style="max-width: 250px; max-height: 110px; width: auto; height: auto; border: 1px solid #00000020;"
                    />
                  </div>
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
                >{{ $entry->details }}</textarea>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-md-12 col-xl-6">
        <div class="card">
          <div class="card-header">
            <label class="form-label" for="name">Product Availability</label>
            <div class="form-check form-check-inline">
              <input type="hidden" name="live" value="0" />
              <input
                class="form-check-input"
                type="checkbox"
                id="live_check"
                name="live"
                value="1"
                @if($entry->live) checked @endif/>
              <label class="form-check-label" for="live_check">Live</label>
            </div>
          </div>
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="category">Category</label>
                <input type="hidden" name="category_id" id="category_id">
                <div class="card-body">
                  <div id="jstree-basic"></div>
                </div>
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="brand">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" value="{{ $entry->brand }}" required />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="price">Price({{ $currencyCode }})</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $entry->price }}" step=".01" required />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ $entry->stock }}" required />
              </div>
            </div>
            <hr />
            <div class="row mb-1">
              <label class="form-label">SKU</label>
              <div class="sku-table-wrapper">
                @foreach ($entry->sku as $i => $sku)
                  <div class="mt-1 sku-table-div">
                    <div class="d-flex">
                      <div class="col-6 px-1">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="sku_names[]" value="{{ $sku->title }}" required />
                        <input type="hidden" name="sku_ids[]" value="{{ $sku->id }}" />
                      </div>
                      <div class="col-6 px-1">
                        <label class="form-label">Type</label>
                        <select class="form-control" name="sku_types[]">
                          <option value="option" @if($sku->type == 'option') selected @endif>Single Choice</option>
                          <option value="check" @if($sku->type == 'check') selected @endif>Multiple Choice</option>
                        </select>
                      </div>
                    </div>
                    <table class="table mt-1">
                      <thead>
                        <tr>
                          <th width="75%">Name</th>
                          <th width="20%">Price</th>
                          <th width="5%"></th>
                        </tr>
                      </thead>
                      <tbody class="sku-body">
                        @foreach ($sku->items as $j => $sitem)
                          <tr>
                            <td style="padding: 1px">
                              <input type="text" name="sku_items[{{$i}}][]" class="form-control" value="{{ $sitem->title }}" />
                            </td>
                            <td style="padding: 1px">
                              <input type="number" name="sku_prices[{{$i}}][]" step=".01" class="form-control" value="{{ $sitem->price }}" />
                            </td>
                            <td style="padding: 1px">
                              <input type="hidden" name="sku_item_ids[{{$i}}][]" value="{{ $sitem->id }}">
                              <button class="btn btn-danger" type="button" onclick="onTableRowDelete(this)">-</button>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-1">
                      <button type="button" class="btn btn-danger me-1" onclick="onSKUDelete(this)">Remove SKU</button>
                      <button type="button" class="btn btn-primary" onclick="onSKUItemAdd(this)">Add Item</button>
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="d-flex mt-1">
                <button type="button" class="btn btn-primary" style="width: 200px" onclick="onSKUAdd()">Add SKU</button>
              </div>
            </div>
            <hr />
            <div class="row mb-1">
              <label class="form-label">Shipping Options</label>
              <div class="shipping-table-wrapper">
                <table class="table mt-1">
                  <thead>
                    <tr>
                      <th width="75%">Name</th>
                      <th width="20%">Price</th>
                      <th width="5%"></th>
                    </tr>
                  </thead>
                  <tbody class="shipping-body">
                    @foreach ($entry->shipping as $shippingItem)
                    <tr>
                      <td style="padding: 1px">
                        <input type="text" name="shipping_items[]" class="form-control" value="{{ $shippingItem->option }}" />
                      </td>
                      <td style="padding: 1px">
                        <input type="number" name="shipping_prices[]" step=".01" class="form-control" value="{{ $shippingItem->price }}" />
                      </td>
                      <td style="padding: 1px">
                        <input type="hidden" name="shipping_ids[]" step=".01" class="form-control" value="{{ $shippingItem->id }}" />
                        <button class="btn btn-danger" type="button" onclick="onTableRowDelete(this)">-</button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="d-flex mt-1">
                <button type="button" class="btn btn-primary" style="width: 200px" onclick="onShippingAdd()">Add Option</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="image" id="documents" value="{{ $entry->image }}">
    <div class="mb-1">
      <button type="submit" class="btn btn-primary me-1">Save</button>
      <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Discard</button>
    </div>
  {{ html()->form()->close() }}
</section>

@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js'))}}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  <script type="text/javascript">
    let product_images = <?php echo json_encode($images) ?>;
    function onAdAdd() {
      $('#ad-body').append(`
        <tr>
          <td style="padding: 1px">
            <input type="text" name="ad_titles[]" class="form-control" />
          </td>
          <td style="padding: 1px">
            <input type="text" name="ad_contents[]" class="form-control" />
          </td>
          <td style="padding: 1px">
            <button class="btn btn-danger" type="button" onclick="onTableRowDelete(this)">-</button>
          </td>
        </tr>
      `)
    }
    function onSKUAdd() {
      $('.sku-table-wrapper').append(`
        <div class="mt-1 sku-table-div">
          <div class="d-flex">
            <div class="col-6 px-1">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" name="sku_names[]" required />
              <input type="hidden" name="sku_ids[]" value="0" />
            </div>
            <div class="col-6 px-1">
              <label class="form-label">Type</label>
              <select class="form-control" name="sku_types[]">
                <option value="option">Single Choice</option>
                <option value="check">Multiple Choice</option>
              </select>
            </div>
          </div>
          <table class="table mt-1">
            <thead>
              <tr>
                <th width="75%">Name</th>
                <th width="20%">Price</th>
                <th width="5%"></th>
              </tr>
            </thead>
            <tbody class="sku-body">

            </tbody>
          </table>
          <div class="d-flex justify-content-end mt-1">
            <button type="button" class="btn btn-danger me-1" onclick="onSKUDelete(this)">Remove SKU</button>
            <button type="button" class="btn btn-primary" onclick="onSKUItemAdd(this)">Add Item</button>
          </div>
        </div>
      `)
    }
    function onSKUItemAdd(obj) {
      const tdiv = $(obj).closest('.sku-table-div')
      const tbody = $(tdiv).find('.sku-body')
      const idx = $('.sku-table-div').index(tdiv)
      tbody.append(`
        <tr>
          <td style="padding: 1px">
            <input type="text" name="sku_items[${idx}][]" class="form-control" />
          </td>
          <td style="padding: 1px">
            <input type="number" name="sku_prices[${idx}][]" step=".01" class="form-control" />
          </td>
          <td style="padding: 1px">
            <input type="hidden" name="sku_item_ids[${idx}][]" value="0">
            <button class="btn btn-danger" type="button" onclick="onTableRowDelete(this)">-</button>
          </td>
        </tr>
      `)
    }
    function onShippingAdd(obj) {
      const tbody = $('.shipping-body')
      tbody.append(`
        <tr>
          <td style="padding: 1px">
            <input type="text" name="shipping_items[]" class="form-control" />
          </td>
          <td style="padding: 1px">
            <input type="number" name="shipping_prices[]" step=".01" class="form-control" />
          </td>
          <td style="padding: 1px">
            <input type="hidden" name="shipping_ids[]" value="0">
            <button class="btn btn-danger" type="button" onclick="onTableRowDelete(this)">-</button>
          </td>
        </tr>
      `)
    }
    function onSKUDelete(obj) {
      const skuTableDiv = $(obj).closest('.sku-table-div')
      skuTableDiv.remove()
      $('.sku-table-div').each((idx, div) => {
        const inputs = $(div).find('.sku-body tr input')
        $(inputs[0]).attr('name', `sku_items[${idx}][]`)
        $(inputs[1]).attr('name', `sku_prices[${idx}][]`)
      })
    }
    function onTableRowDelete(obj) {
      $(obj).closest('tr').remove()
    }
    $('#thumbnail-wrapper').click(function(ev) {
      $('#file_thumbnail').click();
    })
    $('#btn-add-product-image').click(function(ev) {
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
    $('body').on('click', '.remove-product-image', function(ev) {
      console.log(product_images)
      const idx = $('.remove-product-image').index(this)
      product_images.splice(idx, 1)
      $('#documents').val(product_images.join(','))
      $(this).parent().remove();
    })
    file_images.onchange = evt => {
      const formData = new FormData()
      const files = file_images.files
      if (files.length === 0) return
      formData.append( "_token", "{{ csrf_token() }}" );
      for (let i = 0; i < files.length; ++i) {
        var imageWrapper = $('#empty-image-container').clone()
        $(imageWrapper).attr('id', '');
        $(imageWrapper).css('display', 'block');
        var newImage = $(imageWrapper).find('img');
        $(newImage).attr('src', URL.createObjectURL(files[i]));
        $('#images-wrapper').append(imageWrapper);
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
        url: "{{ route($route_prefix.'shopproducts.files.api') }}",
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
          $(".progress-bar").width('0%');
          $(".progress").show();
        },
        error:function(){
          setTimeout(() => {
            $(".progress").hide();
          }, 2000);
        },
        success: function(resp){
          if(resp.status){
            product_images = product_images.concat(resp.files)
            $('#documents').val(product_images.join(','))
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
    var treeBasic = $('#jstree-basic')
    var data = @json($categoryTree);
    var treeObj;
    var selectedNode;
    if (treeBasic.length) {
      initTree(data)
    }
    function initTree(data) {
      treeObj = treeBasic.jstree({
        core: {
          check_callback: true,
          data: data
        },
        types: {
          default: {
            icon: 'far fa-folder'
          },
          html: {
            icon: 'fab fa-html5 text-danger'
          },
          css: {
            icon: 'fab fa-css3-alt text-info'
          },
          img: {
            icon: 'far fa-file-image text-success'
          },
          js: {
            icon: 'fab fa-node-js text-warning'
          }
        }
      });
    }
    $('#jstree-basic').on('changed.jstree', function (e, data) {
      if (data.action == "select_node") {
        selectedNode = data.node
        $('#category_id').val(selectedNode.id)
      }
    })
  </script>
@endsection
