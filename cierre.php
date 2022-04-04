<?php 

include 'db.php';

$id_periodo = $_REQUEST['id_periodo'];

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
<body style="width: 400px">
<div class="wrapper">
      
      <section class="content" style="height: 450px;">
      
      <div class="row">
      
      	<div class="col-md-12">
      	 <div class="box box-info">
      	 
          	 <div class="box-header with-border">
                 <div class="col-md-12 text-center">
                 <h1 style="font-size: 28px">
            		<b>Está seguro de cerrar éste período?</b>
          		</h1>
          		</div>
                </div>
                <br>
                
      	 <div class="box-body">
      	 	<div class="row">
      	 	
      	 	 <form action="periodo_grabar.php" method="post" autocomplete="off">
      	 	<div class="col-md-8">
      	 	<br>
      	 	
      	 	<h4><b>Seleccione el nuevo período:</b></h4>
      	 	  <div class="row">
               		<div class="col-xs-6">
                <label for="del" style="font-size: 20px;">Periodo del</label>
                  <input type="text" id="del" name="del" class="form-control datepicker" readonly="readonly" required>
                </div>
                <div class="col-xs-6">
                <label for="al" style="font-size: 20px;">Periodo al</label>
                  <input type="text" id="al" name="al" class="form-control datepicker" readonly="readonly" required>
                </div>
                </div>
                
            </div>    
            <br>
            <br>
              
            <div class="col-md-2">
            <label for="ver" style="color: white;">ver</label>
              <input type="submit" id="ver" name="ver" value="Grabar" class="btn btn-lg btn-primary form-control">
              <input type="hidden" id="id_periodo" name="id_periodo" value="<?php echo$id_periodo?>">
              
            </div>
            <div class="col-md-2">
            <div class="btn btn-lg btn-default form-control" id="cerrar">Cancelar</div>
            </div>
               </form>
              </div>
      	 </div>
      	 </div>
      	 </div>
      </div>

</section>

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
<script>
document.getElementById("cerrar").onclick = function() {myFunction()};

function myFunction() {
	parent.location.reload(true);
}

</script>
</body>
</html>