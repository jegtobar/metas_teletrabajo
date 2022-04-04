<?php

include 'auth.php';

$ini = $_REQUEST['ini'];
$fin = $_REQUEST['fin'];

$query = "SELECT nombre,
			     cantidad,
			     meta
            FROM mte_metas
           WHERE to_char(periodo_del,'DD-MM-YYYY') = '".$ini."'
                 AND to_char(periodo_al,'DD-MM-YYYY') = '".$fin."'
                 AND codarea = ".$codarea."
           ORDER BY nombre ASC";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {	

echo'
<tr>
<td><input type="text" class="form-control" placeholder="Nombre de la meta..." name="nombre[]" value="'.$row['NOMBRE'].'" required></td>
<td><input type="number" class="form-control" name="cantidad[]" value="'.$row['CANTIDAD'].'" required></td>
<td><input type="number" class="form-control" name="meta[]" value="'.$row['META'].'" required></td>
<td><button type="button" class="btn btn-danger" id="remove" name="remove"><i class="fa fa-trash-o"></i></button></td>
</tr>';
}
?>