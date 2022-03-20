<?php 
error_reporting(0);
include '../auth.php';

$query = "SELECT id_periodo AS periodo_vigente
            FROM mte_periodo
           WHERE vigente = 'S'";
$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$periodo_vigente = $row['PERIODO_VIGENTE'];

$query = "SELECT id_periodo,
                 to_char(fecha_inicio,'DD-MM-YYYY') as inicio,
                 to_char(fecha_fin,'DD-MM-YYYY') as fin
            FROM mte_periodo
           WHERE id_periodo <= ".$periodo_vigente."
           ORDER BY id_periodo ASC";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    
    $id_periodo[] = $row['ID_PERIODO'];
    $inicio[] = $row['INICIO'];
    $fin[] = $row['FIN'];
    
}

$query = "SELECT codarea,
                 nombre
            FROM mte_areas
           WHERE usuarios LIKE '%".$usuario."%'";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    
$codarea = $row['CODAREA'];
$area = $row['NOMBRE'];


if(!isset($_GET['id_periodo'])){
    $periodo = end($id_periodo);
} else {
    $periodo = $_GET['id_periodo'];
}

$query = "SELECT a.id_meta,
                 a.nombre, 
                 a.tipo,
                 NVL(SUM(b.cantidad),0) AS cantidad,
                 a.meta,
                 a.poa,
                 a.activa,
                 a.modalidad
            FROM mte_metas a
            LEFT JOIN mte_cumplimientos b ON a.id_meta = b.id_meta
           WHERE a.codarea = ".$codarea."
                 AND a.id_periodo = ".$periodo."
           GROUP BY a.id_meta,
                 a.nombre,
                 a.tipo,
                 a.meta,
                 a.poa,
                 a.activa,
                 a.modalidad
        ORDER BY id_meta DESC";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    $id_meta[] = $row['ID_META'];
    $nombre[] = $row['NOMBRE'];
    $poa[]=$row['POA'];
    $activa[]=$row['ACTIVA'];
    $modalidad[]=$row['MODALIDAD'];
    if($row['TIPO'] == 'T'){$tipo[] = 'Teletrabajo';}
    if($row['TIPO'] == 'P'){$tipo[] = 'Presencial';}
    if($row['TIPO'] == 'M'){$tipo[] = 'Mixto';}
    
    $cantidad[] = $row['CANTIDAD'];
    $meta[] = $row['META'];
}

$query = "SELECT vigente
            FROM mte_periodo
           WHERE id_periodo = ".$periodo;

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);

$vigente = $row['VIGENTE'];

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
  
    <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />
    
  <link rel="stylesheet" href="dist/jquery.fancybox.min.css">

  <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

 <style>
 #fancybox-wrap {
  position: absolute;
  top: 100px !important;
}
 </style>
</head>
<body class="hold-transition skin-blue layout-top-nav">

<div class="wrapper" id="app">

  <header class="main-header" style="height: 75px;background-color: #A2CE39">
    <nav class="navbar navbar-static-top" style="background-color: #A2CE39">
        <div class="navbar-header text-left">
          <a href="index.php" class="navbar-brand"><img src="img/logo_catastro.png"></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
    </nav>
  </header>
  
  <div class="content-wrapper" style="background-color: #ededed">

<br>
    <section class="content-header text-right">
      
    </section>


    <section class="content">
    
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
        
          <div class="box box-warning">
            <div class="box-header with-border">
             <div class="col-md-6">
             <h1 style="font-size: 28px">
        		<b>Metas y Actividades Realizadas</b>
      		</h1>
      		</div>
              <div class="col-md-6 text-right">
              	<a class="btn btn-lg btn-danger" href="../index.php">Inicio</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              

             <div style="clear: both"></div>
             
             <div class="row">
             
             	<form role="form" method="get" action="" autocomplete="off">
                 <div class="col-md-6">
              
                        <div class="form-group">
                          <label>Seleccionar período</label>
                          <select class="form-control" name="id_periodo">
                          	<?php $i=0;while($i < count($id_periodo)){?>
                          	<option <?php if($id_periodo[$i] == $periodo){echo 'selected="selected"';}?> value="<?php echo $id_periodo[$i]?>"><?php echo $inicio[$i]. ' al ' .$fin[$i]?></option>
                          	<?php $i++;}?>
                          </select>
                        </div>
                 
                 </div>
                 
                 <div class="col-md-4">
                 	<label style="color: white">ver</label>
                 	<button type="submit" class="btn btn-primary">Ver datos</button>
                 </div>
                 <div class="box-footer">
                    <a class="fancy  btn btn-warning mascara add" href="metas_indicadores.php" target="_blank">Indicadores</a>
                 </div>

				</form>              
             </div>
             			<div class="box-footer">
             			<?php if ($vigente == 'S'){?>
                        	<a class="fancy btn btn-warning mascara add" href="form.php">Agregar</a>
                        <?php }?>
                      </div>
                        
             
             
             <div class="box-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Modalidad</th>
                  <th>Tipo</th>
                  <th>POA</th>
                  <th>Activa</th>
                  <th>Meta</th>
                  <th>Realizado</th>
                  <th style="width: 10%">Detalle</th>
                  <?php if ($vigente == 'S'){?>
                  <th style="width: 10%">Editar</th>
                  <!-- <th style="width: 10%">Eliminar</th> -->
                  <?php }?>
                </tr>
                </thead>
                <tbody>
            <?php
            $i=0; while ($i < count($id_meta)){
              if($poa[$i] == 1){$poa[$i]  = 'Si';}else{$poa[$i]  = 'No';}
              if($activa[$i] == 1){$activa[$i] = 'Si';}else{$activa[$i] = 'No';}
              if($modalidad[$i] == 'R'){$modalidad[$i] = 'Regular';}
              if($modalidad[$i] == 'T'){$modalidad[$i] = 'Temporal';}
              if($modalidad[$i] == 'A'){$modalidad[$i] = 'Adicional';}
               echo'
                <tr>
                  <td>'.$nombre[$i].'</td>
           		    <td>'.$tipo[$i].'</td>
                  <td>'.$modalidad[$i].'</td>
                  <td>'.$poa[$i].'</td>
                  <td>'.$activa[$i].'</td>
                  <td>'.$meta[$i].'</td>
                  <td>'.$cantidad[$i].'</td>
                  
                 ';
               if ($vigente == 'S'){
               echo'
               <td><a class="fancy btn btn-default" href="form_new_cumplimiento.php?id_meta='.$id_meta[$i].'"><i class="fa fa-info"></i></a></td>
           		 <td><a class="fancy btn btn-default" href="form_edit.php?id_meta='.$id_meta[$i].'"><i class="fa fa-pencil"></i></a></td>
  		        ';
               }
               echo' 
                </tr>';
                  $i++;}
            ?>
                </tbody>
              </table>
            </div>
              
            </div>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
      
    </section>
    
  </div>

</div>


<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>


<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="vendor/peity/jquery.peity.min.js"></script>

<!-- App scripts -->
<script src="vendor/jquery-steps/lib/modernizr-2.6.2.min.js"></script>
<script src="vendor/jquery-steps/lib/jquery-1.9.1.min.js"></script>
<script src="vendor/jquery-steps/lib/jquery.cookie-1.3.1.js"></script>
<script src="vendor/jquery-steps/build/jquery.steps.js"></script>
<script src="scripts/homer.js"></script>
<script src="dist/jquery.fancybox.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Plugins para Datatables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
       jQuery(document).ready(function() {
           
        $("a.fancy").fancybox({
        	smallBtn : true,
            type : 'iframe',
            width: 600,
            iframe : {
                scrolling : 'yes'
            }       
        });
        
       });
</script>
<script>

  $(function () {
	  $("#tabla").DataTable({
		  "language": {
              "url": "plugins/datatables/Spanish.json"
          },
          "pageLength": 25
	    }); 
  });
  
</script>

<script>
  
</script>
<!-- Fin de plugins para Datatables -->

</body>
</html>