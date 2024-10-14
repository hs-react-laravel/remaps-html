@extends('layouts/contentLayoutMaster')

@section('title', 'Tree')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('fonts/font-awesome/css/font-awesome.min.css'))}}">
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
<section class="context-drag-drop-tree">
  <div class="row">
    <!-- Drag & Drop Tree -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Shop categories</h4>
          <div>
            <button type="button" class="btn btn-icon btn-primary" onclick="onNew()">
              New
            </button>
            <button id="btn-delete" type="button" class="btn btn-icon btn-danger" disabled onclick="onDelete()">
              Delete
            </button>
          </div>
        </div>
        <div class="card-body">
          <div id="jstree-drag-drop"></div>
        </div>
      </div>
    </div>
    <!--/ Drag & Drop Tree -->
  </div>
</section>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script>
    var dragDrop = $('#jstree-drag-drop')
    var data = @json($tree);
    var treeObj;
    var selectedNode;
    if (dragDrop.length) {
      initTree(data)
    }

    function initTree(data) {
      treeObj = dragDrop.jstree({
        core: {
          check_callback: true,
          data: data
        },
        plugins: ['types', 'dnd'],
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

    $('#jstree-drag-drop').on('changed.jstree', function (e, data) {
      if (data.action == "select_node") {
        selectedNode = data.node
        if (selectedNode.id != 1 && selectedNode.id != 2)
        $('#btn-delete').prop('disabled', false);
      }
    })

    $(document).on('dnd_stop.vakata', function (e, obj) {
      setTimeout(() => {
        const nodeIDs = obj.data.nodes;
        const firstNode = dragDrop.jstree().get_node(nodeIDs[0]);
        $.ajax({
          type: 'POST',
          url: "{{ route($route_prefix.'api.shop.movecategory') }}",
          data: {
            parent_category: obj.data.origin._model.data[nodeIDs[0]].parent,
            ids: obj.data.nodes
          },
          success: function(result) {
            console.log('moved')
          }
        })
      }, 500);
    })

    async function onNew() {
      if (!selectedNode) {
        return;
      }
      const { value } = await Swal.fire({
        title: 'Category Name',
        input: 'text'
      })
      if (!value) return
      $.ajax({
        type: 'POST',
        url: "{{ route($route_prefix.'api.shop.createcategory') }}",
        data: {
          company_id: '{{ $company->id }}',
          parent_category: selectedNode.id,
          name: value
        },
        success: function(result) {
          dragDrop.jstree(true).settings.core.data = result;
          dragDrop.jstree(true).refresh();
        }
      })
    }
    async function onDelete() {
      var swal_result = await Swal.fire({
        title: 'Warning!',
        text: 'Are you sure to delete?',
        icon: 'warning',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        buttonsStyling: false
      });
      if (swal_result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: "{{ route($route_prefix.'api.shop.deletecategory') }}",
          data: {
            company_id: '{{ $company->id }}',
            id: selectedNode.id
          },
          success: function(result) {
            dragDrop.jstree(true).settings.core.data = result;
            dragDrop.jstree(true).refresh();
          }
        })
      }
    }
  </script>
@endsection
