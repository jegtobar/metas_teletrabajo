<?php

    include 'db.php';

    $json = file_get_contents('php://input');

    $data = json_decode($json);

    $response = [];

    /*
        Obtener el periodo vigente
    */

    $periodo_vigente = $data->id_periodo;

    /*
        Obtener el codigo de area del usuario logeado
    */

    $codarea = $data->codarea;

    /*Indicador Rendimiento Semanal*/
    $query = "  SELECT SUM(a.meta)AS METATOTAL
                FROM mte_metas a
                WHERE a.activa=1 and a.codarea = ".$codarea."
                    AND a.id_periodo = ".$periodo_vigente;

    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $metaTotal = $row['METATOTAL'];

    $query = "SELECT SUM(a.cantidad)AS REALIZADO
                FROM mte_metas a
                WHERE a.codarea = ".$codarea."
                    AND a.id_periodo = ".$periodo_vigente;

    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $realizadoTotal = $row['REALIZADO'];

    $rendSemanal = $realizadoTotal ?number_format((float)(($realizadoTotal/$metaTotal)*100), 2, '.', '')  : 0;

    if ($rendSemanal < 0){

        $colorText = 'text-danger';
        $bar_style = 'progress-bar-danger';

        $rendimientoSemanal = '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">';
   
    }else{

        if ($rendSemanal<=50){

            $colorText = 'text-danger';
            $bar_style = 'progress-bar-danger';

            $rendimientoSemanal = '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendSemanal.'%">';
        
        }else if($rendSemanal>50 && $rendSemanal<=70){

            $colorText = 'text-danger';
            $bar_style = 'progress-bar-warning';

            $rendimientoSemanal = '<div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendSemanal.'%">';
            
        }else{

            $colorText = 'text-success';
            $bar_style = 'progress-bar-success';

            $rendimientoSemanal = '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendSemanal.'%">';
        
        }
    }
    if($rendSemanal>100){
        $rendSemanal=100;
        }
    $rendimiento_semanal = [
        'text_style' => $colorText,
        'bar_style' => $bar_style,
        'rendimiento' => $rendSemanal
    ];

    $response['rendimiento_semanal'] = $rendimiento_semanal;

    /*Fin indicador Rendimiento Semanal */


    /*Indicador POA */

    $query = "  SELECT SUM(a.meta)AS METATOTAL
                FROM mte_metas a
                WHERE a.codarea = ".$codarea."
                    AND POA=1
                    AND a.id_periodo = ".$periodo_vigente;

    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $metaPoa = $row['METATOTAL'];

    $query = "  SELECT SUM(a.cantidad)AS REALIZADO
                FROM mte_metas a
                WHERE a.codarea = ".$codarea."
                    AND POA=1
                    AND a.id_periodo = ".$periodo_vigente;

    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $realizadoPoa = $row['REALIZADO'];
    $rendPoaSemanal = $realizadoPoa ? number_format((float)(($realizadoPoa/$metaPoa)*100), 2, '.', '') : 0;

    if ($rendPoaSemanal<=50){

        $colorText = 'text-danger';
        $bar_style = 'progress-bar-danger';

        $rendimientoPoa = '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendPoaSemanal.'%">';
    
    }else if($rendPoaSemanal>50 && $rendPoaSemanal<=70){

        $colorText = 'text-warning';
        $bar_style = 'progress-bar-warning';

        $rendimientoPoa = '<div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendPoaSemanal.'%">';
    
    }else{

        $colorText = 'text-success';
        $bar_style = 'progress-bar-success';

        $rendimientoPoa = '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendPoaSemanal.'%">';
    
    }

    if($rendPoaSemanal>100){
        $rendPoaSemanal=100;
        }

    $rendimiento_poa = [
        'text_style' => $colorText,
        'bar_style' => $bar_style,
        'rendimiento' => $rendPoaSemanal
    ];

    $response['rendimiento_poa'] = $rendimiento_poa;

    /*Fin indicador POA */

    /*Indicadores detalle por sección */

    $query = "  SELECT SUM(META) AS META, SUM(REALIZADO) AS REALIZADO, T1.CODAREA, T2.DESCRIPCION 
                FROM MTE_METAS_DETALLE T1
                LEFT JOIN RH_AREAS T2
                ON T1.CODAREA = T2.CODAREA
                WHERE ID_META IN (
                    SELECT 
                    ID_META 
                    FROM MTE_METAS 
                    where activa=1 and codarea = ".$codarea." and id_periodo = ".$periodo_vigente."
                )
                GROUP BY T1.CODAREA, T2.DESCRIPCION
            ";

    $stid = oci_parse($conn, $query);

    oci_execute($stid, OCI_DEFAULT);

    $secciones = [];

    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

        $secciones [] = $row;

    }

    foreach ($secciones as &$seccion) {

        $cumplimientoDetalle = ($seccion["REALIZADO"]/$seccion["META"])*100;

        $seccion['cumplimientop']= number_format($cumplimientoDetalle, 2);

        $bar_style = 'progress-bar-success';
        $text_style = 'text-success';

        if ($seccion["cumplimientop"] <= 50) {
            $bar_style = 'progress-bar-danger';
            $text_style = 'text-danger';
        }elseif ($seccion["cumplimientop"] > 50 && $seccion["cumplimientop"] <= 70) {
            $bar_style = 'progress-bar-warning';
            $text_style = 'text-warning';
        }
        if($seccion["cumplimientop"] >100){
            $seccion["cumplimientop"] =100;
            }
        $seccion['bar_style'] = $bar_style;
        $seccion['text_style'] = $text_style;


    }

    $response["secciones"] = $secciones;

    echo json_encode($response);
    
?>