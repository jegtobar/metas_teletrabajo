<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM INSTITUCION 
			   WHERE ID_INSTITUCION =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: institucion.php?grabar=2');
	} else {
		header('Location: institucion.php?grabar=3');
		die();
	}
	
?>