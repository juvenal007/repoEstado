<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RepoEstado</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->

  <!-- Toastr -->




 </head>   <!-- SweetAlert2 -->
 <style type="text/css">
  @import url(plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css);
  .titulo{
      font-family: Arial, Helvetica, sans-serif;
  }
  .centro{
      text-align: center;
  }
  .pad-top{
      padding-top: 20px;
  }

  .img-left{
      position: absolute;
      text-align: left;
  }
  .right {
      float: right;
  }
  .textoJustificado {
      text-align: justify;
  }
  html{
      font-family: sans-serif;
  }
  padd{
      padding-top: 250px;
  }


 </STYLE>
</style>
<body>
 <main>
  <div class="wrapper">

   <div class="content-wrapper">


    <!-- Main content -->

    <section class="content">
     <div class="container-fluid">
      <div class="row">
       <div><img class="img-left" height="100" src="http://192.168.1.35/repoEstado/assets/img/logoComprobante.jpg" />
       </div>
       <div class="right"><img height="100" src="http://192.168.1.35/repoEstado/assets/img/logo_pencahue.png" />
       </div>
      </div>      
      <div class="centro" style='padding-top: 100px;'>
       <h2 class="titulo">Comprobante Documento: <strong><?php
               echo $documento->docu_tipo
               ;
               ?></strong></h2>
      </div>

      <br>


      <table>
       <thead>
        <tr>
         <th style='font-size: 26px'>Datos del Usuario de origen</th>
         <th></th>
        </tr>

        <tr>
         <td>Rut: </td>
         <th> <?php echo $usuario->usu_rut; ?></th>
        <tr>
         <td>Nombre: </td>
         <th> <?php echo $usuario->usuario_nombre_pri; ?> <?php echo $usuario->usuario_apellido_pat; ?> <?php echo $usuario->usuario_apellido_mat; ?></th>
        </tr>

        <tr>
         <td>Telefono: </td>
         <th> <?php echo $usuario->usuario_telefono; ?> </th>
        </tr> 
        <tr>
         <td>Departamento: </td>
         <th> <?php echo $departamento->depto_nombre; ?> </th>
        </tr> 
        <tr>
         <td>Departamento Telefono: </td>
         <th> <?php echo $departamento->depto_telefono; ?> </th>
        </tr>
        <tr>
         <td></td>
         <th></th>
        </tr>

        <tr>
         <th style='font-size: 26px'>Datos del Documento</th>
         <th></th>
        </tr>
        <tr>
         <td>Codigo: </td>
         <th> <?php echo $codigo; ?></th>
        </tr>
        <tr>
         <td>Codigo Documento: </td>
         <th> <?php echo $documento->docu_codigo; ?></th>
        </tr>
        <tr>
         <td>Tipo: </td>
         <th> <?php echo $documento->docu_tipo; ?></th>
        </tr>
        <tr>
         <td>Fecha Ingreso: </th>
         <th> <?php echo $documento->docu_fecha_ingreso; ?> </th>
        </tr>

        <tr>
         <td>Nombre: </td>
         <th> <?php echo $documento->docu_nombre ?> </th>
        </tr> 
        <tr>
         <td>Archivo: </td>
         <th> <?php echo $archivo->archivo_nombre ?> </th>
        </tr>
        <tr>
         <td>Descripcion: </td>
         <th class="textoJustificado"> <?php echo $rest = substr($documento->docu_descripcion, 0, 120); ?> </th>
        </tr> 
        <tr>
         <td>Estado: </td>
         <th> <?php echo $documento->docu_estado ?> </th>
        </tr>
       </thead>  
       <tbody>
        <tr></tr>
       </tbody>
      </table>


      <br>
      <br>
      <br />
      <div class="centro">
       <img src="<?php echo $base64 ?>" height="50"/>
<!--       <img height="200px"src="http://localhost/repoEstado/Barcode/barcode_generator/Code128b/30/asdasd/true"/>-->
      </div>

     </div>


    </section>

   </div>

  </div>

 </div>

</main>




</body>
</html>


