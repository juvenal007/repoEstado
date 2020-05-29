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

  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
 </head>   <!-- SweetAlert2 -->
 <style>
  .tabla {
      padding: 5px;
      border-top: 0px;
      border-right: 0px;
      border-bottom: 1px solid black;
      border-left: 0px;
  }

  .xyz { 
      background-size: auto; 
      text-align: center; 
      padding-top: 100px; 
  } 
  .btn-circle.btn-sm { 
      width: 30px; 
      height: 30px; 
      padding: 6px 0px; 
      border-radius: 15px; 
      font-size: 8px; 
      text-align: center; 
  } 
  .btn-circle.btn-md { 
      width: 50px; 
      height: 50px; 
      padding: 7px 10px; 
      border-radius: 25px; 
      font-size: 10px; 
      text-align: center; 
  } 
  .btn-circle.btn-xl { 
      width: 70px; 
      height: 70px; 
      padding: 10px 16px; 
      border-radius: 35px; 
      font-size: 12px; 
      text-align: center; 
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
            Crear Departamento
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
            <div v-show="active">Show</div>
            <table class="table table-bordered table-responsive">
             <thead>
              <tr>
               <th>Codigo Barra</th>
               <th>Cod</th>
               <th>Nombre</th>
               <th>Descripcion</th>                         
               <th>Fecha Ingreso</th>
               <th>Tiempo Total</th>
               <th>Opciones</th>              
              </tr>
             </thead>
             <tbody class="mx-auto">
              <tr  v-for="doc in estadosMen">
               <td><a @click='seguimiento(doc)' href="#">{{doc.docu_tipo}}-{{doc.iddocumento}}</a></td>
               <td>{{doc.docu_codigo}}</td>
               <td v-bind:title="doc.docu_nombre">{{doc.docu_nombre_corta}}</td>
               <td v-bind:title="doc.docu_descripcion">{{doc.docu_descripcion_corta}}</td>
               <td>{{doc.docu_fecha_ingreso}}</td>
               <td v-if="doc.docu_falta_dias >= 5"><span class="right badge badge-danger">{{doc.docu_falta_dias}} Dias, {{doc.docu_falta_horas}} Horas, {{doc.docu_falta_minutos}} Minutos</span></td>
               <td v-if="doc.docu_falta_dias > 1 && doc.docu_falta_dias < 5"><span class="right badge badge-warning">{{doc.docu_falta_dias}} Dias, {{doc.docu_falta_horas}} Horas, {{doc.docu_falta_minutos}} Minutos</span></td>
               <td v-if="doc.docu_falta_dias <= 1"><span class="right badge badge-info">{{doc.docu_falta_dias}} Dias, {{doc.docu_falta_horas}} Horas, {{doc.docu_falta_minutos}} Minutos</span></td>
               <td>
                <button type="button" class="btn btn-default btn-sm" @click='descargarDoc(doc)' data-toggle="modal" data-target="#modal-xl"><i class="far fa-file-word"></i></button>
                <button type="button" class="btn btn-default btn-sm" @click='verDocumento(doc.iddocumento)'><i class="far fa-file-pdf"></i></button>
                <button type="button" class="btn btn-default btn-sm" @click='editarDocumento(doc)' data-toggle="modal" data-target="#modal-xl-edit"><i class="far fa-edit"></i></button>
                <button type="button" class="btn btn-default btn-sm" @click='eliminarDocumento(doc.iddocumento)'><i class="far fa-trash-alt"></i></button>

               </td>
              </tr>
             </tbody>  
             <tfoot>
              <tr>
               <th>Codigo Barra</th>
               <th>Cod</th>
               <th>Nombre</th>
               <th>Descripcion</th>               
               <th>Fecha Ingreso</th>
               <th>Tiempo Total</th>
               <th>Opciones</th>  
              </tr>
             </tfoot>
            </table>
           </div>
          </div><!-- /.card-body -->
         </div>
         <!-- /.card -->
         <pre>{{$data}}</pre>


         <div class="modal fade" id="modal-xl">
          <div class="modal-dialog modal-xl">
           <div class="modal-content mx-auto centered center">
            <div class="modal-header">
             <h4 class="modal-title">Historial de Documentos</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
             </button>
            </div>
            <div class="modal-body mx-auto">  
             <div class="card-body mx-auto">
              <div class="tab-content p-0">
               <table class="table table-bordered table-responsive mx-auto centered center">
                <center>
                 <thead>
                  <tr>
                   <th>ID</th>
                   <th>Nombre Archivo</th>
                   <th>Extensión</th>
                   <th>Fecha Ingreso</th>                         
                   <th>ID Documento</th>  
                   <th>Descargar</th>
                  </tr>
                 </thead>
                </center>
                <tbody class="mx-auto">
                 <tr  v-for="archivo in archivos" class="mx-auto">     
                  <td>{{archivo.idarchivo}}</td>
                  <td>{{archivo.archivo_nombre}}</td>       
                  <td>{{archivo.archivo_extension}}</td>
                  <td>{{archivo.archivo_fecha_ingreso}}</td>
                  <td>{{archivo.documento_iddocumento}}</td>             
                  <td>
                <center><button type="button" class="btn btn-default btn-sm" @click='descarga(archivo)'><i class="far fa-file-word"></i></button></center>             
                </td>
                </tr>
                </tbody>  

               </table>    
              </div>
             </div>
            </div>
            <pre>{{$data}}</pre>
            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-default btn-block" data-dismiss="modal">CERRAR</button>

            </div>
           </div>
           <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
         </div>
         <!-- /.modal -->




         <div class="modal fade" id="modal-xl-edit">
          <div class="modal-dialog modal-xl">
           <div class="modal-content mx-auto centered center">
            <div class="modal-header">
             <h4 class="modal-title">Editar Documento</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
             </button>
            </div>
            <div class="modal-body mx-auto">  
             <div class="card-body mx-auto">
              <div class="tab-content p-0">
               <div class="form-group row">
                <label for="archivo" class="col-2 col-form-label">Archivo</label> 
                <div class="col-9">
                 <div class="input-group">
                  <div class="custom-file">
                   <input type="file" @change="onFileSelected" class="custom-file-input" id="archivo">
                   <label class="custom-file-label" for="archivo">Elegir Archivo</label>
                  </div>
                  <div class="input-group-append">
                   <span class="input-group-text">Subir</span>
                  </div>
                 </div>
                </div>
               </div>  
              </div>
             </div>
            </div>
            <pre>{{$data}}</pre>



            <div class="modal-footer justify-content-between">            
             <div class="offset-3 col-6">
              <button @click="agregarArchivo()" name="enviar" type="submit" class="btn-lg btn-block btn-success" data-dismiss="modal">AGREGAR</button>
             </div>
            </div>
           </div>
           <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
         </div>
         <!-- /.modal -->


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

  <script src="<?= base_url() ?>plugins/datatables/jquery.dataTables.js"></script>
  <script src="<?= base_url() ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="<?= base_url() ?>plugins/moment/moment-with-locales.js"></script>

  <script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
  <script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?= base_url() ?>assets/js/pendientesMensaje.js"></script>
  <script>
$(window).load(function () {
  $(".loader").fadeOut("slow");
});
  </script>
 </body>
</html>
