<div class="sidebar-content email-app-sidebar">
  <div class="email-app-menu">
    <div class="text-center form-group-compose compose-btn">
      <button type="button" class="compose-email btn btn-primary w-100" data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#compose-mail">
        Redactar
      </button>
    </div>
    <div class="sidebar-menu-list">
      <div class="list-group list-group-messages">
        <a href="{{ url('/') }}" class="list-group-item list-group-item-action @if(Request::url() === url('/')) active @endif ">
          <i data-feather="mail" class="font-medium-3 me-50"></i>
          <span class="align-middle">Bandeja de entrada</span>
          <span class="badge badge-light-primary rounded-pill float-end">{{$messagesCount['unseen'] ?? 0}} </span>
        </a>
        <a href="{{ url('get/seen/emails') }}" class="list-group-item list-group-item-action">
          <i data-feather="send" class="font-medium-3 me-50"></i>
          <span class="align-middle">Leídos</span>
          <span class="badge badge-light-primary rounded-pill float-end">{{$messagesCount['seen'] ?? 0}}</span>

        </a>
        <a href="#" class="list-group-item list-group-item-action">
          <i data-feather="star" class="font-medium-3 me-50"></i>
          <span class="align-middle">Borradores</span>
          <span class="badge badge-light-primary rounded-pill float-end">{{$messagesCount['draft'] ?? 0}}</span>

        </a>
        <a href="{{ url('get/deleted/emails') }}" class="list-group-item list-group-item-action">
          <i data-feather="trash" class="font-medium-3 me-50"></i>
          <span class="align-middle">Basura</span>
        </a>
      </div>
      <!-- <hr /> -->
      <h6 class="px-2 mt-3 mb-1 section-label">Configuraciones</h6>
      <div class="list-group list-group-labels">
        <a href="{{ url('users') }}" class="list-group-item list-group-item-action @if(Request::url() === url('users'))
          active @endif"><span class="bullet bullet-sm bullet-success me-1"></span>Usuarios</a>
        <a href="{{ url('contacts') }}" class="list-group-item list-group-item-action @if(Request::url() === url('contacts'))
          active @endif" class="list-group-item list-group-item-action"><span class="bullet bullet-sm bullet-primary me-1"></span>Contactos</a>
        <a href="{{ url('groups') }}" class="list-group-item list-group-item-action @if(Request::url() === url('groups'))
          active @endif" class="list-group-item list-group-item-action"><span class="bullet bullet-sm bullet-primary me-1"></span>Grupos</a>
        <a href="{{ url('email/temp') }}" class="list-group-item list-group-item-action @if(Request::url() === url('email/temp'))
          active @endif" class="list-group-item list-group-item-action"><span class="bullet bullet-sm bullet-primary me-1"></span>Plantilla</a>
        <!-- <a href="{{ url('email/temp') }}" data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#modals-template-in" class="list-group-item list-group-item-action" class="list-group-item list-group-item-action"><span class="bullet bullet-sm bullet-primary me-1"></span></a> -->
      </div>
      <div class="text-center form-group-compose compose-btn">
        <!-- <button type="button" >
        Plantilla
      </button> -->
      </div>
    </div>

  </div>
</div>

<!-- compose email -->
<div class="modal modal-sticky" id="compose-mail" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="p-0 modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Mensaje nuevo</h5>
        <div class="modal-actions">
          <a href="#" class="text-body me-75"><i data-feather="minus"></i></a>
          <a href="#" class="text-body me-75 compose-maximize"><i data-feather="maximize-2"></i></a>
          <a class="text-body" href="#" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></a>
        </div>
      </div>
      <div class="p-0 modal-body flex-grow-1">
        <form id="composeForm" class="compose-form" method="POST" action="{{url('/api/email/send')}}" enctype="multipart/form-data">
          <div class="compose-mail-form-field select2-primary">
            <label for="email-to" class="form-label">Para: </label>
            <div class="flex-grow-1">
              <select class="select2 form-select w-100" id="email-to" name="emailTo" multiple>
                @if (isset($contacts) && count($contacts) >= 1)
                @foreach ($contacts as $contact)
                <option value="{{ $contact->id }}">{{ $contact->email }}</option>
                @endforeach
                @endif

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
              <select class="select2 form-select w-100" id="emailCC" name="emailCC" multiple>
                @if (isset($groups) && count($groups) >= 1)
                @foreach ($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
                @endif

              </select>
            </div>
            <a class="text-body toggle-cc" href="#"><i data-feather="x"></i></a>
          </div>
          <div class="compose-mail-form-field bcc-wrapper">
            <label for="emailBCC" class="form-label">Bcc: </label>
            <div class="flex-grow-1">
              <!-- <input type="text" id="emailBCC" class="form-control" placeholder="BCC"/> -->
              <select class="select2 form-select w-100" id="emailBCC" name="emailBCC" multiple>
                @if (isset($groups) && count($groups) >= 1)
                @foreach ($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
                @endif
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
                <button type="submit" class="btn btn-primary">Enviar</button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                  <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#"> Agendar Envío</a>
                </div>
              </div>
              <!-- add attachment -->
              <div class="email-attachement">
                <label for="file-input" class="form-label">
                  <i data-feather="paperclip" width="17" height="17" class="ms-50"></i>
                </label>
                <input id="file-input" name="files[]" multiple type="file" class="d-none"/>
              </div>
            </div>
            <div class="footer-action d-flex align-items-center">
              <div class="dropup d-inline-block">
                <i class="cursor-pointer font-medium-2 me-50" data-feather="more-vertical" role="button" id="composeActions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
              <i data-feather="trash" class="cursor-pointer font-medium-2" data-bs-dismiss="modal"></i>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ compose email -->
