<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM PROTOCOLO 
			   WHERE ID_PROTOCOLO =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: protocolo.php?grabar=2');
	} else {
		header('Location: protocolo.php?grabar=3');
		die();
	}
	
?>