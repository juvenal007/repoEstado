<?php
if (isset($_SESSION)) {
    $this->session->sess_destroy();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RepoEstado</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
 
  <link href="assets/font/css/all.css" rel="stylesheet">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  
</head>
<body class="hold-transition login-page">
<main>
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <div class="login-logo">
    <a href="../../index2.html"><b>Repo</b>Estado</a>
    <img width="250px" src="<?= base_url() ?>assets/img/Logo.jpg" class="img-fluid centered" />
  </div>
        
        
        
      <p class="login-box-msg">Iniciar Sesión</p>

      <!-- LOGIN INICIAR SESION -->
     
        <div class="input-group mb-3">
            <input @keyup="iniciarEnter" v-focus type="user" class="form-control" placeholder="Usuario" v-model="usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input @keyup="iniciarEnter" type="password" autocomplete="new-password" class="form-control new-password" placeholder="Contraseña" v-model="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
      
      <!-- FIN LOGIN -->
      
        <div class="row">
          
          <!-- /.col -->
          <div class="col-12">
            <button @click='iniciar' type="submit" class="btn btn-primary btn-block">ENTRAR</button>
          </div>
          <!-- /.col -->
        </div>
   
      <br>
      <p class="mb-1">
        <a href="forgot-password.html">Olvidé mi contraseña</a>
      </p>
<!--      <p class="mb-0">
        <a href="#" class="text-center">Registrar nuevo usuario</a>
      </p>-->
    </div>
    <!-- /.login-card-body -->
  </div>
  <pre>{{$data}}</pre>
</div>
</main>

<!-- /.login-box -->

<!--<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>-->
<script src="<?= base_url() ?>assets/recursos/jquery-3.2.1.min.js"></script>
<script src="<?= base_url() ?>assets/recursos/vue.js"></script>
<script src="<?= base_url() ?>assets/recursos/axios.min.js"></script>
<!-- jQuery -->
<script src="<?= base_url() ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>dist/js/adminlte.min.js"></script>
<script src="<?= base_url() ?>assets/font/js/all.js"></script>
<script src="<?= base_url() ?>plugins/toastr/toastr.min.js"></script>
<script src="<?= base_url() ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url() ?>assets/js/login.js"></script>


</body>
</html>

