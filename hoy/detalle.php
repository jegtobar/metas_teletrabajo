<?php 
error_reporting(0);
include '../auth.php';

$id_meta = $_REQUEST['id_meta'];

$query = "SELECT nombre
            FROM mte_metas
           WHERE id_meta = ".$id_meta;

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$meta = $row['NOMBRE'];  

$query = "SELECT a.usuario,
                 b.descripcion,
                 a.cantidad
            FROM mte_cumplimientos a,
                 rh_areas b
           WHERE a.codarea = b.codarea
                 AND id_meta = ".$id_meta."
           ORDER BY a.id_cumplimiento DESC";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    $area[] = $row['DESCRIPCION'];
    $user[] = $row['USUARIO'];
    $cantidad[] = $row['CANTIDAD'];
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Metas | Monitor</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="css/skins/_all-skins.min.css">
<style>
tr:nth-child(even) {
  background-color: #c9ffa3;
}
</style>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav" style="width: 750px">
<div class="wrapper">

  <div class="content-wrapper" style="background-color: #ededed">

	<br>
      <section class="content">

      <div class="">
          <h1><?php echo $meta ?></h1>
      </div>

      <hr>
      
      <div class="row">
      		
      		<div class="col-md-12">
              	<div class="box box-widget" style="border-radius: 25px;">
              		<div class="box-body">
              			<table id="table" class="table table-bordered" style="font-size: 18px">
                            <thead>
                            <tr>
                              <th>Area</th>
                              <th>Cantidad</th>
                              <th>Usuario</th>
                            </tr>
                            </thead>
                            <tbody>
                        <?php
                        $i=0; while ($i < count($area)) {
                           echo'
                            <tr>
                             <td>'.$area[$i].'</td>
            		         <td class="text-right">'.number_format($cantidad[$i]).'</td>
                             <td>'.$user[$i].'</td>
                            </tr>';
                            $i++;
                              }
                              
                        ?>
                            <tr>
                             <td></td>
                             <td class="text-right"><b>Total: <?php echo number_format(array_sum($cantidad))?></b></td>
                             <td></td>
                            </tr>
                           </tbody>
                        </table>
              		</div>
              	</div>
          	</div>
      
      </div>
      
      
		
        
        

      </section>

  </div>

</div>

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="js/bootstrap.min.js"></script>
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="js/demo.js"></script>

</body>
</html>