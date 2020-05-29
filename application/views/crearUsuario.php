<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RepoEstado</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
 </head>
 <style>
  .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('assets/img/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
      opacity: .8;
  }
 </style>
 <body class="hold-transition sidebar-mini layout-fixed">
  <div class="loader"></div>
  <main>
   <div class="wrapper">

    <!-- Navbar -->
    <?php $this->load->view('tema/notificaciones'); ?>   
    <!-- /.navbar -->

    <!--****** MENU DROPDOWN ***************** ******-->
    <!-- ********************************************--> 

    <?php $this->load->view('tema/menu'); ?>   
    <!-- ********************************************--> 
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
     <!-- Content Header (Page header) -->





     <div class="content-header">
      <div class="container-fluid">
       <div class="row mb-2">
        <div class="col-sm-6">
         <h1 class="m-0 text-dark">{{titulo}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
         <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Inicio</li>
         </ol>
        </div><!-- /.col -->
       </div><!-- /.row -->
      </div><!-- /.container-fluid -->
     </div>
     <!-- /.content-header -->

     <!-- Main content -->
     <section class="content">
      <div class="container-fluid">







       <!-- Main row -->
       <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
         <!-- Custom tabs (Charts with tabs)-->
         <div class="card">
          <div class="card-header">
           <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1"></i>
            Crear Usuario
           </h3>
           <div class="card-tools">
            <ul class="nav nav-pills ml-auto">                    
             <li class="nav-item">
              <!-- <a class="nav-link" href="#sales-chart" data-toggle="tab"></a> -->
             </li>
            </ul>
           </div>
          </div><!-- /.card-header -->
          <div class="card-body">
           <div class="tab-content p-0">


            <div class="form-group row">
             <label class="col-4 col-form-label" for="text">Rut</label> 
             <div class="col-8">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-address-card"></i>
                </div>
               </div> 
               <input id="rut" name="rut" placeholder="Rut" type="text" autocomplete="off"  class="form-control" v-model='usu_rut' @change="verificador">
              </div>
             </div>           
            </div>
            <div class="form-group row">
             <label for="nombre_pri" class="col-4 col-form-label">Nombre</label> 
             <div class="col-8">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-address-book"></i>
                </div>
               </div> 
               <input id="nombre_pri" name="nombre_pri" placeholder="Principal" type="text" class="form-control" v-model='usuario_nombre_pri'>
              </div>
             </div>
            </div>
            <div class="form-group row">
             <label for="nombre_sec" class="col-4 col-form-label">Nombre 2</label> 
             <div class="col-8">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-address-book"></i>
                </div>
               </div> 
               <input id="nombre_sec" name="nombre_sec" placeholder="Secundario" type="text" class="form-control" v-model='usuario_nombre_secu'>
              </div>
             </div>
            </div>
            <div class="form-group row">
             <label for="apellido_paterno" class="col-4 col-form-label">Apellido Paterno</label> 
             <div class="col-8">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-address-book"></i>
                </div>
               </div> 
               <input id="apellido_paterno" name="apellido_paterno" placeholder="Ingrese Apellido" type="text" class="form-control" v-model='usuario_apellido_pat'>
              </div>
             </div>
            </div>
            <div class="form-group row">
             <label for="apellido_materno" class="col-4 col-form-label">Apellido Materno</label> 
             <div class="col-8">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-address-book"></i>
                </div>
               </div> 
               <input id="apellido_materno" name="apellido_materno" placeholder="Ingrese Apellido" type="text" class="form-control" v-model='usuario_apellido_mat'>
              </div>
             </div>
            </div>           
            <div class="form-group row">
             <label for="anexo" class="col-4 col-form-label">Anexo</label> 
             <div class="col-8">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-bell"></i>
                </div>
               </div> 
               <input id="anexo" name="anexo" placeholder="Anexo" type="text" class="form-control" v-model='usuario_anexo'>
              </div>
             </div>
            </div>

            <div class="form-group row">
             <label for="correo" class="col-4 col-form-label">Correo</label> 
             <div class="col-8">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-bell"></i>
                </div>
               </div> 
               <input id="correo" name="correo" placeholder="Correo" type="text" class="form-control" v-model='usuario_correo'>
              </div>
             </div>
            </div>

            <div class="form-group row">
             <label for="funcion" class="col-4 col-form-label">Funcion</label> 
             <div class="col-8">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-bell"></i>
                </div>
               </div> 
               <input id="funcion" name="funcion" placeholder="Funcion" type="text" class="form-control" v-model='usuario_funcion'>
              </div>
             </div>
            </div>           


            <div class="form-group row">
             <label for="archivo" class="col-4 col-form-label">Archivo</label> 
             <div class="col-8">
              <div class="input-group">
               <div class="custom-file">
                <input type="file" @change="onFileSelected" class="custom-file-input" id="archivo">
                <label class="custom-file-label" for="archivo">Elegir Archivo</label>
               </div>
               <div class="input-group-append">
                <span class="input-group-text">Archivo</span>
               </div>
              </div>
             </div>
            </div>  



            <div class="form-group row">
             <label for="tipo" class="col-4 col-form-label">Tipo</label> 
             <div class="col-8">
              <select v-model='usuario_tipo' id="tipo" name="tipo" class="custom-select">
               <option value="" disabled selected>Tipo de usuario</option>
               <option value="usuario">USUARIO</option>
               <option value="admin">ADMINISTRADOR</option>
              </select>
             </div>
            </div>
            <div class="form-group row">
             <label for="depto" class="col-4 col-form-label">Departamento</label> 
             <div class="col-8">
              <select v-model="departamento_iddepartamento" class="custom-select">
               <option value="" disabled selected>Elegir departamento</option>
               <option v-for="value in departamentos" v-bind:value='value.iddepartamento'>{{value.depto_nombre}}</option>

              </select>   
             </div>
            </div> 
            <div class="form-group row">
             <div class="offset-4 col-8">
              <button @click='crearUsuario' name="submit" type="submit" class="btn btn-primary">Crear Usuario</button>
             </div>
            </div>        

           </div>
          </div><!-- /.card-body -->
         </div>
         <!-- /.card -->

         <pre>{{$data}}</pre>


        </section>
        <!-- /.Left col -->

        <!-- right col -->
       </div>
       <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
     </section>
     <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
     <strong>RepoEstado - Ilustre Municipalidad de Pencahue <a href="http://www.mpencahue.cl">www.mpencahue.cl</a></strong>
     Sistema de estado de documentos.
     <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 0.1
     </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
     <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
   </div>
   <!-- ./wrapper -->
  </main>
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
$.widget.bridge('uibutton', $.ui.button)
  </script>


<!--  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>-->
  <script src="<?= base_url() ?>assets/recursos/jquery-3.2.1.min.js"></script>
  <script src="<?= base_url() ?>assets/recursos/vue.js"></script>
  <script src="<?= base_url() ?>assets/recursos/axios.min.js"></script>

  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="plugins/sparklines/sparkline.js"></script>

  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

  <script src="dist/js/adminlte.js"></script>

  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>

  <script src="<?= base_url() ?>assets/js/JsBarcode.all.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="<?= base_url() ?>plugins/moment/moment-with-locales.js"></script>
  <script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
  <script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?= base_url() ?>assets/js/crearUsuario.js"></script>
   <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <script type="text/javascript">
$(window).load(function () {
  $(".loader").fadeOut("slow");
});
$(document).ready(function () {
  bsCustomFileInput.init();
});
  </script>
 </body>
</html>
