<?php

include 'auth.php';

echo '<pre>';
print_r($_POST);
echo '</pre>';

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$zona = $_POST['zona'];
	$direccion = $_POST['direccion'];
	$estado = $_POST['estado'];
	$capacidad = $_POST['capacidad'];
	$responsable = $_POST['responsable'];
	$telefono = $_POST['telefono'];
	$email = $_POST['email'];
	
	$query = "UPDATE ALBERGUE
		         SET NOMBREALBERGUE = :nombre,
			         ZONA = :zona,
			         DIRECCION = :direccion,
			         ESTADO = :estado,
	                 CAPACIDAD = :capacidad,
	                 NOMBRE_RESPONSABLE = :responsable,
	                 TEL_RESPONSABLE = :telefono,
	                 EMAIL_RESPONSABLE = :email
			   WHERE ID_ALBERGUE =".$id;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":nombre", $nombre);
	oci_bind_by_name($stid, ":zona", $zona);
	oci_bind_by_name($stid, ":direccion", $direccion);
	oci_bind_by_name($stid, ":estado", $estado);
	oci_bind_by_name($stid, ":capacidad", $capacidad);
	oci_bind_by_name($stid, ":responsable", $responsable);
	oci_bind_by_name($stid, ":telefono", $telefono);
	oci_bind_by_name($stid, ":email", $email);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: albergue.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

}

$nombre = $_POST['nombre'];
$zona = $_POST['zona'];
$direccion = $_POST['direccion'];
$estado = $_POST['estado'];
$capacidad = $_POST['capacidad'];
$responsable = $_POST['responsable'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$tipo = 'M';

$query = "INSERT INTO ALBERGUE (ID_ALBERGUE,
		                        NOMBREALBERGUE,
		                        ZONA,
								DIRECCION,
								ESTADO,
                                TIPO,
                                CAPACIDAD,
                                NOMBRE_RESPONSABLE,
                                TEL_RESPONSABLE,
                                EMAIL_RESPONSABLE)
		                VALUES (SEQ_ALBERGUE.NEXTVAL,
		                        :nombre,
		                        :zona,
		                        :direccion,
							    :estado,
                                :tipo,
                                :capacidad,
                                :responsable,
                                :telefono,
                                :email)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":zona", $zona);
oci_bind_by_name($stid, ":direccion", $direccion);
oci_bind_by_name($stid, ":estado", $estado);
oci_bind_by_name($stid, ":tipo", $tipo);
oci_bind_by_name($stid, ":capacidad", $capacidad);
oci_bind_by_name($stid, ":responsable", $responsable);
oci_bind_by_name($stid, ":telefono", $telefono);
oci_bind_by_name($stid, ":email", $email);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: albergue.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>

