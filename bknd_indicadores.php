<?php 
// include '../auth.php';
$query = "SELECT id_periodo AS periodo_vigente
FROM mte_periodo
WHERE vigente = 'S'";
$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$periodo_vigente = $row['PERIODO_VIGENTE'];


$query = "SELECT id_periodo,
     to_char(fecha_inicio,'DD-MM-YYYY') as inicio,
     to_char(fecha_fin,'DD-MM-YYYY') as fin
FROM mte_periodo
WHERE id_periodo <= ".$periodo_vigente."
ORDER BY id_periodo ASC";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

$id_periodo[] = $row['ID_PERIODO'];
$inicio[] = $row['INICIO'];
$fin[] = $row['FIN'];

}

$query = "SELECT codarea,
     nombre
FROM mte_areas
WHERE usuarios LIKE '%".$usuario."%'";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);

$codarea = $row['CODAREA'];
$area = $row['NOMBRE'];

$query = "SELECT ID_PERIODO
FROM MTE_METAS
ORDER BY ID_PERIODO DESC
FETCH FIRST 1 ROWS ONLY";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$idPeriodo = $row['ID_PERIODO'];


/*Indicador Rendimiento Semanal*/
$query = "SELECT SUM(a.meta)AS METATOTAL
FROM mte_metas a
WHERE a.activa=1 and a.codarea = ".$codarea."
     AND a.id_periodo = ".$idPeriodo;

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$metaTotal = $row['METATOTAL'];

$query = "SELECT SUM(a.cantidad)AS REALIZADO
FROM mte_metas a
WHERE a.codarea = ".$codarea."
     AND a.id_periodo = ".$idPeriodo;

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$realizadoTotal = $row['REALIZADO'];

$rendSemanal = $realizadoTotal ? ($realizadoTotal/$metaTotal)*100 : 0;

if ($rendSemanal<=50){
$rendimientoSemanal = '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendSemanal.'%">';
}else if($rendSemanal>50 && $rendSemanal<=70){
$rendimientoSemanal = '<div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendSemanal.'%">';
}else{
$rendimientoSemanal = '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendSemanal.'%">';
}
/*Fin indicador Rendimiento Semanal */


/*Indicador POA */

$query = "SELECT SUM(a.meta)AS METATOTAL
FROM mte_metas a
WHERE a.codarea = ".$codarea."
     AND POA=1
     AND a.id_periodo = ".$idPeriodo;

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$metaPoa = $row['METATOTAL'];

$query = "SELECT SUM(a.cantidad)AS REALIZADO
FROM mte_metas a
WHERE a.codarea = ".$codarea."
     AND POA=1
     AND a.id_periodo = ".$idPeriodo;

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$realizadoPoa = $row['REALIZADO'];

$rendPoaSemanal = $realizadoPoa ? ($realizadoPoa/$metaPoa)*100 : 0;



if ($rendPoaSemanal<=50){
$rendimientoPoa = '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendPoaSemanal.'%">';
}else if($rendPoaSemanal>50 && $rendPoaSemanal<=70){
$rendimientoPoa = '<div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendPoaSemanal.'%">';
}else{
$rendimientoPoa = '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$rendPoaSemanal.'%">';
}

/*Fin indicador POA */

/*Indicadores detalle por sección */

$query = "SELECT META, REALIZADO, T1.CODAREA, T2.DESCRIPCION 
            from MTE_METAS_DETALLE T1
            LEFT JOIN RH_AREAS T2
            ON T1.CODAREA = T2.CODAREA
            where ID_META in 
            (select ID_META from MTE_METAS  where activa=1 and codarea = ".$codarea." and id_periodo = ".$idPeriodo.")";

$stid = oci_parse($conn, $query);

oci_execute($stid, OCI_DEFAULT);

$secciones = [];

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

    $secciones [] = $row;

}

foreach ($secciones as &$seccion) {

    $cumplimientoDetalle = ($seccion["REALIZADO"]/$seccion["META"])*100;

    $seccion['cumplimientop']= $cumplimientoDetalle;

}

// Buscar el detalle de metas por POA, Actividades Regulares y Adicionales

/* 
     Se realiza la busqueda para actividades que son POA
*/

$query = "SELECT T1.*, T2.NOMBRE, T2.TIPO AS MODALIDAD, T2.MODALIDAD AS TIPO
          FROM MTE_METAS_DETALLE T1
          INNER JOIN MTE_METAS T2
          ON T1.ID_META = T2.ID_META
          WHERE T1.ID_META IN (
               SELECT ID_META
               FROM MTE_METAS
               WHERE ID_PERIODO = $periodo_vigente
               AND ACTIVA = 1
               AND CODAREA = $codarea
          )
          AND T2.POA = 1
          AND T2.ACTIVA = 1";

$stid = oci_parse($conn, $query);

oci_execute($stid, OCI_DEFAULT);

$metas_poa = [];

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

     $modalidad = $row["MODALIDAD"] == 'M' ? 'Mixta' : $row['MODALIDAD'] == 'P' ? 'Presencial' : 'Teletrabajo';
     $row["MODALIDAD"] = $modalidad;
     $metas_poa [] = $row;

}

/* 
     Se realiza la busqueda para actividades que son regulares y NO SON POA
*/

$query = "SELECT T1.*, T2.NOMBRE, T2.TIPO AS MODALIDAD, T2.MODALIDAD AS TIPO
          FROM MTE_METAS_DETALLE T1
          INNER JOIN MTE_METAS T2
          ON T1.ID_META = T2.ID_META
          WHERE T1.ID_META IN (
               SELECT ID_META
               FROM MTE_METAS
               WHERE ID_PERIODO = $periodo_vigente
               AND ACTIVA = 1
               AND CODAREA = $codarea
          )
          AND T2.MODALIDAD = 'R'
          AND T2.POA IS NULL
          AND T2.ACTIVA = 1";

$stid = oci_parse($conn, $query);

oci_execute($stid, OCI_DEFAULT);

$metas_regulares = [];

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

     $modalidad = $row["MODALIDAD"] == 'M' ? 'Mixta' : $row['MODALIDAD'] == 'P' ? 'Presencial' : 'Teletrabajo';
     $row["MODALIDAD"] = $modalidad;
     $metas_regulares [] = $row;

}

/* 
     Se realiza la busqueda para actividades que son adicionales y NO SON POA
*/

$query = "SELECT T1.*, T2.NOMBRE, T2.TIPO AS MODALIDAD, T2.MODALIDAD AS TIPO
          FROM MTE_METAS_DETALLE T1
          INNER JOIN MTE_METAS T2
          ON T1.ID_META = T2.ID_META
          WHERE T1.ID_META IN (
               SELECT ID_META
               FROM MTE_METAS
               WHERE ID_PERIODO = $periodo_vigente
               AND ACTIVA = 1
               AND CODAREA = $codarea
          )
          AND T2.MODALIDAD = 'A'
          AND T2.POA IS NULL
          AND T2.ACTIVA = 1";

$stid = oci_parse($conn, $query);

oci_execute($stid, OCI_DEFAULT);

$metas_adicionales = [];

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

     $modalidad = $row["MODALIDAD"] == 'M' ? 'Mixta' : $row['MODALIDAD'] == 'P' ? 'Presencial' : 'Teletrabajo';
     $row["MODALIDAD"] = $modalidad;
     $metas_adicionales [] = $row;

}

/*Fin Indicadores detalle por sección */

?>