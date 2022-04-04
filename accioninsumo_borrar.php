<?php

include 'auth.php';

	$ac = $_GET['ac'];
	$in = $_GET['in'];
	
	$query = "DELETE FROM ACCION_INSUMO 
			   WHERE ID_ACCION =".$ac."
			   	 AND ID_INSUMO =".$in;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: accioninsumo.php?grabar=2');
	} else {
		header('Location: accioninsumo.php?grabar=3');
		die();
	}
	
?>