@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

@section('vendor-style')
{{-- Archivos CSS de proveedores --}}

@php
    // Definimos los archivos CSS de los proveedores en un array
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

{{-- Recorremos el array para incluir los archivos CSS --}}
@foreach ($vendorCssFiles as $cssFile)
    <link rel="stylesheet" href="{{ asset(mix($cssFile)) }}">
@endforeach
@endsection

@section('page-style')
{{-- Archivos CSS específicos de la página --}}

@php
    // Definimos los archivos CSS específicos de la página en un array
    $pageCssFiles = [
        'css/base/pages/app-email.css',
        'css/base/plugins/forms/form-quill-editor.css',
        'css/base/plugins/extensions/ext-component-toastr.css',
        'css/base/plugins/forms/form-validation.css'
    ];
@endphp

{{-- Recorremos el array para incluir los archivos CSS --}}
@foreach ($pageCssFiles as $cssFile)
    <link rel="stylesheet" href="{{ asset(mix($cssFile)) }}">
@endforeach
@endsection

@section('content-sidebar')
    {{-- Incluir el sidebar del contenido --}}
    @include('content/apps/menu-sidebar/app-email-sidebar')
@endsection

@section('content')
<div class="body-content-overlay"></div>

<!-- Inicio de la lista de usuarios -->
<section class="app-user-list">
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

        <!-- Modal para agregar nuevo contacto -->
        <div class="modal modal-slide-in new-user-modal fade" data-bs-backdrop="static" id="modals-slide-in">
            <div class="modal-dialog">
                <form id="contactForm" class="pt-0 add-new-user modal-content" action="{{ url('/contact/store') }}">
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
                    <input id="contact_id" name="contact_id" type="hidden" value="">
                    <input class="csrf_token" type="hidden" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
        <!-- Fin del modal para agregar nuevo contacto -->
    </div>
</section>
<!-- Fin de la lista de usuarios -->
@endsection

@section('vendor-script')
{{-- Archivos JS de proveedores --}}

@php
    // Definimos los archivos JS de los proveedores en un array
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

{{-- Recorremos el array para incluir los archivos JS --}}
@foreach ($vendorJsFiles as $jsFile)
    <script src="{{ asset(mix($jsFile)) }}"></script>
@endforeach
@endsection

@section('page-script')
{{-- Archivos JS específicos de la página --}}

@php
    // Definimos los archivos JS específicos de la página en un array
    $pageJsFiles = [
        'js/scripts/pages/app-email.js',
        'js/scripts/pages/app-contact-list.js'
    ];
@endphp

{{-- Recorremos el array para incluir los archivos JS --}}
@foreach ($pageJsFiles as $jsFile)
    <script src="{{ asset(mix($jsFile)) }}"></script>
@endforeach

<script>
    $(document).ready(function() {
        // Maneja el envío del formulario de contacto
        $("#contactForm").submit(function(e) {
            e.preventDefault(); // Evita la ejecución del submit real

            var form = $(this);
            var actionUrl = form.attr('action');

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

        // Función para actualizar el contacto
        window.update = function(id) {
            $.get(window.location.origin + '/api/contacts/' + id, function(data) {
                $('#basic-icon-default-fullname').val(data.full_name);
                $('#basic-icon-default-email').val(data.email);
                $('#contact_id').val(data.id);
                $('#modals-slide-in').modal('show'); // Muestra el modal con los datos del contacto
            });
        };

        // Función para eliminar el contacto
        window.remove = function(id) {
            $.post(window.location.origin + '/api/contact/remove', { id: id }, function(data) {
                location.reload(); // Recarga la página después de una operación exitosa
            });
        };

        // Maneja el envío del formulario de redacción
        $("#composeForm").submit(function(e) {
            e.preventDefault(); // Evita la ejecución del submit real

            var form = $(this);
            var actionUrl = form.attr('action');

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
                    location.reload(); // Recarga la página después de una operación exitosa
                }
            });
        });
    });
</script>
@endsection
