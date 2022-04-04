<?php

include 'auth.php';

if(isset($_POST['ida']) && !empty($_POST['ida'])){
	$id = $_POST['ida'];
	$id_ins = $_POST['id_institucion'];
	$nombre = $_POST['nombre'];
	$funcion = $_POST['funcion'];

	$query = "UPDATE DEPENDENCIA
		         SET ID_INSTITUCION = :id,
			         NOMBRE = :nombre,
			         FUNCION = :funcion
			   WHERE ID_DEPENDENCIA =".$id;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":id", $id_ins);
	oci_bind_by_name($stid, ":nombre", $nombre);
	oci_bind_by_name($stid, ":funcion", $funcion);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: dependencia.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

}

$id = $_POST['id_institucion'];
$nombre = $_POST['nombre'];
$funcion = $_POST['funcion'];

$query = "INSERT INTO DEPENDENCIA (ID_DEPENDENCIA,
		                           ID_INSTITUCION,
								   NOMBRE,
								   FUNCION)
		                   VALUES (SEQ_DEPENDENCIA.NEXTVAL,
		                           :id,
		                           :nombre,
							       :funcion)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":id", $id);
oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":funcion", $funcion);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: dependencia.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>

