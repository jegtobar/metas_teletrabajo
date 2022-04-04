<?php

include 'auth.php';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	
	$query = "UPDATE CATINSTITUCION 
		         SET NOMBRE = :nombre
			   WHERE ID_CATINSTITUCION =".$id;
	
	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":nombre", $nombre);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: categoria.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}
	
}

$nombre = $_POST['nombre'];

$query = "INSERT INTO CATINSTITUCION (ID_CATINSTITUCION,
								      NOMBRE)
		                      VALUES (SEQ_CATINSTITUCION.NEXTVAL,
		                              :nombre)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":nombre", $nombre);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: categoria.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>