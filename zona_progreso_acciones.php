<!-- AQUI EMPIEZA EL CICLO -->

<?php while($i < count($num_zona)){

$query = "  SELECT  COUNT(COUNT(*)) AS NATENDIDO 
              FROM  INCIDENTE_ACCION IA, 
                    INCIDENTE IC 
             WHERE  IA.ID_INCIDENTE = IC.ID_INCIDENTE
                    AND IC.FECHAFINALIZACION IS NULL
                    AND IA.REACCION IS NULL
                    AND IA.FINALIZACION IS NULL 
                    AND IC.ZONA = ".$num_zona[$i]."
          GROUP BY  IA.ID_ACCION";
$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$natendido[] = (isset($row['NATENDIDO']) && !empty($row['NATENDIDO'])) ? $row['NATENDIDO'] : 0;

$query = "  SELECT  COUNT(COUNT(*)) AS FINALIZADO 
              FROM  INCIDENTE_ACCION IA, 
                    INCIDENTE IC 
             WHERE  IA.ID_INCIDENTE = IC.ID_INCIDENTE
                    AND IC.FECHAFINALIZACION IS NULL
                    AND IA.REACCION IS NOT NULL
                    AND IA.FINALIZACION IS NOT NULL 
                    AND IC.ZONA = ".$num_zona[$i]."
          GROUP BY  IA.ID_ACCION";
$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$finalizado[] = (isset($row['FINALIZADO']) && !empty($row['FINALIZADO'])) ? $row['FINALIZADO'] : 0;
	 
$query = "  SELECT  COUNT(COUNT(*)) AS PROCESO 
              FROM  INCIDENTE_ACCION IA, 
                    INCIDENTE IC 
             WHERE  IA.ID_INCIDENTE = IC.ID_INCIDENTE
                    AND IC.FECHAFINALIZACION IS NULL
                    AND IA.REACCION IS NULL
                    AND IA.FINALIZACION IS NOT NULL 
                    AND IC.ZONA = 3
          GROUP BY  IA.ID_ACCION";
$stid = oci_parse($conn, $query);
oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$proceso[] = (isset($row['PROCESO']) && !empty($row['PROCESO'])) ? $row['PROCESO'] : 0;

if ($finalizado[$i] + $proceso[$i] + $natendido[$i] > 0){

		if($finalizado[$i] > $proceso[$i] + $natendido[$i]){$color = 'success';}
		elseif($natendido[$i] > $finalizado[$i] + $proceso[$i]){$color = 'danger';}
		else{$color = 'warning';}
		
}else{$color = 'primary';}

?>
        <div class="col-lg-2 col-md-2">
		           <div class="box box-<?php echo $color;?>">
				       <div class="box-body" style="height: 160px">
				           <p class="text-center pull-right" style="font-size:20px">
				                <strong>Zona <?php echo $num_zona[$i];?></strong>
				           </p>
				          <a class="btn btn-default btn-xs" href="zonas_detalle.php?zona=<?php echo $num_zona[$i];?>&detalle=accion&regresar=<?php echo $regresar?>">Detalle</a> 
				       <div id="container_barra_<?php echo $i;?>" style="height: 110px"></div>
				       </div>
				   </div>
<script>
//Create the chart
Highcharts.chart('container_barra_<?php echo $i;?>', {
    chart: {
        type: 'column'
    },
    credits: false,
    backgroundColor: 'transparent',
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        min: 0,
        labels:{
            enabled: false
        },
        gridLineWidth: 0,
        title: {
            text: ''
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true                
            }
        }
    },

    series: [{
        name: 'Acciones',
        data: [{
            name: 'N Ate',
            y: <?php echo $natendido[$i];?>,
            color: '#D2D6DE'
        },{
            name: 'Proce',
            y: <?php echo $proceso[$i];?>,
            color: '#F39C12'
        },{
            name: 'Fin',
            y: <?php echo $finalizado[$i];?>,
            color: '#00A65A'
        }]
    }],
});    
</script>
        </div>
<?php $i++;}?>        
        
<!-- AQUI TERMINA EL CICLO -->        
