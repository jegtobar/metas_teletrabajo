<?php

include 'auth.php';

	$per = $_GET['per'];
	$rol = $_GET['rol'];
	$dep = $_GET['dep'];
	
	$query = "DELETE FROM RESPONSABLE 
			        WHERE ID_PERSONA =".$per."
			          AND ID_ROL =".$rol."
			          AND ID_DEPENDENCIA =".$dep;
	
	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: responsable.php?grabar=2');
	} else {
		die();
	}
	
?>