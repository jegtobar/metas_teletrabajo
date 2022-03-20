<?php

	function abrirConexion($usuario, $clave){
		$database = "(DESCRIPTION =
						(ADDRESS_LIST =
						  (ADDRESS = (PROTOCOL = TCP)(HOST = 172.23.50.95)(PORT = 1521))
						)
						(CONNECT_DATA =
						  (SERVICE_NAME = CATGIS)
						)
					  )";

	  	$conexion = oci_connect($usuario, $clave, $database);
	   
		if(!$conexion){
			$msg_error = oci_error();
			exit;
	   	}

		return $conexion;
	}

?>