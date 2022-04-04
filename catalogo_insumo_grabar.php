<?php

include 'auth.php';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$id_tipoinsumo = $_POST['id_tipoinsumo'];
	$nombre = $_POST['nombre'];

	$query = "UPDATE CATINSUMO
		         SET ID_TIPOINSUMO = :id_tipoinsumo,
			         DESCRIPCION = :nombre
			   WHERE ID_INSUMO =".$id;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":id_tipoinsumo", $id_tipoinsumo);
	oci_bind_by_name($stid, ":nombre", $nombre);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: catalogo_insumo.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

}

if(!empty($_POST['id_tipoinsumo'])){$id_tipoinsumo = $_POST['id_tipoinsumo'];} else{$id_tipoinsumo = 0;}
$nombre = $_POST['nombre'];

$query = "INSERT INTO CATINSUMO (ID_INSUMO,
		                         ID_TIPOINSUMO,
								 DESCRIPCION)
		                 VALUES (SEQ_CATINSUMO.NEXTVAL,
		                         :id_tipoinsumo,
		                         :nombre)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":id_tipoinsumo", $id_tipoinsumo);
oci_bind_by_name($stid, ":nombre", $nombre);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: catalogo_insumo.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>

