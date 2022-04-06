<?php 

include 'db.php';
include 'common.php';
$usuario = "gestioniusi";
$password = "lestoniv2010";

$x = abrirConexion($usuario,$password);	

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

if(!isset($_GET['id_periodo'])){
    $periodo = end($id_periodo);
} else {
    $periodo = $_GET['id_periodo'];
}

$query = "SELECT vigente,
                 to_char(fecha_inicio,'YYYY') as anio,
                 to_char(fecha_inicio,'MM') as mes
            FROM mte_periodo
           WHERE id_periodo = ".$periodo;

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);

$vigente = $row['VIGENTE'];
$anio = $row['ANIO'];
$mes = $row['MES'];

$query = "SELECT a.codarea,
                 b.nombre as descripcion,
                 b.icon,
                 b.icon2
            FROM rh_areas a,
                 mte_areas b 
           WHERE a.codarea = b.codarea
                 AND b.grupo = 1
           ORDER BY b.orden ASC";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {	
 
    $codarea[] = $row['CODAREA'];
    $nombre[] = $row['DESCRIPCION'];
    if (!empty($row['ICON'])){$icon[] = $row['ICON'];} else {$icon[] = 'img/avatar5.png';}
    if (!empty($row['ICON2'])){$icon2[] = $row['ICON2'];} else {$icon2[] = '';}
     
}

$a = 0;

foreach ($codarea as $area){

    /*
    $query = "SELECT SUM(b.cantidad) AS realizado,
                     SUM(a.meta) AS meta,
                     ROUND((SUM(b.cantidad) / SUM(a.meta)) * 100) AS porcentaje,
                     a.codarea 
                FROM mte_metas a
                LEFT JOIN mte_cumplimientos b ON a.id_meta = b.id_meta
               WHERE a.codarea = ".$area."
                     AND a.id_periodo = ".$periodo."
            GROUP BY a.codarea";
    */
    $query = "SELECT  realizado,
    SUM(meta) AS meta,
    ROUND((realizado / SUM(meta)) * 100) AS porcentaje,
    codarea   
    FROM  (                  
        SELECT (select sum(realizado)
                  from mte_metas_detalle
                  where id_meta in (select id_meta from mte_metas where codarea = ".$area." and id_periodo = ".$periodo." and activa=1 and modalidad <> 'A')) AS realizado,
                a.meta,
                a.codarea
          FROM  mte_metas a
        WHERE  a.codarea = ".$area."
                AND a.id_periodo = ".$periodo."
                and activa = 1
                and modalidad <> 'A'
      )
    GROUP BY  codarea,realizado";
    
    
    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        
        if(!empty($row['REALIZADO'])){$realizado[$area] = $row['REALIZADO'];} else {$realizado[$area] = 0;}
        if(!empty($row['META'])){$meta[$area] = $row['META'];} else {$meta[$area] = 0;}
        
        $query = "  SELECT SUM(META)AS META, SUM(REALIZADO)AS REALIZADO, T1.CODAREA, T2.DESCRIPCION, T1.ID_PERIODO
        FROM MTE_METAS_DETALLE T1
        LEFT JOIN RH_AREAS T2
        ON T1.CODAREA = T2.CODAREA
        WHERE ID_META IN (
            SELECT 
            ID_META 
            FROM MTE_METAS 
            where activa=1 and modalidad <> 'A' and codarea = ".$area." and id_periodo = ".$periodo."
        )
        GROUP BY T1.CODAREA, T2.DESCRIPCION, ID_PERIODO";

$stid = oci_parse($conn, $query);

oci_execute($stid, OCI_DEFAULT);

$secciones = [];

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

$secciones [] = $row;

}
//Promedio de porcentajes por sección.
$k = 0;
$rendimiento = 0;
foreach ($secciones as &$seccion) {
$query = "SELECT T1.*
FROM MTE_METAS_DETALLE T1
INNER JOIN MTE_METAS T2
ON T1.ID_META = T2.ID_META
WHERE T2.MODALIDAD <> 'A'
AND T2.ACTIVA = 1
and t2.id_periodo = ".$seccion["ID_PERIODO"]."
AND T1.CODAREA =".$seccion["CODAREA"];
$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$metas_adicionales = [];
$i = 0;
$sumaPromedios = 0;

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    if (!empty($row["REALIZADO"])){
        $calculo = ($row["REALIZADO"]/$row["META"])*100;
        if ($calculo >100){
            $calculo =100;
        }
        $sumaPromedios = $sumaPromedios + $calculo;
    }
    $i++;
}


//Nuevo calculo de rendimiento semanal global
$cumplimientoPorcentaje = round($sumaPromedios/$i);
$seccion['cumplimientop'] = $cumplimientoPorcentaje;
$rendimiento = $rendimiento + $cumplimientoPorcentaje;
$k++; 

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
$seccion['selected'] = false;
}
$rendimientoPromedio = 0;
if($k<>0){
  $rendimientoPromedio = round($rendimiento/$k);
}


$text_style = 'text-success';
if ($rendimientoPromedio <= 50) {
$text_style = 'text-danger';
}elseif ($rendimientoPromedio> 50 && $rendimientoPromedio <= 70) {
$text_style = 'text-warning';
}
if( $rendimientoPromedio>100){
$rendimientoPromedio =100;
}

$response["secciones"] = $secciones;
$promedio['rendimiento'] = $rendimientoPromedio;
$promedio['text_style'] = $text_style;

$response["rendimientoSemanalPromedio"] = $promedio;

if($rendimientoPromedio > 100){$porcentaje[$area] = 100;} elseif(!empty($rendimientoPromedio)){$porcentaje[$area] = $rendimientoPromedio;} else {$porcentaje[$area] = 0;}

}

$total_acumulado = round((array_sum($porcentaje) / 7));

$query = "SELECT a.codarea,
                 b.nombre as descripcion,
                 b.icon,
                 b.icon2
            FROM rh_areas a,
                 mte_areas b 
           WHERE a.codarea = b.codarea
                 AND b.grupo = 2
           ORDER BY b.orden ASC";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {	
 
    $codarea2[] = $row['CODAREA'];
    $nombre2[] = $row['DESCRIPCION'];
    if (!empty($row['ICON'])){$icon3[] = $row['ICON'];} else {$icon3[] = 'img/avatar5.png';}
    if (!empty($row['ICON2'])){$icon4[] = $row['ICON2'];} else {$icon4[] = '';}
     
}

$a = 0;

foreach ($codarea2 as $area){

    
  $query = "SELECT  realizado,
  SUM(meta) AS meta,
  ROUND((realizado / SUM(meta)) * 100) AS porcentaje,
  codarea   
  FROM  (                  
      SELECT (select sum(realizado)
                from mte_metas_detalle
                where id_meta in (select id_meta from mte_metas where codarea = ".$area." and id_periodo = ".$periodo." and activa=1 and modalidad <> 'A')) AS realizado,
              a.meta,
              a.codarea
        FROM  mte_metas a
      WHERE  a.codarea = ".$area."
              AND a.id_periodo = ".$periodo."
              and activa = 1
              and modalidad <> 'A'
    )
  GROUP BY  codarea,realizado";
    
    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        
        if(!empty($row['REALIZADO'])){$realizado2[$area] = $row['REALIZADO'];} else {$realizado2[$area] = 0;}
        if(!empty($row['META'])){$meta2[$area] = $row['META'];} else {$meta2[$area] = 0;}
        $query = "  SELECT SUM(META)AS META, SUM(REALIZADO)AS REALIZADO, T1.CODAREA, T2.DESCRIPCION, T1.ID_PERIODO
        FROM MTE_METAS_DETALLE T1
        LEFT JOIN RH_AREAS T2
        ON T1.CODAREA = T2.CODAREA
        WHERE ID_META IN (
            SELECT 
            ID_META 
            FROM MTE_METAS 
            where activa=1 and modalidad <> 'A' and codarea = ".$area." and id_periodo = ".$periodo."
        )
        GROUP BY T1.CODAREA, T2.DESCRIPCION, ID_PERIODO";

$stid = oci_parse($conn, $query);

oci_execute($stid, OCI_DEFAULT);

$secciones = [];

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

$secciones [] = $row;

}
//Promedio de porcentajes por sección.
$k = 0;
$rendimiento = 0;
foreach ($secciones as &$seccion) {
$query = "SELECT T1.*
FROM MTE_METAS_DETALLE T1
INNER JOIN MTE_METAS T2
ON T1.ID_META = T2.ID_META
WHERE T2.MODALIDAD <> 'A'
AND T2.ACTIVA = 1
and t2.id_periodo = ".$seccion["ID_PERIODO"]."
AND T1.CODAREA =".$seccion["CODAREA"];
$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$metas_adicionales = [];
$i = 0;
$sumaPromedios = 0;

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    if (!empty($row["REALIZADO"])){
        $calculo = ($row["REALIZADO"]/$row["META"])*100;
        if ($calculo >100){
            $calculo =100;
        }
        $sumaPromedios = $sumaPromedios + $calculo;
    }
    $i++;
}


//Nuevo calculo de rendimiento semanal global
$cumplimientoPorcentaje = round($sumaPromedios/$i);
$seccion['cumplimientop'] = $cumplimientoPorcentaje;
$rendimiento = $rendimiento + $cumplimientoPorcentaje;
$k++; 

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
$seccion['selected'] = false;
}
$rendimientoPromedio = 0;
if($k<>0){
  $rendimientoPromedio = round($rendimiento/$k);
}


$text_style = 'text-success';
if ($rendimientoPromedio <= 50) {
$text_style = 'text-danger';
}elseif ($rendimientoPromedio> 50 && $rendimientoPromedio <= 70) {
$text_style = 'text-warning';
}
if( $rendimientoPromedio>100){
$rendimientoPromedio =100;
}

$response["secciones"] = $secciones;
$promedio['rendimiento'] = $rendimientoPromedio;
$promedio['text_style'] = $text_style;

$response["rendimientoSemanalPromedio"] = $promedio;

    if($rendimientoPromedio > 100){$porcentaje2[$area] = 100;} elseif(!empty($rendimientoPromedio)){$porcentaje2[$area] = $rendimientoPromedio;} else {$porcentaje2[$area] = 0;}
    
}

$total_acumulado2 = round((array_sum($porcentaje2) / count($porcentaje2)));


$diaact = date('d');
$mesact = date('m');
$aniact = date('Y');

$query = "SELECT ROUND(sum(to_number(proyeccion_solvente))/1000000) AS proyeccion_solvente,
                 ROUND(sum(to_number(proyeccion_mora))/1000000) AS proyeccion_mora                     
            FROM tbl_proyeccion_pagos
           WHERE to_char(fecha,'YYYY') = '". $aniact ."'
       and to_char(fecha,'MM') <= '".$mesact."'";

$stid = oci_parse($x, $query);
oci_execute($stid, OCI_DEFAULT);

while($row = oci_fetch_array($stid, OCI_ASSOC))
{
    $proyeccion_solvente = doubleval($row['PROYECCION_SOLVENTE']);
    $proyeccion_mora     = doubleval($row['PROYECCION_MORA']);
}

$meta_ingreso = $proyeccion_solvente + $proyeccion_mora;
$i = 0;

$anioante = $anio - 1;;

/*
$query = "SELECT NVL(ROUND(a.monto_anio_actual/1000000),0) AS monto_actual,
                     ROUND(b.monto_anio_anterior/1000000) AS monto_anterior
			    FROM ( SELECT SUM( NVL(impuesto,0)   +
								   NVL(multas,0)     +
								   NVL(convenios,0)) AS monto_anio_actual
		                 FROM tbl_actual_pagos
		   			    WHERE TO_NUMBER(TO_CHAR(fecha,'DD'  )) <= ".$diaact."
						  AND TO_NUMBER(TO_CHAR(fecha,'MM'  )) <= ".$mesact." 
						  AND TO_NUMBER(TO_CHAR(fecha,'YYYY'))  = ".$aniact.") a,
		             ( SELECT SUM( NVL(impuesto,0)   +
								   NVL(multas,0)     +
								   NVL(convenios,0)) AS monto_anio_anterior
		                 FROM tbl_historia_pagos
						WHERE TO_NUMBER(TO_CHAR(fecha,'MM'  ))  = ".$mes."
						  AND TO_NUMBER(TO_CHAR(fecha,'YYYY'))  = ".$anioante.") b";
*/

$query = "SELECT ROUND(SUM( NVL(impuesto,0)   +
                            NVL(multas,0)     +
                            NVL(convenios,0))/1000000 ) AS monto_actual
            FROM tbl_actual_pagos
           WHERE TO_NUMBER(TO_CHAR(fecha,'YYYYMMDD'  )) <= '".$aniact.$mesact.$diaact."'
                 AND TO_NUMBER(TO_CHAR(fecha,'YYYY'))  = '".$aniact."'";


$stid = oci_parse($x, $query);
oci_execute($stid, OCI_DEFAULT);

while($row = oci_fetch_array($stid, OCI_ASSOC))
{
    $ingreso   = doubleval($row['MONTO_ACTUAL']);
    //$ingreso_anterior = doubleval($row['MONTO_ANTERIOR']);
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Metas | Monitor</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="css/skins/_all-skins.min.css">
  
  <link rel="stylesheet" href="dist/jquery.fancybox.min.css">
<style type="text/css">

</style>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header" style="height: 75px;background-color: #A2CE39">
    <nav class="navbar navbar-static-top" style="background-color: #A2CE39">
        <div class="navbar-header text-left">
          <a href="index.php" class="navbar-brand"><img src="img/logo_catastro.png"></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
    </nav>
  </header>
  <div class="content-wrapper" style="height:3000px; background-color: #ededed">

	<br>
      <section class="content">
      
      <div class="row">
      
      	<div class="col-md-12">
      	 <div class="box box-info" style="border-radius: 25px;">
      	 <div class="box-body">
      	 	<div class="row">
      	 	 <form action="" method="get" autocomplete="off">
      	 	<div class="col-md-4">
      	 	  
               		<div class="form-group">
                          <label>Seleccionar período</label>
                          <select class="form-control" name="id_periodo">
                          	<?php $i=0;while($i < count($id_periodo)){?>
                          	<option <?php if($id_periodo[$i] == $periodo){echo 'selected="selected"';}?> value="<?php echo $id_periodo[$i]?>"><?php echo $inicio[$i]. ' al ' .$fin[$i]?></option>
                          	<?php $i++;}?>
                          </select>
                        </div>
                </div>      
                <div class="col-md-2">
                <label for="ver" style="color: white;">ver</label>
                  <input type="submit" id="ver" name="ver" value="Ver" class="btn btn-lg btn-primary form-control">
                  
                </div>
                <?php if ($vigente == 'X'){?>
                  <div class="col-md-1">
                  	<label for="cierre" style="color: white;">cierre</label>
					<a class="fancy btn btn-warning btn-lg form-control" href="cierre.php?id_periodo=<?php echo $periodo?>">Cierre</a>
                  </div>
					<?php }?>
               </form>
              </div>
      	 </div>
      	 </div>
      	 </div>
      </div>
      	 
      <div class="row"> 
      	 <div class="col-md-12">
          <div class="box box-widget widget-user" style="border-radius: 25px;">
              
            <div class="box-footer" style="border-radius: 25px; padding-top: 10px">
            <div class="row">
            
            	<div class="col-md-1">
            		<img class="img-circle" src="img/nuevo/mcarcamo.jpg" alt="User Image" height="100px">
            	</div>
            	<div class="col-md-11" style="padding-top: 20px">
            		<div>
                    	<h3 class="widget-user-username" style="font-size: 32px"><b>Dirección de Catastro y Administración del IUSI</b></h3>
                    </div>
            	</div>
            
            </div>
          </div>
          </div>
        </div>
      </div>
        
       <div class="row">
       
         <div class="col-md-4">
          <div class="box box-widget widget-user" style="border-radius: 25px;">
              
            <div class="box-footer" style="border-radius: 25px; padding-top: 10px">
            <div class="row">
            
            	<div class="col-md-2">
            		<img class="img-circle" src="img/nuevo/msamayoa.jpg" alt="User Image" height="100px">
            	</div>
            	<div class="col-md-7" style="padding-top: 10px; padding-right: 0px">
            		<div>
                    	<h3 class="widget-user-username"><b>Subdirección</b></h3>
                  		<h1 class="widget-user-username"><b>Administrativa</b></h1>
                    </div>
            	</div>
            	<div class="col-md-3" style="padding-left: 0px">
            		<h1 <?php if($total_acumulado <= 61){echo 'style="color: #ff0000; font-size: 50px"';}elseif($total_acumulado >=62 && $total_acumulado <= 79){echo 'style="color: #ff5100; font-size: 50px"';}else{echo 'style="color: #2f8c18; font-size: 50px"';}?>><b><?php echo $total_acumulado?>%</b></h1>
            	</div>

              <!-- <div class="col-md-3" style="padding-left: 0px">
              </div> -->
            
            </div>
            </div>
          </div>
        </div>
        
         <div class="col-md-4">
          <div class="box box-widget widget-user" style="border-radius: 25px;">
              
            <div class="box-footer" style="border-radius: 25px; padding-top: 10px">
            <div class="row">
            
            	<div class="col-md-2">
            		<img class="img-circle" src="img/nuevo/ebran.jpg" alt="User Image" height="100px">
            	</div>
            	<div class="col-md-5" style="padding-top: 10px; padding-right: 0px">
            		<div>
                    	<h3 class="widget-user-username"><b>Subdirección </b></h3>
                  		<h1 class="widget-user-username"><b>del IUSI</b></h1>
                    </div>
            	</div>
            	<!-- <div class="col-md-4" style="padding-left: 0px">
            		<h1 style="font-size: 36px;color: #181e8c;margin-top:0px"><b>QTZ <?php echo $meta_ingreso?>M</b></h1>
            		<h1 style="font-size: 36px;color: #2f8c18;margin-top:0px"><b>QTZ <?php echo $ingreso?>M</b></h1>
            	</div> -->

              <div class="col-md-5" style="padding-left: 0px">

                <h1 style="font-size: 36px;color: #2f8c18;margin-top:0px"><b><small>2022</small> QTZ 183M</b></h1>
            		<h1 style="font-size: 36px;color: #181e8c;margin-top:0px"><b><small>2021</small> QTZ 163M</b></h1>
            		
            	</div>

              <!-- <div class="col-md-4" style="padding-left: 0px">
              </div> -->
            
            </div>
                
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="box box-widget widget-user" style="border-radius: 25px;">
              
            <div class="box-footer" style="border-radius: 25px; padding-top: 10px">
            <div class="row">
            
            	<div class="col-md-2">
            		<img class="img-circle" src="img/nuevo/lgonzales.jpg" alt="User Image" height="100px">
            	</div>
            	<div class="col-md-7" style="padding-top: 10px; padding-right: 0px">
            		<div>
                    	<h3 class="widget-user-username"><b>Subdirección</b></h3>
                  		<h1 class="widget-user-username"><b>de Jurídico</b></h1>
                    </div>
            	</div>
            	<div class="col-md-3" style="padding-left: 0px">
            		<h1 <?php if($total_acumulado2 <= 61 ){echo 'style="color: #ff0000; font-size: 50px"';}elseif($total_acumulado2 >= 62 && $total_acumulado2 <= 79){echo 'style="color: #ff5100; font-size: 50px"';}else{echo 'style="color: #2f8c18; font-size: 50px"';}?>><b><?php echo $total_acumulado2?>%</b></h1>
            	</div>

              <!-- <div class="col-md-3" style="padding-left: 0px">
              </div> -->
            
            </div>
                
            </div>
          </div>
        </div>
      	
      </div>
      <div class="row">
      
		<?php $i=0; foreach($codarea as $cu){?>
		<a href="metas_indicadores_dashboard.php?area=<?php echo $cu;?>&id_periodo=<?php echo $periodo;?>" class="fancy" style="color: black;">
        <div class="col-md-3">
          <div class="box box-widget widget-user text-center" style="height:375px; border-radius: 25px;">
              
            <div class="box-footer" style="border-radius: 25px">
            	  <img class="img-circle" src="<?php echo $icon[$i]?>" alt="User Image" height="100px">
              <?php if (!empty($icon2[$i])){?>
                <img class="img-circle" src="<?php echo $icon2[$i]?>" alt="User Image" height="100px">
              <?php }?>
            	<br>
            	<br>
                <div class="text-center">
                  
                	<h3 class="widget-user-username" style="color: #181e8c; font-size: 32px; height: 70px"><?php echo $nombre[$i];?></h3>
                  <br>
                  <h1 class="widget-user-username" <?php if($porcentaje[$cu] <= 61){echo 'style="color: #ff0000; font-size: 40px"';}elseif($porcentaje[$cu]>=62 && $porcentaje[$cu] <= 79){echo 'style="color:#ff5100; font-size: 40px"';}else{echo 'style="color: #2f8c18; font-size: 40px"';}?>><b><?php echo $porcentaje[$cu]?>%</b></h1>
                </div>
              	<div class="row">
              	
              		<div class="col-md-2"></div>
              		<div class="col-md-8">
              		<table>
                    	<tr>
                    		<!-- <td class="text-left"><h3><b>Meta:</b></h3></td>
                    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    		<td class="text-right"><h3><?php echo number_format($meta[$cu])?></h3></td> -->
                    	</tr>
                    	<tr>
                    		<!-- <td class="text-left"><h3 style="margin-top: 0px"><b>Realizado:</b></h3></td>
                    		<td></td>
                    		<td class="text-right"><h3 style="margin-top: 0px"><?php echo number_format($realizado[$cu])?></h3></td>
                    	 -->
                      </tr>
                	</table>
              		</div>
              		<div class="col-md-2"></div>
              	
              	</div>
                
            </div>
          </div>
        </div>
        </a>
        <?php $i++; }?>

        <?php $i=0; foreach($codarea2 as $cu){?>
		    <a href="metas_indicadores_dashboard.php?area=<?php echo $cu;?>&id_periodo=<?php echo $periodo;?>" class="fancy" style="color: black;">
        <div class="col-md-3">
          <div class="box box-widget widget-user text-center" style="height:375px; border-radius: 25px;">
              
            <div class="box-footer" style="border-radius: 25px">
            	  <img class="img-circle" src="<?php echo $icon3[$i]?>" alt="User Image" height="100px">
              <?php if (!empty($icon4[$i])){?>
                <img class="img-circle" src="<?php echo $icon4[$i]?>" alt="User Image" height="100px">
              <?php }?>
            	<br>
            	<br>
                <div class="text-center">
                	<h3 class="widget-user-username" style="color: #181e8c; font-size: 32px; height: 70px"><?php echo $nombre2[$i];?></h3>
                  <br>
                  <h1 class="widget-user-username" <?php if($porcentaje2[$cu] <= 61){echo 'style="color: #ff0000; font-size: 40px"';}elseif($porcentaje2[$cu] >=62 && $porcentaje2[$cu] <= 79){echo 'style="color: #ff5100; font-size: 40px"';}else{echo 'style="color: #2f8c18; font-size: 40px"';}?>><b><?php echo $porcentaje2[$cu]?>%</b></h1>
                </div>
              	<div class="row">
              	
              		<div class="col-md-2"></div>
              		<div class="col-md-8">
              		<table>
                    	<tr>
                    		<!-- <td class="text-left"><h3><b>Meta:</b></h3></td>
                    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    		<td class="text-right"><h3><?php echo number_format($meta2[$cu])?></h3></td> -->
                    	</tr>
                    	<tr>
                    		<!-- <td class="text-left"><h3 style="margin-top: 0px"><b>Realizado:</b></h3></td>
                    		<td></td>
                    		<td class="text-right"><h3 style="margin-top: 0px"><?php echo number_format($realizado2[$cu])?></h3></td> -->
                    	</tr>
                	</table>
              		</div>
              		<div class="col-md-2"></div>
              	
              	</div>
                
            </div>
          </div>
        </div>
        </a>
        <?php $i++; }?>
        
	</div>
	
      </section>

  </div>

  <footer class="main-footer">
    <div class="container">
      <strong>Muniguate 2020</strong>
    </div>

  </footer>
</div>

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="js/bootstrap.min.js"></script>
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="js/demo.js"></script>
<script src="dist/jquery.fancybox.min.js"></script>
<script>
       jQuery(document).ready(function() {
        $("a.fancy").fancybox({
        	smallBtn : true,
            type : 'iframe',
            width: 600,
            iframe : {
                scrolling : 'yes'
            }       
        });
       });
</script>
<script>
//Date picker
$('.datepicker').datepicker({
	format: 'dd-mm-yyyy',
	autoclose: true
});
</script>
</body>
</html>
