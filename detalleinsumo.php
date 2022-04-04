<div class="box-header with-border"><br>
              <h1 class="box-title" style=" font-size:34px"><span class="fa fa-truck"></span>&nbsp;Ubicaci&oacute;n de Insumos</h1>
            </div>
    <div class="box box-success">
            
            <!-- /.box-header -->
            <div class="box-body">
              
              <div style ="float: right">
               <div class="box-footer">
                <a class="btn btn-danger" href="?section=insumos">Regresar</a>
               </div>
             </div>
             <div style="clear: both"></div>
              
              <form role="form" method="post" action="persona_grabar.php" enctype="multipart/form-data" id="form" autocomplete="off">
                
                <!-- text input -->
                <div class="form-group">
                  <label>Bodega: </label>
                  <input type="text" class="form-control" placeholder="Bodega" name="nombre" value="" required>
                </div>
                <div class="form-group">
                  <label>Responsable: </label>
                  <input type="text" class="form-control" placeholder="Responsable" name="nombre" value="" required>
                </div>
                <div class="form-group">
                  <label>Celular del Responsable: </label>
                  <input type="text" class="form-control" placeholder="Celular del Responsable" name="nombre" value="" required>
                </div>
                <div class="form-group">
                  <label>Correo electr&oacute;nico del Responsable: </label>
                  <input type="text" class="form-control" placeholder="Correo del responsable" name="nombre" value="" required>
                </div>
                <div class="form-group">
                  <label>Cantidad: </label>
                  <input type="text" class="form-control" placeholder="Cantidad" name="nombre" value="" required>
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