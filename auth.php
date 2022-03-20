<?php
    session_start();
	//bloqueado en servidor 172.23.25.31 en los demas hay que habilitarlo
	/*ini_set("session.cookie_lifetime",8*60*60);
    ini_set("session.gc_maxlifetime",8*60*60);*/
    $_SESSION['matenimiento'] = false;
    
    if ($_SESSION['matenimiento']) {
        header('location: ingreso.php');
        exit();
    }

    /* DB CONNECTION */
    $host     = '127.0.0.1';
	$db_user  = 'root';
	//$db_pass  = 'area51';
	$db_pass  = 'udiwf'; //172.23.25.31
	$database = 'udi';
	
	$link = mysqli_connect( $host, $db_user, $db_pass, $database ) or die( 'Error connecting to MySQL server (' . mysqli_connect_errno() .') '. mysqli_connect_error() );
	mysqli_set_charset($link, 'utf8');

    $key = 'app_S0l1c1tudes.15';
    /* /DB CONNECTION */
    
	$user = (isset($_POST['user']) && !empty($_POST['user'])) ? strtolower(trim($_POST['user'])) : strtolower($_SESSION['user']);
	$pass = (isset($_POST['pass']) && !empty($_POST['pass'])) ? $_POST['pass']                   : $_SESSION['pass'];
	
	/*Daniel A. Melchor 12/06/2020
	  al cargar documentos pdf despues de las 18:00 horas mostraba la fecha del siguiente dia
	  para evitar esto se agrega linea de zona horaria date_default_timezone_set('America/Guatemala');
	*/
	date_default_timezone_set('America/Guatemala');
	
	if(!isset($user) || !isset($pass)) {
	    header('location: ingreso.php');
	    exit();
	}// /if !isset($username) || !isset($password)

	$_SESSION['user'] = trim($user);
	$_SESSION['pass'] = $pass;

	$query = "SELECT u.usuario,
					 u.password,
					 u.nombre,
					 u.activo,
					 u.cod_dependencia,
					 u.nivel,
					 d.descripcion AS nom_dependencia,
	                 u.laip_revisor,
	                 u.laip_editor
				FROM udi_usuarios u,
					 udi_dependencias d
			   WHERE LOWER(RTRIM(u.usuario)) = '". mysqli_real_escape_string($link, trim($user)) ."'
				 AND u.password              = MD5('". mysqli_real_escape_string($link, $pass) ."')
				 AND u.cod_dependencia       = d.cod_dependencia";

	$result = mysqli_query($link, $query);

	if(!$result) {
		echo('Ha Ocurrido un Error mientras se verificaban sus datos '.
			 'Por favor Notifiquenos .\\n Si este error Persiste, Gracias');
	}else{
	   $row = mysqli_fetch_array($result);

	   $_SESSION['nombre_usuario'] = $row['nombre'];
	   $nombre_user = $_SESSION['nombre_usuario'];

	   $_SESSION['usuario_activo'] = $row['activo'];
	   $activo = $_SESSION['usuario_activo'];

	   $_SESSION['iddependencia'] = $row['cod_dependencia'];
	   $id_dependencia = $_SESSION['iddependencia'];
	   
	   $_SESSION['niv'] = $row['nivel'];
	   $nivel = $_SESSION['niv'];
	   
	   $_SESSION['nomdependencia'] = $row['nom_dependencia'];
	   $nom_dependencia = $_SESSION['nomdependencia'];
	   
	   $_SESSION['laip_editor'] = $row['laip_editor'];
	   $laip_editor = $_SESSION['laip_editor'];
	   
	   $_SESSION['laip_revisor'] = $row['laip_revisor'];
	   $laip_revisor = $_SESSION['laip_revisor'];
	   
	}// /if(!$result)

	if (mysqli_num_rows($result) == 0 || 'X' == $activo) {
		unset($_SESSION['user']);
		unset($_SESSION['pass']);
		unset($_SESSION['nombre_usuario']);
		unset($_SESSION['usuario_activo']);
		unset($_SESSION['iddependencia']);
		unset($_SESSION['niv']);
		unset($_SESSION['nomdependencia']);
		unset($_SESSION['laip_editor']);
		unset($_SESSION['laip_revisor']);

		$_SESSION['error_login'] = 'Usuario o contraseña incorrectos.';
		header('location: ingreso.php');
		exit();

		
	}// /if oci_num_rows($idConsulta) == 0
	
	if ('N' == $activo) {

		unset($_SESSION['user']);
		unset($_SESSION['pass']);
		unset($_SESSION['nombre_usuario']);
		unset($_SESSION['usuario_activo']);
		unset($_SESSION['iddependencia']);
		unset($_SESSION['iddependencia']);
		unset($_SESSION['niv']);
		unset($_SESSION['nomdependencia']);
		unset($_SESSION['laip_editor']);
		unset($_SESSION['laip_revisor']);

		$_SESSION['error_login'] = 'Usuario inactivo. Favor comuniquese con el administrador.';
		header('location: ingreso.php');
		exit();
		
	}// /if oci_num_rows($idConsulta) == 0
?>	