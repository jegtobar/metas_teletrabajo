<?php
include 'auth.php';

$error = 'N';
$error_message = '';

    $modificar_formulario = (isset($_POST['modificar_formulario']) && !empty($_POST['modificar_formulario'])) ?  mysqli_real_escape_string( $link, $_POST['modificar_formulario'] ) : 'N';

	$nombre = mysqli_real_escape_string( $link, $_POST['nombre'] );
	$direccion_fisica = mysqli_real_escape_string( $link, $_POST['direccion_fisica'] );
	$telefonos = mysqli_real_escape_string( $link, $_POST['telefonos'] );
	$atencion_lunes = (isset($_POST['atencion_lunes']) && !empty($_POST['atencion_lunes'])) ?  mysqli_real_escape_string( $link, $_POST['atencion_lunes'] ) : 'N';
	$atencion_martes = (isset($_POST['atencion_martes']) && !empty($_POST['atencion_martes'])) ?  mysqli_real_escape_string( $link, $_POST['atencion_martes'] ) : 'N';
	$atencion_miercoles = (isset($_POST['atencion_miercoles']) && !empty($_POST['atencion_miercoles'])) ?  mysqli_real_escape_string( $link, $_POST['atencion_miercoles'] ) : 'N';
	$atencion_jueves = (isset($_POST['atencion_jueves']) && !empty($_POST['atencion_jueves'])) ?  mysqli_real_escape_string( $link, $_POST['atencion_jueves'] ) : 'N';
	$atencion_viernes = (isset($_POST['atencion_viernes']) && !empty($_POST['atencion_viernes'])) ?  mysqli_real_escape_string( $link, $_POST['atencion_viernes'] ) : 'N';
	$atencion_sabado = (isset($_POST['atencion_sabado']) && !empty($_POST['atencion_sabado'])) ?  mysqli_real_escape_string( $link, $_POST['atencion_sabado'] ) : 'N';
	$atencion_domingo = (isset($_POST['atencion_domingo']) && !empty($_POST['atencion_domingo'])) ?  mysqli_real_escape_string( $link, $_POST['atencion_domingo'] ) : 'N';
	$horario_lunes_inicio = mysqli_real_escape_string( $link, $_POST['horario_lunes_inicio'] );
	$horario_lunes_fin = mysqli_real_escape_string( $link, $_POST['horario_lunes_fin'] );
	$horario_martes_inicio = mysqli_real_escape_string( $link, $_POST['horario_martes_inicio'] );
	$horario_martes_fin = mysqli_real_escape_string( $link, $_POST['horario_martes_fin'] );
	$horario_miercoles_inicio = mysqli_real_escape_string( $link, $_POST['horario_miercoles_inicio'] );
	$horario_miercoles_fin = mysqli_real_escape_string( $link, $_POST['horario_miercoles_fin'] );
	$horario_jueves_inicio = mysqli_real_escape_string( $link, $_POST['horario_jueves_inicio'] );
	$horario_jueves_fin = mysqli_real_escape_string( $link, $_POST['horario_jueves_fin'] );
	$horario_viernes_inicio = mysqli_real_escape_string( $link, $_POST['horario_viernes_inicio'] );
	$horario_viernes_fin = mysqli_real_escape_string( $link, $_POST['horario_viernes_fin'] );
	$horario_sabado_inicio = mysqli_real_escape_string( $link, $_POST['horario_sabado_inicio'] );
	$horario_sabado_fin = mysqli_real_escape_string( $link, $_POST['horario_sabado_fin'] );
	$horario_domingo_inicio = mysqli_real_escape_string( $link, $_POST['horario_domingo_inicio'] );
	$horario_domingo_fin = mysqli_real_escape_string( $link, $_POST['horario_domingo_fin'] );
	$cierra_mediodia = (isset($_POST['cierra_mediodia']) && !empty($_POST['cierra_mediodia'])) ?  mysqli_real_escape_string( $link, $_POST['cierra_mediodia'] ) : 'N';
	$horario_cierra_mediodia_inicio = mysqli_real_escape_string( $link, $_POST['horario_cierra_mediodia_inicio'] );
	$horario_cierra_mediodia_fin = mysqli_real_escape_string( $link, $_POST['horario_cierra_mediodia_fin'] );
	
	$id_institucion = $_POST['id_institucion'];
	$id_unidad      = $_POST['id_unidad'];
	
if ('S' == $modificar_formulario) {
    $query = "UPDATE unidad
                 SET nombre = '". $nombre ."',
                     direccion_fisica = '". $direccion_fisica ."',
				     telefonos = '". $telefonos ."',
				     atencion_lunes = '". $atencion_lunes ."',
				     atencion_martes = '". $atencion_martes ."',
				     atencion_miercoles = '". $atencion_miercoles ."',
				     atencion_jueves = '". $atencion_jueves ."',
				     atencion_viernes = '". $atencion_viernes ."',
    				 atencion_sabado = '". $atencion_sabado ."',
    				 atencion_domingo = '". $atencion_domingo ."',
    				 horario_lunes_inicio = '". $horario_lunes_inicio ."',
    				 horario_lunes_fin = '". $horario_lunes_fin ."',
    				 horario_martes_inicio = '". $horario_martes_inicio ."',
    				 horario_martes_fin = '". $horario_martes_fin ."',
    				 horario_miercoles_inicio = '". $horario_miercoles_inicio ."',
    				 horario_miercoles_fin = '". $horario_miercoles_fin ."',
    				 horario_jueves_inicio = '". $horario_jueves_inicio ."',
    				 horario_jueves_fin = '". $horario_jueves_fin ."',
    				 horario_viernes_inicio = '". $horario_viernes_inicio ."',
    				 horario_viernes_fin = '". $horario_viernes_fin ."',
    				 horario_sabado_inicio = '". $horario_sabado_inicio ."',
    				 horario_sabado_fin = '". $horario_sabado_fin ."',
    				 horario_domingo_inicio = '". $horario_domingo_inicio ."',
    				 horario_domingo_fin = '". $horario_domingo_fin ."',
    				 cierra_mediodia = '". $cierra_mediodia ."',
    				 horario_cierra_mediodia_inicio = '". $horario_cierra_mediodia_inicio ."',
    				 horario_cierra_mediodia_fin = '". $horario_cierra_mediodia_fin ."',
                     usuario_actualizacion = '". $user ."',
                     fecha_actualizacion = NOW()
               WHERE idunidad = ". $id_unidad;
			  		  
    $result = mysqli_query($link, $query);
    
    if (!$result) {
        $error = 'S';
        $error_message.= 'Error al actualizar los datos de la unidad: '. mysqli_errno($link) . ' - '. mysqli_error($link) . '<br>';
    }
    
    if (isset($_FILES) && !empty($_FILES)) {
        include 'unidad_upload_file.php';
    }
    
    include 'unidad_save_contact.php';
    
    include 'unidad_save_areas.php';
    
    db_close_conn($link);
    
    $_SESSION['error'] = $error;
    $_SESSION['error_message'] = $error_message;
    
    header('Location: unidad.php');
}

if ('N' == $modificar_formulario) {
	$query = "INSERT INTO unidad (nombre,
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
    				              horario_cierra_mediodia_fin,
	                              institucion_idinstitucion,
                                  usuario_actualizacion,
                                  fecha_actualizacion
    	                         )
			  VALUES ('". $nombre ."',
			  		  '". $direccion_fisica ."',
			  		  '". $telefonos ."',
			  		  '". $atencion_lunes ."',
			  		  '". $atencion_martes ."',
			  		  '". $atencion_miercoles ."',
			  		  '". $atencion_jueves ."',
			  		  '". $atencion_viernes ."',
			  		  '". $atencion_sabado ."',
			  		  '". $atencion_domingo ."',
			  		  '". $horario_lunes_inicio ."',
			  		  '". $horario_lunes_fin ."',
			  		  '". $horario_martes_inicio ."',
			  		  '". $horario_martes_fin ."',
			  		  '". $horario_miercoles_inicio ."',
			  		  '". $horario_miercoles_fin ."',
			  		  '". $horario_jueves_inicio ."',
			  		  '". $horario_jueves_fin ."',
			  		  '". $horario_viernes_inicio ."',
			  		  '". $horario_viernes_fin ."',
			  		  '". $horario_sabado_inicio ."',
			  		  '". $horario_sabado_fin ."',
			  		  '". $horario_domingo_inicio ."',
			  		  '". $horario_domingo_fin ."',
			  		  '". $cierra_mediodia ."',
			  		  '". $horario_cierra_mediodia_inicio ."',
			  		  '". $horario_cierra_mediodia_fin ."',
			  		  '". $id_institucion ."',
                      '". $user ."',
                      NOW()
			  		 )";
	
	$result = mysqli_query($link, $query);
	
	if (!$result) {
	    $error = 'S';
	    $error_message.= 'Error al grabar los datos de la unidad: '. mysqli_errno($link) . ' - '. mysqli_error($link) . '<br>';
	}
	
	$id_unidad = mysqli_insert_id( $link );
	
	if (isset($_FILES) && !empty($_FILES)) {
		include 'unidad_upload_file.php';
	}
	
	include 'unidad_save_contact.php';
	
	include 'unidad_save_areas.php';
	
	db_close_conn($link);
	
	$_SESSION['error'] = $error;
	$_SESSION['error_message'] = $error_message;
	
	header('Location: unidad_listado.php');
}