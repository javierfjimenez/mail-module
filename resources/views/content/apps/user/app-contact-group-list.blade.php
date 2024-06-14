@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

{{-- Sección de estilos del vendor --}}
@section('vendor-style')
    {{-- Archivos CSS del vendor --}}
    @foreach ([
        'vendors/css/editors/quill/katex.min.css',
        'vendors/css/editors/quill/monokai-sublime.min.css',
        'vendors/css/editors/quill/quill.snow.css',
        'vendors/css/forms/select/select2.min.css',
        'vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
        'vendors/css/tables/datatable/responsive.bootstrap5.min.css',
        'vendors/css/tables/datatable/buttons.bootstrap5.min.css',
        'vendors/css/tables/datatable/rowGroup.bootstrap5.min.css'
    ] as $cssFile)
        <link rel="stylesheet" href="{{ asset(mix($cssFile)) }}">
    @endforeach
@endsection

{{-- Sección de estilos de la página --}}
@section('page-style')
    {{-- Archivos CSS específicos de la página --}}
    @foreach ([
        'css/base/pages/app-email.css',
        'css/base/plugins/forms/form-quill-editor.css',
        'css/base/plugins/extensions/ext-component-toastr.css',
        'css/base/plugins/forms/form-validation.css'
    ] as $cssFile)
        <link rel="stylesheet" href="{{ asset(mix($cssFile)) }}">
    @endforeach
@endsection

{{-- Área de la barra lateral --}}
@section('content-sidebar')
    @include('content/apps/menu-sidebar/app-email-sidebar')
@endsection

{{-- Contenido principal --}}
@section('content')
<div class="body-content-overlay"></div>
<section class="app-user-list">
    <div class="card">
        <div class="pt-0 card-datatable table-responsive">
            <table class="table user-list-table">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>

        {{-- Modal para agregar nuevo grupo --}}
        <div class="modal modal-slide-in new-user-modal fade" data-bs-backdrop="static" id="modals-slide-in">
            <div class="modal-dialog">
                <form id="groupForm" class="pt-0 add-new-user modal-content" action="{{ url('/group/store') }}">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="mb-1 modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Grupo</h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-fullname">Nombre</label>
                            <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="John Doe" name="name" />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="contact">Contacto</label>
                            <select multiple name="contact[]" id="contact" class="select2 form-select">
                                @foreach ($contacts as $contact)
                                    <option value="{{ $contact->id }}">{{ $contact->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="group-status">Estatus</label>
                            <select name="status" id="group-status" class="form-select">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary me-1 data-submit">Guardar</button>
                            <button id="cancel-user-create" type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                    <input id="group_id" name="group_id" type="hidden" value="">
                    <input class="csrf_token" type="hidden" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

{{-- Sección de scripts del vendor --}}
@section('vendor-script')
    {{-- Archivos JS del vendor --}}
    @foreach ([
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
    ] as $jsFile)
        <script src="{{ asset(mix($jsFile)) }}"></script>
    @endforeach
@endsection

{{-- Sección de scripts de la página --}}
@section('page-script')
    {{-- Archivos JS específicos de la página --}}
    @foreach ([
        'js/scripts/pages/app-contact-group-list.js',
        'js/scripts/pages/app-email.js'
    ] as $jsFile)
        <script src="{{ asset(mix($jsFile)) }}"></script>
    @endforeach

    <script>
        $(document).ready(function() {
            // Enviar el formulario de grupo
            $("#groupForm").submit(function(e) {
                e.preventDefault(); // Evitar la ejecución del envío predeterminado del formulario

                var form = $(this);
                var actionUrl = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(), // Serializar los elementos del formulario
                    headers: {
                        'X-CSRF-TOKEN': $('.csrf_token').val()
                    },
                    success: function() {
                        location.reload(); // Recargar la página en caso de éxito
                    }
                });
            });

            // Función para actualizar el grupo
            window.update = function(id) {
                $.get(window.location.origin + '/api/groups/' + id, function(data) {
                    $("#contact").val(data.contacts).change();
                    $('#basic-icon-default-fullname').val(data.full_name);
                    $('#group_id').val(data.id);
                    $('#modals-slide-in').modal('show');
                });
            };

            // Función para eliminar el grupo
            window.remove = function(id) {
                $.post(window.location.origin + '/api/group/remove', { id: id }, function(data) {
                    console.log(data);
                    location.reload(); // Recargar la página en caso de éxito
                });
            };

            // Enviar el formulario de redacción de correos
            $("#composeForm").submit(function(e) {
                e.preventDefault(); // Evitar la ejecución del envío predeterminado del formulario
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
                    success: function() {
                        location.reload(); // Recargar la página en caso de éxito
                    }
                });
            });
        });
    </script>
@endsection
