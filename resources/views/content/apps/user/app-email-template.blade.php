@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

@section('vendor-style')
{{-- Archivos CSS de proveedores --}}

{{-- Definimos un array con los archivos CSS de proveedores --}}
@php
    $vendorCssFiles = [
        'vendors/css/editors/quill/katex.min.css',
        'vendors/css/editors/quill/monokai-sublime.min.css',
        'vendors/css/editors/quill/quill.snow.css',
        'vendors/css/forms/select/select2.min.css',
        'vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
        'vendors/css/tables/datatable/responsive.bootstrap5.min.css',
        'vendors/css/tables/datatable/buttons.bootstrap5.min.css',
        'vendors/css/tables/datatable/rowGroup.bootstrap5.min.css'
    ];
@endphp

{{-- Iteramos sobre el array y agregamos cada archivo CSS --}}
@foreach ($vendorCssFiles as $cssFile)
    <link rel="stylesheet" href="{{ asset(mix($cssFile)) }}">
@endforeach
@endsection

@section('page-style')
{{-- Archivos CSS específicos de la página --}}

{{-- Definimos un array con los archivos CSS específicos de la página --}}
@php
    $pageCssFiles = [
        'css/base/pages/app-email.css',
        'css/base/plugins/forms/form-quill-editor.css',
        'css/base/plugins/extensions/ext-component-toastr.css',
        'css/base/plugins/forms/form-validation.css'
    ];
@endphp

{{-- Iteramos sobre el array y agregamos cada archivo CSS --}}
@foreach ($pageCssFiles as $cssFile)
    <link rel="stylesheet" href="{{ asset(mix($cssFile)) }}">
@endforeach
@endsection

@section('content-sidebar')
    {{-- Incluimos la barra lateral específica de la aplicación --}}
    @include('content/apps/menu-sidebar/app-email-sidebar')
@endsection

@section('content')
{{-- Estilos CSS específicos dentro del contenido --}}
<style>
  .my_scroll_div {
    overflow-y: scroll;
    max-height: 600px;
    resize: none;
  }
</style>

<div class="body-content-overlay"></div>

<!-- users list start -->
<section class="app-user-list">
  <!-- list and filter start -->
  <div class="card">
    <div class="pt-0 card-datatable table-responsive my_scroll_div d-flex justify-content-center" style="margin-bottom:15rem!important;">
      <br />
      {{-- Formulario para guardar plantillas de correo electrónico --}}
      <form id="emailTemplateForm" method="post" action="{{ url('api/email/template/store') }}" class="mb-3">
        {{-- Botón para guardar el formulario --}}
        <div class="my-2 d-flex justify-content-end">
          <button type="submit" class="btn btn-primary me-1 data-submit">Guardar</button>
        </div>
        {{-- Campo de entrada para el email del remitente --}}
        <div class="mb-3">
          <label class="form-label" for="contact">Enviado por:</label>
          <input type="text" id="contact" name="email" class="form-control" placeholder="john@doe.com" value="{{ $email }}">
        </div>
        {{-- Editor de texto para la plantilla del correo electrónico --}}
        <div class="">
          <label class="form-label" for="ck-editor">Plantilla:</label>
          <textarea name="template" id="ck-editor" cols="100" rows="30">{!! html_entity_decode($emailTemplate) !!}</textarea>
        </div>
        <div class="body-content-overlay"></div>
      </form>
    </div>
  </div>
</section>
<!-- users list ends -->
@endsection

@section('vendor-script')
{{-- Archivos JS de proveedores --}}

{{-- Definimos un array con los archivos JS de proveedores --}}
@php
    $vendorJsFiles = [
        'vendors/js/editors/quill/katex.min.js',
        'vendors/js/editors/quill/highlight.min.js',
        'vendors/js/editors/quill/quill.min.js',
        'vendors/js/forms/select/select2.full.min.js',
        'vendors/js/tables/datatable/jquery.dataTables.min.js',
        'vendors/js/tables/datatable/dataTables.bootstrap5.min.js',
        'vendors/js/tables/datatable/dataTables.responsive.min.js',
        'vendors/js/tables/datatable/responsive.bootstrap5.js',
        'vendors/js/tables/datatable/datatables.buttons.min.js',
        'vendors/js/tables/datatable/jszip.min.js',
        'vendors/js/tables/datatable/pdfmake.min.js',
        'vendors/js/tables/datatable/vfs_fonts.js',
        'vendors/js/tables/datatable/buttons.html5.min.js',
        'vendors/js/tables/datatable/buttons.print.min.js',
        'vendors/js/tables/datatable/dataTables.rowGroup.min.js',
        'vendors/js/forms/validation/jquery.validate.min.js',
        'vendors/js/forms/cleave/cleave.min.js',
        'vendors/js/forms/cleave/addons/cleave-phone.us.js'
    ];
@endphp

{{-- Iteramos sobre el array y agregamos cada archivo JS --}}
@foreach ($vendorJsFiles as $jsFile)
    <script src="{{ asset(mix($jsFile)) }}"></script>
@endforeach
@endsection

@section('page-script')
{{-- Archivos JS específicos de la página --}}

{{-- Definimos un array con los archivos JS específicos de la página --}}
@php
    $pageJsFiles = [
        'js/scripts/pages/app-user-list.js',
        'js/scripts/pages/app-email.js'
    ];
@endphp

{{-- Iteramos sobre el array y agregamos cada archivo JS --}}
@foreach ($pageJsFiles as $jsFile)
    <script src="{{ asset(mix($jsFile)) }}"></script>
@endforeach

{{-- Script para inicializar y manejar formularios y funciones específicas --}}
<script>
  $(document).ready(function() {
    // Inicialización del editor de texto
    new nicEditor({ fullPanel: true }).panelInstance('ck-editor');

    // Manejo del envío del formulario de plantilla de email
    $("#emailTemplateForm").submit(function(e) {
      e.preventDefault(); // Evita la ejecución del submit real
      var form = $(this);
      var actionUrl = form.attr('action');

      // Envío de datos del formulario mediante AJAX
      $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), // Serializa los elementos del formulario
        headers: {
          'X-CSRF-TOKEN': $('.csrf_token').val()
        },
        success: function(data) {
          location.reload(); // Recarga la página después de una operación exitosa
        }
      });
    });

    // Función para actualizar un usuario
    function update(id) {
      $.get(window.location.origin + '/api/users/' + id, (data) => {
        $('#basic-icon-default-fullname').val(data.full_name);
        $('#basic-icon-default-email').val(data.email);
        $('#user_id').val(data.id);
        $('#modals-slide-in').modal('show');
      });
    }

    // Función para eliminar un usuario
    function remove(id) {
      $.post(window.location.origin + '/api/user/remove', { id: id }, (data) => {
        console.log(data)
      });
    }

    // Manejo del envío del formulario de composición de mensajes
    $("#composeForm").submit(function(e) {
      e.preventDefault(); // Evita la ejecución del submit real
      var form = $(this);
      var actionUrl = form.attr('action');

      // Envío de datos del formulario mediante AJAX
      $.ajax({
        type: "POST",
        url: actionUrl,
        data: new FormData(this),
        dataType: "json",
        processData: false,
        contentType: false,
        headers: {
          "Accept": "application/json",
          'X-CSRF-TOKEN': $('.csrf_token').val()
        },
        success: function(data) {
           location.reload(); // recargar la página después de enviar el formulario
        }
      });
    });
  });
</script>
@endsection
