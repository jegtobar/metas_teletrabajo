<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM TIPOINSUMO 
			   WHERE ID_TIPOINSUMO =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: tipoinsumo.php?grabar=2');
	} else {
		header('Location: tipoinsumo.php?grabar=3');
		die();
	}
	
?>