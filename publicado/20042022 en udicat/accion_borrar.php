<?php

	include '../auth.php';

	$id_meta = $_REQUEST['id_meta'];

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Satisfaccion Cliente Interno</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" />
    <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="vendor/jquery-steps/demo/css/jquery.steps.css">
    <link rel="stylesheet" href="styles/custom_radios.css">
<!-- Parsley Style -->
  <style type="text/css">
  .parsley-required{
  color: red;
  }
  </style>
<!-- End Parsley Style -->
</head>
<body  style="width: 530px; height: 280px">
    
    
<!-- Main Wrapper -->
<div id="wrapper">

    <div class="content animate-panel">
       
        
    </div>
    
<footer class="footer">
</footer>    
    
</div>



<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>
<script src="dist/jquery.fancybox.min.js"></script>
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="vendor/peity/jquery.peity.min.js"></script>

<!-- App scripts -->
<script src="vendor/jquery-steps/lib/modernizr-2.6.2.min.js"></script>
<script src="vendor/jquery-steps/lib/jquery-1.9.1.min.js"></script>
<script src="vendor/jquery-steps/lib/jquery.cookie-1.3.1.js"></script>
<script src="vendor/jquery-steps/build/jquery.steps.js"></script>
<script src="scripts/homer.js"></script>

<script src="vendor/jquery-validate/jquery.validate.js"></script>

<script>
$( document ).ready(function() {
    
    swal({
                title: "Eliminar!",
                text: "Desea eliminar el registro? Se eliminarán también los cumplimientos ingresados!!",
                type: "error",
                showCancelButton: true,
                confirmButtonColor: "#3F5872",
                confirmButtonText: "Ok",
                closeOnConfirm: false,
                closeOnCancel: false 
         },
            function (isConfirm) {
                if (isConfirm) {
                	window.location.href = "borrar.php?id_meta=<?php echo $id_meta?>";
                } else {
                	parent.location.reload(true);
                }
            }
    );

    function borrar()
    {
        console.log('borrado');
        
    }
});
</script>

</body>
</html>



