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
      <!-- list and filter start -->
      <br />
      <form id="emailTemplateForm" method="post" action="{{url('api/email/template/store')}}" class="mb-3">
        <div class="d-flex justify-content-end my-2">
          <button type="submit" class="btn btn-primary me-1 data-submit">Guardar</button>
        </div>
        <div class="">
          <textarea name="template" id="ck-editor" cols="100" rows="30">{!! html_entity_decode($emailTemplate)!!}</textarea>
        </div>

        <div class="body-content-overlay"></div>

      </form>
      <!-- {{$emailTemplate}} -->

    </div>
  </div>
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
  new nicEditor({
    fullPanel: true
  }).panelInstance('ck-editor');

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
</script>
@endsection