<?php

include 'auth.php';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$id_criticidad = $_POST['id_criticidad'];
	$nombre = $_POST['nombre'];
	$descripion = $_POST['descripcion'];
	$borrar = $_POST['img'];
	
	if(!empty($_FILES['imagen']['name'])){
	
	$target_dir = "img/ave/";
	$target_file = $target_dir . basename($_FILES["imagen"]["name"]);
	$imagen_tipo = pathinfo($target_file,PATHINFO_EXTENSION);
	
	
	// Check if file already exists
	if (file_exists($target_file)) {
		header('Location: criticidad.php?grabar=2');
		die();
	}
	
	// Allow certain file formats
	if($imagen_tipo != "jpg" && $imagen_tipo != "png" && $imagen_tipo != "jpeg" &&
			$imagen_tipo != "JPG" && $imagen_tipo != "PNG" && $imagen_tipo != "JPEG") {
				header('Location: criticidad.php?grabar=4');
				die();
			}
	
			if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["imagen"]["name"]). " has been uploaded.";
			} else {
				header('Location: criticidad.php?grabar=3');
				die();
			}
			
    unlink($borrar);
    
	$query = "UPDATE CRITICIDAD
		         SET ID_CRITICIDAD = UPPER(:id_criticidad),
			         NOMBRE = :nombre,
			         DESCRIPCION = :descripcion,
			         SIMBOLO = :imagen
			   WHERE ID_CRITICIDAD ='".$id."'";

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":id_criticidad", $id_criticidad);
	oci_bind_by_name($stid, ":descripcion", $descripion);
	oci_bind_by_name($stid, ":nombre", $nombre);
	oci_bind_by_name($stid, ":imagen", $target_file);
	$mensaje = oci_execute($stid, OCI_DEFAULT);

	if($mensaje){

		oci_commit($conn);
		header('Location: criticidad.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

	}
	
	
	else{
		$id = $_POST['id'];
		$id_criticidad = $_POST['id_criticidad'];
		$nombre = $_POST['nombre'];
		$descripion = $_POST['descripcion'];
		
		$query = "UPDATE CRITICIDAD
		             SET ID_CRITICIDAD = UPPER(:id_criticidad),
				         NOMBRE = :nombre,
			             DESCRIPCION = :descripcion
			       WHERE ID_CRITICIDAD ='".$id."'";
		
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ":nombre", $nombre);
		oci_bind_by_name($stid, ":id_criticidad", $id_criticidad);
		oci_bind_by_name($stid, ":descripcion", $descripion);
		$mensaje = oci_execute($stid, OCI_DEFAULT);
		
		if($mensaje){
		
			oci_commit($conn);
			header('Location: criticidad.php?grabar=1');
			die();
		} else {
			echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
			die();
	}}}

$target_dir = "img/ave/";
$target_file = $target_dir . basename($_FILES["imagen"]["name"]);
$imagen_tipo = pathinfo($target_file,PATHINFO_EXTENSION);


// Check if file already exists
if (file_exists($target_file)) {
	header('Location: criticidad.php?grabar=2');
	die();
}

// Allow certain file formats
if($imagen_tipo != "jpg" && $imagen_tipo != "png" && $imagen_tipo != "jpeg" &&
   $imagen_tipo != "JPG" && $imagen_tipo != "PNG" && $imagen_tipo != "JPEG") {
			header('Location: criticidad.php?grabar=4');
			die();
}

if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["imagen"]["name"]). " has been uploaded.";
} else {
	header('Location: criticidad.php?grabar=3');
	die();
	}
	
$id_criticidad = $_POST['id_criticidad'];
$nombre = $_POST['nombre'];
$descripion = $_POST['descripcion'];

$query = "INSERT INTO CRITICIDAD (ID_CRITICIDAD,
								  NOMBRE,
								  DESCRIPCION,
								  SIMBOLO)
		                  VALUES (UPPER(:id_criticidad),
		                          :nombre,
							      :descripcion,
								  :imagen)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":id_criticidad", $id_criticidad);
oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":descripcion", $descripion);
oci_bind_by_name($stid, ":imagen", $target_file);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: criticidad.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>