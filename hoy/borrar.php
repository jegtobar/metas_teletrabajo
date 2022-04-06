<?php

	include '../auth.php';

	$id_meta = $_REQUEST['id_meta'];

	$query = "DELETE FROM MTE_CUMPLIMIENTOS
	               WHERE id_meta = ".$id_meta;

	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);


	if($mensaje){
	    
	    oci_commit($conn);
	    
	    $query = "DELETE FROM MTE_METAS
	               WHERE id_meta = ".$id_meta;
	    
	    $stid = oci_parse($conn, $query);
	    $mensaje = oci_execute($stid, OCI_DEFAULT);

		$query = "DELETE FROM MTE_METAS_DETALLE
	               WHERE id_meta = ".$id_meta;
	    
	    $stid = oci_parse($conn, $query);
	    $mensaje = oci_execute($stid, OCI_DEFAULT);
	    
	    
	    if($mensaje){
	        
	        oci_commit($conn);
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