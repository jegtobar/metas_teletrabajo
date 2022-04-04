<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM INCIDENCIA 
			   WHERE ID_INCIDENCIA =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: incidencia.php?grabar=2');
	} else {
		header('Location: incidencia.php?grabar=3');
		die();
	}
	
?>