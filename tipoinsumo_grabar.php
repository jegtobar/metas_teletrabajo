<?php

include 'auth.php';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];

	$query = "UPDATE TIPOINSUMO
		         SET DESCRIPCION = :nombre
			   WHERE ID_TIPOINSUMO =".$id;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":nombre", $nombre);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: tipoinsumo.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

}

$nombre = $_POST['nombre'];

$query = "INSERT INTO TIPOINSUMO (ID_TIPOINSUMO,
								  DESCRIPCION)
		                  VALUES (SEQ_TIPOINSUMO.NEXTVAL,
		                          :nombre)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":nombre", $nombre);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: tipoinsumo.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>