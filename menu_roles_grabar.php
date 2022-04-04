<?php

include 'auth.php';

echo "<pre>";
print_r($_POST);
echo "</pre>";

if (isset($_POST['id']) && !empty($_POST['id'])){

    $rol = $_POST['id_rol'];
    $opcion = $_POST['opcion'];
    
        $query = "DELETE FROM MENUROL
	      		   WHERE ID_ROL = ".$rol;
        
        $stid = oci_parse($conn, $query);
        $mensaje = oci_execute($stid, OCI_DEFAULT);
    
    foreach ($opcion as $menurol){
        $query = "INSERT INTO MENUROL (ID_MENU, 
                                       ID_ROL)
		                       VALUES (".$menurol.",
		           		               ".$rol.")";

        $stid = oci_parse($conn, $query);
        $mensaje = oci_execute($stid, OCI_DEFAULT);
    }


    if($mensaje){

        oci_commit($conn);
        header('Location: menu_roles.php?grabar=1');

    } else {

        echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
        die();
    }



}else{

    $opcion = $_POST['opcion'];;
    $rol = $_POST['id_rol'];

    foreach ($opcion as $menurol)
    {
            $query = "INSERT INTO MENUROL (ID_MENU,
                                           ID_ROL)
		                           VALUES (".$menurol.",
		           		                   ".$rol.")";
        echo $query."<br><br>";
    
        $stid = oci_parse($conn, $query);
    
        $mensaje = oci_execute($stid, OCI_DEFAULT);
    }

    if($mensaje){

        oci_commit($conn);

        header('Location: menu_roles.php?grabar=1');
    } else {
        echo "ERROR AL GRABAR DATOS, POR FAVOR INTENTELO DE NUEVO O PONGASE EN CONTACTO CON EL ADMINISTRADOR";
    }
}
?>

