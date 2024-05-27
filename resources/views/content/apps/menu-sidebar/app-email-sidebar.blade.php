<div class="sidebar-content email-app-sidebar">
  <div class="email-app-menu">
    <div class="form-group-compose text-center compose-btn">
      <button type="button" class="compose-email btn btn-primary w-100" data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#compose-mail">
        Redactar
      </button>
    </div>
    <div class="sidebar-menu-list">
      <div class="list-group list-group-messages">
        <a href="{{ url('/') }}" class="list-group-item list-group-item-action @if(Request::url() === url('/')) active @endif ">
          <i data-feather="mail" class="font-medium-3 me-50"></i>
          <span class="align-middle">Bandeja de entrada</span>
          <span class="badge badge-light-primary rounded-pill float-end">3</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action">
          <i data-feather="send" class="font-medium-3 me-50"></i>
          <span class="align-middle">Enviados</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action">
          <i data-feather="star" class="font-medium-3 me-50"></i>
          <span class="align-middle">Borradores</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action">
          <i data-feather="trash" class="font-medium-3 me-50"></i>
          <span class="align-middle">Basura</span>
        </a>
      </div>
      <!-- <hr /> -->
      <h6 class="section-label mt-3 mb-1 px-2">Configuraciones</h6>
      <div class="list-group list-group-labels">
        <a href="{{ url('users') }}" class="list-group-item list-group-item-action @if(Request::url() === url('users'))
          active @endif"><span class="bullet bullet-sm bullet-success me-1"></span>Usuarios</a>
        <a href="{{ url('contacts') }}" class="list-group-item list-group-item-action @if(Request::url() === url('contacts'))
          active @endif" class="list-group-item list-group-item-action"><span class="bullet bullet-sm bullet-primary me-1"></span>Contactos</a>
        <a href="{{ url('groups') }}" class="list-group-item list-group-item-action" class="list-group-item list-group-item-action"><span class="bullet bullet-sm bullet-primary me-1"></span>Grupos</a>
          <a href="#" data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#modals-template-in" class="list-group-item list-group-item-action" class="list-group-item list-group-item-action"><span class="bullet bullet-sm bullet-primary me-1"></span>Plantilla</a>
      </div>
      <div class="form-group-compose text-center compose-btn">
      <!-- <button type="button" >
        Plantilla
      </button> -->
    </div>
    </div>
    
  </div>
</div>