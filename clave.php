<?php

include 'auth.php';

if (isset($_POST['confirm'])){

	if ($_POST['confirm'] == $_POST['nuevo']){
	$nuevo = $_POST['nuevo'];
	$antiguo = $_POST['antiguo'];
	$confirm = $_POST['confirm'];
	
	$query = "SELECT CLAVE,
			         USUARIO
  		     	FROM LOGIN
		       WHERE USUARIO='".$_SESSION['nombreusuario']."'
		         AND CLAVE = '".$_POST['antiguo']."'";

	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	if(!empty($row)){
	
		$query = "UPDATE LOGIN
		             SET CLAVE = :clave
			       WHERE USUARIO ='".$_SESSION['nombreusuario']."'";
		
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ":clave", $_POST['nuevo']);
		oci_execute($stid, OCI_DEFAULT);
		
		oci_commit($conn);
		
		$_SESSION['nombreusuario']  = $_SESSION['nombreusuario'];
		$_SESSION['password'] = $_POST['nuevo'];
		
		header('Location: principal.php?id=1');
		die();
	} else {
		header("Location: clave.php?id=2");
		die();
	}
	
	
}
else {
	header("Location: clave.php?id=3");
	die();
}
}
?>

<!DOCTYPE html>
<html>
<link rel="shortcut icon" href="img/docs.png">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cambiar Contraseña</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="lib/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="lib/ionicons-2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="css/skins/_all-skins.min.css">

<!-- Parsley Style -->
  <style type="text/css">
  .parsley-required{
  color: red;
  }
  .parsley-type{
  color: red;
  }
  </style>
<!-- End Parsley Style -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php
	include 'menu.php';
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cambiar Contraseña
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-10">
        
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <div style ="float: right">
               <div class="box-footer">
                <a class="btn btn-danger" href="principal.php">Regresar</a>
               </div>
             </div>
             <div style="clear: both"></div>
              
              <form role="form" method="post" action="clave.php" enctype="multipart/form-data" id="form" autocomplete="off">                

                <div class="form-group">
                  <label for="exampleInputPassword1">Contraseña anterior</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="antiguo" value="<?php  if(empty($rowe['CLAVE'])){echo"";}else{echo $rowe['CLAVE'];}?>" required>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Contraseña nueva</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="nuevo" value="<?php  if(empty($rowe['CLAVE'])){echo"";}else{echo $rowe['CLAVE'];}?>" required>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirmar contraseña</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="confirm" value="<?php  if(empty($rowe['CLAVE'])){echo"";}else{echo $rowe['CLAVE'];}?>" required>
                </div>
                
			   <div class="box-footer">
                <button type="submit" class="btn btn-primary">Grabar</button>
                <input type="hidden" value="<?php if(isset($id)){echo $id;}?>" name="id">
              </div>
              
              </form>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="lib/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="lib/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="js/demo.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>

<!-- Script y plugins para validacion -->
<script src="lib/Parsley.js-2.6.2/dist/parsley.min.js"></script>
<script src="lib/Parsley.js-2.6.2/dist/i18n/es.js"></script>

<script type="text/javascript">

$("[data-mask]").inputmask();

$(function () {
  $('#form').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
  })
  .on('form:submit', function() {
   // return false; // Don't submit form for this demo
  });
});
</script>
<!-- Fin Script y plugins para validacion -->

<?php 
if(isset($_GET['id']))
{
if ($_GET['id'] == 1){
echo '<script>
	  alert("La contraseña fue actualizada con éxito!")	
	 </script>';
}
if ($_GET['id'] == 2){
	echo '<script>
	  alert("La contraseña antigua no es la correcta!")
	 </script>';
}
if ($_GET['id'] == 3){
	echo '<script>
	  alert("La contraseña nueva y confirmación no coinciden!")
	 </script>';
}
}
?>

</body>
</html>
