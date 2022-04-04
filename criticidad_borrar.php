<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "SELECT SIMBOLO
			    FROM CRITICIDAD
			   WHERE ID_CRITICIDAD ='".$id."'";
	
	$stid = oci_parse($conn, $query);
	oci_execute($stid, OCI_DEFAULT);
	$rowe = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	
	
	$query = "DELETE FROM CRITICIDAD 
			   WHERE ID_CRITICIDAD ='".$id."'";
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
		
		unlink($rowe['SIMBOLO']);
	
		header('Location: criticidad.php?grabar=5');
	} else {
		header('Location: criticidad.php?grabar=6');
		die();
	}
	
?>