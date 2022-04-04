<?php 

include 'auth.php';

$query = "SELECT * 
            FROM ROL
           WHERE UPPER(NOMBRE) LIKE '%ALCALDE%AUXILIAR%'";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$aa = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);

$id_alcalde_auxiliar = $aa['ID_ROL'];

if (isset($_REQUEST['per'])){
	$per = $_REQUEST['per'];
	$rol = $_REQUEST['rol'];
	$dep = $_REQUEST['dep'];
	$query = "SELECT PR.NOMBRE, 
			         PR.ID_PERSONA, 
			         RL.NOMBRE AS ROL, 
			         RL.ID_ROL, DP.NOMBRE AS DEPENDENCIA, 
			         DP.ID_DEPENDENCIA, 
			         RS.ZONA,
			         RS.TITULAR
                FROM RESPONSABLE RS,
                     PERSONA PR,
                     ROL RL,
                     DEPENDENCIA DP
               WHERE RS.ID_PERSONA = PR.ID_PERSONA
                 AND RS.ID_DEPENDENCIA = DP.ID_DEPENDENCIA
                 AND RS.ID_ROL = RL.ID_ROL
                 AND PR.ID_PERSONA = ".$per."
                 AND RL.ID_ROL = ".$rol."
                 AND DP.ID_DEPENDENCIA = ".$dep;

	$stid = oci_parse($conn, $query);
	oci_execute($stid, OCI_DEFAULT);
	$rowe = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
} else {
	$rowe="";
}

$id_persona = array();
$nombre_persona = array();

$query = "SELECT ID_PERSONA,
		         NOMBRE
  			FROM PERSONA";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	array_push($id_persona, $row['ID_PERSONA']);
	array_push($nombre_persona, $row['NOMBRE']);
}

$id_dependencia = array();
$nombre_dependencia = array();

$query = "SELECT ID_DEPENDENCIA,
		         NOMBRE
  			FROM DEPENDENCIA";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	array_push($id_dependencia, $row['ID_DEPENDENCIA']);
	array_push($nombre_dependencia, $row['NOMBRE']);
}

$id_rol = array();
$nombre_rol = array();

$query = "SELECT ID_ROL,
		         NOMBRE
  			FROM ROL";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	array_push($id_rol, $row['ID_ROL']);
	array_push($nombre_rol, $row['NOMBRE']);
}


$i = 0;
$a = 0;
$c = 0;
?>

<!DOCTYPE html>
<html>
<link rel="shortcut icon" href="img/docs.png">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Responsable</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="lib/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="lib/ionicons-2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
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
        Responsable
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
                <a class="btn btn-danger" href="responsable.php">Regresar</a>
               </div>
             </div>
             <div style="clear: both"></div>
              
              <form role="form" method="post" action="responsable_grabar.php" enctype="multipart/form-data" id="form" autocomplete="off">
              
                <!-- Select -->
                <div class="form-group">
                  <label>Persona: </label>
                  <select class="form-control select2" name="id_persona" required>
                    <option></option>
                    <?php while ($i < count($id_persona)){?>
						     <option value="<?php echo $id_persona[$i];?>"<?php if(!empty($rowe)){if($rowe['ID_PERSONA'] == $id_persona[$i] ){echo 'selected="selected"';}}?>><?php echo $nombre_persona[$i];?></option>
						    <?php $i++;}?>
                  </select>
                </div>
                <!-- Select -->
                <div class="form-group">
                  <label>Dependencia: </label>
                  <select class="form-control select2" name="id_dependencia" required>
                    <option></option>
                    <?php while ($a < count($id_dependencia)){?>
						     <option value="<?php echo $id_dependencia[$a];?>"<?php if(!empty($rowe)){if($rowe['ID_DEPENDENCIA'] == $id_dependencia[$a] ){echo 'selected="selected"';}}?>><?php echo $nombre_dependencia[$a];?></option>
						    <?php $a++;}?>
                  </select>
                </div>
                <!-- Select -->
                <div class="form-group">
                  <label>Rol: </label>
                  <select class="form-control select2" name="id_rol" required>
                    <option></option>
                    <?php while ($c < count($id_rol)){?>
						     <option value="<?php echo $id_rol[$c];?>"<?php if(!empty($rowe)){if($rowe['ID_ROL'] == $id_rol[$c] ){echo 'selected="selected"';}}?>><?php echo $nombre_rol[$c];?></option>
						    <?php $c++;}?>
                  </select>
                </div>
                <!-- Select -->
                <div class="form-group zona" style="display: none">
                  <label>Zona: </label>
                   <input type="text" class="form-control" name="zona" value="<?php  if(empty($rowe['ZONA'])){echo"0";}else{echo $rowe['ZONA'];}?>">
                </div>
                
                <!-- checkbox -->
              <div class="form-group">
                <label>Titular: </label>
                  <input type="checkbox" class="flat-red" name="titular" <?php if(!empty($rowe)){if($rowe['TITULAR'] == 'S' ){echo 'checked';}}?>>
              </div>

			   <div class="box-footer">
                <button type="submit" class="btn btn-primary">Grabar</button>
                <input type="hidden" value="<?php if(isset($per)){echo $per;}?>" name="id_pr">
                <input type="hidden" value="<?php if(isset($rol)){echo $rol;}?>" name="id_rl">
                <input type="hidden" value="<?php if(isset($dep)){echo $dep;}?>" name="id_dp">
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
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
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

<script>
//Flat red color scheme for iCheck
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
  checkboxClass: 'icheckbox_flat-green',
  radioClass: 'iradio_flat-green'
});
</script>

<script>
$(document).ready(function(){
	  if ($('select[name="id_rol"]').val() == <?php echo $id_alcalde_auxiliar; ?> )
	  {
		   $('.zona').show();
	  } else {
        $('.zona').hide();
		  
		  }
	  
	});

</script>

<script>


$('select[name="id_rol"]').change(function(){
	  if ($(this).val() == <?php echo $id_alcalde_auxiliar; ?> )
	  { 
		   $('.zona').show();
	  } else {
          $('.zona').hide();
		  
		  }
	  
	})
	
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
