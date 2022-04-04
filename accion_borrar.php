<?php

include 'auth.php';

$ini = $_REQUEST['fecha_ini'];
$fin = $_REQUEST['fecha_fin'];

$query = "DELETE FROM MTE_METAS
               WHERE to_char(periodo_del,'DD-MM-YYYY') = '".$ini."'
                     AND to_char(periodo_al,'DD-MM-YYYY') = '".$fin."'
                     AND codarea = ".$codarea."";

$stid = oci_parse($conn, $query);
$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: accion.php?grabar=2');
} else {
	die();
}

?>

