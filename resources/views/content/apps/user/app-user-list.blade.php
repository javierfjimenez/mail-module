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
{{-- CKEditor CDN --}}
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

    <div class="card-datatable table-responsive pt-0">
      <table class="user-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <!-- <th>ID</th> -->
            <th>Name</th>
            <th>Email</th>
            <!-- <th>Status</th> -->
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- Modal to add new user starts-->
    <div class="modal modal-slide-in new-user-modal fade" data-bs-backdrop="static" id="modals-slide-in">
      <div class="modal-dialog">
        <form id="userForm" class="add-new-user modal-content pt-0" action="{{url('/users/store')}}">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-fullname">Nombre Completo</label>
              <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="John Doe" name="name" />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-email">Email</label>
              <input type="text" id="basic-icon-default-email" class="form-control dt-email" placeholder="john.doe@example.com" name="email" />
            </div>
            <div class="mb-1">
              <label class="form-label" for="basic-icon-default-contact">Contraseña</label>
              <input type="password" class="form-control" placeholder="***********" name="password" />
            </div>
            <div class="mb-1">
              <label class="form-label" for="user-role">Rol</label>
              <select name="role" id="user-role" class="select2 form-select">
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-primary me-1 data-submit">Guardar</button>
              <button id="cancel-user-create" type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
          <input id="user_id" name="user_id" type="hidden" value="">
          <input class="csrf_token" type="hidden" value="{{csrf_token()}}">
        </form>
      </div>
    </div>
    <!-- Modal to add new user Ends-->
    <!-- Modal to add new user starts-->
    <div class="modal new-user-modal fade" data-bs-backdrop="static" id="modals-template-in">
      <div class="modal-dialog modal-xl">
        <form id="emailTemplateForm" class="add-new-user modal-content pt-0" action="{{url('/users/store')}}">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Plantilla de correo</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <div class="ck-editor-template">
                <textarea class="form-control" id="ck-editor" placeholder="Enter the Description" rows="20" name="body"></textarea>
                <!-- <textarea id="editor"><?php echo htmlspecialchars('<h1>Example</h1><p>Hello world</p>'); ?></textarea> -->

              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-primary me-1 data-submit">Guardar</button>
              <button id="cancel-email-template" type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
          <input id="template_id" name="template_id" type="hidden" value="">
          <input class="csrf_token" type="hidden" value="{{csrf_token()}}">
        </form>
      </div>
    </div>
    <!-- Modal to add new user Ends-->
  </div>
  <!-- list and filter end -->
</section>
<!-- users list ends -->

<!-- compose email -->
<div class="modal modal-sticky" id="compose-mail" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content p-0">
      <div class="modal-header">
        <h5 class="modal-title">Mensaje nuevo</h5>
        <div class="modal-actions">
          <a href="#" class="text-body me-75"><i data-feather="minus"></i></a>
          <a href="#" class="text-body me-75 compose-maximize"><i data-feather="maximize-2"></i></a>
          <a class="text-body" href="#" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></a>
        </div>
      </div>
      <div class="modal-body flex-grow-1 p-0">
        <form class="compose-form">
          <div class="compose-mail-form-field select2-primary">
            <label for="email-to" class="form-label">Para: </label>
            <div class="flex-grow-1">
              <select class="select2 form-select w-100" id="email-to" multiple>
                <option data-avatar="1-small.png" value="Jane Foster">Jane Foster</option>
                <option data-avatar="3-small.png" value="Donna Frank">Donna Frank</option>
                <option data-avatar="5-small.png" value="Gabrielle Robertson">Gabrielle Robertson</option>
                <option data-avatar="7-small.png" value="Lori Spears">Lori Spears</option>
              </select>
            </div>
            <div>
              <a class="toggle-cc text-body me-1" href="#">Cc</a>
              <a class="toggle-bcc text-body" href="#">Bcc</a>
            </div>
          </div>
          <div class="compose-mail-form-field cc-wrapper">
            <label for="emailCC" class="form-label">Cc: </label>
            <div class="flex-grow-1">
              <!-- <input type="text" id="emailCC" class="form-control" placeholder="CC"/> -->
              <select class="select2 form-select w-100" id="emailCC" multiple>
                <option data-avatar="1-small.png" value="Jane Foster">Jane Foster</option>
                <option data-avatar="3-small.png" value="Donna Frank">Donna Frank</option>
                <option data-avatar="5-small.png" value="Gabrielle Robertson">Gabrielle Robertson</option>
                <option data-avatar="7-small.png" value="Lori Spears">Lori Spears</option>
              </select>
            </div>
            <a class="text-body toggle-cc" href="#"><i data-feather="x"></i></a>
          </div>
          <div class="compose-mail-form-field bcc-wrapper">
            <label for="emailBCC" class="form-label">Bcc: </label>
            <div class="flex-grow-1">
              <!-- <input type="text" id="emailBCC" class="form-control" placeholder="BCC"/> -->
              <select class="select2 form-select w-100" id="emailBCC" multiple>
                <option data-avatar="1-small.png" value="Jane Foster">Jane Foster</option>
                <option data-avatar="3-small.png" value="Donna Frank">Donna Frank</option>
                <option data-avatar="5-small.png" value="Gabrielle Robertson">Gabrielle Robertson</option>
                <option data-avatar="7-small.png" value="Lori Spears">Lori Spears</option>
              </select>
            </div>
            <a class="text-body toggle-bcc" href="#"><i data-feather="x"></i></a>
          </div>
          <div class="compose-mail-form-field">
            <label for="emailSubject" class="form-label">Asunto: </label>
            <input type="text" id="emailSubject" class="form-control" placeholder="Subject" name="emailSubject" />
          </div>
          <div id="message-editor">
            <div class="editor" data-placeholder="Type message..."></div>
            <div class="compose-editor-toolbar">
              <span class="ql-formats me-0">
                <select class="ql-font">
                  <option selected>Sailec Light</option>
                  <option value="sofia">Sofia Pro</option>
                  <option value="slabo">Slabo 27px</option>
                  <option value="roboto">Roboto Slab</option>
                  <option value="inconsolata">Inconsolata</option>
                  <option value="ubuntu">Ubuntu Mono</option>
                </select>
              </span>
              <span class="ql-formats me-0">
                <button class="ql-bold"></button>
                <button class="ql-italic"></button>
                <button class="ql-underline"></button>
                <button class="ql-link"></button>
              </span>
            </div>
          </div>
          <div class="compose-footer-wrapper">
            <div class="btn-wrapper d-flex align-items-center">
              <div class="btn-group dropup me-1">
                <button type="button" class="btn btn-primary">Send</button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                  <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#"> Schedule Send</a>
                </div>
              </div>
              <!-- add attachment -->
              <div class="email-attachement">
                <label for="file-input" class="form-label">
                  <i data-feather="paperclip" width="17" height="17" class="ms-50"></i>
                </label>

                <input id="file-input" type="file" class="d-none" />
              </div>
            </div>
            <div class="footer-action d-flex align-items-center">
              <div class="dropup d-inline-block">
                <i class="font-medium-2 cursor-pointer me-50" data-feather="more-vertical" role="button" id="composeActions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </i>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="composeActions">
                  <a class="dropdown-item" href="#">
                    <span class="align-middle">Add Label</span>
                  </a>
                  <a class="dropdown-item" href="#">
                    <span class="align-middle">Plain text mode</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">
                    <span class="align-middle">Print</span>
                  </a>
                  <a class="dropdown-item" href="#">
                    <span class="align-middle">Check Spelling</span>
                  </a>
                </div>
              </div>
              <i data-feather="trash" class="font-medium-2 cursor-pointer" data-bs-dismiss="modal"></i>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ compose email -->
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
<script src="{{ asset(mix('js/scripts/pages/app-user-list.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/pages/app-email.js')) }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script>
  $("#userForm").submit(function(e) {

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
    $.get(window.location.origin + '/api/users/' + id, (data, status) => {
      $('#basic-icon-default-fullname').val(data.full_name);
      $('#basic-icon-default-email').val(data.email);
      $('#user_id').val(data.id);
      $('#modals-slide-in').modal('show');
    });
  }

  function remove(id) {
    $.post(window.location.origin + '/api/user/remove', {
      id: id
    }, (data, status) => {
      console.log(data)
    });
  }
  ClassicEditor.create(document.querySelector('#ck-editor'), {
      ckbox: {
        tokenUrl: "{{ route('ckbox_token') }}",
        theme: 'lark'
      },
      toolbar: {
    items: [
        'undo', 'redo',
        '|', 'heading',
        '|', 'fontfamily', 'fontsize', 'color', 'fontBackgroundColor',
        '|', 'bold', 'italic', 'strikethrough', 'subscript', 'superscript',
        '|', 'link', 'uploadImage', 'blockQuote', 'codeBlock',
        '|', 'alignment',
        '|', 'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent'
    ],
    shouldNotGroupWhenFull: true
}


    })
    .catch(error => {
      console.error(error);
    });
</script>
@endsection