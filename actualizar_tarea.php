<?php

include '../auth.php';
$grabo = 'N';
$idMetaPadre = $_POST['metaId'];
$nombre = $_POST['nombre'];
// $cantidad = $_POST['cantidad'];
// $mte_meta = $_POST['mte_meta'];
$modalidad = $_POST['modalidad'];
$justificacion = $_POST['justificacion'];
$tipo = $_POST['tipo'];
$detalle = [];
if (isset($_POST['detalleMetaEdit'])){


    $detalle['meta']=$_POST['detalleMetaEdit'];
    $meta = 0;
    foreach ($detalle['meta'] as $item) {
        $meta = $meta + (int)$item;
        
    }

}

if(!isset($_POST['estatus'])){
    $activa=0;
}else{
    $activa = $_POST['estatus'];
}

if(!isset($_POST['poa'])){
    $poa=0;
}else{
    $poa = $_POST['poa'];
}




if(empty($justificacion)){
    $justificacion = " ";
}


$query = "SELECT b.ID_META_DETALLE,
                     a.DESCRIPCION,
                     b.META
              FROM MTE_METAS_DETALLE b
              INNER JOIN rh_areas a on a.CODAREA = b.CODAREA
              WHERE ID_META =".$idMetaPadre;
    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
      $id_detalle[] = $row['ID_META_DETALLE'];
      $dependencia[] = $row['DESCRIPCION'];
      $detalle_meta[] = $row['META'];
    }
    $grabo = '';
    if (isset($detalle_meta)){
      $metaTDet = 0;
    foreach ($detalle_meta as $item) {
        $metaTDet =  $metaTDet + $item;
    }
    
}





if (isset($_POST['guardarMeta'])){
   
  
    $query = "UPDATE MTE_METAS 
                 SET NOMBRE = '".$nombre."',
                     TIPO = '".$tipo."',
                     MODALIDAD = '".$modalidad."',
                     USUARIO = '".$usuario."',
                     POA = '".$poa."',
                     ACTIVA = '".$activa."',
                     JUSTIFICACION = '".$justificacion."'
               WHERE id_meta = ".$idMetaPadre;


   $stid = oci_parse($conn, $query);          
   $mensaje = oci_execute($stid, OCI_DEFAULT);
  
 
   if($mensaje){
       
       oci_commit($conn);
       $grabo = 'S';
       
       if (isset($_POST['metaIdDetalle'])){
       $idMetaDetalle=[];
       $idMetaDetalle['id']=$_POST['metaIdDetalle'];
       $grabo = 'S';
       $i=0;

       $query = "SELECT  META,CODAREA,ID_PERIODO
       FROM  MTE_METAS
       WHERE id_meta = ".$idMetaPadre;
       $stid = oci_parse($conn, $query);
       oci_execute($stid, OCI_DEFAULT);
       $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
       $metaActual = $row['META'];
       $cod_area_parent = $row['CODAREA'];
       $id_periodo = $row['ID_PERIODO'];

       $metaT = 0;
       $l=0;
       foreach ($idMetaDetalle['id'] as $item) {
           $m = $detalle['meta']{$l};
           $metaT = $metaT + $m ;
           $l++;
       }
       if($metaT > $metaActual){
           $grabo = 'M';
       }else{

       foreach ($idMetaDetalle['id'] as $item) {
           $meta = $detalle['meta']{$i};
           $idMeta = $item;
       
           $query = "UPDATE MTE_METAS_DETALLE
                 SET META = $meta,
                     COD_AREA_PARENT = $cod_area_parent,
                     ID_PERIODO = $id_periodo
               WHERE ID_META_DETALLE = ".$idMeta;
               $stid = oci_parse($conn, $query);
               $msj = oci_execute($stid, OCI_DEFAULT);
               if($msj){
                   oci_commit($conn);
                   $i++;
               }else {
                       $e = oci_error($stid);
                       print htmlentities($e['message']);
                       print "\n<pre>\n";
                       print htmlentities($e['sqltext']);
                       printf("\n%".($e['offset']+1)."s", "^");
                       print  "\n</pre>\n";
                       
                       die();
                       
                   }
           }
       }
   }

       
   } else {
       
       $e = oci_error($stid);
       print htmlentities($e['message']);
       print "\n<pre>\n";
       print htmlentities($e['sqltext']);
       printf("\n%".($e['offset']+1)."s", "^");
       print  "\n</pre>\n";
       
       die();
       
   }
}


if (isset($_POST['seccionDetalleNew'])){
   $realizado = 0;
   $i=0;
   $detalleMeta = [];
   $detalleMeta['seccion'] =$_POST['seccionDetalleNew'];
   $detalleMeta['meta'] = $_POST['detalleMetaEditNew'];

   $meta = 0;
   foreach ($detalleMeta['meta'] as $item) {
       $meta = $meta + $item;
   }

   $query = "SELECT  META 
               FROM  MTE_METAS
               WHERE id_meta = ".$idMetaPadre;
   $stid = oci_parse($conn, $query);
   oci_execute($stid, OCI_DEFAULT);
   $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
   $metaActual = $row['META'];
   if($meta > $metaActual){
       $grabo = 'M';
   }else{
   $cantidad=0;
    $query = "UPDATE MTE_METAS 
                 SET NOMBRE = '".$nombre."',
                     CANTIDAD = ".$cantidad.",
                     TIPO = '".$tipo."',
                     MODALIDAD = '".$modalidad."',
                     USUARIO = '".$usuario."',
                     POA = '".$poa."',
                     ACTIVA = '".$activa."',
                     JUSTIFICACION = '".$justificacion."'
               WHERE id_meta = ".$idMetaPadre;
   
                 
   $stid = oci_parse($conn, $query);          
   $mensaje = oci_execute($stid, OCI_DEFAULT);
  
 
   if($mensaje){
       oci_commit($conn);
       $grabo = 'S';
       foreach ($detalleMeta['seccion'] as $item) {
           $meta = $detalleMeta['meta']{$i};
   
           $query="INSERT INTO MTE_METAS_DETALLE(
                                               ID_META,
                                               CODAREA,
                                               META,
                                               FECHA,
                                               USUARIO,
                                               REALIZADO)
                                               VALUES(
                                                       $idMetaPadre,
                                                       $item,
                                                       $meta,
                                                       SYSDATE,
                                                       '".$usuario."',
                                                       ".$realizado."
                                               )";
                                    
           $stid = oci_parse($conn, $query);
           $msj = oci_execute($stid, OCI_DEFAULT);
           if($msj){
               oci_commit($conn);
               $i++;
           }else {
                   $e = oci_error($stid);
                   print htmlentities($e['message']);
                   print "\n<pre>\n";
                   print htmlentities($e['sqltext']);
                   printf("\n%".($e['offset']+1)."s", "^");
                   print  "\n</pre>\n";
                   
                   die();
                   
               }
   }
}
}
}

?>

<!DOCTYPE html>
<html>
<head>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">

   <!-- Page title -->
   <title>Satisfaccion Cliente Interno</title>

   <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
   <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

   <!-- Vendor styles -->
   <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css" />
   <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css" />
   <link rel="stylesheet" href="vendor/animate.css/animate.css" />
   <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css" />
   <link rel="stylesheet" href="vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" />
   <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />

   <!-- App styles -->
   <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
   <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css" />
   <link rel="stylesheet" href="styles/style.css">
   <link rel="stylesheet" href="dist/jquery.fancybox.min.css">
   <link rel="stylesheet" href="vendor/jquery-steps/demo/css/jquery.steps.css">
   <link rel="stylesheet" href="styles/custom_radios.css">
<!-- Parsley Style -->
 <style type="text/css">
 .parsley-required{
 color: red;
 }
 </style>
<!-- End Parsley Style -->
</head>
<body class="hide-sidebar">
   
   
<!-- Main Wrapper -->
<div id="wrapper">

   <div class="content animate-panel">
      
       
   </div>
   
<footer class="footer">
</footer>    
   
</div>



<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>
<script src="dist/jquery.fancybox.min.js"></script>
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="vendor/peity/jquery.peity.min.js"></script>

<!-- App scripts -->
<script src="vendor/jquery-steps/lib/modernizr-2.6.2.min.js"></script>
<script src="vendor/jquery-steps/lib/jquery-1.9.1.min.js"></script>
<script src="vendor/jquery-steps/lib/jquery.cookie-1.3.1.js"></script>
<script src="vendor/jquery-steps/build/jquery.steps.js"></script>
<script src="scripts/homer.js"></script>

<script src="vendor/jquery-validate/jquery.validate.js"></script>


<?php if ($grabo == 'S'){?>
<script>
$( document ).ready(function() {
   
   swal({
               title: "Listo!",
               text: "El registro ha sido grabado con éxito",
               type: "success",
               showCancelButton: false,
               confirmButtonColor: "#3F5872",
               confirmButtonText: "Ok",
               closeOnConfirm: false,
               closeOnCancel: false 
        },
           function (isConfirm) {
               if (isConfirm) {
                       parent.location.reload(true);
               }
           }
   );

});
</script>
<?php }?>


<?php if ($grabo == 'M'){?>
<script>
$( document ).ready(function() {
   
   swal({
       type: 'error',
       title: 'Oops...',
       text: 'El detalle no puede ser mayor a la meta establecida',
        },
           function (isConfirm) {
               if (isConfirm) {
                       parent.location.reload(true);
               }
           }
   );

});
</script>
<?php }?>
</body>
</html>
