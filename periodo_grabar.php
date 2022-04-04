<?php

	include 'db.php';

	$id_periodo = $_POST['id_periodo'];
	$del = $_POST['del'];
	$al = $_POST['al'];

	$query = "UPDATE mte_periodo
                 SET vigente = 'N'
	               WHERE id_periodo = ".$id_periodo;

	$stid = oci_parse($conn, $query);
	$mensaje = oci_execute($stid, OCI_DEFAULT);

	if($mensaje){
	    
	    oci_commit($conn);
	    $id_periodos = $id_periodo + 1;
	    
	    $query = "INSERT INTO MTE_PERIODO (id_periodo,
                                           fecha_inicio,
                                           fecha_fin,
                                           vigente)
                                   VALUES (".$id_periodos.",
                                           TO_DATE('".$del."','DD-MM-YYYY'),
                                           TO_DATE('".$al."','DD-MM-YYYY'),
                                           'S')";
	    
	    $stid = oci_parse($conn, $query);
	    $mensaje = oci_execute($stid, OCI_DEFAULT);
	    
	    if($mensaje){
	        
	        oci_commit($conn);
	        
	        $query = "INSERT INTO MTE_METAS 
                      SELECT SEQ_MTE_METAS.NEXTVAL as id_meta,
                             codarea,
                             null as periodo_del,
                             null as periodo_al,
                             nombre,
                             null as cantidad,
                             null as meta,
                             tipo,
                             ".$id_periodos." as id_periodo,
                             sysdate as fecha,
                             'SISTEMA' as usuario
                        FROM MTE_METAS
                       WHERE id_periodo = ".$id_periodo;
	        
	        $stid = oci_parse($conn, $query);
	        $mensaje = oci_execute($stid, OCI_DEFAULT);
	        
	        if($mensaje){
	            
	            oci_commit($conn);
                
	            header('Location:index.php');
	            //echo "<script>parent.location.reload(true);</script>";
	            die();
	            
	        } else {
	            
	            $e = oci_error($stid);
	            print htmlentities($e['message']);
	            print "\n<pre>\n";
	            print htmlentities($e['sqltext']);
	            printf("\n%".($e['offset']+1)."s", "^");
	            print  "\n</pre>\n";
	            
	            die();
	            
	        }
	        
	    } else {
	        
	        $e = oci_error($stid);
	        print htmlentities($e['message']);
	        print "\n<pre>\n";
	        print htmlentities($e['sqltext']);
	        printf("\n%".($e['offset']+1)."s", "^");
	        print  "\n</pre>\n";
	        
	        die();
	        
	    }
	    
	    
	} else {
	    
	    $e = oci_error($stid);
	    print htmlentities($e['message']);
	    print "\n<pre>\n";
	    print htmlentities($e['sqltext']);
	    printf("\n%".($e['offset']+1)."s", "^");
	    print  "\n</pre>\n";
	    
	    die();
	    
	}

?>