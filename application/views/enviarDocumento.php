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
          <div class="card-header">
           <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1"></i>
            Crear Documento
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
             <label for="tipo" class="col-12 col-md-2 col-form-label">Tipo Documento</label> 
             <div class="col-md-4 col-12">
              <select @change="menuUsuarios()" id="tipo" name="tipo" class="custom-select" v-model="tipo">
               <option value="" disabled selected>Elegir Documento</option>
               <option value="MEMORANDO">Memorando</option>
               <option value="CIRCULAR">Circular</option>
               <option value="OFICIO">Oficio</option>
               <option value="DECRETO">Decreto</option>
               <option value="RESOLUCION">Resolución</option>
               <option value="OTROS">Otros</option>
              </select>
             </div>  
             <label for="codigo" class="col-md-1 col-12 col-form-label">Codigo</label> 
             <div class="col-md-4 col-12">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-file"></i>
                </div>
               </div> 
               <input id="codigo" name="codigo" placeholder="Codigo Documento" type="text" class="form-control" v-model="codigo">
              </div>
             </div>
            </div>
            <div class="form-group row">
             <label for="nombre" class="col-md-2 col-12 col-form-label">Nombre</label> 
             <div class="col-md-9 col-12">
              <div class="input-group">
               <div class="input-group-prepend">
                <div class="input-group-text">
                 <i class="fa fa-file"></i>
                </div>
               </div> 
               <input id="nombre" name="nombre" placeholder="Nombre Documento" type="text" class="form-control" v-model="nombre">
              </div>
             </div>
            </div>


            <div class="form-group row">
             <label for="archivo" class="col-md-2 col-12 col-form-label">Archivo</label> 
             <div class="col-md-9 col-12">
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
             <label for="descripcion" class="col-md-2 col-12 col-form-label">Descripcion</label> 
             <div class="col-md-9 col-12">
              <textarea id="descripcion" name="descripcion" cols="40" rows="7" class="form-control" v-model="descripcion"></textarea>
             </div>
            </div>
            <div v-show='mostrar' class="form-group row">
             <label for="depto" class="col-md-2 col-12 col-form-label">Departamento</label> 
             <div class="col-md-6 col-12">
              <select v-model="departamento_iddepartamento" class="custom-select" @change="cargarUsuarios()">
               <option value="" disabled selected>Elegir departamento</option>
               <option v-for="value in departamentos" v-bind:value='value.iddepartamento'>{{value.depto_nombre}}</option>
              </select>                 
             </div>
             <div class="col-md-3 col-12">
              <button @click="destinatariosDeptos()" name="enviar" type="submit" class="btn btn-block btn-info">AGREGAR DEPTO COMPLETO</button>
             </div>
            </div>
            <div v-show='mostrar' class="form-group row">
             <label for="depto" class="col-md-2 col-12 col-form-label">Usuario</label> 
             <div class="col-md-6 col-12">
              <select v-model="usuario" class="custom-select">
               <option value="" disabled selected>Elegir Usuario</option>
               <option v-for="u in usuarios" v-bind:value='u.usu_rut'>{{u.usu_rut}} || {{u.usuario_nombre_pri}} {{u.usuario_apellido_pat}}</option>
              </select>   
             </div>
             <div class="col-md-3 col-12">
              <button @click="destinatariosUsuario()" name="enviar" type="submit" class="btn btn-block btn-info">AGREGAR USUARIO </button>
             </div>
            </div>
            <div v-show='mostrar' class="form-group row">
             <label for="depto" class="col-md-2 col-12 col-form-label">Destinarios</label> 
             <div class="col-md-9 col-12">
              <div class="card card-primary card-outline">
               <div class="card-header">
                <h3 class="card-title">Destinatarios</h3>
                <div class="card-tools">

                </div>
                <!-- /.card-tools -->
               </div>
               <!-- /.card-header -->
               <div class="card-body p-0">
                <div class="mailbox-controls">
                 <!-- Check all button -->                              
                 <!-- /.btn-group -->    
                 <!-- /.float-right -->
                </div>
                <div class="table-responsive mailbox-messages">
                 <table class="table table-hover table-striped">
                  <thead>
                  <th>Borrar</th>
                  <th>Nombre</th>
                  <th>Departamento</th>
                  </thead>
                  <tbody>
                   <tr  v-for="dest in destinatariosArr">                   
                    <td>
                     <div class="btn-group">
                      <button type="button" class="btn btn-default btn-sm" @click='eliminarDestinatario(dest.id)'><i class="far fa-trash-alt"></i></button>
                     </div>
                    </td>                 
                    <td>{{dest.nombre}}</td> 
                    <td>{{dest.departamento}}</td> 
                   </tr>                  
                  </tbody>
                 </table>
                 <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
               </div>
               <!-- /.card-body -->
               <div class="card-footer p-0">
                <div class="mailbox-controls">
                 <!-- Check all button -->

                 <!-- /.btn-group -->
                 <!-- /.float-right -->
                </div>
               </div>
              </div>
              <!-- /.card -->
             </div>
            </div>
          

            <div class="form-group row">
             <div class="offset-3 col-6">
              <button @click="crearDocumento()" name="enviar" type="submit" class="btn-lg btn-block btn-success">ENVIAR</button>
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
  <script src="<?= base_url() ?>plugins/moment/moment-with-locales.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="<?= base_url() ?>plugins/moment/moment-with-locales.js"></script>
  <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.0/JsBarcode.all.js"></script>-->
  <script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
  <script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?= base_url() ?>assets/js/enviarDocumento.js"></script>
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

