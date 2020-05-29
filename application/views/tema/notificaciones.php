<nav class="main-header navbar navbar-expand navbar-white navbar-light">
 <!-- Left navbar links -->
 <ul class="navbar-nav">
  <li class="nav-item">
   <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
   <a href="<?= base_url('menu'); ?>" class="nav-link">Inicio</a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
   <a href="<?= base_url('listaUsuarios'); ?>" class="nav-link">Departamentos</a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
   <a href="<?= base_url('listaUsuarios'); ?>" class="nav-link">Usuarios</a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
   <a href="<?= base_url('porCodigo'); ?>" class="nav-link">Buscar Documento</a>
  </li>
 </ul>



 <!-- Right navbar links -->
 <ul class="navbar-nav ml-auto">
  <!-- Messages Dropdown Menu -->
  <li class="nav-item dropdown">

   <!--****** NUMERO DE NOTIFICACIONES NUEVAS ******-->
   <!-- ********************************************-->
   <a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-comments"></i>          
    <span v-show="cantidadEstados == 0 || cantidadEstados == 1" class="badge badge-success navbar-badge">{{cantidadEstados}}</span>
    <span v-show="cantidadEstados > 5" class="badge badge-danger navbar-badge">{{cantidadEstados}}</span>
    <span v-show="cantidadEstados > 1 && cantidadEstados <= 5" class="badge badge-warning navbar-badge">{{cantidadEstados}}</span>
   </a>

   <!--****** NUMERO DE NOTIFICACIONES NUEVAS ******-->
   <!-- ********************************************-->
   <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <!--****** MENU DROPDOWN DE MENSAJES ******-->
    <!-- ********************************************-->
    <span class="dropdown-item dropdown-header">{{cantidadEstados}} Notificaciones</span>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item" v-for="estado in estadosNotificaciones" @click='verEstado(estado)'>
     <!-- Message Start -->

     <div class="row">
     
       <div class="col-4 mx-auto d-block">
        <img src="<?= base_url(); ?>assets/img/fotoPerfil.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle  mx-auto d-block" />
       </div>
  

      <div class="col-6 no-border">
       <center><h3 class="dropdown-item-title">
         {{estado.docu_tipo}}-{{estado.iddocumento}}
        </h3>   
        <p class="text-sm">{{estado.estado_nombre}}</p>
        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{estado.docu_falta}}</p></center> 
      </div>
      <div class="col-2">    
          <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>       
      </div>

     </div>
     <!-- Message End -->
    </a>
    <div class="dropdown-divider"></div>


    <div class="dropdown-divider"></div>
    <a href="<?= base_url('pendientes'); ?>" class="dropdown-item dropdown-footer">Ver todas las pendientes.</a>
   </div>


  </li>

  <!--****** MENU DROPDOWN DE MENSAJES ******-->
  <!-- ********************************************-->
  <!-- Notifications Dropdown Menu -->

  <!--****** MENU DROPDOWN DE NOTIFICACIONES ******-->
  <!-- ********************************************-->

  <li class="nav-item dropdown">
   <a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-bell"></i>
    <span v-show="cantidadEstadosMen == 0 || cantidadEstadosMen == 1" class="badge badge-success navbar-badge">{{cantidadEstadosMen}}</span>
    <span v-show="cantidadEstadosMen > 5" class="badge badge-danger navbar-badge">{{cantidadEstadosMen}}</span>
    <span v-show="cantidadEstadosMen > 1 && cantidadEstadosMen <= 5" class="badge badge-warning navbar-badge">{{cantidadEstadosMen}}</span>
   </a>




   <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <!--****** MENU DROPDOWN DE MENSAJES ******-->
    <!-- ********************************************-->
    <span class="dropdown-item dropdown-header">{{cantidadEstadosMen}} Notificaciones</span>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item" v-for='e in estadosMen' @click='verEstado(e)' >
     <!-- Message Start -->
     
       <div class="row">
     
       <div class="col-4 mx-auto d-block">
        <img src="<?= base_url(); ?>assets/img/memorando.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle  mx-auto d-block" />
       </div>
  

      <div class="col-6 no-border">
       <center><h3 class="dropdown-item-title">
         {{e.docu_tipo}}-{{e.iddocumento}} 
        </h3>   
        <p class="text-sm">{{e.estado_nombre}}</p>
        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{e.docu_falta}}</p></center> 
      </div>
      <div class="col-2">    
          <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>       
      </div>

     </div>   
     <!-- Message End -->
    </a>
    <div class="dropdown-divider"></div>


    <div class="dropdown-divider"></div>
    <a href="<?= base_url('pendientesMen'); ?>" class="dropdown-item dropdown-footer">Ver todas las pendientes.</a>
   </div>



  </li>
  <li class="nav-item dropdown">
   <a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-address-book"></i>
    <span class="badge badge-warning navbar-badge"></span>
   </a>
   <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <a href="<?= base_url('perfilUsuario'); ?>" class="dropdown-item dropdown-header"><strong>Perfil</strong></a>
    <div class="dropdown-divider"></div> 
    <a href="<?= base_url('logout'); ?>" class="dropdown-item dropdown-header"><strong>Logout</strong></a>                 

   </div>
  </li>           

 </ul>
</nav>

