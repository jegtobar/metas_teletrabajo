<?php

include 'auth.php';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$id_criticidad = $_POST['id_criticidad'];
	$nombre = $_POST['nombre'];
	$descripion = $_POST['descripcion'];

	$query = "UPDATE INCIDENCIA
		         SET ID_CRITICIDAD = :id_criticidad,
			         NOMBRE = :nombre,
			         DESCRIPCION = :descripcion
			   WHERE ID_INCIDENCIA =".$id;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":id_criticidad", $id_criticidad);
	oci_bind_by_name($stid, ":nombre", $nombre);
	oci_bind_by_name($stid, ":descripcion", $descripion);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: incidencia.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

}

$id_criticidad = $_POST['id_criticidad'];
$nombre = $_POST['nombre'];
$descripion = $_POST['descripcion'];

$query = "INSERT INTO INCIDENCIA (ID_INCIDENCIA,
		                          ID_CRITICIDAD,
								  NOMBRE,
								  DESCRIPCION)
		                  VALUES (SEQ_INCIDENCIA.NEXTVAL,
		                          :id_criticidad,
		                          :nombre,
							      :descripcion)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":id_criticidad", $id_criticidad);
oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":descripcion", $descripion);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: incidencia.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>

