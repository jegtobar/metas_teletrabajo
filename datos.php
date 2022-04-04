<?php

include 'auth.php';

$protocolo = $_POST['protocolo'];
if(isset($_POST['id_accion']) && !empty($_POST['id_accion'])){
	$accion = $_POST['id_accion'];
}else{$accion = 0;}
$query = "  SELECT  ID_ACCION,
				    DESCRIPCION
  			  FROM  ACCION
 		     WHERE  ID_PROTOCOLO = '".$protocolo."'";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

$var_select = '';

$var_select.= '<option></option>';

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	$var_select.= '<option value="'. $row['ID_ACCION'] .'"';
	if ($accion==$row['ID_ACCION']) {
		$var_select.= 'selected="selected"';
	}
	$var_select.= '>'. $row['DESCRIPCION'] .'</option>';
}

echo $var_select;