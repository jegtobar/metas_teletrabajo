<?php 

include '../auth.php';

if ($_REQUEST['id_cumplimiento'] > 0){
    
    $query = "SELECT a.id_meta,
                     a.id_cumplimiento,
                     a.cantidad,
                     b.nombre
                FROM mte_cumplimientos a,
                     mte_metas b
               WHERE a.id_meta = b.id_meta 
                     AND a.id_cumplimiento = ".$_REQUEST['id_cumplimiento'];
    
    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $id_meta = $row['ID_META'];
    $cumplimiento = $row['ID_CUMPLIMIENTO'];
    $cantidad = $row['CANTIDAD'];
    $nombre = $row['NOMBRE'];
    
} else {
    
    $query = "SELECT id_meta,
                     nombre
                FROM mte_metas
               WHERE id_meta = ".$_REQUEST['id_meta'];
    
    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $id_meta = $row['ID_META'];
    $nombre = $row['NOMBRE'];
    
}

?>

<!DOCTYPE html>
<html>
<link rel="shortcut icon" href="img/docs.png">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Metas</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="lib/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="lib/ionicons-2.0.1/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="css/skins/_all-skins.min.css">

<!-- Parsley Style -->
  <style type="text/css">
  .parsley-required{
  color: red;
  }
  </style>

</head>
<body style="width: 750px">
<div class="wrapper">


      <div class="row">
        <div class="col-md-12">
        
          <div class="box" style="margin: 0; top-border: 0px">
          <form role="form" method="post" action="cumplimiento_grabar.php" enctype="multipart/form-data" id="form" autocomplete="off">
           <div class="box-header with-border">
           	<h3>Ingreso de datos</h3>
           </div>

            <div class="box-body">
              
              
                 <div class="box-body">
    
    				<label style="font-size: 20px">Meta</label>
                    <input type="text" class="form-control" readonly value="<?php echo $nombre;?>">
                    
                    
                    <label style="font-size: 20px">Realizado</label>
                    <input type="number" class="form-control" name="cumplimiento" value="<?php if(isset($cumplimiento)){echo $cantidad;}?>" required>
    
                </div>
                  
                            
            </div>
            
            <div class="box-footer text-right">
				<div class="btn btn-default" id="cerrar">Cancelar</div>
                <button type="submit" class="btn btn-primary" id="prueba" name="prueba">Grabar</button>
                <input type="hidden" name="id_meta" value="<?php echo $id_meta?>">
                <?php if(isset($cumplimiento)){?><input type="hidden" name="update" value="<?php echo $cumplimiento?>"><?php }?>
              </div>
			</form>
          </div>
        </div>

      </div>



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
<!-- AdminLTE for demo purposes -->
<script src="js/demo.js"></script>

<script src="js/jquery-ui.js"></script>

<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>

<!-- Script y plugins para validacion -->
<script src="lib/Parsley.js-2.6.2/dist/parsley.min.js"></script>
<script src="lib/Parsley.js-2.6.2/dist/i18n/es.js"></script>

<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">


$(function () {
  $('#form').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
  })
  .on('form:submit', function() {
		})
   // return false; // Don't submit form for this demo
  });
  $('#prueba').on('click', function() {

	  $("#form").submit(function () {

		    var this_master = $(this);

		    this_master.find('input[type="checkbox"]').each( function () {
		        var checkbox_this = $(this);


		        if( checkbox_this.is(":checked") == true ) {
		            checkbox_this.attr('value','1');
		        } else {
		            checkbox_this.prop('checked',true);
		            //DONT' ITS JUST CHECK THE CHECKBOX TO SUBMIT FORM DATA    
		            checkbox_this.attr('value','0');
		        }
		    })
		})
	});

</script>
<!-- Fin Script y plugins para validacion -->

<script>
$('#cerrar').on('click',function(){
    parent.jQuery.fancybox.close();
});
</script>

</body>
</html>