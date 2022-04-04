<?php

include 'auth.php';

$region = "+502";

if(isset($_POST['id']) && !empty($_POST['id'])){
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$tel = $region.$_POST['tel'];
	if(isset($_POST['tel_alt']) && !empty($_POST['tel_alt'])){
	$tel_alt = $region.$_POST['tel_alt'];
	}
	$email = $_POST['email'];
	$email_alt = $_POST['email_alt'];
	$id_disp = 1;
	$plataforma = 1;

	$query = "UPDATE PERSONA
		         SET NOMBRE = :nombre,
		             ID_DISPOSITIVO = :id_disp,
		             PLATAFORMA = :plataforma,
					 TELEFONO = :tel,
		             TELEFONO_ALTERNO = :tel_alt,
		             EMAIL = :email,
		             EMAIL_ALTERNO = :email_alt
			   WHERE ID_PERSONA =".$id;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":nombre", $nombre);
	oci_bind_by_name($stid, ":id_disp", $id_disp);
	oci_bind_by_name($stid, ":plataforma", $plataforma);
	oci_bind_by_name($stid, ":tel", $tel);
	oci_bind_by_name($stid, ":tel_alt", $tel_alt);
	oci_bind_by_name($stid, ":email", $email);
	oci_bind_by_name($stid, ":email_alt", $email_alt);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: persona.php?grabar=1');
		die();
	} else {
		echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
		die();
	}

}

$nombre = $_POST['nombre'];
$tel = $region.$_POST['tel'];
if(isset($_POST['tel_alt']) && !empty($_POST['tel_alt'])){
$tel_alt = $region.$_POST['tel_alt'];
}
$email = $_POST['email'];
$email_alt = $_POST['email_alt'];
$id_disp = 1;
$plataforma = 1;

$query = "INSERT INTO PERSONA (ID_PERSONA,
		                       NOMBRE,
		                       ID_DISPOSITIVO,
		                       PLATAFORMA,
							   TELEFONO,
		                       TELEFONO_ALTERNO,
		                       EMAIL,
		                       EMAIL_ALTERNO)
		               VALUES (SEQ_PERSONA.NEXTVAL,
							   :nombre,
		                       :id_disp,
		                       :plataforma,
							   :tel,
		                       :tel_alt,
		                       :email,
		                       :email_alt)";

$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":id_disp", $id_disp);
oci_bind_by_name($stid, ":plataforma", $plataforma);
oci_bind_by_name($stid, ":tel", $tel);
oci_bind_by_name($stid, ":tel_alt", $tel_alt);
oci_bind_by_name($stid, ":email", $email);
oci_bind_by_name($stid, ":email_alt", $email_alt);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: persona.php?grabar=1');
} else {
	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
}
?>

