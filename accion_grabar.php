<?php

include 'auth.php';

$del = $_POST['del'];
$al = $_POST['al'];
$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$meta = $_POST['meta'];

if (isset($_POST['update']) && !empty($_POST['update'])){


    $query = "DELETE FROM MTE_METAS 
               WHERE to_char(periodo_del,'DD-MM-YYYY') = '".$del."'
                     AND to_char(periodo_al,'DD-MM-YYYY') = '".$al."'
                     AND codarea = ".$codarea."";
    
    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    
    foreach ($nombre as $key => $value) {
    	    
        $query = "INSERT INTO MTE_METAS (ID_META,
    	                                 CODAREA,
        						         PERIODO_DEL,
        		                         PERIODO_AL,
        		                         NOMBRE,
        		                         CANTIDAD,
        		                         META)
        		                 VALUES (SEQ_MTE_METAS.NEXTVAL,
        		           	 	         ".$codarea.",
        		           		         '".$del."',
        		                         '".$al."',
        		           		         '".$nombre[$key]."',
        		           		         ".$cantidad[$key].",
        		           		         ".$meta[$key].")";
    		 
        $stid = oci_parse($conn, $query);          
    	$mensaje = oci_execute($stid, OCI_DEFAULT);
    
    }
    
    
    if($mensaje){
        
    	oci_commit($conn);
    	header('Location: accion.php?grabar=1');
    	
    } else {
        
    	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
    	die();
    	
    }

	
}else{

    foreach ($nombre as $key => $value) {
    
        $query = "INSERT INTO MTE_METAS (ID_META,
        		                        CODAREA,
        						        PERIODO_DEL,
        		                        PERIODO_AL,
        		                        NOMBRE,
        		                        CANTIDAD,
        		                        META)
        		                VALUES (SEQ_MTE_METAS.NEXTVAL,
        		           		        ".$codarea.",
        		           		        '".$del."',
        		                        '".$al."',
        		           		        '".$nombre[$key]."',
        		           		        ".$cantidad[$key].",
        		           		        ".$meta[$key].")";
        
        $stid = oci_parse($conn, $query);
        $mensaje = oci_execute($stid, OCI_DEFAULT);
    }
    
    if($mensaje){
    
    	oci_commit($conn);
    	header('Location: accion.php?grabar=1');
    	
    } else {
        
    	echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
    	die();
    	
    }
}

?>

