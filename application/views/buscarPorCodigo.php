
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


          <div class="card-body">
           <div class="tab-content p-0">   

            <div class="form-group row">
             <label for="codigo" class="col-3 col-form-label">Codigo Documento</label> 
             <div class="col-6">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-address-book"></i>
                </div>
               </div> 
               <input id="usuario" name="codigo" placeholder="Codigo" type="text" class="form-control" v-model='codigo'>
              </div>
             </div>
            </div> 
            <div class="form-group row">
             <div class="offset-3 col-6">
              <button @click="buscarPorCodigo(codigo)" name="enviar" type="submit" class="btn-lg btn-block btn-success">BUSCAR</button>
             </div>
            </div>
           </div>
           <div class="card">
            <div class="card-header">
             <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Documentos
             </h3>
             <div class="card-tools">
              <ul class="nav nav-pills ml-auto">                    
               <li class="nav-item">
                <!-- <a class="nav-link" href="#sales-chart" data-toggle="tab"></a> -->
               </li>
              </ul>
             </div>
            </div><!-- /.card-header -->
            <div class="card-body mx-auto">
             <div class="tab-content p-0">



              <table id="example3" class="table-bordered table-responsive">
               <thead>
                <tr>
                 <th>Codigo Barra</th>
                 <th>Codigo</th>
                 <th>Nombre</th>
                 <th>Descripcion</th>
                 <th>Usuario</th>
                 <th>Estado</th>
                 <th>Fecha Ingreso</th>
                 <th>Transcurrido</th>
                 <th>Opciones</th>              
                </tr>
               </thead>
               <tbody>
                <tr  v-for="doc in documentos">
                 <td><a @click='seguimiento(doc.iddocumento)' href="#">{{doc.docu_tipo}}-{{doc.iddocumento}}</a></td>
                 <td>{{doc.docu_codigo}}</td>
                 <td>{{doc.docu_nombre}}</td>
                 <td>{{doc.docu_descripcion}}</td>
                 <td>{{doc.usuario_nombre_pri}} {{doc.usuario_apellido_pat}}</td>
                 <td>{{doc.docu_estado}}</td>
                 <td>{{doc.docu_fecha_ingreso}}</td>
                 <td v-if="doc.docu_falta_dias >= 5"><span class="right badge badge-danger">Hace {{doc.docu_falta_dias}} Dias, {{doc.docu_falta_horas}} Horas, {{doc.docu_falta_minutos}} Minutos</span></td>
                 <td v-if="doc.docu_falta_dias > 1 && doc.docu_falta_dias < 5"><span class="right badge badge-warning">Hace {{doc.docu_falta_dias}} Dias, {{doc.docu_falta_horas}} Horas, {{doc.docu_falta_minutos}} Minutos</span></td>
                 <td v-if="doc.docu_falta_dias <= 1"><span class="right badge badge-info">Hace {{doc.docu_falta_dias}} Dias, {{doc.docu_falta_horas}} Horas, {{doc.docu_falta_minutos}} Minutos</span></td>
                 <td>
                  <button class="btn text-blue" @click='verDocumento(doc.iddocumento)'><i class="far fa-2x fa-file-pdf"></i></button>
  <!--                <button class="btn" href="www.google.cl"><i class="far fa-2x fa-edit"></i></button>
                  <button class="btn text-danger" href="www.google.cl"><i class="far fa-2x fa-trash-alt"></i></button>-->
                 </td>
                </tr>
               </tbody>  
               <tfoot>
                <tr>
                 <th>Codigo Barra</th>
                 <th>Codigo</th>
                 <th>Nombre</th>
                 <th>Descripcion</th>
                 <th>Usuario</th>
                 <th>Estado</th>
                 <th>Fecha Ingreso</th>
                 <th>Transcurrido</th>
                 <th>Opciones</th>  
                </tr>
               </tfoot>
              </table>

             </div>
            </div><!-- /.card-body -->
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
   <!-- jQuery -->
   <script src="plugins/jquery/jquery.min.js"></script>
   <!-- jQuery UI 1.11.4 -->
   <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
   <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
   <script>
$.widget.bridge('uibutton', $.ui.button)
   </script>


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





  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="<?= base_url() ?>plugins/moment/moment-with-locales.js"></script>
   <script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
   <script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>

   <script src="<?= base_url() ?>assets/js/porCodigo.js"></script>
   <script type="text/javascript">
$(window).load(function () {
  $(".loader").fadeOut("slow");
});
   </script>
 </body>
</html>
