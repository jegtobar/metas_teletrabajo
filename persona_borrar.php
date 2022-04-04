<?php

include 'auth.php';

	$id = $_GET['id'];
	
	$query = "DELETE FROM PERSONA
			   WHERE ID_PERSONA =".$id;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: persona.php?grabar=2');
	} else {
		header('Location: persona.php?grabar=3');
	}
	
?>