<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM CATDANIOS 
			   WHERE ID_DANIO =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: danios.php?grabar=2');
	} else {
		header('Location: danios.php?grabar=3');
		die();
	}
	
?>