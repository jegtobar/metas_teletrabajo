<?php 

include '../auth.php';

if (isset($_REQUEST['fecha_ini'])){
	$ini = $_REQUEST['fecha_ini'];
	$fin = $_REQUEST['fecha_fin'];
	
	$query = "SELECT nombre, 
			         cantidad, 
			         meta,
                     to_char(periodo_del,'DD-MM-YYYY') as ini,
                     to_char(periodo_al,'DD-MM-YYYY') as fin
                FROM mte_metas
               WHERE to_char(periodo_del,'DD-MM-YYYY') = '".$ini."'
                 AND to_char(periodo_al,'DD-MM-YYYY') = '".$fin."'
                 AND codarea = ".$codarea."
               ORDER BY periodo_del DESC";

	$stid = oci_parse($conn, $query);
	oci_execute($stid, OCI_DEFAULT);
	$rowe = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	
} else {
	$rowe="";
}

$i = 0;
$a = 0;
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php
	include 'menu.php';
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Accion
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
        
          <div class="box box-warning">
            <div class="box-header with-border" id="accion">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <div style ="float: right">
               <div class="box-footer">
                <a class="btn btn-danger" href="accion.php">Regresar</a>
               </div>
             </div>
             <div style="clear: both"></div>
              
              <form role="form" method="post" action="accion_grabar.php" enctype="multipart/form-data" id="form" autocomplete="off">
              
                <div class="form-group">
                  <label>Periodo del</label>
                  <input type="text" class="form-control datepicker" placeholder="Nombre de la meta..." name="del" required <?php if(isset($ini)){echo 'value="'.$ini.'"';}?>>
                </div>
                
                <div class="form-group">
                  <label>Periodo al</label>
                  <input type="text" class="form-control datepicker" placeholder="Nombre de la meta..." name="al" required <?php if(isset($ini)){echo 'value="'.$fin.'"';}?>>
                </div>
                
              <div class="box-footer">
                <button type="button" class="btn btn-warning mascara add" id="add" name="add">Agregar</button>
              </div>
                <!-- Tabla -->
             <div class="box-body no-padding">
              <table id="sortable" class="table table-striped">
              <thead>
                <tr>
                  <th class="col-md-4">Nombre</th>
                  <th class="col-md-2">Modalidad</th>
                  <th class="col-md-2">Cantidad</th>
                  <th class="col-md-2">Meta</th>
                  <th class="col-md-2">Eliminar</th>
                </tr>
                </thead>
                <tbody id="body">
                </tbody>
              </table>
            </div>
                
			   <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="prueba" name="prueba" disabled>Grabar</button>
                <?php if (isset($ini)){echo '<input type="hidden" name="update" value="'.$ini.'">';}?>
              </div>
              
              </form>              
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!--/.col (right) -->
      </div>
    </section>
    <!-- /.content -->
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
$("body").on('click','.borrar', function(e){
	      $(this).closest("tr").remove();

});
		
$('#add').on('click', function() {

	$('button[name="prueba"]').removeAttr('disabled');

	 $.ajax
	   ({
	   type: "POST",
	   url: "accion_nuevo.php",
	   cache: false,
	   success: function(html)
	   {
		   $('#sortable tbody').append(html).on('click', '#remove', function () {

				   $(this).closest("tr").remove();

					   
			  });
  
	   } 
	   });

});

</script>

<script>
$(document).ready(function(){

	<?php if (isset($ini)){?>

    $('button[name="prueba"]').removeAttr('disabled');

	var ini = $('input[name="del"]').val();
	var fin = $('input[name="al"]').val();
	$.ajax
	({
		type: "POST",
	    url: "accion_tabla.php",
		data: {'ini':ini,'fin':fin},
		cache: false,
		success: function(html)
		{
		$('tbody[id="body"]').html(html);

		$("body").on('click', '#remove', function () {
		      $(this).closest("tr").remove();

		});
		
		} 
	});

    <?php }?>
	
});

</script>

<script>
//Date picker
$('.datepicker').datepicker({
	format: 'dd-mm-yyyy',
	autoclose: true
});
</script>

<?php 
if(isset($_GET['grabar']))
{
    if ($_GET['grabar'] == 1){
    echo '<script>
    	  alert("Datos grabados exitosamente!")	
    	 </script>';
    }
}
?>
</body>
</html>