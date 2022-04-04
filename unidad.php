<?php
include 'auth.php';

$_SESSION['id_institucion'] = (isset($_SESSION['id_institucion']) && !empty($_SESSION['id_institucion'])) ? $_SESSION['id_institucion'] : $_POST['id_institucion'];
$_SESSION['nombre_institucion'] = (isset($_SESSION['nombre_institucion']) && !empty($_SESSION['nombre_institucion'])) ? $_SESSION['nombre_institucion'] : $_POST['nombre_institucion'];

$_SESSION['id_unidad'] = (isset($_SESSION['id_unidad']) && !empty($_SESSION['id_unidad'])) ? $_SESSION['id_unidad'] : $_POST['id_unidad'];

if (!isset($_SESSION['id_institucion']) && empty($_SESSION['id_institucion'])) {
    header('Location: principal.php');
}

if (isset($_SESSION['id_unidad']) && !empty($_SESSION['id_unidad'])) {
$sql = "SELECT nombre,
               direccion_fisica,
               telefonos,
               atencion_lunes,
               atencion_martes,
               atencion_miercoles,
               atencion_jueves,
               atencion_viernes,
               atencion_sabado,
               atencion_domingo,
               horario_lunes_inicio,
               horario_lunes_fin,
               horario_martes_inicio,
               horario_martes_fin,
               horario_miercoles_inicio,
               horario_miercoles_fin,
               horario_jueves_inicio,
               horario_jueves_fin,
               horario_viernes_inicio,
               horario_viernes_fin,
               horario_sabado_inicio,
               horario_sabado_fin,
               horario_domingo_inicio,
               horario_domingo_fin,
               cierra_mediodia,
               horario_cierra_mediodia_inicio,
               horario_cierra_mediodia_fin
          FROM unidad
         WHERE idunidad = ". $_SESSION['id_unidad'];

$result = mysqli_query($link, $sql);

while($row = mysqli_fetch_array($result)) {
    $nombre_unidad = $row['nombre'];
    $direccion_fisica = $row['direccion_fisica'];
    $telefonos = $row['telefonos'];
    $atencion_lunes = $row['atencion_lunes'];
    $atencion_martes = $row['atencion_martes'];
    $atencion_miercoles = $row['atencion_miercoles'];
    $atencion_jueves = $row['atencion_jueves'];
    $atencion_viernes = $row['atencion_viernes'];
    $atencion_sabado = $row['atencion_sabado'];
    $atencion_domingo = $row['atencion_domingo'];
    $horario_lunes_inicio = $row['horario_lunes_inicio'];
    $horario_lunes_fin = $row['horario_lunes_fin'];
    $horario_martes_inicio = $row['horario_martes_inicio'];
    $horario_martes_fin = $row['horario_martes_fin'];
    $horario_miercoles_inicio = $row['horario_miercoles_inicio'];
    $horario_miercoles_fin = $row['horario_miercoles_fin'];
    $horario_jueves_inicio = $row['horario_jueves_inicio'];
    $horario_jueves_fin = $row['horario_jueves_fin'];
    $horario_viernes_inicio = $row['horario_viernes_inicio'];
    $horario_viernes_fin = $row['horario_viernes_fin'];
    $horario_sabado_inicio = $row['horario_sabado_inicio'];
    $horario_sabado_fin = $row['horario_sabado_fin'];
    $horario_domingo_inicio = $row['horario_domingo_inicio'];
    $horario_domingo_fin = $row['horario_domingo_fin'];
    $cierra_mediodia = $row['cierra_mediodia'];
    $horario_cierra_mediodia_inicio = $row['horario_cierra_mediodia_inicio'];
    $horario_cierra_mediodia_fin = $row['horario_cierra_mediodia_fin'];
}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ficha electrónica</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="lib/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="lib/ionicons-2.0.1/css/ionicons.min.css">
  <!-- PNotify -->
  <link href="lib/pnotify/dist/pnotify.css" rel="stylesheet">
  <link href="lib/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
  <link href="lib/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="css/skins/_all-skins.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php
  	include 'menu.php';
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
  <?php
    if ('S' == $_SESSION['error'] && isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        echo '<input type="hidden" id="error" value="S"><input type="hidden" id="error_message" value="'. $_SESSION['error_message'] .'">';
    }
    
    if ('N' == $_SESSION['error'] && isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        echo '<input type="hidden" id="error" value="N">';
    }
    
    unset($_SESSION['error']);
    unset($_SESSION['error_message']);
  ?>
  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
            <div class="col-md-6">
            <section class="content-header">
                <h1>
                    Unidades&nbsp;&nbsp;-&nbsp;&nbsp;<small><?php echo $_SESSION['nombre_institucion']; ?></small>
                </h1>
            </section>
            </div>
            <div class="col-md-6">
            <section class="content-header pull-right">
                <a href="unidad_listado.php" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Regresar</a>
                <button type="button" id="send_form" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Grabar</button>
            </section>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
    <form id="unidad-form" role="form" action="unidad_grabar.php" method="post" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="id_institucion" value="<?php echo $_SESSION['id_institucion']; ?>">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_detalles_generales" data-toggle="tab">Detalles generales</a></li>
              <li><a href="#tab_contactos" data-toggle="tab">Contactos</a></li>
              <li><a href="#tab_areas" data-toggle="tab">Instalaciones de la unidad</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_detalles_generales">
                <div class="row">
                    <div class="col-md-6">
                    <!--  -->
<!-- Datos generales -->
<!--  -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Datos generales</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <div class="form-group">
                  <label for="nombre">Nombre de la unidad:</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" required="" value="<?php echo $nombre_unidad; ?>">
                </div>
                <div class="form-group">
                  <label for="direccion_fisica">Dirección física:</label>
                  <input type="text" class="form-control" id="direccion_fisica" name="direccion_fisica" placeholder="" required="" value="<?php echo $direccion_fisica; ?>">
                </div>
                <div class="form-group">
                  <label for="telefonos">Teléfonos:</label>
                  <input type="text" class="form-control" id="telefonos" name="telefonos" placeholder="" required="" value="<?php echo $telefonos; ?>">
                </div>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
          
<!--  -->
<!-- Archivos -->
<!--  -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Archivos</h3>
              <!--
              <button type="button" name="btn_add_file" id="btn_add_file" class="btn btn-default btn-xs pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Agregar</button>
              -->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                  <div class="form-group">
                    <label for="foto">Fotografía</label>
                      <input type="file" id="archivo[]" name="archivo[]">
                      
                      <div class="clearfix"></div>
                  </div>
                  
                  <table class="table table-condensed table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>Archivos</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  if (isset($_SESSION['id_unidad']) && !empty($_SESSION['id_unidad'])) {
                  $sql = "SELECT idarchivo_unidad,
                                 nombre,
                                 ruta
                            FROM archivo_unidad
                           WHERE unidad_idunidad = ". $_SESSION['id_unidad'];
                  
                  $result = mysqli_query($link, $sql);
                  
                  while($row = mysqli_fetch_array($result)) {
                  ?>
                    <tr>
                        <td><a href="download_file.php?ruta=<?php echo $row['ruta']; ?>&nombre=<?php echo $row['nombre']; ?>" class="btn btn-info btn-sm"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Descargar</a>&nbsp;&nbsp;<?php echo $row['nombre']; ?></td>
                    </tr>    
                  <?php
                  }
                  }
                  ?>
                  </tbody>
                  </table>
                  
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->

                    </div>
                    <div class="col-md-6">
                    <!--  -->
<!-- Horario de atención -->
<!--  -->
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Horario de atención</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
              <div class="invalid-form-error-message"></div>
              <div id="startTimeErrorContainer" class="bg-danger"></div>
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Día</th>
                            <th>Abierto</th>
                            <th>De</th>
                            <th>A</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lunes</td>
                            <td><input type="checkbox" id="atencion_lunes" name="atencion_lunes" value="S" <?php if ('S' == $atencion_lunes) { echo 'checked="checked"'; } ?>></td>
                            <td><input type="text" id="horario_lunes_inicio" name="horario_lunes_inicio" class="form-control" value="<?php echo $horario_lunes_inicio; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de inicio del lunes es incorrecto"></td>
                            <td><input type="text" id="horario_lunes_fin" name="horario_lunes_fin" class="form-control" value="<?php echo $horario_lunes_fin; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de finalizacion del lunes es incorrecto"></td>
                        </tr>
                        <tr>
                            <td>Martes</td>
                            <td><input type="checkbox" id="atencion_martes" name="atencion_martes" value="S" <?php if ('S' == $atencion_martes) { echo 'checked="checked"'; } ?>></td>
                            <td><input type="text" id="horario_martes_inicio" name="horario_martes_inicio" class="form-control" value="<?php echo $horario_martes_inicio; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de inicio del martes es incorrecto"></td>
                            <td><input type="text" id="horario_martes_fin" name="horario_martes_fin" class="form-control" value="<?php echo $horario_martes_fin; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de finalizacion del martes es incorrecto"></td>
                        </tr>
                        <tr>
                            <td>Miércoles</td>
                            <td><input type="checkbox" id="atencion_miercoles" name="atencion_miercoles" value="S" <?php if ('S' == $atencion_miercoles) { echo 'checked="checked"'; } ?>></td>
                            <td><input type="text" id="horario_miercoles_inicio" name="horario_miercoles_inicio" class="form-control" value="<?php echo $horario_miercoles_inicio; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de inicio del miercoles es incorrecto"></td>
                            <td><input type="text" id="horario_miercoles_fin" name="horario_miercoles_fin" class="form-control" value="<?php echo $horario_miercoles_fin; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de finalizacion del miercoles es incorrecto"></td>
                        </tr>
                        <tr>
                            <td>Jueves</td>
                            <td><input type="checkbox" id="atencion_jueves" name="atencion_jueves" value="S" <?php if ('S' == $atencion_jueves) { echo 'checked="checked"'; } ?>></td>
                            <td><input type="text" id="horario_jueves_inicio" name="horario_jueves_inicio" class="form-control" value="<?php echo $horario_jueves_inicio; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de inicio del jueves es incorrecto"></td>
                            <td><input type="text" id="horario_jueves_fin" name="horario_jueves_fin" class="form-control" value="<?php echo $horario_jueves_fin; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de finalizacion del jueves es incorrecto"></td>
                        </tr>
                        <tr>
                            <td>Viernes</td>
                            <td><input type="checkbox" id="atencion_viernes" name="atencion_viernes" value="S" <?php if ('S' == $atencion_viernes) { echo 'checked="checked"'; } ?>></td>
                            <td><input type="text" id="horario_viernes_inicio" name="horario_viernes_inicio" class="form-control" value="<?php echo $horario_viernes_inicio; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de inicio del viernes es incorrecto"></td>
                            <td><input type="text" id="horario_viernes_fin" name="horario_viernes_fin" class="form-control" value="<?php echo $horario_viernes_fin; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de finalizacion del viernes es incorrecto"></td>
                        </tr>
                        <tr>
                            <td>Sábado</td>
                            <td><input type="checkbox" id="atencion_sabado" name="atencion_sabado" value="S" <?php if ('S' == $atencion_sabado) { echo 'checked="checked"'; } ?>></td>
                            <td><input type="text" id="horario_sabado_inicio" name="horario_sabado_inicio" class="form-control" value="<?php echo $horario_sabado_inicio; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de inicio del sabado es incorrecto"></td>
                            <td><input type="text" id="horario_sabado_fin" name="horario_sabado_fin" class="form-control" value="<?php echo $horario_sabado_fin; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de finalizacion del sabado es incorrecto"></td>
                        </tr>
                        <tr>
                            <td>Domingo</td>
                            <td><input type="checkbox" id="atencion_domingo" name="atencion_domingo" value="S" <?php if ('S' == $atencion_domingo) { echo 'checked="checked"'; } ?>></td>
                            <td><input type="text" id="horario_domingo_inicio" name="horario_domingo_inicio" class="form-control" value="<?php echo $horario_domingo_inicio; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de inicio del domingo es incorrecto"></td>
                            <td><input type="text" id="horario_domingo_fin" name="horario_domingo_fin" class="form-control" value="<?php echo $horario_domingo_fin; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de finalizacion del domingo es incorrecto"></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                
                <div class="form-group">
                  <label for="cierra_mediodia" class="col-sm-4 col-md-4 control-label">Cierra a medio día:</label>

                  <div class="col-sm-8 col-md-8">
                    <input type="checkbox" id="cierra_mediodia" name="cierra_mediodia" value="S" <?php if ('S' == $cierra_mediodia) { echo 'checked="checked"'; } ?>>
                  </div>
                </div>
                <br>
                
                <div class="form-group">
                  <label for="horario_cierra_mediodia_inicio" class="col-sm-1 col-md-1 control-label">De:</label>

                  <div class="col-sm-4 col-md-4">
                    <input type="text" class="form-control" id="horario_cierra_mediodia_inicio" name="horario_cierra_mediodia_inicio" value="<?php echo $horario_cierra_mediodia_inicio; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de inicio para el cierre a medio dia es incorrecto">
                  </div>
                  
                  <label for="horario_cierra_mediodia_fin" class="col-sm-1 col-md-1 control-label">A:</label>

                  <div class="col-sm-4 col-md-4">
                    <input type="text" class="form-control" id="horario_cierra_mediodia_fin" name="horario_cierra_mediodia_fin" value="<?php echo $horario_cierra_mediodia_fin; ?>" data-parsley-pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])" data-parsley-errors-container="#startTimeErrorContainer" data-parsley-pattern-message="El horario de finalizacion para el cierre a medio dia es incorrecto">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
                    </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_contactos">
                <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Contactos</h3>
              <button type="button" name="btn_add_contact" id="btn_add_contact" class="btn btn-default btn-xs pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Agregar contacto</button>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
<div class="row">
              <div class="box-body" id="container_contacts">
                  
                  <?php
if (isset($_SESSION['id_unidad']) && !empty($_SESSION['id_unidad'])) {
                  $sql = "SELECT idcontacto,
                                 nombre,
                                 titulo,
                                 email,
                                 telefono,
                                 nombre_foto,
                                 ruta_foto
                            FROM contacto
                           WHERE contacto_idunidad = ". $_SESSION['id_unidad'];
                  
                  $result = mysqli_query($link, $sql);
                  
                  while($row = mysqli_fetch_array($result)) {
                  ?>

<div class="col-md-3">
                    <div class="form-group">
                      <label for="">Nombre:</label>
                      <input type="text" class="form-control" name="contacto_existente[nombre][]" placeholder="" required="" value="<?php echo $row['nombre']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="">Titulo del cargo:</label>
                      <input type="text" class="form-control" name="contacto_existente[titulo][]" placeholder="" required="" value="<?php echo $row['titulo']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="">Correo electrónico:</label>
                      <input type="text" class="form-control" name="contacto_existente[email][]" placeholder="" required="" value="<?php echo $row['email']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="">Teléfono directo:</label>
                      <input type="text" class="form-control" name="contacto_existente[telefono][]" placeholder="" required="" value="<?php echo $row['telefono']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="">Fotografía:</label>
                      <input type="file" name="contacto_existente[]">
                    </div>
                    <div class="form-group">
                      <label for="">Fotografía:</label>
                      <?php
                      if (isset($row['ruta_foto']) && !empty($row['ruta_foto'])) {
                      ?>
                      <a href="download_file.php?ruta=<?php echo $row['ruta_foto']; ?>&nombre=<?php echo $row['nombre_foto']; ?>" class="btn btn-info btn-sm"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Descargar</a>&nbsp;&nbsp;<?php echo $row['nombre_foto']; ?>
                      <?php
                        }
                      ?>
                    </div>
                    
                    <input type="hidden" class="form-control" name="contacto_existente[idcontacto][]" placeholder="" required="" value="<?php echo $row['idcontacto']; ?>">
                    <input type="hidden" class="form-control" name="contacto_existente[delete_file][]" placeholder="" required="" value="<?php echo $row['ruta_foto']; ?>">
                    <br>
</div>


                  <?php
                  }
} else {
                  ?>                  
                  
<div class="col-md-3">
                    <div class="form-group">
                      <label for="">Nombre:</label>
                      <input type="text" class="form-control" name="contacto[nombre][]" placeholder="" required="">
                    </div>
                    <div class="form-group">
                      <label for="">Titulo del cargo:</label>
                      <input type="text" class="form-control" name="contacto[titulo][]" placeholder="" required="">
                    </div>
                    <div class="form-group">
                      <label for="">Correo electrónico:</label>
                      <input type="text" class="form-control" name="contacto[email][]" placeholder="" required="">
                    </div>
                    <div class="form-group">
                      <label for="">Teléfono directo:</label>
                      <input type="text" class="form-control" name="contacto[telefono][]" placeholder="" required="">
                    </div>
                    <div class="form-group">
                      <label for="">Fotografía:</label>
                      <input type="file" name="contacto[]">
                    </div>
                    <br><br><br><br>
</div>
<?php
}
?>
                  </div>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_areas">

                <?php
                    $sql = "SELECT idtipo_area_unidad,
                                   nombre
                              FROM tipo_area_unidad
                             ORDER BY idtipo_area_unidad";
                    
                    $result = mysqli_query($link, $sql);
                     
                    while($row = mysqli_fetch_array($result)) {
                        
if (isset($_SESSION['id_unidad']) && !empty($_SESSION['id_unidad'])) {
                        $sql2 = "SELECT idarea_unidad,
                                        disponible,
                                        estado,
                                        estado_observaciones,
                                        ventilacion,
                                        ventilacion_observaciones,
                                        iluminacion,
                                        iluminacion_observaciones,
                                        higiene,
                                        higiene_observaciones,
                                        otro,
                                        otro_observaciones,
                                        nombre_foto,
                                        ruta_foto
                                   FROM area_unidad
                                  WHERE tipo_area_unidad_idtipo_area_unidad = ". $row['idtipo_area_unidad'] ."
                                    AND unidad_idunidad = ". $_SESSION['id_unidad'];
                        
                        $result2 = mysqli_query($link, $sql2);
                         
                        while($row2 = mysqli_fetch_array($result2)) {
                            $disponible = $row2['disponible'];
                            $estado = $row2['estado'];
                            $estado_observaciones = $row2['estado_observaciones'];
                            $ventilacion = $row2['ventilacion'];
                            $ventilacion_observaciones = $row2['ventilacion_observaciones'];
                            $iluminacion = $row2['iluminacion'];
                            $iluminacion_observaciones = $row2['iluminacion_observaciones'];
                            $higiene = $row2['higiene'];
                            $higiene_observaciones = $row2['higiene_observaciones'];
                            $otro = $row2['otro'];
                            $otro_observaciones = $row2['otro_observaciones'];
                            $nombre_foto = $row2['nombre_foto'];
                            $ruta_foto = $row2['ruta_foto'];
                        }
}
                ?>
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
<div class="box-body">
<div class="row">
<div class="col-md-4 col-md-offset-2 text-right">
<?php echo '<strong>'. $row['nombre'] .'</strong>'; ?>
</div>
<div class="col-md-4">
                <div class="form-group">
                  <div class="col-sm-4 col-md-4">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][disponible]" value="S" data-id="<?php echo $row['idtipo_area_unidad'] ?>" <?php if ('S' == $disponible) { echo 'checked="checked"'; } ?>> Si
                  </div>

                  <div class="col-sm-4 col-md-4">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][disponible]" value="N" data-id="<?php echo $row['idtipo_area_unidad'] ?>" <?php if ('N' == $disponible || !isset($_SESSION['id_unidad'])) { echo 'checked="checked"'; } ?>> No
                  </div>
                </div>
</div>
</div>
<br>
<div id="area_unidad_container_<?php echo $row['idtipo_area_unidad']; ?>">
<div class="row">
<div class="col-md-4 col-md-offset-2">
                <div class="form-group">
                
	              <label for="estado" class="col-sm-2 col-md-2 control-label">Estado:</label>
                
                  <div class="col-sm-5 col-md-5">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][estado]" value="SATISFACTORIA" <?php if ('SATISFACTORIA' == $estado) { echo 'checked="checked"'; } ?>> Satisfactorio
                  </div>

                  <div class="col-sm-5 col-md-5">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][estado]" value="DEFICIENTE" <?php if ('DEFICIENTE' == $estado) { echo 'checked="checked"'; } ?>> Deficiente
                  </div>
                  
                  <label for="estado" class="col-sm-12 col-md-12 control-label">Observaciones:</label>
                  
                  <div class="col-sm-12 col-md-12">
                    <textarea rows="" cols="" class="form-control" name="area[<?php echo $row['idtipo_area_unidad']; ?>][estado_observaciones]"><?php echo $estado_observaciones; ?></textarea>
                    
                  </div>

                </div>
                
                <div class="form-group">
                
                   <label for="estado" class="col-sm-2 col-md-2 control-label">Ventilación:</label>
                
                  <div class="col-sm-5 col-md-5">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][ventilacion]" value="SATISFACTORIA" <?php if ('SATISFACTORIA' == $ventilacion) { echo 'checked="checked"'; } ?>> Satisfactorio
                  </div>

                  <div class="col-sm-5 col-md-5">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][ventilacion]" value="DEFICIENTE" <?php if ('DEFICIENTE' == $ventilacion) { echo 'checked="checked"'; } ?>> Deficiente
                  </div>
                  
                  <label for="estado" class="col-sm-12 col-md-12 control-label">Observaciones:</label>
                  
                  <div class="col-sm-12 col-md-12">
                    <textarea rows="" cols="" class="form-control" name="area[<?php echo $row['idtipo_area_unidad']; ?>][ventilacion_observaciones]" ><?php echo $ventilacion_observaciones; ?></textarea>
                    
                  </div>
                </div>
                
                <div class="form-group">
                
                   <label for="estado" class="col-sm-2 col-md-2 control-label">Iluminación:</label>
                
                  <div class="col-sm-5 col-md-5">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][iluminacion]" value="SATISFACTORIA" <?php if ('SATISFACTORIA' == $iluminacion) { echo 'checked="checked"'; } ?>> Satisfactorio
                  </div>

                  <div class="col-sm-5 col-md-5">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][iluminacion]" value="DEFICIENTE" <?php if ('DEFICIENTE' == $iluminacion) { echo 'checked="checked"'; } ?>> Deficiente
                  </div>
                  
                  <label for="estado" class="col-sm-12 col-md-12 control-label">Observaciones:</label>
                  
                  <div class="col-sm-12 col-md-12">
                    <textarea rows="" cols="" class="form-control" name="area[<?php echo $row['idtipo_area_unidad']; ?>][iluminacion_observaciones]" ><?php echo $iluminacion_observaciones; ?></textarea>
                    
                  </div>
                </div>
</div>
<div class="col-md-4">                
                <div class="form-group">
                
                   <label for="estado" class="col-sm-2 col-md-2 control-label">Higiene:</label>
                
                  <div class="col-sm-5 col-md-5">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][higiene]" value="SATISFACTORIA" <?php if ('SATISFACTORIA' == $higiene) { echo 'checked="checked"'; } ?>> Satisfactorio
                  </div>

                  <div class="col-sm-5 col-md-5">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][higiene]" value="DEFICIENTE" <?php if ('DEFICIENTE' == $higiene) { echo 'checked="checked"'; } ?>> Deficiente
                  </div>
                  
                  <label for="estado" class="col-sm-12 col-md-12 control-label">Observaciones:</label>
                  
                  <div class="col-sm-12 col-md-12">
                    <textarea rows="" cols="" class="form-control" name="area[<?php echo $row['idtipo_area_unidad']; ?>][higiene_observaciones]" ><?php echo $higiene_observaciones; ?></textarea>
                    
                  </div>
                </div>
                
                <div class="form-group">
                
                   <label for="estado" class="col-sm-2 col-md-2 control-label">Otro:</label>
                
                  <div class="col-sm-5 col-md-5">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][otro]" value="SATISFACTORIA" <?php if ('SATISFACTORIA' == $otro) { echo 'checked="checked"'; } ?>> Satisfactorio
                  </div>

                  <div class="col-sm-5 col-md-5">
                    <input type="radio" name="area[<?php echo $row['idtipo_area_unidad']; ?>][otro]" value="DEFICIENTE" <?php if ('DEFICIENTE' == $otro) { echo 'checked="checked"'; } ?>> Deficiente
                  </div>
                  
                  <label for="estado" class="col-sm-12 col-md-12 control-label">Observaciones:</label>
                  
                  <div class="col-sm-12 col-md-12">
                    <textarea rows="" cols="" class="form-control" name="area[<?php echo $row['idtipo_area_unidad']; ?>][otro_observaciones]" ><?php echo $otro_observaciones; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                                
                    <label for="" class="col-sm-12 col-md-12 control-label">Fotografía:</label>
                  
                    <div class="col-sm-12 col-md-12">
                    <?php
                      if (isset($ruta_foto) && !empty($ruta_foto)) {
                      ?>
                      <a href="download_file.php?ruta=<?php echo $ruta_foto; ?>&nombre=<?php echo $nombre_foto; ?>" class="btn btn-info btn-sm"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Descargar</a>&nbsp;&nbsp;<?php echo $nombre_foto; ?>
                      <input type="hidden" class="form-control" name="area[<?php echo $row['idtipo_area_unidad']; ?>][delete_file]" placeholder="" required="" value="<?php echo $ruta_foto; ?>">
                      <?php
                        }
                      ?>
                      <input type="file" name="area[<?php echo $row['idtipo_area_unidad']; ?>]">
                    </div>
                </div>
</div>          
<!-- #area_unidad_container_# -->

</div>
<!-- .col-md-6 -->
</div>
<!-- .row -->
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
                <?php
                    }
                ?>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
      </div>
      <!-- /.row -->
      <?php
      if (isset($_SESSION['id_unidad']) && !empty($_SESSION['id_unidad'])) {
      ?>
      <input type="hidden" name="modificar_formulario" value="S">
      <input type="hidden" name="id_unidad" value="<?php echo $_SESSION['id_unidad']; ?>">
      <?php
      }
      ?>
    </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <small><b>Version</b> 1.0</small>
    </div>
    <strong>Copyright &copy; 2017 <span class="text-primary">Inteligencia de Negocios</span>.</strong> Todos los derechos reservados del autor.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="lib/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="lib/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="js/app.min.js"></script>
<!-- Parsley -->
<script src="lib/Parsley.js-2.6.2/dist/parsley.min.js"></script>
<script src="lib/Parsley.js-2.6.2/dist/i18n/es.js"></script>
<!-- PNotify -->
<script src="lib/pnotify/dist/pnotify.js"></script>
<script src="lib/pnotify/dist/pnotify.buttons.js"></script>
<script src="lib/pnotify/dist/pnotify.nonblock.js"></script>
<!-- Input mask -->
<script src="lib/Inputmask-3.x/dist/jquery.inputmask.bundle.js"></script>

<script type="text/javascript">
$(function () {

  $('#send_form').on('click', function() {
	  $('#unidad-form').submit();
  });

  (function($){
      $.fn.regex = function(pattern, fn, fn_a){
          var fn = fn || $.fn.text;
          return this.filter(function() {
              return pattern.test(fn.apply($(this), fn_a));
          });
      };
  })(jQuery);

$.each($('input').regex(/disponible/, $.fn.attr, ['name']),function(){    
    if($(this).is(':checked') && 'N' == this.value) {
        var idTipoAreaUnidad = $(this).data("id");
        $("textarea[name*='area["+ idTipoAreaUnidad +"]']").prop('readonly', true);
        $("input[name*='area["+ idTipoAreaUnidad +"][estado]']").prop('disabled', true);
        $("#area_unidad_container_"+ idTipoAreaUnidad).hide();
    }
});

$('input').regex(/disponible/, $.fn.attr, ['name']).on('change', function() {
    if($(this).is(':checked') && 'S' == this.value) {
        var idTipoAreaUnidad = $(this).data("id");
        $("textarea[name*='area["+ idTipoAreaUnidad +"]']").prop('readonly', false);
        $("input[name*='area["+ idTipoAreaUnidad +"][estado]']").prop('disabled', false);
        $("#area_unidad_container_"+ idTipoAreaUnidad).show();
    }

    if($(this).is(':checked') && 'N' == this.value) {
        var idTipoAreaUnidad = $(this).data("id");
        $("textarea[name*='area["+ idTipoAreaUnidad +"]']").prop('readonly', true);
        $("input[name*='area["+ idTipoAreaUnidad +"][estado]']").prop('disabled', true);
        $("#area_unidad_container_"+ idTipoAreaUnidad).hide();

        /* clean on change */
        $("input[name*='area["+ idTipoAreaUnidad +"][estado]']").prop('checked', false);
        $("textarea[name*='area["+ idTipoAreaUnidad +"][estado_observaciones]']").val('');

        $("input[name*='area["+ idTipoAreaUnidad +"][ventilacion]']").prop('checked', false);
        $("textarea[name*='area["+ idTipoAreaUnidad +"][ventilacion_observaciones]']").val('');
        
        $("input[name*='area["+ idTipoAreaUnidad +"][iluminacion]']").prop('checked', false);
        $("textarea[name*='area["+ idTipoAreaUnidad +"][iluminacion_observaciones]']").val('');

        $("input[name*='area["+ idTipoAreaUnidad +"][higiene]']").prop('checked', false);
        $("textarea[name*='area["+ idTipoAreaUnidad +"][higiene_observaciones]']").val('');

        $("input[name*='area["+ idTipoAreaUnidad +"][otro]']").prop('checked', false);
        $("textarea[name*='area["+ idTipoAreaUnidad +"][otro_observaciones]']").val('');
    }
});

$('input[id*="horario"]').inputmask("hh:mm", {
    placeholder: "HH:MM", 
    insertMode: true, 
    showMaskOnHover: false
  }
);




$('#btn_add_contact').on('click', function() {
    var htmlAddRow = '';

    htmlAddRow+= '<div class="col-md-3">';
    htmlAddRow+= '<div class="form-group">';
    htmlAddRow+= '<label for="">Nombre:</label>';
    htmlAddRow+= '<input type="text" class="form-control" name="contacto[nombre][]" placeholder="" required="">';
    htmlAddRow+= '</div>';
    htmlAddRow+= '<div class="form-group">';
    htmlAddRow+= '<label for="">Titulo del cargo:</label>';
    htmlAddRow+= '<input type="text" class="form-control" name="contacto[titulo][]" placeholder="" required="">';
    htmlAddRow+= '</div>';
    htmlAddRow+= '<div class="form-group">';
    htmlAddRow+= '<label for="">Correo electrónico:</label>';
    htmlAddRow+= '<input type="text" class="form-control" name="contacto[email][]" placeholder="" required="">';
    htmlAddRow+= '</div>';
    htmlAddRow+= '<div class="form-group">';
    htmlAddRow+= '<label for="">Teléfono directo:</label>';
    htmlAddRow+= '<input type="text" class="form-control" name="contacto[telefono][]" placeholder="" required="">';
    htmlAddRow+= '</div>';
    htmlAddRow+= '<div class="form-group">';
    htmlAddRow+= '<label for="">Fotografía:</label>';
    htmlAddRow+= '<input type="file" name="contacto[]">';
    htmlAddRow+= '</div>';
    htmlAddRow+= '<br>';
    htmlAddRow+= '<button type="button" id="btn_del_responsable" class="btn btn-xs btn-danger pull-right"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>';
    htmlAddRow+= '<br><br><br>';
    htmlAddRow+= '</div>';

    $( '#container_contacts' ).append(htmlAddRow).on('click', '#btn_del_responsable', function () {
        $(this).closest("div").remove();
    });

});
  

  var parsleyOptions = {
		  /*
		    successClass: 'has-success',
		    errorClass: 'has-error',
		    classHandler : function( _el ){
		        return _el.$element.closest('.form-group');
		    }
		    */
		  successClass: "has-success",
		    errorClass: "has-error",
		    classHandler: function(el) {
		    	return el.$element.closest(".form-group");
		    },
		    errorsWrapper: "<span class='help-block'></span>",
		    errorTemplate: "<span></span>"
		};

  $('#unidad-form').parsley(parsleyOptions).on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
  })
  .on('form:submit', function() {
    $(this).submit();
  });

  window.Parsley.addValidator('maxFileSize', {
      validateString: function(_value, maxSize, parsleyInstance) {
        if (!window.FormData) {
          alert('You are making all developpers in the world cringe. Upgrade your browser!');
          return true;
        }
        var files = parsleyInstance.$element[0].files;
        return files.length != 1  || files[0].size <= maxSize * 1024;
      },
      requirementType: 'integer',
      messages: {
        en: 'This file should not be larger than %s Kb',
        fr: "Ce fichier est plus grand que %s Kb.",
        es: "El archivo no puede ser mayor de %s Kb"
      }
    });

  if($('#atencion_lunes').is(':checked')) {
	   $('#horario_lunes_inicio').prop('readonly', false);
      $('#horario_lunes_fin').prop('readonly', false);
   } else {
      $('#horario_lunes_inicio').prop('readonly', true);
      $('#horario_lunes_fin').prop('readonly', true);
   }

   if($('#atencion_martes').is(':checked')) {
      $('#horario_martes_inicio').prop('readonly', false);
      $('#horario_martes_fin').prop('readonly', false);
   } else {
      $('#horario_martes_inicio').prop('readonly', true);
      $('#horario_martes_fin').prop('readonly', true);
   }

   if($('#atencion_miercoles').is(':checked')) {
		  $('#horario_miercoles_inicio').prop('readonly', false);
		  $('#horario_miercoles_fin').prop('readonly', false);
	  } else {
		  $('#horario_miercoles_inicio').prop('readonly', true);
		  $('#horario_miercoles_fin').prop('readonly', true);
	  }

   if($('#atencion_jueves').is(':checked')) {
		  $('#horario_jueves_inicio').prop('readonly', false);
		  $('#horario_jueves_fin').prop('readonly', false);
	  } else {
		  $('#horario_jueves_inicio').prop('readonly', true);
		  $('#horario_jueves_fin').prop('readonly', true);
	  }

   if($('#atencion_viernes').is(':checked')) {
		  $('#horario_viernes_inicio').prop('readonly', false);
		  $('#horario_viernes_fin').prop('readonly', false);
	  } else {
		  $('#horario_viernes_inicio').prop('readonly', true);
		  $('#horario_viernes_fin').prop('readonly', true);
	  }

   if($('#atencion_sabado').is(':checked')) {
		  $('#horario_sabado_inicio').prop('readonly', false);
		  $('#horario_sabado_fin').prop('readonly', false);
	  } else {
		  $('#horario_sabado_inicio').prop('readonly', true);
		  $('#horario_sabado_fin').prop('readonly', true);
	  }

   if($('#atencion_domingo').is(':checked')) {
		  $('#horario_domingo_inicio').prop('readonly', false);
		  $('#horario_domingo_fin').prop('readonly', false);
	  } else {
		  $('#horario_domingo_inicio').prop('readonly', true);
		  $('#horario_domingo_fin').prop('readonly', true);
	  }

   if($('#cierra_mediodia').is(':checked')) {
		  $('#horario_cierra_mediodia_inicio').prop('readonly', false);
		  $('#horario_cierra_mediodia_fin').prop('readonly', false);
	  } else {
		  $('#horario_cierra_mediodia_inicio').prop('readonly', true);
		  $('#horario_cierra_mediodia_fin').prop('readonly', true);
	  }
   

 $('#atencion_lunes').on('change', function() {
	  if($('#atencion_lunes').is(':checked')) {
		  $('#horario_lunes_inicio').prop('readonly', false);
		  $('#horario_lunes_fin').prop('readonly', false);
	  } else {
		  $('#horario_lunes_inicio').prop('readonly', true);
		  $('#horario_lunes_fin').prop('readonly', true);
		  $('#horario_lunes_inicio').val('');
	      $('#horario_lunes_fin').val('');
	  }
 });

 $('#atencion_martes').on('change', function() {
	  if($('#atencion_martes').is(':checked')) {
		  $('#horario_martes_inicio').prop('readonly', false);
		  $('#horario_martes_fin').prop('readonly', false);
	  } else {
		  $('#horario_martes_inicio').prop('readonly', true);
		  $('#horario_martes_fin').prop('readonly', true);
		  $('#horario_martes_inicio').val('');
		  $('#horario_martes_fin').val('');
	  }
 });

 $('#atencion_miercoles').on('change', function() {
	  if($('#atencion_miercoles').is(':checked')) {
		  $('#horario_miercoles_inicio').prop('readonly', false);
		  $('#horario_miercoles_fin').prop('readonly', false);
	  } else {
		  $('#horario_miercoles_inicio').prop('readonly', true);
		  $('#horario_miercoles_fin').prop('readonly', true);
         $('#horario_miercoles_inicio').val('');
         $('#horario_miercoles_fin').val('');
	  }
 });

 $('#atencion_jueves').on('change', function() {
	  if($('#atencion_jueves').is(':checked')) {
		  $('#horario_jueves_inicio').prop('readonly', false);
		  $('#horario_jueves_fin').prop('readonly', false);
	  } else {
		  $('#horario_jueves_inicio').prop('readonly', true);
		  $('#horario_jueves_fin').prop('readonly', true);
		  $('#horario_jueves_inicio').val('');
		  $('#horario_jueves_fin').val('');
	  }
 });

 $('#atencion_viernes').on('change', function() {
	  if($('#atencion_viernes').is(':checked')) {
		  $('#horario_viernes_inicio').prop('readonly', false);
		  $('#horario_viernes_fin').prop('readonly', false);
	  } else {
		  $('#horario_viernes_inicio').prop('readonly', true);
		  $('#horario_viernes_fin').prop('readonly', true);
		  $('#horario_viernes_inicio').val('');
		  $('#horario_viernes_fin').val('');
	  }
 });

 $('#atencion_sabado').on('change', function() {
	  if($('#atencion_sabado').is(':checked')) {
		  $('#horario_sabado_inicio').prop('readonly', false);
		  $('#horario_sabado_fin').prop('readonly', false);
	  } else {
		  $('#horario_sabado_inicio').prop('readonly', true);
		  $('#horario_sabado_fin').prop('readonly', true);
		  $('#horario_sabado_inicio').val('');
		  $('#horario_sabado_fin').val('');
	  }
 });

 $('#atencion_domingo').on('change', function() {
	  if($('#atencion_domingo').is(':checked')) {
		  $('#horario_domingo_inicio').prop('readonly', false);
		  $('#horario_domingo_fin').prop('readonly', false);
	  } else {
		  $('#horario_domingo_inicio').prop('readonly', true);
		  $('#horario_domingo_fin').prop('readonly', true);
		  $('#horario_domingo_inicio').val('');
		  $('#horario_domingo_fin').val('');
	  }
 });

 $('#cierra_mediodia').on('change', function() {
	  if($('#cierra_mediodia').is(':checked')) {
		  $('#horario_cierra_mediodia_inicio').prop('readonly', false);
		  $('#horario_cierra_mediodia_fin').prop('readonly', false);
	  } else {
		  $('#horario_cierra_mediodia_inicio').prop('readonly', true);
		  $('#horario_cierra_mediodia_fin').prop('readonly', true);
		  $('#horario_cierra_mediodia_inicio').val('');
		  $('#horario_cierra_mediodia_fin').val('');
	  }
 }); 



 if( 'S' == $("#error").val() ) {      
     new PNotify({
         title: 'Error',
         text: $("#error_message").val(),
         type: 'error',
         hide: false,
         styling: 'bootstrap3',
         addclass: 'stack-bottomright'
     });
 }

 if( 'N' == $("#error").val() ) {
     new PNotify({
         title: 'Datos grabados correctamente',
         text: 'Los datos se guardaron correctamente en la base de datos!',
         type: 'success',
         styling: 'bootstrap3',
         addclass: 'stack-bottomright'
     });
 }
  
});
</script>
<?php
include 'bitacora.php';
?>
</body>
</html>