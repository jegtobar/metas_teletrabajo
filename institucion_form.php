<?php 

include 'auth.php';

if (isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
	$query = "SELECT ID_INSTITUCION,
		             ID_CATINSTITUCION,
			         ID_TIPOINSTITUCION,
			         NOMBRE,
			         FUNCION
  			    FROM INSTITUCION
		       WHERE ID_INSTITUCION=".$id;

	$stid = oci_parse($conn, $query);
	oci_execute($stid, OCI_DEFAULT);
	$rowe = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
} else {
	$rowe="";
}

$id_categoria = array();
$nombre_categoria = array();

$query = "SELECT ID_CATINSTITUCION,
		         NOMBRE
  			FROM CATINSTITUCION";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	array_push($id_categoria, $row['ID_CATINSTITUCION']);
	array_push($nombre_categoria, $row['NOMBRE']);
}

$id_tipo = array();
$nombre_tipo = array();

$query = "SELECT ID_TIPOINSTITUCION,
		         NOMBRE
  			FROM TIPOINSTITUCION";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	array_push($id_tipo, $row['ID_TIPOINSTITUCION']);
	array_push($nombre_tipo, $row['NOMBRE']);
}

$i = 0;
$a = 0;
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
        Institución
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
                <a class="btn btn-danger" href="institucion.php">Regresar</a>
               </div>
             </div>
             <div style="clear: both"></div>
              
              <form role="form" method="post" action="institucion_grabar.php" enctype="multipart/form-data" id="form" autocomplete="off">
              
                <!-- Select -->
                <div class="form-group">
                  <label>Categoría: </label>
                  <select class="form-control select2" name="id_categoria" required>
                    <option></option>
                    <?php while ($i < count($id_categoria)){?>
						     <option value="<?php echo $id_categoria[$i];?>"<?php if(!empty($rowe)){if($rowe['ID_CATINSTITUCION'] == $id_categoria[$i] ){echo 'selected="selected"';}}?>><?php echo $nombre_categoria[$i];?></option>
						    <?php $i++;}?>
                  </select>
                </div>
                <!-- Select -->
                <div class="form-group">
                  <label>Tipo: </label>
                  <select class="form-control select2" name="id_tipo" required>
                    <option></option>
                    <?php while ($a < count($id_tipo)){?>
						     <option value="<?php echo $id_tipo[$a];?>"<?php if(!empty($rowe)){if($rowe['ID_TIPOINSTITUCION'] == $id_tipo[$a] ){echo 'selected="selected"';}}?>><?php echo $nombre_tipo[$a];?></option>
						    <?php $a++;}?>
                  </select>
                </div>
                <!-- text input -->
                <div class="form-group">
                  <label>Nombre: </label>
                  <input type="text" class="form-control" placeholder="Nombre de la institución..." name="nombre" value="<?php  if(empty($rowe['NOMBRE'])){echo"";}else{echo $rowe['NOMBRE'];}?>" required>
                </div>
                
                <!-- textarea -->
                <div class="form-group">
                  <label>Función: </label>
                  <textarea class="form-control" rows="3" placeholder="Función..." name="funcion" required><?php  if(empty($rowe['FUNCION'])){echo"";}else{echo $rowe['FUNCION'];}?></textarea>
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
