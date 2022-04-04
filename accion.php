<?php 

include 'auth.php';

$query = "SELECT COUNT(id_meta) AS cantidad, 
                 TO_CHAR(periodo_del,'DD-MM-YYYY') || ' al ' || TO_CHAR(periodo_al,'DD-MM-YYYY') as periodo,
                 TO_CHAR(periodo_del,'DD-MM-YYYY') as ini,
                 TO_CHAR(periodo_al,'DD-MM-YYYY') as fin
            FROM mte_metas
           WHERE CODAREA = ".$codarea."
        GROUP BY periodo_del,
                 periodo_al
        ORDER BY periodo_del DESC";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

?>

<!DOCTYPE html>
<html>
<link rel="shortcut icon" href="img/docs.png">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Metas</title>
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
  <!-- Data Table -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

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
        Metas
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
        
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <div style ="float: right">
               <div class="box-footer">
                <a class="btn btn-success" href="accion_form.php">Nuevo</a>
               </div>
             </div>
             <div style="clear: both"></div>
             
             <div class="box-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Período</th>
                  <th>Cantidad de Metas</th>
                  <th style="width: 10%">Editar</th>
                  <th style="width: 10%">Eliminar</th>
                </tr>
                </thead>
                <tbody>
            <?php
            while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
               echo'
                <tr>
                 <td>'.$row['PERIODO'].'</td>
           		 <td>'.$row['CANTIDAD'].'</td>
           		 <td><a class="btn btn-default" href="accion_form.php?fecha_ini='.$row['INI'].'&fecha_fin='.$row['FIN'].'"><i class="fa fa-pencil"></i></a></td>
  		         <td><a class="btn btn-danger" href="accion_borrar.php?fecha_ini='.$row['INI'].'&fecha_fin='.$row['FIN'].'"><i class="fa fa-trash-o"></i></a></td>
                </tr>';
                  }
            ?>
                </tbody>
              </table>
            </div>
              
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!--/.col (right) -->
      </div>
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

<script src="js/jquery-ui.js"></script>

<!-- Plugins para Datatables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

<script>

  $(function () {
	  $("#tabla").DataTable({
		  "language": {
              "url": "plugins/datatables/Spanish.json"
          }
	    }); 
  });
  
</script>
<!-- Fin de plugins para Datatables -->

<?php 
if(isset($_GET['grabar']))
{
if ($_GET['grabar'] == 1){
echo '<script>
	  alert("Datos grabados exitosamente!")	
	 </script>';
}
if ($_GET['grabar'] == 2){
	echo '<script>
	  alert("Datos eliminados exitosamente!")
	 </script>';
}
}
?>

</body>
</html>