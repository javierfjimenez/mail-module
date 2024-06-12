@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

@section('vendor-style')
{{-- Page Css files --}}

<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-email.css')) }}">

<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection
<!-- Sidebar Area -->
@section('content-sidebar')
@include('content/apps/menu-sidebar/app-email-sidebar')
@endsection

@section('content')
<div class="body-content-overlay"></div>
<!-- users list start -->
<section class="app-user-list">
  <!-- list and filter start -->
  <div class="card">

    <div class="pt-0 card-datatable table-responsive">
      <table class="table user-list-table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- Modal to add new user starts-->
    <div class="modal modal-slide-in new-user-modal fade" data-bs-backdrop="static" id="modals-slide-in">
      <div class="modal-dialog">
        <form id="contactForm" class="pt-0 add-new-user modal-content" action="{{url('/contact/store')}}">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="mb-1 modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear Contacto</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Nombre</label>
              <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="John Doe" name="name" />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-email">Email</label>
              <input type="text" id="basic-icon-default-email" class="form-control dt-email" placeholder="john.doe@example.com" name="email" />
            </div>
            <div class="mb-1">
                <label class="form-label" for="contact-status">Estatus</label>
                <select name="status" id="contact-status" class="form-select">
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-primary me-1 data-submit">Guardar</button>
              <button id="cancel-user-create" type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
      </div>
      <input id="contact_id" name="contact_id" type="hidden" value="">
      <input class="csrf_token" type="hidden" value="{{csrf_token()}}">
      </form>
    </div>
  </div>
  <!-- Modal to add new user Ends-->
  </div>
  <!-- list and filter end -->
</section>
<!-- users list ends -->

@endsection

@section('vendor-script')
{{-- Vendor js files --}}
<script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
@endsection

@section('page-script')
{{-- Page js files --}}
<script src="{{ asset(mix('js/scripts/pages/app-email.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/pages/app-contact-list.js')) }}"></script>

<script>
  $("#contactForm").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var actionUrl = form.attr('action');

    $.ajax({
      type: "POST",
      url: actionUrl,
      data: form.serialize(), // serializes the form's elements.
      headers: {
        'X-CSRF-TOKEN': $('.csrf_token').val()
      },
      success: function(data) {
        location.reload();
        //alert(data); // show response from the php script.
      }
    });

  });

  function update(id) {
    $.get(window.location.origin + '/api/contacts/' + id, (data, status) => {
      $('#basic-icon-default-fullname').val(data.full_name);
      $('#basic-icon-default-email').val(data.email);
      $('#contact_id').val(data.id);
      $('#modals-slide-in').modal('show');
    });
  }

  function remove(id) {
    $.post(window.location.origin + '/api/contact/remove', {
      id: id
    }, (data, status) => {
      console.log(data)
    });
  }
</script>
@endsection
