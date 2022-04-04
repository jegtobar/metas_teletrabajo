<?php
		
	session_start();
	header('Content-Type: text/html; charset=utf-8');	
	include('db.php');
	
	$usuario = "RRHH";
	$password = "RRHHADMIN";

    $conn = abrirConexion($usuario,$password);
	
	@$usuario  = isset($_POST['usuario'])  ? $_POST['usuario']  : $_SESSION['usuario'];
	@$password = isset($_POST['password']) ? $_POST['password'] : $_SESSION['password'];

	# redirect to login page if not logged in
	if(!isset($usuario) || !isset($password)) {
		echo "<script language=\"javascript\">window.location=\"index.php\"</script>";
		exit();
	}// /if !isset($username) || !isset($password)

	$_SESSION['usuario']  = $usuario;
	$_SESSION['password'] = $password;

	$query = "select e.usuario,
					 e.pass,
					 e.idemp,
					 e.nit,
					 e.nombre,
					 e.apellido,
					 e.codarea,
                     (select descripcion from rh_areas where codarea = e.codarea) as seccion,
					 e.ruta_sap,
					 e.emailmuni
				from RH_EMPLEADOS e
			   where upper(rtrim(e.usuario)) = '". strtoupper(trim($usuario,'UTF-8')) ."' 
				 and rtrim(desencriptar(e.pass)) = '". trim($password) ."' and e.status = 'A'"; 
	
	$idConsulta = oci_parse($conn, $query);
	oci_execute($idConsulta, OCI_DEFAULT);	
	
	if(!$idConsulta) {
		echo('Ha Ocurrido un Error mientras se verificaban sus datos '.
			 'Por favor Notifiquenos .\\n Si este error Persiste, Gracias');
	}else{
	   $row = oci_fetch_array($idConsulta);
	   
	   $_SESSION['nombreusuario'] = $row['NOMBRE']." ".$row['APELLIDO'];
	   $nombreusuario = $_SESSION['nombreusuario'];
        $_SESSION['area']  = $row['SECCION'];
		
	   $usuario = strtoupper(trim($usuario,'UTF-8'));
	   if (16 == $row['CODAREA'] || 29 == $row['CODAREA'] || 36 == $row['CODAREA'] || 39 == $row['CODAREA'] || 40 == $row['CODAREA'] || 41 == $row['CODAREA'] || 42 == $row['CODAREA'] || 43 == $row['CODAREA']) {
	       $_SESSION['codarea'] = 16;
	       $codarea = $_SESSION['codarea'];
	   } else {
	       $_SESSION['codarea'] = $row['CODAREA'];
	       $codarea = $_SESSION['codarea'];
	   }
	   
	    $_SESSION['idemp'] = $row['IDEMP'];
	   $idemp = $_SESSION['idemp'];
	   
	   $_SESSION['nit'] = $row['NIT'];
	   $nit = $_SESSION['nit'];
	   
   	   $_SESSION['ruta_sap'] = $row['RUTA_SAP'];
	   $ruta_sap = $_SESSION['ruta_sap'];
	   
       $_SESSION['email'] = $row['EMAILMUNI'];
	   $email = $_SESSION['email'];	   
	   	   
	}// /if !$idConsulta
	
	if (oci_num_rows($idConsulta) == 0) {
		unset($_SESSION['usuario']);
		unset($_SESSION['password']);		 
		unset($_SESSION['nombreusuario']);
		unset($_SESSION['codarea']);
		unset($_SESSION['idemp']);
		unset($_SESSION['nit']);
		unset($_SESSION['email']);		

		$_SESSION = array();
		session_destroy();

		echo "<form name=\"mensajeform\" method=\"post\" action=\"index.php\">
				<input type=\"hidden\" name=\"mensaje\" value=\"Usuario o contrase&ntilde;a incorrectos\" />
			  </form>
			  
			  <script type=\"text/javascript\">
				document.mensajeform.submit();
			  </script>";

		exit();
	}// /if oci_num_rows($idConsulta) == 0