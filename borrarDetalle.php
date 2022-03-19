<?php

	include '../auth.php';

	$id_meta = $_REQUEST['id_meta'];

	$query = "SELECT REALIZADO FROM MTE_METAS_DETALLE WHERE ID_META_DETALLE =".$id_meta;
	$stid = oci_parse($conn, $query);
	oci_execute($stid, OCI_DEFAULT);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	$realizado = $row['REALIZADO'];

	$query = "SELECT ID_META, CANTIDAD 
			FROM MTE_METAS
			WHERE ID_META = (SELECT ID_META FROM MTE_METAS_DETALLE WHERE ID_META_DETALLE =".$id_meta.")";
			$stid = oci_parse($conn, $query);
			oci_execute($stid, OCI_DEFAULT);
			$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
			$idMeta = $row['ID_META'];
			$cantidad = $row['CANTIDAD'];
	

	$nuevaCantidad = (int)$cantidad - (int)$realizado;
	echo $nuevaCantidad;


	$query = "DELETE FROM MTE_METAS_DETALLE
			WHERE ID_META_DETALLE = ".$id_meta;

	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);

	if($mensaje){
	    
	    oci_commit($conn);
	    
		$query = "DELETE FROM MTE_METAS_DETALLE
		WHERE ID_META_DETALLE = ".$id_meta;
	    
	    $stid = oci_parse($conn, $query);
	    $mensaje = oci_execute($stid, OCI_DEFAULT);
	    
	    
	    if($mensaje){
	        
	        oci_commit($conn);
			$query = "UPDATE MTE_METAS 
			SET	CANTIDAD = ".$nuevaCantidad."
			WHERE id_meta = ".$idMeta;
			$stid = oci_parse($conn, $query);          
			$mensaje = oci_execute($stid, OCI_DEFAULT);
			if($mensaje){
				oci_commit($conn);
			}
	        echo "<script>parent.location.reload(true);</script>";
	        die();
	        
	    } else {
	        
	        $e = oci_error($stid);
	        print htmlentities($e['message']);
	        print "\n<pre>\n";
	        print htmlentities($e['sqltext']);
	        printf("\n%".($e['offset']+1)."s", "error");
	        print  "\n</pre>\n";
	        
	        die();
	        
	    }
	    
	} else {
	    
	    $e = oci_error($stid);
	    print htmlentities($e['message']);
	    print "\n<pre>\n";
	    print htmlentities($e['sqltext']);
	    printf("\n%".($e['offset']+1)."s", "error");
	    print  "\n</pre>\n";
	    
	    die();
	    
	}

?>