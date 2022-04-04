<?php 

include 'auth.php';

if (isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
	$query = "SELECT ID_MENU,
	                 ID_ROL
  		     	FROM MENUROL
		       WHERE ID_ROL = ".$id;
    
	$stid = oci_parse($conn, $query);
	oci_execute($stid, OCI_DEFAULT);
	$opciones = array();
	$rol = array();
	while ($rowe = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	    array_push($opciones, $rowe['ID_MENU']);
	    array_push($rol, $rowe['ID_ROL']);
	}
} else {
	$rowe="";
}

$id_menu = array();
$nombre = array();

$query = "  SELECT ID_MENU,
		           DESCRIPCION
  			  FROM CATMENU
          ORDER BY ID_MENU ASC";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	array_push($id_menu, $row['ID_MENU']);
	array_push($nombre, $row['DESCRIPCION']);
}

$id_rol = array();
$nombre_rol = array();

$query = "SELECT ID_ROL,
		         NOMBRE
  			FROM ROL ";
if(isset($_REQUEST['id'])){
    $query.="WHERE ID_ROL =".$id;
}else{
    $query.="WHERE ID_ROL NOT IN (SELECT ID_ROL FROM MENUROL)";
}

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    array_push($id_rol, $row['ID_ROL']);
    array_push($nombre_rol, $row['NOMBRE']);
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
  <title>Permisos</title>
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

<style type="text/css">
label.btn span {
  font-size: 1.5em ;
}

label input[type="radio"] ~ i.fa.fa-circle-o{
    color: #c8c8c8;    display: inline;
}
label input[type="radio"] ~ i.fa.fa-dot-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="radio"] ~ i.fa {
color: #7AA3CC;
}

label input[type="checkbox"] ~ i.fa.fa-square-o{
    color: #c8c8c8;    display: inline;
}
label input[type="checkbox"] ~ i.fa.fa-check-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-check-square-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="checkbox"] ~ i.fa {
color: #7AA3CC;
}

div[data-toggle="buttons"] label.active{
    color: #7AA3CC;
}

div[data-toggle="buttons"] label {
display: inline-block;
padding: 6px 12px;
margin-bottom: 0;
font-size: 14px;
font-weight: normal;
line-height: 2em;
text-align: left;
white-space: nowrap;
vertical-align: top;
cursor: pointer;
background-color: none;
border: 0px solid 
#c8c8c8;
border-radius: 3px;
color: #c8c8c8;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}

div[data-toggle="buttons"] label:hover {
color: #7AA3CC;
}

div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
-webkit-box-shadow: none;
box-shadow: none;
}
</style>

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
        Roles
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-10">
        
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <div style ="float: right">
               <div class="box-footer">
                <a class="btn btn-danger" href="menu_roles.php">Regresar</a>
               </div>
             </div>
             <div style="clear: both"></div>
              
              <form role="form" method="post" action="menu_roles_grabar.php" enctype="multipart/form-data" id="form" autocomplete="off">
              
                <!-- Select -->
                <div class="form-group">
                  <label>Rol: </label>
                  <select class="form-control select2" name="id_rol" required>
                    <option></option>
                    <?php while ($a < count($id_rol)){?>
						     <option value="<?php echo $id_rol[$a];?>"<?php if(!empty($rol)){if($rol[$a] == $id_rol[$a] ){echo 'selected="selected"';}}?>><?php echo $nombre_rol[$a];?></option>
						    <?php $a++;}?>
                  </select>
                </div>
                
                 <div class="btn-group btn-group-vertical" data-toggle="buttons">
                  <?php while ($i < count($id_menu)){?>  
                    <label class="btn <?php if(!empty($opciones)){$c = 0; while ($c < count($opciones)){if($opciones[$c] == $id_menu[$i]){echo 'active';}$c++;}}?>">
                        <input type="checkbox" name='opcion[]' value="<?php echo $id_menu[$i]?>"<?php if(!empty($opciones)){$c = 0; while ($c < count($opciones)){if($opciones[$c] == $id_menu[$i]){echo 'checked';}$c++;}}?>><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i> <span><?php echo $nombre[$i]?></span>
                    </label>
                  <?php $i++;}?>  
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
