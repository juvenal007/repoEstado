<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RepoEstado</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?= base_url() ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= base_url() ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/toastr/toastr.min.css">
 </head>   <!-- SweetAlert2 -->
 <style>
  .boton-fecha{
      -radius: 4px;
      background-color: #ffffff;
      display: inline-block;
      font-weight: 600;
      padding: 5px;
  }
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
         <input id="iddocumento" type="hidden" value="<?= $iddocumento ?>" />
        </div><!-- /.col -->
       </div><!-- /.row -->
      </div><!-- /.container-fluid -->
     </div>

     <section class="content">
      <div class="container-fluid">
       <!-- Main row -->
       <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
         <div class="card">
          <div class="card-header">
           <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1"></i>
            Seguimiento Documentos
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
            <!-- Timelime example  -->
            <div class="row">
             <div class="col-md-12">
              <!-- The time line -->
              <div class="timeline">
               <!-- timeline time label -->
               <!-- /.timeline-label -->
               <!-- timeline item -->
               <div>
                <i class="fas fa-envelope bg-blue"></i>
               </div>
               <br />
               <div v-for="e in estadosFinales">
                <div class="mx-auto">
                 <button v-show="e.estado_nombre == 'TERMINADO'" class="btn btn-success"><strong>{{e.estado_nombre}}</strong></button>
                 <button v-show="e.estado_nombre == 'ENVIADO'" class="btn btn-success"><strong>{{e.estado_nombre}}</strong></button>
                 <button v-show="e.estado_nombre == 'EN PROCESO'" class="btn btn-warning"><strong>{{e.estado_nombre}}</strong></button>
                 <button v-show="e.estado_nombre == 'RECIBIDO'" class="btn btn-success"><strong>{{e.estado_nombre}}</strong></button>
                 <button v-show='!(e.estado_min == 0 && e.estado_hora == 0 && e.estado_dia == 0)' class="btn btn-primary">Se ha demorado {{e.estado_dia}} Dias, {{e.estado_hora}} Horas, {{e.estado_min}} Minutos</button>
                 <button v-show="e.ultimo == true" class="btn btn-danger">Se esta demorando {{e.estado_dias}} Dias, {{e.estado_horas}} Horas, {{e.estado_minutos}} Minutos</button>
                </div>
                <!-- /.timeline-label -->
                <!-- timeline item -->                
                <div class="timeline-item">
                 <span class="time text-sm text- font-weight-bold"><i class="fas fa-clock"></i> Hora: {{e.fecha_ingreso}}</span>
                 <h3 class="timeline-header"><a href="#">{{e.idestado}} | {{e.usuario_nombre_pri}} {{e.usuario_nombre_secu}}</a>  Recibo documento: {{e.docu_nombre}}</h3>
                 <div class="timeline-body">
                  <strong>Codigo: </strong>{{e.docu_tipo}}-{{e.iddocumento}}   
                  <br>
                  <strong>Descripción: </strong>{{e.docu_descripcion}}  
                  <br>
                  <strong>Departamento: </strong>{{e.depto_nombre}}  
                  <br>
                  <strong>Anexo: </strong>{{e.usuario_anexo}}  
                 </div>
                 <div class="timeline-footer">
                  <!--                  <a class="btn btn-warning btn-sm">{{documento.docu_estado}}</a>-->
                  <!--                  <a class="btn btn-danger btn-sm">Delete</a>-->

                 </div>
                </div>   
               </div>
               <div>
                <i class="fas fa-clock bg-gray"></i>
               </div>
              </div>
             </div>
             <!-- /.col -->
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
  <script src="<?= base_url() ?>plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url() ?>plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
$.widget.bridge('uibutton', $.ui.button)
  </script>

<!--  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>-->
  <script src="<?= base_url() ?>assets/recursos/jquery-3.2.1.min.js"></script>
  <script src="<?= base_url() ?>assets/recursos/vue.js"></script>
  <script src="<?= base_url() ?>assets/recursos/axios.min.js"></script>
  <script src="<?= base_url() ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="<?= base_url() ?>plugins/sparklines/sparkline.js"></script>

  <script src="<?= base_url() ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

  <script src="<?= base_url() ?>dist/js/adminlte.js"></script>

  <!-- jQuery Knob Chart -->
  <script src="<?= base_url() ?>plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?= base_url() ?>plugins/moment/moment.min.js"></script>
  <script src="<?= base_url() ?>plugins/daterangepicker/daterangepicker.js"></script>

  <script src="<?= base_url() ?>assets/js/JsBarcode.all.min.js"></script>

  <script src="<?= base_url() ?>plugins/datatables/jquery.dataTables.js"></script>
  <script src="<?= base_url() ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

  <script src="<?= base_url() ?>plugins/moment/moment-with-locales.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.0/JsBarcode.all.js"></script>-->
  <script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
  <script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?= base_url() ?>assets/js/verEstado.js"></script>
    <script type="text/javascript">
$(window).load(function () {
  $(".loader").fadeOut("slow");
});
  </script>
 </body>
</html>

