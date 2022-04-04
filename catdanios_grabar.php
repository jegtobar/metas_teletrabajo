<?php

include 'auth.php';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$cant = $_POST['cantidad'];
	$val = $_POST['valor'];
	
	if(empty($cant)){$cantidad = "N";}elseif($cant == 'on'){$cantidad = "S";}
	if(empty($val)){$valor = "N";}elseif($val == 'on'){$valor = "S";}
	
	$query = "UPDATE GRUPODANIO 
	             SET DESCRIPCION = :nombre,
	                 REQUIERE_CANTIDAD = :cantidad,
	                 REQUIERE_VALOR = :valor
			   WHERE ID_GRUPODANIO =".$id;
	
	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":nombre", $nombre);
	oci_bind_by_name($stid, ":cantidad", $cantidad);
	oci_bind_by_name($stid, ":valor", $valor);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
	
	
	if($mensaje){
	
		oci_commit($conn);
	
		header('Location: catdanios.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}
	
}

$nombre = $_POST['nombre'];
$cant = $_POST['cantidad'];
$val = $_POST['valor'];

if(empty($cant)){$cantidad = "N";}elseif($cant == 'on'){$cantidad = "S";}
if(empty($val)){$valor = "N";}elseif($val == 'on'){$valor = "S";}


$query = "INSERT INTO GRUPODANIO (ID_GRUPODANIO,
								  DESCRIPCION,
                                  REQUIERE_CANTIDAD,
                                  REQUIERE_VALOR)
		                  VALUES (SEQ_GRUPODANIO.NEXTVAL,
		                          :nombre,
                                  :cantidad,
                                  :valor)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":cantidad", $cantidad);
oci_bind_by_name($stid, ":valor", $valor);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: catdanios.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>