
@extends('layouts/contentLayoutMaster')

@section('title', 'Create')

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

<section>
  {{ Form::model($product, array('route' => array('shopproducts.digital.update', $product->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
    @csrf
    <div class="d-flex justify-content-between">
      <h4 class="card-title">Edit Digital Product</h4>
      <div class="mb-1">
        <button type="submit" class="btn btn-primary me-1">Save</button>
        <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Discard</button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-xl-6">
        <div id="dropContainer" class="card">
          <div class="card-body">
            <div class="row mb-1">
              <div class="col-12 mb-1">
                <label class="form-label" for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $product->title }}" required />
              </div>
              <div class="col-6 mb-1">
                <label class="form-label" for="title">Make</label>
                <input type="text" class="form-control" id="make" name="make" value="{{ $product->digital->make }}" required />
              </div>
              <div class="col-6">
                <label class="form-label" for="title">Model</label>
                <input type="text" class="form-control" id="model" name="model" value="{{ $product->digital->model }}" required />
              </div>
              <div class="col-6 mb-1">
                <label class="form-label" for="title">Engine Code</label>
                <input type="text" class="form-control" id="engine_code" name="engine_code" value="{{ $product->digital->engine_code }}" required />
              </div>
              <div class="col-6">
                <label class="form-label" for="title">Engine Displacement</label>
                <input type="text" class="form-control" id="engine_displacement" name="engine_displacement" value="{{ $product->digital->engine_displacement }}" required />
              </div>
              <div class="col-12 mb-1">
                <label class="form-label" for="title">Horsepower Stock</label>
                <input type="text" class="form-control" id="hp_stock" name="hp_stock" value="{{ $product->digital->hp_stock }}" required />
              </div>
              <div class="col-12 mb-1">
                <label class="form-label" for="ecu_make">ECU Make</label>
                <input type="text" class="form-control" id="ecu_make" name="ecu_make" value="{{ $product->digital->ecu_make }}" required />
              </div>
              <div class="col-12 mb-1">
                <label class="form-label" for="ecu_model">ECU Model</label>
                <input type="text" class="form-control" id="ecu_model" name="ecu_model" value="{{ $product->digital->ecu_model }}" required />
              </div>
              <div class="col-6 mb-1">
                <label class="form-label" for="title">Software Version</label>
                <input type="text" class="form-control" id="software_version" name="software_version" value="{{ $product->digital->software_version }}" required />
              </div>
              <div class="col-6">
                <label class="form-label" for="title">Software Number</label>
                <input type="text" class="form-control" id="software_number" name="software_number" value="{{ $product->digital->software_number }}" required />
              </div>
              <div class="col-6 mb-1">
                <label class="form-label" for="title">Hardware Version</label>
                <input type="text" class="form-control" id="hardware_version" name="hardware_version" value="{{ $product->digital->hardware_version }}" required />
              </div>
              <div class="col-6 mb-1">
                <label class="form-label" for="title">Checksum</label>
                <input type="text" class="form-control" id="checksum" name="checksum" value="{{ $product->digital->checksum }}" required />
              </div>
              <div class="col-12 mb-1">
                <label class="form-label" for="title">Tuning Tool</label>
                <input type="text" class="form-control" id="tuning_tool" name="tuning_tool" value="{{ $product->digital->tuning_tool }}" required />
              </div>
              <div class="col-12">
                <div style="margin-bottom: 2px; cursor: pointer">
                  <label for="document" class="form-label">File</label>
                  <div class="input-group" onclick="onUpload()">
                    <span class="input-group-text">Choose File</span>
                    <input
                      type="text"
                      class="form-control"
                      id="file_name"
                      name="file_name"
                      readonly />
                    <input
                      type="hidden"
                      class="form-control"
                      id="document"
                      name="document"
                      readonly />
                  </div>
                </div>
                <div class="progress progress-bar-{{ substr($styling['navbarColor'], 3) }}" style="display: none">
                  <div
                    class="progress-bar progress-bar-striped progress-bar-animated"
                    role="progressbar"
                    aria-valuenow="0"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <span class="text-danger">Drag and drop file here</span>
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
              <input class="form-check-input" type="checkbox" id="live_check" name="live" value="1" @if($product->live) checked @endif/>
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
                <label class="form-label" for="price">Price({{ $currencyCode }})</label>
                <input type="number" class="form-control" id="price" name="price" step=".01" value="{{ $product->price }}" required />
              </div>
            </div>
            <div class="row mb-1">
              <div class="col-12">
                <label class="form-label" for="description">Description</label>
                <textarea type="text" class="form-control" id="description" name="description" required>{{ $product->description }}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="image" id="documents">
    <div class="mb-1">
      <button type="submit" class="btn btn-primary me-1">Save</button>
      <button type="button" class="btn btn-flat-secondary me-1" onclick="history.back(-1)">Discard</button>
    </div>
  {{ Form::close() }}
  {{ Form::open(array('id' => 'uploadForm', 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
    <input type="file" name="file" id="hidden_upload" style="display: none" />
  {{ Form::close() }}
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
    let product_images = []
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
    // upload product file
    function onUpload() {
      $('#hidden_upload').trigger('click');
    }
    function submitFile() {
      const [file] = hidden_upload.files
      if (file) {
        $('#file_name').val(file.name)
        $("#uploadForm").submit();
      }
    }
    dropContainer.ondragover = dropContainer.ondragenter = function(evt) {
      evt.preventDefault()
    }
    dropContainer.ondrop = function(evt) {
      const dT = new DataTransfer();
      dT.items.add(evt.dataTransfer.files[0]);
      hidden_upload.files = dT.files
      evt.preventDefault()
      submitFile()
    }
    hidden_upload.onchange = evt => {
      submitFile()
    }
    $("#uploadForm").on('submit', function(e){
      e.preventDefault();
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
        url: "{{ route('api.upload.product.digital') }}",
        data: new FormData(this),
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
            $('#uploadForm')[0].reset();
            $('#document').val(resp.file);
          }else{
          }
        }
      });
    })
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
