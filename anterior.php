<?php

include 'db.php';

$tabla = $_GET['tabla'];
$id = $_GET['id'];

echo $query = "INSERT INTO BITACORA (USUARIO,
		                        TABLA,
		                        ANTERIOR)
		                VALUES ('GMARTINEZ',
		                        '".$tabla."',
		                        'AQUI EL RESULTADO DEL QUERY')";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
oci_commit($conn);

echo $tabla.$id;