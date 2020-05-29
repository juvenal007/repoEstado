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

  <link rel="stylesheet" href="dist/css/adminlte.min.css">



  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
 </head>   <!-- SweetAlert2 -->
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






     <div class="modal fade" id="modal-overlay">
      <div class="modal-dialog">
       <div class="modal-content">
        <div class="overlay d-flex justify-content-center align-items-center">
         <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
        <div class="modal-header">
         <h4 class="modal-title">GENERANDO DOCUMENTO</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
         </button>
        </div>
        <div class="modal-body">
         <p>CARGANDO...</p>
        </div>
        <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <button type="button" class="btn btn-primary">Save changes</button>
        </div>

        <pre>{{$data}}</pre>


       </div>
       <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
     </div>
     <!-- /.modal -->










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
            {{subtitulo}}
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
             <label for="depto" class="col-3 col-form-label">Departamento</label> 
             <div class="col-6">
              <select v-model="departamento_iddepartamento" class="custom-select" @change="cargarUsuarios()">
               <option value="" disabled selected>Elegir departamento</option>
               <option v-for="value in departamentos" v-bind:value='value.iddepartamento'>{{value.depto_nombre}}</option>
              </select>   
             </div>
            </div>

            <br />

            <div class="row">    
             <div v-for="u in usuarios" class="col-md-4">
              <div class="card card-widget widget-user">
               <!-- Add the bg color to the header using any of the bg-* classes -->
               <div class="widget-user-header text-white"
                    style="background: url('<?= base_url() ?>assets/img/fondo3.jpg')  center center;
                    width: 100%;

                    display: block;
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover;">
                <h3 class="widget-user-desc text-right">{{u.usuario_nombre_pri}} {{u.usuario_apellido_pat}}</h3>
                <h5 class="widget-user-desc text-right">{{u.usuario_funcion}}</h5>
               </div>
               <div class="widget-user-image">
                <img class="img-circle" v-bind:src="'http://placeimg.com/640/480/people/'+u.usu_rut" alt="User Avatar">
               </div>
               <div class="card-footer">
                <div class="row">
                 <div class="col-sm-12 border-right">
                  <div class="description">
                   <h6 class="description-header">Rut: {{u.usu_rut}}</h6>
                   <h6 class="description-header">Correo: {{u.usuario_correo}}</h6>
                   <h6 class="description-text">Anexo: {{u.usuario_anexo}}</h6>
                  </div>
                  <!-- /.description-block -->
                 </div>                  
                 <!-- /.col -->
                </div>
                <!-- /.row -->
               </div>
              </div>    
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
  <script src="<?= base_url() ?>assets/js/listaUsuarios.js"></script>
   <script type="text/javascript">
$(window).load(function () {
  $(".loader").fadeOut("slow");
});
 </script>
 </body>
</html>

