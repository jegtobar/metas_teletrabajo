<?php

include 'auth.php';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$descripion = $_POST['descripcion'];

	$query = "UPDATE ROL
		         SET NOMBRE = :nombre,
			         DESCRIPCION = :descripcion
			   WHERE ID_ROL =".$id;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":nombre", $nombre);
	oci_bind_by_name($stid, ":descripcion", $descripion);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: rol.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

}

$nombre = $_POST['nombre'];
$descripion = $_POST['descripcion'];

$query = "INSERT INTO ROL (ID_ROL,
						   NOMBRE,
						   DESCRIPCION)
		           VALUES (SEQ_ROL.NEXTVAL,
		                   :nombre,
						   :descripcion)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":descripcion", $descripion);

$mensaje = oci_execute($stid, OCI_DEFAULT);

if($mensaje){

	oci_commit($conn);

	header('Location: rol.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>