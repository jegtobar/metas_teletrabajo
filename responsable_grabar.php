<?php

include 'auth.php';

echo "<pre>";
print_r($_POST);
echo "</pre>";



if(isset($_POST['id_rl']) && !empty($_POST['id_rl'])){
	

	
	$id_pr = $_POST['id_pr'];
	$id_dp = $_POST['id_dp'];
	$id_rl = $_POST['id_rl'];
	$id_per = $_POST['id_persona'];
	$id_dep = $_POST['id_dependencia'];
	$id_rol = $_POST['id_rol'];
	$zona = $_POST['zona'];

	if(empty($_POST['titular'])){$titular = "N";}elseif($_POST['titular'] == 'on'){
		$titular = "S";
		$query = "UPDATE RESPONSABLE
		             SET TITULAR = 'N'
			       WHERE ID_ROL = ".$id_rl."
			             AND ZONA <= 0";
		
		$stid = oci_parse($conn, $query);
		$mensaje = oci_execute($stid, OCI_DEFAULT);
		
	}
	
	$query = "UPDATE RESPONSABLE
		         SET ID_PERSONA = :id_persona,
			         ID_DEPENDENCIA = :id_dependencia,
			         ID_ROL = :id_rol,
			         ZONA = :zona,
			         TITULAR = :titular
			   WHERE ID_PERSONA = ".$id_pr."
                 AND ID_ROL = ".$id_rl."
                 AND ID_DEPENDENCIA = ".$id_dp;

	$stid = oci_parse($conn, $query);
	oci_bind_by_name($stid, ":id_persona", $id_per);
	oci_bind_by_name($stid, ":id_dependencia", $id_dep);
	oci_bind_by_name($stid, ":id_rol", $id_rol);
	oci_bind_by_name($stid, ":titular", $titular);
	oci_bind_by_name($stid, ":zona", $zona);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){

		oci_commit($conn);

		header('Location: responsable.php?grabar=1');
		die();
		} else {
		header('Location: responsable.php?grabar=3');
		die();
		}

}

$id_per = $_POST['id_persona'];
$id_dep = $_POST['id_dependencia'];
$id_rol = $_POST['id_rol'];
$zona = $_POST['zona'];

if(empty($_POST['titular'])){$titular = "N";}elseif($_POST['titular'] == 'on'){
	$titular = "S";
	$query = "UPDATE RESPONSABLE
		             SET TITULAR = 'N'
			       WHERE AND ID_ROL = ".$id_rl;

	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);
}

$query = "INSERT INTO RESPONSABLE (ID_PERSONA,
		                           ID_ROL,
								   ID_DEPENDENCIA,
		                           ZONA,
		                           TITULAR)
		                   VALUES (:id_persona,
		                           :id_rol,
		                           :id_dependencia,
		                           :zona,
		                           :titular)";
$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":id_persona", $id_per);
oci_bind_by_name($stid, ":titular", $titular);
oci_bind_by_name($stid, ":id_dependencia", $id_dep);
oci_bind_by_name($stid, ":id_rol", $id_rol);
oci_bind_by_name($stid, ":zona", $zona);

$mensaje = oci_execute($stid, OCI_DEFAULT);


if($mensaje){

	oci_commit($conn);

	header('Location: responsable.php?grabar=1');
} else {
	header('Location: responsable.php?grabar=3');
}
?>

