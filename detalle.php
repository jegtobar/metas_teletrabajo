<?php 
error_reporting(0);
include 'db.php';

$codarea = $_REQUEST['area'];
$id_periodo = $_REQUEST['id_periodo'];

$query = "SELECT c.nombre AS descripcion,
                 count(b.nit) AS empleados,
                 c.icon
            FROM rh_areas a,
                 rh_empleados b,
                 mte_areas c
           WHERE a.codarea = b.codarea
                 and a.codarea = ".$codarea."
                 and a.codarea = c.codarea
                 and b.status = 'A'
           GROUP BY c.nombre,
                 c.icon";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$area = $row['DESCRIPCION'];
$empleados = $row['EMPLEADOS'];
$icon = $row['ICON'];

$query = "SELECT a.nombre,
                 sum(b.cantidad) as cantidad,
                 a.meta,
                 a.tipo
            FROM mte_metas a
            LEFT JOIN mte_cumplimientos b ON a.id_meta = b.id_meta
           WHERE a.codarea = ".$codarea."
                 AND a.id_periodo = ".$id_periodo."
           GROUP BY a.nombre,
                    a.meta,
                    a.tipo";

$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);

$teletrabajo = 0;
$presencial = 0;
$mixto = 0;

$tele = 0;
$pres = 0;
$mix = 0;

while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
    
    if(!empty($row['NOMBRE'])){$nombre[] = $row['NOMBRE'];} else {$nombre[] = "";}
    if(!empty($row['CANTIDAD'])){$cantidad[] = $row['CANTIDAD'];} else {$cantidad[] = 0;}
    if(!empty($row['META'])){$meta[] = $row['META'];} else {$meta[] = 0;}
    if(!empty($row['TIPO'])){$tipo[] = $row['TIPO'];} else {$tipo[] = 0;}
    
    if ($row['TIPO'] == 'T'){$modalidad[] = 'Teletrabajo';$teletrabajo++; $tele = $tele + $row['CANTIDAD'];}
    if ($row['TIPO'] == 'P'){$modalidad[] = 'Presencial';$presencial++; $pres = $pres + $row['CANTIDAD'];}
    if ($row['TIPO'] == 'M'){$modalidad[] = 'Mixto';$mixto++; $mix = $mix + $row['CANTIDAD'];}
    
    $porcent[] = round(($row['CANTIDAD'] / $row['META']) * 100 ,2);
    
}

$sum_cantidad = array_sum($cantidad);
$sum_meta = array_sum($meta);

$porcentaje = round(($sum_cantidad / $sum_meta) * 100 ,2);

$actividades = $teletrabajo + $presencial;

$i = 0;

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
<style>
tr:nth-child(even) {
  background-color: #c9ffa3;
}
</style>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

<!--  
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
-->
  <div class="content-wrapper" style="background-color: #ededed">

	<br>
      <section class="content">

      <div class="">
          <h1><?php echo $area ?></h1>
      </div>

      <hr>
      
      <!--
      <div class="row">
      
      	<div class="col-md-6">
          	<div class="box box-widget" style="height:300px; border-radius: 25px;">
          		<div class="box-body">
          			<div id="linea" style="height:280px"></div>
          		</div>
          	</div>
      	</div>
      	
      	<div class="col-md-4">
          	<div class="box box-widget" style="height:300px; border-radius: 25px;">
          		<div class="box-body">
          			<div class="row">
          				<div class="col-md-8">
          					<div id="dona" style="top:0px; height:280px"></div>
    						<div id="addText" style="position:absolute; top:0px;"></div>
          				</div>
          				<div class="col-md-4 text-center">
          					<br>
          					<br>
          					<br>
          					<br>
          					<h3><small class="label" style="background-color: #1847f0">&nbsp;</small>Teletrabajo</h3>
          					<h3><small class="label" style="background-color: #64f018">&nbsp;</small>Presencial</h3>
          				</div>
          			</div>
          		</div>
          	</div>
      	</div>
      	
      	<div class="col-md-2">
          	<div class="box box-widget" style="height:300px; border-radius: 25px;">
          		<div class="box-body">
          			<div class="row">
              			<div class="col-md-12 text-center">
              				<img src="img/users.png" height="100px">
              			</div>
          			</div>
          			<div class="row">
          				<div class="col-md-12 text-center">
          					<h1><b><?php echo $empleados;?></b></h1>
          					<h1>Colaboradores</h1>
          				</div>
          			</div>
          		</div>
          	</div>
      	</div>
      	
      </div>
      -->
      
      <div class="row">
      
      <!--
      	<div class="col-md-2">
            <div class="box box-widget widget-user text-center" style="height:450px; border-radius: 25px;"> 
                <div class="box-footer" style="border-radius: 25px">
                	<img class="img-circle" src="<?php echo $icon?>" alt="User Image" height="100px">
                	<br>
                	<br>
                    <div class="text-center">
                    	<h3 class="widget-user-username"><?php echo $area;?></h3>
                  		<h1 class="widget-user-username" <?php if($porcentaje < 76){echo 'style="color: #e82113;"';}elseif($porcentaje < 86){echo 'style="color: #e8c113;"';}else{echo 'style="color: #41e813;"';}?>><b><?php if($porcentaje > 100){echo $porcentaje = 100;}else{echo $porcentaje;}?>%</b></h1>
                    </div>
                  	<div class="row">
                  		<div class="col-md-2"></div>
                  		<div class="col-md-8">
                  		<table class="table">
                        	<tr>
                        		<td><h3><b>Meta:</b></h3></td>
                        		<td class="text-right"><h3><?php echo $sum_meta?></h3></td>
                        	</tr>
                        	<tr>
                        		<td><h3><b>Realizado:</b></h3></td>
                        		<td class="text-right"><h3><?php echo $sum_cantidad?></h3></td>
                        	</tr>
                    	</table>
                  		</div>
                  		<div class="col-md-2"></div>
                  	</div>
                </div>
              </div>
          </div>
-->
            <div class="col-md-6">
              	<div class="box box-widget" style="height:475px; border-radius: 25px;">
              		<div class="box-body">
              			<div id="distribucion" style="height:450px"></div>
              		</div>
              	</div>
              </div>
              
              <div class="col-md-6">
          	<div class="box box-widget" style="height:475px; border-radius: 25px;">
          		<div class="box-body">
          			<div class="row">
          				<div class="col-md-12">
          					<div id="dona" style="height:415px"></div>
    						<div id="addText" style="position:absolute; top:0px;"></div>
          				</div>
          				
                      </div>
                      <div class="row">
                      <div class="col-md-4 text-center">
                            <h3 style="margin-top: 0px"><small class="label" style="background-color: #64f018">&nbsp;</small>&nbsp;&nbsp;Presencial</h3>
                       </div>
                       <div class="col-md-4 text-center">
                            <h3 style="margin-top: 0px"><small class="label" style="background-color: #1847f0">&nbsp;</small>&nbsp;&nbsp;Teletrabajo</h3>
          			 </div>
          			  <div class="col-md-4 text-center">
                            <h3 style="margin-top: 0px"><small class="label" style="background-color: #ecf230">&nbsp;</small>&nbsp;&nbsp;Mixto</h3>
          			 </div>
                      </div>
          		</div>
          	</div>
      	</div>
      		
      		<div class="col-md-12">
              	<div class="box box-widget" style="border-radius: 25px;">
              		<div class="box-body">
              			<table id="table" class="table table-bordered" style="font-size: 18px">
                            <thead>
                            <tr>
                              <th>Descripcion</th>
                              <th>Modalidad</th>
                              <th>Realizado</th>
                              <th>Meta</th>
                            </tr>
                            </thead>
                            <tbody>
                        <?php
                        while ($i < count($nombre)) {
                           echo'
                            <tr>
                             <td>'.$nombre[$i].'</td>
            		         <td>'.$modalidad[$i].'</td>
            		         <td class="text-right">'.number_format($cantidad[$i]).'</td>
              		         <td class="text-right">'.number_format($meta[$i]).'</td>
                            </tr>';
                            $i++;
                              }
                              
                        ?>
                           </tbody>
                        </table>
              		</div>
              	</div>
          	</div>
      
      </div>
      
      
		
        
        

      </section>

  </div>

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
<script src="js/highcharts.js"></script>

<script>
Highcharts.chart('linea', {
    chart: {
        type: 'line'
    },
    credits: false,
    title: {
        text: 'Historico de Actividades Realizadas'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: ''
        }
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '18px'
                }
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Tokyo',
        color: 'orange',
        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
    }]
});
</script>
<script>
$(function() {
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'dona',
            type: 'pie'
        },
        title: {
            text: 'EJECUCIÓN DE ACTIVIDADES POR TIPO',
            style: {
                fontSize: '30px' 
             }
        },
        credits: false,
        plotOptions: {
            pie: {
                innerSize: '60%',
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return Math.round(this.percentage*100)/100 + ' %';
                    },
                    style: {
                        fontSize: '30px'
                    }, 
                    distance: 20,
                    showInLegend: false
                },
            }
        },
        series: [{
            name: 'Actividades',
            /*size: '100%',*/
            innerSize: '70%',
            colorByPoint: true,
            data: [{
                name: 'Teletrabajo',
                y: <?php echo $tele?>,
                color: '#1847f0'
            }, {
                name: 'Presencial',
                y: <?php echo $pres?>,
                color: '#64f018'
            }, {
                name: 'Mixto',
                y: <?php echo $mix?>,
                color: '#ecf230'
            }]
        }]
    },
                                     
    function(chart) { // on complete
        var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
        var textY = chart.plotTop  + (chart.plotHeight * 0.5);

        var span = '<span id="pieChartInfoText" style="position:absolute; text-align:center;">';
        span += '<span style="font-size: 45px"><b><?php echo number_format(array_sum($cantidad));?></b></span><br>';
        span += '<span style="font-size: 20px"><b>Actividades</b></span>';
        span += '</span>';

        $("#addText").append(span);
        span = $('#pieChartInfoText');
        span.css('left', textX + (span.width() * -0.5));
        span.css('top', textY + (span.height() * -0.5));
    });
});
</script>

<script>

Highcharts.chart('distribucion', {
    chart: {
        type: 'column'
    },
    credits: false,
    title: {
        text: 'CLASIFICACIÓN DE ACTIVIDADES POR TIPO',
        style: {
            fontSize: '30px' 
         }
    },
    xAxis: {
        categories: [
            'Teletrabajo',
            'Presencial',
            'Mixto'
        ],
        crosshair: true,
        labels: {
            style: {
                fontSize: '30px'
            }
        }
    },
    yAxis: {
        min: 0,
        title: false,
        gridLineWidth: 0,
    },
    legend: {
        enabled: false
    },
    tooltip: {
        enabled: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '30px'
                }
            }
        }
    },
    series: [{
        name: 'Cantidad',
        data: [
            {
                name: "Teletrabajo",
                y: <?php echo $teletrabajo?>,
                color: '#03c2fc'
            },
            {
                name: "Presencial",
                y: <?php echo $presencial?>,
                color: '#b505fa'
            },
            {
                name: "Mixto",
                y: <?php echo $mixto?>,
                color: '#407bb3'
            }]
    }]
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
