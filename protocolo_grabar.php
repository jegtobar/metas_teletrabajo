<?php

include 'auth.php';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$id_criticidad = $_POST['id_criticidad'];
	$nombre = $_POST['nombre'];
	$descripion = $_POST['descripcion'];

	$query = "UPDATE PROTOCOLO
		         SET ID_CRITICIDAD = :id_criticidad,
			         NOMBRE = :nombre,
			         DESCRIPCION = :descripcion
			   WHERE ID_PROTOCOLO =".$id;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":id_criticidad", $id_criticidad);
	oci_bind_by_name($stid, ":nombre", $nombre);
	oci_bind_by_name($stid, ":descripcion", $descripion);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: protocolo.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

}

if(!empty($_POST['id_criticidad'])){$id_criticidad = $_POST['id_criticidad'];} else{$id_criticidad = 0;}
echo $nombre = $_POST['nombre'];
echo $descripion = $_POST['descripcion'];

echo $query = "INSERT INTO PROTOCOLO (ID_PROTOCOLO,
		                              ID_CRITICIDAD,
								      NOMBRE,
								      DESCRIPCION)
		                      VALUES (SEQ_PROTOCOLO.NEXTVAL,
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

	header('Location: protocolo.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>

