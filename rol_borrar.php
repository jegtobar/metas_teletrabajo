<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM ROL 
			   WHERE ID_ROL =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: rol.php?grabar=2');
	} else {
		header('Location: rol.php?grabar=3');
		die();
	}
	
?>