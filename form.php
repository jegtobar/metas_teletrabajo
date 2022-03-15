<?php 

include '../auth.php';

$query ="SELECT codarea,descripcion
FROM RH_AREAS
WHERE CODAREA IN(SELECT CODAREA FROM RH_EMPLEADOS WHERE DEPENDE='".$nit."')";
$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$data=[];
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
  $arreglo=[];
  $arreglo['codarea'] = $row['CODAREA'];
  $arreglo['descripcion'] = $row['DESCRIPCION'];
  $data[]=$arreglo;
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
<body style="width: 850px">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-12">
        <div class="box" style="margin: 0; top-border: 0px">
        <form role="form" method="post" action="accion_grabar.php" enctype="multipart/form-data" id="form" autocomplete="off">
          <div class="box-header with-border">
          <h3>Nueva Meta</h3>
          </div>

          <div class="box-body">
              <label style="font-size: 20px">Nombre</label>
              <input type="text" class="form-control" placeholder="Nombre de la meta..." name="nombre" value="<?php if (isset($id_meta)){echo $nombre;}?>" required>
              <br>
              <label style="font-size: 20px">Modalidad</label>
              <select class="form-control" name="tipo" required>
                <option disabled selected="selected" value="N">Seleccione uno...</option>
                <option value="P" <?php if(isset($id_meta)){if($tipo == 'P'){echo 'selected="selected"';}}?>>Presencial</option>
                <option value="T" <?php if(isset($id_meta)){if($tipo == 'T'){echo 'selected="selected"';}}?>>Teletrabajo</option>
                <option value="M" <?php if(isset($id_meta)){if($tipo == 'M'){echo 'selected="selected"';}}?>>Mixto</option>
              </select>
              <br>
              <label style="font-size: 20px">Tipo</label>
              <select class="form-control" name="modalidad" required>
                <option disabled selected="selected" value="N">Seleccione uno...</option>
                <option value="R" <?php if(isset($id_meta)){if($tipo == 'R'){echo 'selected="selected"';}}?>>Regular</option>
                <option value="T" <?php if(isset($id_meta)){if($tipo == 'T'){echo 'selected="selected"';}}?>>Temporal</option>
                <option value="A" <?php if(isset($id_meta)){if($tipo == 'A'){echo 'selected="selected"';}}?>>Adicional</option>
              </select>
              <br>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <label for="poa" style="font-size: 20px">POA</label>
                    <input type="checkbox" value="1" name="poa" id="poa" aria-label="poa" >
                  </div>
                </div>
              </div>
              <br>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <label for="activa" style="font-size: 20px">Activa</label>
                    <input type="checkbox" value="1" name="activa" id="activa" aria-label="activa" >
                  </div>
                </div>
              </div>
              <br>
              <button type="button" class="btn btn-primary" id="agregar">Agregar Tarea</button>
              <br>
              <br>
              <div class="row">
                <div class="col-md-6" id="listaSecciones">
                  <select class="form-control" name="seccion[]">
                    <option disabled selected="selected" value="N">Seleccione una sección...</option>
                    <?php foreach($data as $value){ ?>
                    <option value="<?php echo $value['codarea']; ?>"><?php echo $value['descripcion']; ?></option> 
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-6" id="listaMetas">
                  <label for="meta" style="font-size: 20px">Meta: </label>
                  <input type="number" name="meta[]" id="meta" placeholder="meta">
                </div>
              </div>
              
          </div>
          <br>
          <div class="box-footer text-right">
            <div class="btn btn-default" id="cerrar">Cancelar</div>
              <button type="submit" class="btn btn-primary" id="prueba" name="prueba">Grabar</button>
              <input type="hidden" name="cantidad" value="0">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

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
<script>
  $('#agregar').on('click',function(){
    let select = '<select class="form-control" name="seccion[]">' +
       '<option disabled selected="selected" value="N">Seleccione una sección...</option>' +
       <?php 
          foreach($data as $value){
            echo "'".'<option value="'.$value['codarea'].'">."' . $value['descripcion']. '</option>'."'";
          }
       ?>
    + '</select>'
        
    let meta = '<br><label for="meta" style="font-size: 20px">Meta:&nbsp; </label>' +
    '<input type="number" name="meta[]" id="meta" placeholder="meta">'

    $('#listaSecciones').append(select);
    $('#listaMetas').append(meta);     
    
  });
</script>
</html>