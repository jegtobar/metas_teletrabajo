<?php

include 'auth.php';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$id_cat = $_POST['id_categoria'];
	$id_tipo = $_POST['id_tipo'];
	$nombre = $_POST['nombre'];
	$funcion = $_POST['funcion'];
	
	$query = "UPDATE INSTITUCION
		         SET ID_CATINSTITUCION = :id_cat,
			         ID_TIPOINSTITUCION = :id_tipo,
			         NOMBRE = :nombre,
			         FUNCION = :funcion
			   WHERE ID_INSTITUCION =".$id;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":id_cat", $id_cat);
	oci_bind_by_name($stid, ":id_tipo", $id_tipo);
	oci_bind_by_name($stid, ":nombre", $nombre);
	oci_bind_by_name($stid, ":funcion", $funcion);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: institucion.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

}

$id_cat = $_POST['id_categoria'];
$id_tipo = $_POST['id_tipo'];
$nombre = $_POST['nombre'];
$funcion = $_POST['funcion'];

$query = "INSERT INTO INSTITUCION (ID_INSTITUCION,
		                           ID_CATINSTITUCION,
		                           ID_TIPOINSTITUCION,
								   NOMBRE,
								   FUNCION)
		                   VALUES (SEQ_INSTITUCION.NEXTVAL,
		                           :id_cat,
		                           :id_tipo,
		                           :nombre,
							       :funcion)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":id_cat", $id_cat);
oci_bind_by_name($stid, ":id_tipo", $id_tipo);
oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":funcion", $funcion);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: institucion.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>

