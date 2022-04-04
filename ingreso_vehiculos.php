<div class="box-header with-border"><br>
              <h1 class="box-title" style=" font-size:34px"><span class="fa fa-truck"></span>&nbsp;Ingreso de Camiones Cisterna</h1>
            </div>
    <div class="box box-success">
            
            <!-- /.box-header -->
            <div class="box-body">
              
              <div style ="float: right">
               <div class="box-footer">
                <a class="btn btn-danger" href="?section=inventario_vehiculos">Regresar</a>
               </div>
             </div>
             <div style="clear: both"></div>
              
              <form role="form" method="post" action="persona_grabar.php" enctype="multipart/form-data" id="form" autocomplete="off">
                
                <!-- text input -->
                <div class="form-group">
                  <label>Zona: </label>
                  <input type="text" class="form-control" placeholder="Zona" name="nombre" value="" required>
                </div>
                <div class="form-group">
                  <label>Placas: </label>
                  <input type="text" class="form-control" placeholder="Placas" name="nombre" value="" required>
                </div>
                <div class="form-group">
                  <label>Capacidad: </label>
                  <input type="text" class="form-control" placeholder="Capacidad Lts" name="nombre" value="" required>
                </div>                
              <div class="form-group">
<label>Especificaciones T&eacute;cnicas</label>
<textarea class="form-control" rows="3" placeholder="Especificaciones Tecnicas ..."></textarea>
</div>
<div class="form-group">
                  <label>Estatus: </label>

<div class="radio">
<label>
<input id="optionsRadios1" name="optionsRadios" value="option1" checked="" type="radio">
Mal estado
</label>
</div>
<div class="radio">
<label>
<input id="optionsRadios2" name="optionsRadios" value="option2" type="radio">
Aceptable
</label>
</div>
<div class="radio">
<label>
<input id="optionsRadios3" name="optionsRadios" value="option3" type="radio">
&Oacute;ptimo
</label>
</div>
            
                  </div>
 <div class="form-group">
                  <label>Chofer Responsable: </label>
                  <select class="form-control">
                  <option value="">Chofer1</option>
                  <option value="">Chofer2</option>
                  <option value="">Chofer3</option>
                  </select>
                </div>

<div class="form-group">
<label>&Uacute;ltima revisi&oacute;n:</label>
<div class="input-group date">
<div class="input-group-addon">
<i class="fa fa-calendar"></i>
</div>
<input id="datepicker" class="form-control pull-right" type="text">
</div>
</div>
              
                <!-- text input -->
               
                
			   <div class="box-footer">
                <button type="submit" class="btn btn-primary">Grabar</button>
                <input type="hidden" value="<?php if(isset($id)){echo $id;}?>" name="id">
              </div>
              
              </form>
            </div>
            <!-- /.box-body -->
          </div>