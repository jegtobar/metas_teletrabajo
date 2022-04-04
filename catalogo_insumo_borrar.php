<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM CATINSUMO 
			   WHERE ID_INSUMO =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: catalogo_insumo.php?grabar=2');
	} else {
		header('Location: catalogo_insumo.php?grabar=3');
		die();
	}
	
?>