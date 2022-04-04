<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM TIPOINSTITUCION 
			   WHERE ID_TIPOINSTITUCION =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: tipo.php?grabar=2');
	} else {
		header('Location: tipo.php?grabar=3');
		die();
	}
	
?>