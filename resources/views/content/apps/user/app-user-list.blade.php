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
<style>
  #ck-editor {
    width: 1000px;
    height: 700px;
    margin: 20px auto;
  }

  .ck-editor__editable[role="textbox"] {
    /* Editing area */
    min-height: 200px;
  }

  .ck-content .image {
    /* Block images */
    max-width: 80%;
    margin: 20px auto;
  }
</style>
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
        <form id="emailTemplateForm" class="add-new-user modal-content pt-0" action="{{url('/api/email/template')}}">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Plantilla de correo</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="mb-1">
              <div id="editor"></div>
            </div>

            <div class="ck-editor-template">
              <textarea class="form-control" id="ck-editor" placeholder="Enter the Description" cols="50" rows="50" name="template">


              <p>&nbsp;</p>


<div style="-webkit-text-stroke-width:0px; margin-left:auto; margin-right:auto">
<table id="m_-4047652640647140030Table_01" style="border:undefined">
    <tbody>
        <tr>
            <td>
            <table align="center" id="m_-4047652640647140030backgroundTable" style="border:undefined; width:100%">
                <tbody>
                    <tr>
                        <td style="vertical-align:top">
                        <table align="center" id="m_-4047652640647140030newsTable" style="border:undefined; width:600px">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top">
                                    <div id="m_-4047652640647140030container" style="padding:0px">
                                    <table align="center" style="border:undefined; width:100%">
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align:top">
                                                <table style="border:undefined; width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:center; vertical-align:top">&nbsp;
                                                            <p><sub><img src="{{asset('images/email-template/Logo.png')}}"  style="height:154px; width:235px" /></sub></p>


                                                            <p><sup><span style="font-family:Verdana,Geneva,sans-serif"><span style="font-size:11px"><strong>__</strong></span></span></sup></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                &nbsp;


                                                <table style="border:undefined; width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:center; vertical-align:top">&nbsp;
                                                            <p style="margin-left:0cm; margin-right:0cm; text-align:center"><span style="font-family:Verdana,Geneva,sans-serif"><span style="font-size:11px"><strong>__</strong></span></span></p>


                                                            <p style="margin-left:0cm; margin-right:0cm; text-align:center"><span style="font-size:10px"><strong><span style="font-family:Arial,Helvetica,sans-serif"><span style="background-color:white"><span style="color:#555555">**DISCLAIMER**</span></span></span></strong></span></p>


                                                            <p style="margin-left:0cm; margin-right:0cm; text-align:justify"><span style="font-size:10px"><span style="font-family:Arial,Helvetica,sans-serif"><span style="background-color:white"><span style="color:#555555">We inform you, as the recipient of this message, that electronic mail and communications via the Internet do not allow the confidentiality of the messages transmitted, nor their integrity or correct reception, to be assured or guaranteed, for which BANCO CENTRAL DE VENEZUELA (BCV) assumes no responsibility for such circumstances. If you do not consent to the use of email or communications via the Internet, please notify us and let us know immediately. This message is addressed exclusively to its recipient and contains confidential information subject to professional secrecy, the disclosure of which is not permitted by law. If you have received this message by mistake, please immediately remove it, as well as any document attached to it. Likewise, we inform you that the distribution, copying or use of this message, or any document attached to it, whatever its purpose, is prohibited by law.</span></span></span></span></p>


                                                            <p style="margin-left:0cm; margin-right:0cm; text-align:justify"><span style="font-size:10px"><span style="font-family:Arial,Helvetica,sans-serif"><span style="background-color:white"><span style="color:#555555">For the purposes of the provisions of current regulations regarding the protection of personal data, we inform you that your data will be incorporated into an automated personal data file, created under the responsibility of BANCO CENTRAL DE VENEZUELA (BCV) with the in order to offer you a more personalized, agile and efficient service.</span></span></span></span></p>


                                                            <p style="margin-left:0cm; margin-right:0cm; text-align:justify"><span style="font-size:10px"><span style="font-family:Arial,Helvetica,sans-serif"><span style="background-color:white"><span style="color:#555555">BANCO CENTRAL DE VENEZUELA (BCV) undertakes to comply with its obligation to secrecy of personal data and its duty to store it, and will adopt the necessary measures to prevent its alteration, loss, treatment or unauthorized access, taking into account all times of the state of technology.</span></span></span></span></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>


                                                <table style="border:undefined; width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:center; vertical-align:top"><a href="#"><img src="{{asset('images/email-template/TerminosCondiciones.png')}}" style="height:19px; width:735px" /></a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                &nbsp;


                                                <table style="border:undefined; width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:center; vertical-align:top"><a href="http://www.bcv.org.ve" target="_blank"><img alt="Banco Central de Venezuela (BCV)" src="{{asset('images/email-template/Web.png')}}" style="height:30px; width:30px" /></a></td>
                                                            <td style="text-align:center; vertical-align:top"><a href="https://www.facebook.com/Banco-Central-de-Venezuela-937741406327397/" target="_blank"><img alt="Facebook BCV" src="{{asset('images/email-template/Facebook.png')}}" style="height:30px; width:30px" /></a></td>
                                                            <td style="text-align:center; vertical-align:top"><a href="http://www.bcv.org.ve/bcv/contactos" target="_blank"><img alt="Contactos BCV" src="{{asset('images/email-template/Contactos.png')}}" style="height:30px; width:30px" /></a></td>
                                                            <td style="text-align:center; vertical-align:top"><a href="https://twitter.com/BCV_ORG_VE" target="_blank"><img alt="Twitter BVC" src="{{asset('images/email-template/Twitter.png')}}" style="height:30px; width:30px" /></a></td>
                                                            <td style="text-align:center; vertical-align:top"><a href="https://www.instagram.com/bcv.org.ve/" target="_blank"><img alt="Instagram BCV" src="{{asset('images/email-template/Instagram.png')}}"style="height:30px; width:30px" /></a></td>
                                                            <td style="text-align:center; vertical-align:top"><a href="https://www.youtube.com/user/BancoCentralBCV" target="_blank"><img alt="Youtube BCV" src="{{asset('images/email-template/Youtube.png')}}" style="height:30px; width:30px" /></a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                    </td>
                                    <td style="vertical-align:top">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
    </tbody>
</table>
</div>
                  
              </textarea>
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
  // new nicEditor({
  //   fullPanel: true
  // }).panelInstance('ck-editor');

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


  $("#emailTemplateForm").submit(function(e) {

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

  $("#composeForm").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
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
        // location.reload();
        //alert(data); // show response from the php script.
      }
    });

  });
</script>
@endsection