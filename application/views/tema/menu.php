<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
 <!-- Brand Logo -->
 <a href="<?= base_url('menu'); ?>" class="brand-link">
  <img src="<?= base_url() ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
       style="opacity: .8">
  <span class="brand-text font-weight-light">RepoEstado</span>
 </a>

 <!-- Sidebar -->
 <div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
   <div class="image">
    <img width="200px" src="<?= base_url() ?><?= $usuario = $this->session->userdata('user')->usuario_img; ?>" class="img-circle" alt="User Image">
   </div>
   <div class="info">
       <?php $usuario = $this->session->userdata('user'); ?>
    <a href="#" class="d-block"><?php echo $usuario->usuario_nombre_pri ?> <?php echo $usuario->usuario_apellido_pat ?></a>
   </div>
  </div>
  <!-- Sidebar Menu -->
  <nav class="mt-2">
   <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-header">Documentos</li>
    <li class="nav-item has-treeview">
     <a href="<?= base_url('enviarDocumento'); ?>" class="nav-link active">
      <i class="right fas fa-share"></i>
      <p>
       Enviar
       <span class="right badge badge-success">ENVIAR</span>
      </p>
     </a>
     <a href="<?= base_url('recibirDocumento'); ?>" class="nav-link active">
      <i class="right fas fa-calendar-check"></i>
      <p>
       Recibir
       <span class="right badge badge-warning">RECIBIR</span>
      </p>
     </a>
     <a href="<?= base_url('terminarDocumento'); ?>" class="nav-link active">
      <i class="right fas fa-arrow-down"></i>
      <p>
       Terminar
       <span class="right badge badge-danger">TERMINAR</span>
      </p>
     </a>
     <a href="<?= base_url('verDocumento'); ?>" class="nav-link active">
      <i class="right fas fa-tasks"></i>
      <p>
       Mis documentos
       <span class="right badge badge-info">Documentos</span>
      </p>
     </a>

    </li> 
    <!--    <li class="nav-header">DEPARTAMENTOS</li>  -->

    <?php
    $usuario = $this->session->userdata('user');
    if ($usuario->usuario_tipo == 'admin') {
        ?>
        <li class="nav-header"><i class="nav-icon far fa-circle text-success"></i> Menu Administrador</li>     
        <?php
    }
    ?>

            <?php
         $usuario = $this->session->userdata('user');
         if ($usuario->usuario_tipo == 'admin') {
             ?>

    <li class="nav-item has-treeview">
     <a href="#" class="nav-link">
      <i class="nav-icon fas fa-tree"></i>
      <p>
       Departamentos
       <i class="fas fa-angle-left right"></i>
      </p>
     </a>
     <ul class="nav nav-treeview">
     
          <li class="nav-item">
           <a href="<?= base_url('crearDepartamento'); ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Agregar Departamento</p>
           </a>
          </li> 
     


      <li class="nav-item">
       <a href="<?= base_url('listaDepartamentos'); ?>" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Lista Departamentos</p>
       </a>
      </li>
     </ul>
    </li>
         <?php
      }
      ?>
    <li class="nav-item has-treeview">
     <a href="#" class="nav-link">
      <i class="nav-icon fas fa-chart-pie"></i>
      <p>
       Usuarios
       <i class="right fas fa-angle-left"></i>
      </p>
     </a>
     <ul class="nav nav-treeview">

      <?php
      $usuario = $this->session->userdata('user');
      if ($usuario->usuario_tipo == 'admin') {
          ?>

          <li class="nav-item">
           <a href="<?= base_url('crearUsuario'); ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Agregar Usuarios</p>
           </a>
          </li>
          <?php
      }
      ?>


      <li class="nav-item">
       <a href="<?= base_url('listaUsuarios'); ?>" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Lista Usuarios</p>
       </a>
      </li>

     </ul>
    </li>




    <li class="nav-item has-treeview">
     <a href="#" class="nav-link">
      <i class="nav-icon fas fa-tree"></i>
      <p>
       Documentos
       <i class="fas fa-angle-left right"></i>
      </p>
     </a>



     <ul class="nav nav-treeview">

      <?php
      $usuario = $this->session->userdata('user');
      if ($usuario->usuario_tipo == 'admin') {
          ?>
          <li class="nav-item">
           <a href="<?= base_url('porDepartamento'); ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Por Departamento</p>
           </a>
          </li>   
          <?php
      }
      ?>

      <?php
      $usuario = $this->session->userdata('user');
      if ($usuario->usuario_tipo == 'admin') {
          ?>
          <li class="nav-item">
           <a href="<?= base_url('porUsuario'); ?>" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Por Usuario</p>
           </a>
          </li> 
          <?php
      }
      ?>

      <li class="nav-item">
       <a href="<?= base_url('porCodigo'); ?>" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Por Código</p>
       </a>
      </li>   
     </ul>
    </li>   

    <?php
    $usuario = $this->session->userdata('user');
    if ($usuario->usuario_tipo == 'admin') {
        ?>
        <li class="nav-item has-treeview">
         <a href="<?= base_url('documentosPendientes'); ?>" class="nav-link active">
          <i class="right fas fa-share"></i>
          <p>
           PENDIENTES
           <span class="right badge badge-dark">PENDIENTES</span>
          </p>
         </a>   
        </li> 
        <?php
    }
    ?>
   </ul>
  </nav>
  <!-- /.sidebar-menu -->
 </div>
 <!-- /.sidebar -->
</aside>