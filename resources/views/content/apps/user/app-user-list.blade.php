@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

@section('vendor-style')
    {{-- Incluyendo archivos CSS del vendor --}}
    @foreach (['editors/quill/katex.min.css', 'editors/quill/monokai-sublime.min.css', 'editors/quill/quill.snow.css', 'forms/select/select2.min.css', 'tables/datatable/dataTables.bootstrap5.min.css', 'tables/datatable/responsive.bootstrap5.min.css', 'tables/datatable/buttons.bootstrap5.min.css', 'tables/datatable/rowGroup.bootstrap5.min.css'] as $cssFile)
        <link rel="stylesheet" href="{{ asset(mix("vendors/css/$cssFile")) }}">
    @endforeach
@endsection

@section('page-style')
    {{-- Incluyendo archivos CSS de la página --}}
    @foreach (['base/pages/app-email.css', 'base/plugins/forms/form-quill-editor.css', 'base/plugins/extensions/ext-component-toastr.css', 'base/plugins/forms/form-validation.css'] as $cssFile)
        <link rel="stylesheet" href="{{ asset(mix("css/$cssFile")) }}">
    @endforeach
@endsection

<!-- Área de la barra lateral -->
@section('content-sidebar')
    {{-- Incluyendo la barra lateral específica para esta sección --}}
    @include('content/apps/menu-sidebar/app-email-sidebar')
@endsection

@section('content')
    <div class="body-content-overlay"></div>
    <!-- Inicio de la lista de usuarios -->
    <section class="app-user-list">
        <!-- Inicio de la lista y filtros -->
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
            <!-- Inicio del modal para agregar nuevo usuario -->
            <div class="modal modal-slide-in new-user-modal fade" data-bs-backdrop="static" id="modals-slide-in">
                <div class="modal-dialog">
                    <form id="userForm" class="pt-0 add-new-user modal-content" action="{{ url('/users/store') }}">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="mb-1 modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <!-- Campo para nombre completo -->
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">Nombre Completo</label>
                                <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname"
                                    placeholder="John Doe" name="name" />
                            </div>
                            <!-- Campo para email -->
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-email">Email</label>
                                <input type="email" id="basic-icon-default-email" class="form-control dt-email"
                                    placeholder="john.doe@example.com" name="email" />
                            </div>
                            <!-- Campo para contraseña -->
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-password">Contraseña</label>
                                <input type="password" id="basic-icon-default-password" class="form-control"
                                    placeholder="***********" name="password" />
                            </div>
                            <!-- Campo para seleccionar estatus -->
                            <div class="mb-1">
                                <label class="form-label" for="user-status">Estatus</label>
                                <select name="status" id="user-status" class="form-select">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                            <!-- Botones para guardar o cancelar -->
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary me-1 data-submit">Guardar</button>
                                <button id="cancel-user-create" type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                        <input id="user_id" name="user_id" type="hidden" value="">
                        <input class="csrf_token" type="hidden" value="{{ csrf_token() }}">
                    </form>
                </div>
            </div>
            <!-- Fin del modal para agregar nuevo usuario -->
        </div>
        <!-- Fin de la lista y filtros -->
    </section>
    <!-- Fin de la lista de usuarios -->
@endsection

@section('vendor-script')
    {{-- Incluyendo archivos JS del vendor --}}
    @foreach (['editors/quill/katex.min.js', 'editors/quill/highlight.min.js', 'editors/quill/quill.min.js', 'forms/select/select2.full.min.js', 'tables/datatable/jquery.dataTables.min.js', 'tables/datatable/dataTables.bootstrap5.min.js', 'tables/datatable/dataTables.responsive.min.js', 'tables/datatable/responsive.bootstrap5.js', 'tables/datatable/datatables.buttons.min.js', 'tables/datatable/jszip.min.js', 'tables/datatable/pdfmake.min.js', 'tables/datatable/vfs_fonts.js', 'tables/datatable/buttons.html5.min.js', 'tables/datatable/buttons.print.min.js', 'tables/datatable/dataTables.rowGroup.min.js', 'forms/validation/jquery.validate.min.js', 'forms/cleave/cleave.min.js', 'forms/cleave/addons/cleave-phone.us.js'] as $jsFile)
        <script src="{{ asset(mix("vendors/js/$jsFile")) }}"></script>
    @endforeach
@endsection

@section('page-script')
    {{-- Incluyendo archivos JS de la página --}}
    <script src="{{ asset(mix('js/scripts/pages/app-user-list.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-email.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <script>
        // Ejecutar cuando el DOM esté listo
        $(document).ready(function() {
            // Manejar el envío del formulario de usuario
            $("#userForm").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('.csrf_token').val()
                    },
                    success: function() {
                        location.reload();
                    }
                });
            });

            // Manejar el envío del formulario de plantilla de correo electrónico
            $("#emailTemplateForm").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('.csrf_token').val()
                    },
                    success: function() {
                        location.reload();
                    }
                });
            });

            // Función para actualizar el usuario
            function update(id) {
                $.get(window.location.origin + '/api/users/' + id, function(data) {
                    $('#basic-icon-default-fullname').val(data.full_name);
                    $('#basic-icon-default-email').val(data.email);
                    $('#user_id').val(data.id);
                    $('#modals-slide-in').modal('show');
                });
            }

            // Función para eliminar el usuario
            function remove(id) {
                $.post(window.location.origin + '/api/user/remove', {
                    id: id
                }, function(data) {
                    console.log(data);
                });
            }

            // Manejar el envío del formulario de redacción de correos
            $("#composeForm").submit(function(e) {
                e.preventDefault();
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
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
