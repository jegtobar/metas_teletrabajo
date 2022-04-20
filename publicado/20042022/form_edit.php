<?php 

include '../auth.php';

if (isset($_REQUEST['id_meta'])){
    
    $pendienteAsignar = 0;
    $query = "SELECT id_meta,
                     nombre,
                     tipo,
                     modalidad,
                     cantidad,
                     meta,
                     poa,
                     activa
                FROM mte_metas
               WHERE id_meta = ".$_REQUEST['id_meta'];
        
        $stid = oci_parse($conn, $query);
        oci_execute($stid, OCI_DEFAULT);
        
        $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        $id_meta = $row['ID_META'];
        $nombre = $row['NOMBRE'];
        $tipo = $row['TIPO'];
        $cantidad = $row['CANTIDAD'];
        $meta = $row['META'];
        $modalidad = $row['MODALIDAD'];
        $poa = $row['POA'];
        $activa = $row['ACTIVA'];
    $query = "SELECT b.ID_META_DETALLE,
                     a.DESCRIPCION,
                     b.META
              FROM MTE_METAS_DETALLE b
              INNER JOIN rh_areas a on a.CODAREA = b.CODAREA
              WHERE ID_META =".$id_meta;
    $stid = oci_parse($conn, $query);
    oci_execute($stid, OCI_DEFAULT);
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
      $id_detalle[] = $row['ID_META_DETALLE'];
      $dependencia[] = $row['DESCRIPCION'];
      $detalle_meta[] = $row['META'];
    }
    $grabo = '';
    if (isset($detalle_meta)){
      $metaT = 0;
    foreach ($detalle_meta as $item) {
        $metaT = $metaT + $item;
        $pendienteAsignar=$metaT;
    }
    
    // if($metaT >= $meta ){
    //   $grabo = 'M';
    // }
    
    }
    // $pendiente = $meta - $pendienteAsignar;
      

      $inDetalle = 'S';
      /*areas */
      $query = "SELECT CODAREA FROM RH_EMPLEADOS WHERE NIT='".$nit."'";
      $stid = oci_parse($conn, $query);
      oci_execute($stid, OCI_DEFAULT);
      $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
      $codareaUsuario = $row['CODAREA'];

      $query ="SELECT descripcion,
                      codarea
                      from rh_areas
                      start with codarea = ".$codareaUsuario."
                      connect by depende = prior codarea";
            $stid = oci_parse($conn, $query);
      oci_execute($stid, OCI_DEFAULT);
      $data=[];
      while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $arreglo=[];
        $arreglo['codarea'] = $row['CODAREA'];
        $arreglo['descripcion'] = $row['DESCRIPCION'];
        $data[]=$arreglo;
        }
      if (empty($data)){
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
      }
      
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
<body style="width: 750px" onload="setearMeta(this.form)">
<div class="wrapper">


      <div class="row">
        <div class="col-md-12">
        
          <div class="box" style="margin: 0; top-border: 0px">
          <form role="form" method="post" action="actualizar_tarea.php" enctype="multipart/form-data" id="form" autocomplete="off">
           <div class="box-header with-border">
           	<h3>Editar información</h3>
           </div>

            <div class="box-body">
              
             <div class="box-body">
             <label style="font-size: 18px">Id</label>
            <input type="text" class="form-control"  name="idMeta" value="<?php if (isset($id_meta)){echo $id_meta;}?>" disabled>
            <br>
            <label style="font-size: 18px">Nombre</label>
            <input type="text" class="form-control" placeholder="Nombre de la meta..." name="nombre" value="<?php if (isset($id_meta)){echo $nombre;}?>">
            <br>
            <label style="font-size: 18px">Modalidad</label>
            <select class="form-control" name="tipo" required>
              <option disabled selected="selected" value="N">Seleccione uno...</option>
              <option value="P" <?php if(isset($id_meta)){if($tipo == 'P'){echo 'selected="selected"';}}?>>Presencial</option>
              <option value="T" <?php if(isset($id_meta)){if($tipo == 'T'){echo 'selected="selected"';}}?>>Teletrabajo</option>
              <option value="M" <?php if(isset($id_meta)){if($tipo == 'M'){echo 'selected="selected"';}}?>>Mixto</option>
            </select>
            <br>
            <label style="font-size: 18px">Tipo</label>
            <select class="form-control" name="modalidad" required>
              <option disabled selected="selected" value="N">Seleccione uno...</option>
              <option value="R" <?php if(isset($id_meta)){if($modalidad == 'R'){echo 'selected="selected"';}}?>>Regular</option>
              <option value="T" <?php if(isset($id_meta)){if($modalidad == 'T'){echo 'selected="selected"';}}?>>Temporal</option>
              <option value="A" <?php if(isset($id_meta)){if($modalidad == 'A'){echo 'selected="selected"';}}?>>Adicional</option>
            </select>
            <br>
            <!-- <div class="input-group mb-3">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <label for="mte_meta" style="font-size: 18px">Meta</label>
                  <input type="text" class="text" value="<?php if (isset($id_meta)){echo $meta;}?>" id="mte_meta" name="mte_meta">
                </div>
              </div>
            </div> -->

             <div class="input-group mb-3">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <label for="mte_meta" style="font-size: 18px">Meta actual</label>
                  <input type="text" id="asignacion" class="asignacion" value="" id="asignacion" name="asignacion" disabled>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <label for="poa" style="font-size: 18px">POA</label>
                  <input type="checkbox" name="poa" <?php if(isset($id_meta)){if($poa == '1'){echo 'checked';}}?> aria-label="poa" value="1">
                </div>
              </div>
            </div>
            <br>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <label for="activa" style="font-size: 18px">Activa</label>
                  <input type="checkbox" name="estatus" id="estatus" aria-label="estatus" <?php if(isset($id_meta)){if($activa == '1'){echo 'checked value="1"';}}?> value="1" >
                  <br>
                  <label for="justificacion" id="labelJustificacion" style="font-size: 18px">Justificación:</label>
                  <br>
                  <textarea name="justificacion" id="justificacion" cols="40" rows="3"></textarea>
                </div>
              </div>
            </div>
            <br>
            <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sección</th>
                  <th>Meta</th>
                  <th style="width: 10%">Eliminar</th>
                  
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($id_detalle)){
                $i=0; while ($i < count($id_detalle)){
                  echo'
                    <tr>
                    <td>'.$dependencia[$i].'</td>
                    <td><input type="text" onkeyup="setearMeta(this.form)" class="textMeta" value="'.$detalle_meta[$i].'" id="detalleMetaEdit" name="detalleMetaEdit[]" ></td>
                    <td><a class="fancy btn btn-danger" href="accion_borrar_detalle.php?id_meta='.$id_detalle[$i].'"><i class="fa fa-trash-o"></i></a></td>';
                  echo' 
                    </tr>';
                      $i++;}
                }
                ?>
                    </tbody>
              </table>
              <br>
              <!-- En caso de no existir detalle de la meta se mostrará la siguiente tabla -->
              <button type="button" class="btn btn-primary" id="agregar">Agregar Tarea</button>
              <table id="tablaDetalle" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sección</th>
                    <th>Meta</th>
                  </tr>
                  </thead>
                  <tbody id="listaSecciones">
                    <tr>
                      <td >
                        <select class="form-control" name="seccionDetalleNew[]">
                          <option disabled selected="selected" value="N">Seleccione una sección...</option>
                          <?php foreach($data as $value){ ?>
                          <option value="<?php echo $value['codarea']?>"><?php echo $value['descripcion']?></option> 
                          <?php } ?>
                        </select>
                      </td>
                      <td>
                        <input type="number" class="Can_Produc" name="detalleMetaEditNew[]" id="detalleMetaEditNew" placeholder="meta">
                      </td>
                    </tr>
                  </tbody>
                </table>

            </div>         
          </div>
            
            <div class="box-footer text-right">
				      <div class="btn btn-default" id="cerrar">Cancelar</div>
                <input type="hidden" name="cantidad" value="0">
                <input type="hidden" name="metaId" value="<?php echo $id_meta;?>">
                <?php 
                if(!empty($id_detalle)){
                  foreach ($id_detalle as $item) {
                    echo'<input type="hidden" name="metaIdDetalle[]" value="'.$item.'">';
                  }
                }
                ?>
                <button type="submit" class="btn btn-primary" id="guardarMeta" name="guardarMeta">Grabar</button>

                
                
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
<script>
  $("#justificacion").hide();
  $("#labelJustificacion").hide();
    $('#estatus').on('change',function(){
      if (this.checked) {
      $("#justificacion").hide();
      $("#labelJustificacion").hide();
      } else {
      $("#justificacion").show();
      $("#labelJustificacion").show();
      }  
    })
</script>
<?php if (isset($inDetalle)){?>
<script>

$('#agregar').on('click',function(){
    let select = '<tr><td><select class="form-control" name="seccionDetalleNew[]">' +
       '<option disabled selected="selected" value="N">Seleccione una sección...</option>' +
       <?php 
          foreach($data as $value){
            echo "'".'<option value="'.$value['codarea'].'">' . $value['descripcion']. '</option>'."'".'+'; 
          }
       ?>
    + '</select></td>'+'<td><input type="number" class="Can_Produc" name="detalleMetaEditNew[]" onchange="setearMeta(this.form)" id="detalleMetaEditNew" placeholder="meta"></td></tr>'

    // let remover = '<br><button type="button" class="btn btn-danger" id="remover">Remover</button>'
    
    $('#listaSecciones').append(select);
    $('.Can_Produc').keyup(function () {
        const valueActual = document.getElementById('asignacion').value
        var valor = parseInt(valor_inicial);
        var valor_sumar = 0;
        $('.Can_Produc').each(function () {
          
            valor_sumar += parseInt($(this).val());
          
        });
        $('#asignacion').val(valor + valor_sumar);
        const value = document.getElementById('asignacion').value      
    });

    $('.detalleMetaEdit').keyup(function(){
      var total=0;
      for(var x=0;x<f.length;x++){//recorremos los campos dentro del form
          if(f[x].name.indexOf('detalleMetaEdit')!=-1){//si el nombre campo contiene la palabra 'aporte'
              total+=Number(f[x].value);//sumamos, convirtiendo el contenido del campo a número
          }
      }
      document.getElementById('asignacion').value=total;//al final colocamos la suma en algún input
    })
     
    
  });
</script>
<?php }?>

<!-- <?php if ($grabo == 'M'){?>
<script>
$("#agregar").hide();
$("#tablaDetalle").hide();
</script>
<?php }?> -->

<script>
 
 function setearMeta(f){
    var total=0;
    for(var x=0;x<f.length;x++){//recorremos los campos dentro del form
        if(f[x].name.indexOf('detalleMetaEdit')!=-1){//si el nombre campo contiene la palabra 'aporte'
            total+=Number(f[x].value);//sumamos, convirtiendo el contenido del campo a número
        }
    }
    document.getElementById('asignacion').value=total;//al final colocamos la suma en algún input
 }

    $('.Can_Produc').keyup(function () {
        const valueActual = document.getElementById('asignacion').value
        var valor = parseInt(valueActual);
        var valor_sumar = 0;
        $('.Can_Produc').each(function () {
            valor_sumar += parseInt($(this).val());
        });
        $('#asignacion').val(valor + valor_sumar);
        const value = document.getElementById('asignacion').value
      
    });


</script>

</html>