<?php

	include '../auth.php';

	$id_meta = $_REQUEST['id_meta'];

	$query = "SELECT META FROM MTE_METAS_DETALLE WHERE ID_META_DETALLE =".$id_meta;
	$stid = oci_parse($conn, $query);
	oci_execute($stid, OCI_DEFAULT);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	$metaDetalle = $row['META'];


	$query = "SELECT ID_META, META
			FROM MTE_METAS
			WHERE ID_META = (SELECT ID_META FROM MTE_METAS_DETALLE WHERE ID_META_DETALLE =".$id_meta.")";
			$stid = oci_parse($conn, $query);
			oci_execute($stid, OCI_DEFAULT);
			$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
			$idMeta = $row['ID_META'];
			$meta = $row['META'];
	

	$nuevaCantidad = (int)$meta - (int)$metaDetalle;



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
			SET	META = ".$nuevaCantidad."
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