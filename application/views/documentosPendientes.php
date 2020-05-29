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
         <h1 class="m-0 text-dark">Inicio</h1>
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
     
     
     
          <div class="container-fluid">  
      <div class="col-sm-12">
       <div class="card card-primary card-outline">
        <div class="card-header">
         <h3 class="card-title">
          <i class="far fa-chart-bar"></i>
          DESCARGAR PERSONAS PENDIENTES
         </h3>         
         <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
           <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
           <i class="fas fa-times"></i>
          </button>
         </div>
        </div>
        <div class="card-body"> 
         <button onclick="location.href='http://192.168.1.35/repoEstado/excel'" type="button" class="btn btn-block btn-success">DESCARGAR PENDIENTES</button>         
        </div>        
        <!-- /.card-body-->
       </div>
       <!-- /.description-block -->
      </div>  
     </div>
     
     
     
     
     
     

     <div class="container-fluid">  
      <div class="col-sm-12">
       <div class="card card-primary card-outline">
        <div class="card-header">
         <h3 class="card-title">
          <i class="far fa-chart-bar"></i>
          Documentos Pendientes por Departamento

         </h3>         
         <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
           <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
           <i class="fas fa-times"></i>
          </button>
         </div>
        </div>
        <div class="card-body">
 <!--                   <canvas id="myChart" width="400" height="400"></canvas>-->
         <canvas id="myChart" width="400" height="100" aria-label="Hello ARIA World" role="img"></canvas>
         
        </div>        
        <!-- /.card-body-->
       </div>
       <!-- /.description-block -->
      </div>  
     </div>

     <div class="container-fluid">  
      <div class="col-sm-12">
       <div class="card card-primary card-outline">
        <div class="card-header">
         <h3 class="card-title">
          <i class="far fa-chart-bar"></i>
          Documentos Pendientes por Usuario
         </h3>         
         <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
           <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
           <i class="fas fa-times"></i>
          </button>
         </div>
        </div>
        <div class="card-body">
         <canvas id="pendientesPorUsuario" width="400" height="1000" aria-label="Hello ARIA World" role="img"></canvas>
        
        </div>        
        <!-- /.card-body-->
       </div>
       <!-- /.description-block -->
      </div>  
     </div>

     <!-- Main row -->
     <div class="container-fluid">  

      <!-- Left col -->
     
     </div>
     <pre>{{$data}}</pre>
     <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
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
 <script src="plugins/moment/moment.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<!--<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>-->
 <script src="<?= base_url() ?>assets/recursos/jquery-3.2.1.min.js"></script>
 <script src="<?= base_url() ?>assets/recursos/vue.js"></script>
 <script src="<?= base_url() ?>assets/recursos/axios.min.js"></script>

 <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

 <script src="plugins/sparklines/sparkline.js"></script>

 <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

 <script src="dist/js/adminlte.js"></script>
 <script src="<?= base_url() ?>plugins/moment/moment-with-locales.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
 <!-- jQuery Knob Chart -->
 <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
 <!-- daterangepicker -->

 <script src="plugins/daterangepicker/daterangepicker.js"></script>
 <script src="<?= base_url() ?>assets/js/documentosPendientes.js"></script>
 <script type="text/javascript">
$(window).load(function () {
  $(".loader").fadeOut("slow");
});
 </script>

</body>
</html>

