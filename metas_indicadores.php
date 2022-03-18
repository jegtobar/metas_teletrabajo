<?php 
include '../auth.php';
include 'bknd_indicadores.php';
?>
<!DOCTYPE html>
<html>
<link rel="shortcut icon" href="images/favicon2.png">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Dashboard Metas</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="vendor/animate.css/animate.css" />
    
    <link rel="stylesheet" href="vendor/toastr/build/toastr.min.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css" />

</head>
<body class="fixed-sidebar hide-sidebar">


<!-- Main Wrapper -->
<div id="wrapper">

<div class="normalheader transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <img alt="logo"  style="height: 75px" src="img/logo_catastro.png">
                </div>
                <div class="col-md-10">
                    <h2 class="font-light m-b-xs" style="margin-top: 12px; ">
                        Direcci&oacute;n de Catastro y Administraci&oacute;n del IUSI.
                    </h2>
                    <!-- <small>Gesti&oacute;n de la suscripci&oacute;n de convenios del IUSI.</small> -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content animate-panel">
<div class="row">
	<div class="col-lg-6 col-md-6">
        <div id="rendSemanal">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h4 class="font-light m-b-xs" style="margin-top: 12px; ">
                        Rendimiento Semanal
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="progress">
                        <?php echo $rendimientoSemanal; echo ($rendSemanal ? $rendSemanal.'%' : null);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div id="rendPoa">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h4 class="font-light m-b-xs" style="margin-top: 12px; ">
                        POA
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="progress">
                         <?php echo $rendimientoPoa; echo ($rendPoaSemanal.'%');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="col-md-12">
        <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h4 class="font-light m-b-xs" style="margin-top: 12px; ">
                        Secciones
                    </h4>
                </div>
                <div class="panel-body">
    <?php          

        foreach ($secciones as $indicador) {
            
            echo '<div class="col-md-6">';

            echo $indicador['DESCRIPCION'] . '</div><div class="col-md-6">';

            $bar_style = 'progress-bar-success';

            if ($indicador["cumplimientop"] <= 50) {
                $bar_style = 'progress-bar-danger';
            }elseif ($indicador["cumplimientop"] > 50 && $indicador["cumplimientop"] <= 70) {
                $bar_style = 'progress-bar-warning';
            }


    ?>
        <div class="panel-body">
                    <div class="progress">
    <?php    
            echo '<div class="progress-bar '. $bar_style .' progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:'.$indicador["cumplimientop"].  '%">' . $indicador["cumplimientop"] . '%';
    ?>

        </div>
        </div>
        </div>
</div>


<?php
        }
    
    ?>
</div>
</div>
</div>
</div>

        <!-- Detalle -->

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">POA</a></li>
        </ul>

        <br>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="50%">Descripción</th>
                            <th width="30%">Modalidad</th>
                            <th width="10%">Realizado</th>
                            <th width="10%">Meta</th>
                        </tr>
                    </thead>
                    <t-body>
                        <?php 

                            foreach ($metas_poa as $meta) {
                                
                                echo ' <tr>
                                            <td>'. $meta['NOMBRE'] .'</td>
                                            <td>' . $meta['MODALIDAD'] .'</td>
                                            <td>'.$meta['REALIZADO'].'</td>
                                            <td>'.$meta['META'].'</td>
                                        </tr>';

                            }
                            
                        ?>
                    </t-body>
                </table>
            </div>
        </div>

        <br>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Actividades Regulares</a></li>
        </ul>

        <br>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="50%">Descripción</th>
                                <th width="30%">Modalidad</th>
                                <th width="10%">Realizado</th>
                                <th width="10%">Meta</th>
                            </tr>
                        </thead>
                        <t-body>
                             <?php 

                                foreach ($metas_regulares as $meta) {
                                    
                                    echo ' <tr>
                                            <td>'. $meta['NOMBRE'] .'</td>
                                            <td>' . $meta['MODALIDAD'] .'</td>
                                            <td>'.$meta['REALIZADO'].'</td>
                                            <td>'.$meta['META'].'</td>
                                        </tr>';

                                }
                                
                            ?>
                        </t-body>
                    </table>
                </div>
            </div>
        </div>

        <br>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Adicionales</a></li>
        </ul>

        <br>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="50%">Actividad</th>
                                <th width="30%">Modalidad</th>
                                <th width="10%">Realizado</th>
                                <th width="10%">Meta</th>
                            </tr>
                        </thead>
                        <t-body>
                            <?php 

                                foreach ($metas_adicionales as $meta) {
                                    
                                    echo ' <tr>
                                            <td>'. $meta['NOMBRE'] .'</td>
                                            <td>' . $meta['MODALIDAD'] .'</td>
                                            <td>'.$meta['REALIZADO'].'</td>
                                            <td>'.$meta['META'].'</td>
                                        </tr>';

                                }
                                
                            ?>
                        </t-body>
                    </table>
                </div>
            </div>
        </div>

    <!-- Footer-->
    <footer class="footer">
        <span class="pull-right">
            2022
        </span>
        Dirección de Catastro y Administración del IUSI. Municipalidad de Guatemala.
    </footer>

</div>

<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="vendor/chartist/custom/chartist.css" />

<!-- App scripts -->
<script src="scripts/homer.js"></script>
<script src="scripts/charts.js"></script>
<!-- HIGHCHARTS -->
<script src="js/highcharts.js"></script>

<script>
    // Highcharts.chart('aprobados',<?php echo json_encode($aprobados);?>)
    // Highcharts.chart('rechazados',<?php echo json_encode($rechazados);?>)
    // Highcharts.chart('motivos',<?php echo json_encode($motivos);?>)
    
    
</script>

</body>
</html>