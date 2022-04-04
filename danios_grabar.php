<?php

include 'auth.php';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$grupodanio = $_POST['grupodanio'];
	$indiv = $_POST['individual'];
	
	if(empty($indiv)){$individual = 0;}elseif($indiv == 'on'){$individual = 1;}
	
	$query = "UPDATE CATDANIOS 
		         SET DESCRIPCION = :nombre,
	                 ID_GRUPODANIO = :grupodanio,
	                 DANIO_INDIVIDUAL = ".$individual."
			   WHERE ID_DANIO =".$id;
	
	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":nombre", $nombre);
	oci_bind_by_name($stid, ":grupodanio", $grupodanio);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: danios.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}
	
}

$nombre = $_POST['nombre'];
$grupodanio = $_POST['grupodanio'];
$indiv = $_POST['individual'];

if(empty($indiv)){$individual = 0;}elseif($indiv == 'on'){$individual = 1;}

$query = "INSERT INTO CATDANIOS (ID_DANIO,
								 DESCRIPCION,
                                 ID_GRUPODANIO,
                                 DANIO_INDIVIDUAL)
		                 VALUES (SEQ_CATDANIOS.NEXTVAL,
		                         :nombre,
                                 :grupodanio,
                                 ".$individual.")";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":grupodanio", $grupodanio);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: danios.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>