<?php 
$js="";
?>
<link rel="stylesheet" href="http://172.23.25.246/arcgis_js_api/library/3.19/3.19/dijit/themes/nihilo/nihilo.css">
    <link rel="stylesheet" href="http://172.23.25.246/arcgis_js_api/library/3.19/3.19/esri/css/esri.css">
    <link rel="stylesheet" href="css/editfeatures.css"/>
    
    <?php 
	if($_REQUEST['js']==""){
		$js = "mapAgua";
	}
	if($_REQUEST['js']=="hidrantes"){
		$js = "mapAgua";
	}
	if($_REQUEST['js']=="pozos"){
		$js = "mapPozos";
	}
	if($_REQUEST['js']=="piscinas"){
		$js = "mapPiscina";
	}
	?>
    <script src="http://172.23.25.246/arcgis_js_api/library/3.19/3.19/init.js"></script>
    <script src="js/<?php echo $js;?>.js"></script>
    
<div class="box-header with-border"><br>
              <h1 class="box-title" style=" font-size:34px"><span class="fa fa-globe"></span>&nbsp;Ubicaciones Fuentes de Agua</h1>
            </div><br>
            <a href="?section=agua&js=hidrantes"><img src="img/hidrante.jpg">Hidrantes</a>&nbsp;&nbsp;&nbsp;
            <a href="?section=agua&js=pozos"><img src="img/pozo.jpg">Pozos</a>&nbsp;&nbsp;&nbsp;
            <a href="?section=agua&js=piscinas"><img src="img/piscina.jpg">Piscinas</a>
<div class="box box-success">
            
            <!-- /.box-header -->
            <div class="box-body">
              
              <div style ="float: right">
               <div class="box-footer">
                <a class="btn btn-success" href="#">Nuevo</a>
               </div>
             </div>
             <div style="clear: both"></div>
             
             <div class="box-body">
             <!--
             <center>
             <img src="img/mapa.jpg">
             </center>
             -->
<div id="cpCenter" data-dojo-type="dijit/layout/ContentPane" data-dojo-props="region:'center'">
        <div id="divMap" style="height:800px"></div>
    </div>  
            </div>             
            </div>
             
            </div>
            <!-- /.box-body -->
          </div>