<?php

	include '../auth.php';

	$id_cumplimiento = $_REQUEST['id_cumplimiento'];

	$query = "DELETE FROM MTE_CUMPLIMIENTOS
	                WHERE id_cumplimiento = ".$id_cumplimiento;

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

?>