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
  .banner{      
      width: 100%;

      height: 30%;
      /*      -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;*/
      background-size: auto;
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






     <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-lg">
       <div class="modal-content">
        <div class="modal-header">
         <h4 class="modal-title">Large Modal</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
         </button>
        </div>
        <div class="modal-body">







         <div class="form-group row">
          <label for="nombre" class="col-md-4 col-12 col-form-label">Nombre</label> 
          <div class="col-md-8 col-12">
           <div class="input-group">
            <div class="input-group-prepend">
             <div class="input-group-text">
              <i class="fa fa-address-book"></i>
             </div>
            </div> 
            <input id="nombre" name="nombre" placeholder="Nombre departamento" type="text" class="form-control" v-model="depto.depto_nombre">
           </div>
          </div>
         </div>
         <div class="form-group row">
          <label for="descripcion" class="col-md-4 col-12 col-form-label">Descripcion</label> 
          <div class="col-md-8 col-12">
           <div class="input-group">
            <div class="input-group-prepend">
             <div class="input-group-text">
              <i class="fa fa-align-justify"></i>
             </div>
            </div> 
            <input id="descripcion" name="descripcion" placeholder="Descripcion" type="text" class="form-control" v-model="depto.depto_descripcion">
           </div>
          </div>
         </div>

         <div class="form-group row">
          <label for="telefono" class="col-md-4 col-12 col-form-label">Telefono</label> 
          <div class="col-md-8 col-12">
           <div class="input-group">
            <div class="input-group-prepend">
             <div class="input-group-text">
              <i class="fa fa-bell"></i>
             </div>
            </div> 
            <input id="telefono" name="telefono" placeholder="Telefono" type="text" class="form-control" v-model="depto.depto_telefono">
           </div>
          </div>
         </div> 

         <div class="form-group row">
          <label for="archivo" class="col-md-4 col-12 col-form-label">Imagen</label> 
          <div class="col-md-8 col-12">
           <div class="input-group">
            <div class="custom-file">
             <input type="file" @change="onFileSelected" class="custom-file-input" id="archivo">
             <label class="custom-file-label" for="archivo">Elegir Archivo</label>
            </div>
            <div class="input-group-append">
             <span class="input-group-text">Imagen</span>
            </div>
           </div>
          </div>
         </div>   
         <div v-show='depto.depto_img != ""' class="col-12 mx-auto">
          <center><img v-bind:src="depto.depto_img" width="250 px" alt="Image" class="img-thumbnail mx-auto" id="image-display" > </center>
         </div>
         <br />      

         <pre>{{$data}}</pre>

        </div>
        <div class="modal-footer justify-content-between">
         <button @click='editDepto' name="submit" type="submit" class="btn btn-primary btn-block">EDITAR</button>

        </div>
       </div>
       <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
     </div>


















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

            <div class="row">    

             <div v-for="d in departamentos" class="col-md-12">           


              <div class="card card-widget widget-user">
               <!-- Add the bg color to the header using any of the bg-* classes -->
               <div id='banner' class="widget-user-header text-white"
                    style="background: url('<?= base_url() ?>assets/img/fondo1.jpg')  center center;
                    width: 100%;
                    display: block;
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover;">
                <p><h3 class="widget-user-desc float-left">{{d.depto_nombre}}</h3></p>
                <h3 class="widget-user-desc float-right text-warning"></h3>
               </div>
               <div class="widget-user-image">
                <img class="img-circle" src="<?= base_url() ?>assets/img/escudoMuni.png" alt="User Avatar">
               </div>
               <div class="card-footer">
                <div class="row">
                 <div class="col-sm-4 border-right">
                  <div class="description">
                   <h6 class="description-header">Nombre: {{d.depto_nombre}}</h6>

                   <h6 class="description-text">Jefe Depto: JEFE DEPTO</h6>
                   <h6 class="description-text">Anexo JEFE: 999</h6>
                  </div>
                  <!-- /.description-block -->
                 </div>   
                 <div class="col-sm-8 border-right">
                  <div class="card card-primary card-outline">
                   <div class="card-header">
                    <h3 class="card-title">
                     <i class="far fa-chart-bar"></i>
                     Lista de Usuarios
                    </h3>
                    <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse show" aria-expanded="false">
                      <i class="fas fa-minus"></i>
                     </button>
                     <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                     </button>
                    </div>
                   </div>
                   <div class="card-body">

                   </div>
                   <!-- /.card-body-->
                  </div>
                  <!-- /.description-block -->
                 </div>  
                 <!-- /.col -->
                </div>
                <br />
                <!-- /.row -->
                <div class="form-group row">
                 <div class="col-12">
                  <button @click="editarDepartamento(d)" type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-lg">
                   Editar
                  </button>
                 </div>
                </div>
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

<!--  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>-->
  <script src="<?= base_url() ?>assets/recursos/jquery-3.2.1.min.js"></script>
  <script src="<?= base_url() ?>assets/recursos/vue.js"></script>
  <script src="<?= base_url() ?>assets/recursos/axios.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="<?= base_url() ?>plugins/moment/moment-with-locales.js"></script>

  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="plugins/sparklines/sparkline.js"></script>

  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

  <script src="dist/js/adminlte.js"></script>




  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>

  <script src="<?= base_url() ?>assets/js/JsBarcode.all.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.0/JsBarcode.all.js"></script>-->
  <script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
  <script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?= base_url() ?>assets/js/listaDepartamentos.js"></script>
  <script type="text/javascript">
$(window).load(function () {
  $(".loader").fadeOut("slow");

  $('#acordeon').collapse({
    toggle: false
  })
});
  </script>
 </body>
</html>
