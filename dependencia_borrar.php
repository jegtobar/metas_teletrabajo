<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM DEPENDENCIA 
			   WHERE ID_DEPENDENCIA =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: dependencia.php?grabar=2');
	} else {
		header('Location: dependencia.php?grabar=3');
	}
	
?>