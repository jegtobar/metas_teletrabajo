<?php

/* Database connection information */

$ora_conn['user']     = "rrhh";
$ora_conn['password'] = "rrhhadmin";
$ora_conn['schema']   = "CATGIS";
$ora_conn['port']     = "1521";
$ora_conn['server']   = "172.23.50.95";

$connection_string = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)
(HOST = {$ora_conn['server']  })(PORT = {$ora_conn['port'] })))(CONNECT_DATA=(SID={$ora_conn['schema']})))";

/*
 * Oracle connection
 */
$conn = oci_connect($ora_conn['user'], $ora_conn['password'], $connection_string, 'AL32UTF8');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

?>
