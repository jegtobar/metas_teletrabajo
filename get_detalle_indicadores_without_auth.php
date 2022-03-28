<?php

    include 'db.php';
    
     $json = file_get_contents('php://input');

     $data = json_decode($json);

     $response = [];

     /* 
          Se realiza la busqueda para actividades que son POA
     */

     $query = "SELECT T1.*, T2.NOMBRE, T2.TIPO AS MODALIDAD, T2.MODALIDAD AS TIPO
               FROM MTE_METAS_DETALLE T1
               INNER JOIN MTE_METAS T2
               ON T1.ID_META = T2.ID_META
               WHERE T2.POA = 1
               AND T2.ACTIVA = 1
               and t2.id_periodo = $data->id_periodo
               AND T1.CODAREA = $data->codarea"; 

     $stid = oci_parse($conn, $query);

     oci_execute($stid, OCI_DEFAULT);

     $metas_poa = [];

     while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

          $modalidad = $row["MODALIDAD"] == 'M' ? 'Mixta' : $row['MODALIDAD'] == 'P' ? 'Presencial' : 'Teletrabajo';
          $row["MODALIDAD"] = $modalidad;
          $calculo = round(($row["REALIZADO"]/$row["META"])*100);
          if($calculo<=50){
               $colorText='text-danger';
          }elseif($calculo>50 and $calculo<=70){
               $colorText='text-warning';
          }else{
           $colorText='text-success';
          }
 
          if($calculo>=100){
                $calculo = 100;
                $colorText = 'text-success';
           }
 
           $row["PROMEDIO"]=$calculo;
           $row["COLORTEXT"] = $colorText;
          $metas_poa [] = $row;

     }

     $response["metas_poa"] = $metas_poa;

     /* 
          Se realiza la busqueda para actividades que son regulares y NO SON POA
     */

     $query = "SELECT T1.*, T2.NOMBRE, T2.TIPO AS MODALIDAD, T2.MODALIDAD AS TIPO
               FROM MTE_METAS_DETALLE T1
               INNER JOIN MTE_METAS T2
               ON T1.ID_META = T2.ID_META
               WHERE T2.MODALIDAD = 'R'
               AND T2.POA = 0
               AND T2.ACTIVA = 1
               and t2.id_periodo = $data->id_periodo
               AND T1.CODAREA = $data->codarea";

     $stid = oci_parse($conn, $query);

     oci_execute($stid, OCI_DEFAULT);

     $metas_regulares = [];

     while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

          $modalidad = $row["MODALIDAD"] == 'M' ? 'Mixta' : $row['MODALIDAD'] == 'P' ? 'Presencial' : 'Teletrabajo';
          $row["MODALIDAD"] = $modalidad;
          $calculo = round(($row["REALIZADO"]/$row["META"])*100);
          if($calculo<=50){
               $colorText='text-danger';
          }elseif($calculo>50 and $calculo<=70){
               $colorText='text-warning';
          }else{
           $colorText='text-success';
          }
 
          if($calculo>=100){
                $calculo = 100;
                $colorText = 'text-success';
           }
 
           $row["PROMEDIO"]=$calculo;
           $row["COLORTEXT"] = $colorText;
          $metas_regulares [] = $row;

     }

     $response["metas_regulares"] = $metas_regulares;

     /* 
          Se realiza la busqueda para actividades que son adicionales y NO SON POA
     */

     $query = "SELECT T1.*, T2.NOMBRE, T2.TIPO AS MODALIDAD, T2.MODALIDAD AS TIPO
               FROM MTE_METAS_DETALLE T1
               INNER JOIN MTE_METAS T2
               ON T1.ID_META = T2.ID_META
               WHERE T2.MODALIDAD = 'A'
               AND T2.POA = 0
               AND T2.ACTIVA = 1
               and t2.id_periodo = $data->id_periodo
               AND T1.CODAREA = $data->codarea";


     $stid = oci_parse($conn, $query);

     oci_execute($stid, OCI_DEFAULT);

     $metas_adicionales = [];

     while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

          $modalidad = $row["MODALIDAD"] == 'M' ? 'Mixta' : $row['MODALIDAD'] == 'P' ? 'Presencial' : 'Teletrabajo';
          $row["MODALIDAD"] = $modalidad;
          $calculo = round(($row["REALIZADO"]/$row["META"])*100);
          if($calculo<=50){
               $colorText='text-danger';
          }elseif($calculo>50 and $calculo<=70){
               $colorText='text-warning';
          }else{
           $colorText='text-success';
          }
 
          if($calculo>=100){
                $calculo = 100;
                $colorText = 'text-success';
           }
 
           $row["PROMEDIO"]=$calculo;
           $row["COLORTEXT"] = $colorText;
          $metas_adicionales [] = $row;

     }

     $response["metas_adicionales"] = $metas_adicionales;

     echo json_encode($response);

?>