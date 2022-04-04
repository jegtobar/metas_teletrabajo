<?php 

include 'auth.php';

if (isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
	$query = "SELECT ID_ALBERGUE,
		             NOMBREALBERGUE,
			         ZONA,
			         DIRECCION,
			         ESTADO,
	                 CAPACIDAD,
	                 NOMBRE_RESPONSABLE,
	                 TEL_RESPONSABLE,
	                 EMAIL_RESPONSABLE
  			    FROM ALBERGUE
		       WHERE ID_ALBERGUE=".$id;

	$stid = oci_parse($conn, $query);
	oci_execute($stid, OCI_DEFAULT);
	$rowe = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
} else {
	$rowe="";
}

?>

<!DOCTYPE html>
<html>
<link rel="shortcut icon" href="img/docs.png">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Institucion</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="lib/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="lib/ionicons-2.0.1/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/select2.min.css">
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
        Albergue
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-10">
        
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <div style ="float: right">
               <div class="box-footer">
                <a class="btn btn-danger" href="albergue.php">Regresar</a>
               </div>
             </div>
             <div style="clear: both"></div>
              
              <form role="form" method="post" action="albergue_grabar.php" enctype="multipart/form-data" id="form" autocomplete="off">
              
              
                <!-- text input -->
                <div class="form-group">
                  <label>Nombre: </label>
                  <input type="text" class="form-control" placeholder="Nombre del albergue..." name="nombre" value="<?php  if(empty($rowe['NOMBREALBERGUE'])){echo"";}else{echo $rowe['NOMBREALBERGUE'];}?>" required>
                </div>
                
                <!-- text input -->
                <div class="form-group">
                  <label>Zona: </label>
                  <input type="text" class="form-control" placeholder="Zona..." name="zona" value="<?php  if(empty($rowe['ZONA'])){echo"";}else{echo $rowe['ZONA'];}?>" required>
                </div>
                
                <!-- text input -->
                <div class="form-group">
                  <label>Direcci&oacute;n: </label>
                  <input type="text" class="form-control" placeholder="Direcci&oacute;n..." name="direccion" value="<?php  if(empty($rowe['DIRECCION'])){echo"";}else{echo $rowe['DIRECCION'];}?>" required>
                </div>
                
                <!-- Select -->
                <div class="form-group">
                  <label>Estado: </label>
                  <select class="form-control select2" name="estado" required>
                      <option></option>
					  <option value="A"<?php if(!empty($rowe)){if($rowe['ESTADO'] == 'A' ){echo 'selected="selected"';}}?>>ACTIVO</option>
                      <option value="B"<?php if(!empty($rowe)){if($rowe['ESTADO'] == 'B' ){echo 'selected="selected"';}}?>>DE BAJA</option>
                  </select>
                </div>
                
                <!-- text input -->
                <div class="form-group">
                  <label>Capacidad: </label>
                  <input type="text" class="form-control" placeholder="Capacidad de personas..." name="capacidad" value="<?php  if(empty($rowe['CAPACIDAD'])){echo"";}else{echo $rowe['CAPACIDAD'];}?>" required>
                </div>
                
                <!-- text input -->
                <div class="form-group">
                  <label>Nombre: </label>
                  <input type="text" class="form-control" placeholder="Nombre del responsable..." name="responsable" value="<?php  if(empty($rowe['NOMBRE_RESPONSABLE'])){echo"";}else{echo $rowe['NOMBRE_RESPONSABLE'];}?>" required>
                </div>
                
                <!-- text input -->
                <div class="form-group">
                  <label>Tel&eacute;fono: </label>
                  <input type="text" class="form-control" placeholder="Tel&eacute;fono del responsable..." name="telefono" value="<?php  if(empty($rowe['TEL_RESPONSABLE'])){echo"";}else{echo $rowe['TEL_RESPONSABLE'];}?>" required>
                </div>
                
                <!-- text input -->
                <div class="form-group">
                  <label>Email: </label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-at"></i>
                  </div>
                  <input type="text" class="form-control" placeholder="Email..." name="email" value="<?php  if(empty($rowe['EMAIL_RESPONSABLE'])){echo"";}else{echo $rowe['EMAIL_RESPONSABLE'];}?>" required data-parsley-type="email">
                </div>
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

<!-- Script y plugins para validacion -->
<script src="lib/Parsley.js-2.6.2/dist/parsley.min.js"></script>
<script src="lib/Parsley.js-2.6.2/dist/i18n/es.js"></script>

<script type="text/javascript">
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

<!-- Select 2 -->
<script src="plugins/select2/js/select2.full.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
    });
});
</script>

<?php 
if(isset($_GET['grabar']))
{
if ($_GET['grabar'] == 1){
echo '<script>
	  alert("Datos grabados exitosamente!")	
	 </script>';
}
}
?>

</body>
</html>
