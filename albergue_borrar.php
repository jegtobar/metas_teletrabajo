<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM ALBERGUE
			   WHERE ID_ALBERGUE =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: albergue.php?grabar=2');
	} else {
		header('Location: albergue.php?grabar=3');
		die();
	}
	
?>