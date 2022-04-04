<?php

include 'auth.php';

if(isset($_POST['ac']) && !empty($_POST['ac'])){
	$ac = $_POST['ac'];
	$in = $_POST['in'];
	$id_accion = $_POST['id_accion'];
	$id_insumo = $_POST['id_insumo'];
	$nombre = $_POST['nombre'];
	
	$query = "UPDATE ACCION_INSUMO
		         SET ID_ACCION = :id_accion,
			         ID_INSUMO = :id_insumo,
			         COMENTARIO = :nombre
			   WHERE ID_ACCION =".$ac."
			   		 AND ID_INSUMO =".$in;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":id_accion", $id_accion);
	oci_bind_by_name($stid, ":id_insumo", $id_insumo);
	oci_bind_by_name($stid, ":nombre", $nombre);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: accioninsumo.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

}

$id_accion = $_POST['id_accion'];
$id_insumo = $_POST['id_insumo'];
$nombre = $_POST['nombre'];

$query = "INSERT INTO ACCION_INSUMO (ID_ACCION,
		                             ID_INSUMO,
								     COMENTARIO)
		                     VALUES (:id_accion,
		                             :id_insumo,
		                             :nombre)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":id_accion", $id_accion);
oci_bind_by_name($stid, ":id_insumo", $id_insumo);
oci_bind_by_name($stid, ":nombre", $nombre);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: accioninsumo.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>

