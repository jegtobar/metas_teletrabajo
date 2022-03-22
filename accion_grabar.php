<?php

include '../auth.php';
$grabo = 'N';

$nombre = $_POST['nombre'];
$modalidad = $_POST['modalidad'];
$tipo = $_POST['tipo'];
$cantidad = $_POST['cantidad'];
$poa = $_POST['poa'];
$activa = $_POST['activa'];
$detalle = [];
$detalle['seccion'] =$_POST['seccion'];
$detalle['meta'] = $_POST['meta'];


$meta = 0;
foreach ($detalle['meta'] as $item) {
    $meta = $meta + $item;
}


$query = "SELECT id_periodo,
                 to_char(fecha_inicio,'DD-MM-YYYY') as inicio,
                 to_char(fecha_fin,'DD-MM-YYYY') as fin
            FROM mte_periodo
           WHERE vigente = 'S'";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$id_periodo = $row['ID_PERIODO'];
$del = $row['INICIO'];
$al = $row['FIN'];

$query = "SELECT codarea
            FROM mte_areas
           WHERE usuarios LIKE '%".$usuario."%'";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$codarea = $row['CODAREA'];

   
$query = "INSERT INTO MTE_METAS (ID_META,
                                CODAREA,
                                PERIODO_DEL,
                                PERIODO_AL,
                                NOMBRE,
                                CANTIDAD,
                                META,
                                TIPO,
                                ID_PERIODO,
                                USUARIO,
                                MODALIDAD,
                                POA,
                                ACTIVA)
                        VALUES (SEQ_MTE_METAS.NEXTVAL,
                                ".$codarea.",
                                TO_DATE('".$del."','DD-MM-YYYY'),
                                TO_DATE('".$al."','DD-MM-YYYY'),
                                '".$nombre."',
                                ".$cantidad.",
                                ".$meta.",
                                '".$tipo."',
                                ".$id_periodo.",
                                '".$usuario."',
                                '".$modalidad."',
                                '".$poa."',
                                '".$activa."')";


$stid = oci_parse($conn, $query);
$mensaje = oci_execute($stid, OCI_DEFAULT);

if($mensaje){

    oci_commit($conn);
    $grabo='S';
    $realizado = 0;
    $i=0;
    //Detalle meta
    $query = "SELECT id_meta from mte_metas
    where rownum<=1
    order by id_meta desc
    ";
    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $idMeta = $row['ID_META'];

    foreach ($detalle['seccion'] as $item) {
        $meta = $detalle['meta']{$i};

        $query="INSERT INTO MTE_METAS_DETALLE(ID_META,
                                            CODAREA,
                                            META,
                                            FECHA,
                                            USUARIO,
                                            REALIZADO,
                                            COD_AREA_PARENT)
                                            VALUES($idMeta,
                                                    $item,
                                                    $meta,
                                                    SYSDATE,
                                                    '".$usuario."',
                                                    ".$realizado.",
                                                    $codarea
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

} else {
    
    $e = oci_error($stid);
    print htmlentities($e['message']);
    print "\n<pre>\n";
    print htmlentities($e['sqltext']);
    printf("\n%".($e['offset']+1)."s", "^");
    print  "\n</pre>\n";
    
    die();
    
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
</body>
</html>
