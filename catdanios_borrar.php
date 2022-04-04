<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM GRUPODANIO 
			   WHERE ID_GRUPODANIO =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: catdanios.php?grabar=2');
	} else {
		header('Location: catdanios.php?grabar=3');
		die();
	}
	
?>