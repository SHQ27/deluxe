<?php $descripciones = array(
    'running' => 'Instancias ejecutandose',
    'terminated' => 'Instancias eliminadas (desapareceran en minutos)',
    'shutting-down' => 'Instancias que se estan apagando',
); ?>
<div id="sf_admin_container">
    <h1>Instancias de Amazon</h1>
    
    <?php if ($mensaje): ?>
    <ul class="<?php if ($status): ?>notice<?php else: ?>error_list<?php endif; ?>">
    	<li><?php echo $mensaje ?></li>
    </ul>
    <?php endif; ?>
    
    <h2>Información</h2>
    <?php if ( ($estados['running']) != $desiredCapacity): ?>
    <p class="infoAmazon">
	    Amazon tarda unos minutos en apagar o levantar las instancias y en mostrar reflejado el cambio.
	    <br/>
	    Sea paciente, puede chequear si el estado se actualizó haciendo <a href="/backend/aws">click aqui</a>
	   </p>
    <?php endif; ?>
    <dl>
    <?php foreach($estados as $tipo => $cantidad): ?>
    <?php if (isset($descripciones[$tipo])): ?>    	
    	<dt><?php echo $descripciones[$tipo] ?>:</dt>
    	<dd><?php echo $cantidad ?></dd>
    <?php endif; ?>
    <?php endforeach; ?>    
    	<dt>Instancias deseadas:</dt>
    	<dd><?php echo $desiredCapacity ?></dd>
    	<dt>AMI:</dt>
    	<dd><?php echo $ami->name ?></dd>
    </dl>
    
	<h2>Estadisticas</h2>
	
	<script>
	var instancesChartsData = <?php echo html_entity_decode($instancesChartsData); ?>;
	var dbChartData = <?php echo html_entity_decode($dbChartData); ?>;
	</script>
	<div id="instances_div"></div>
	<div id="db_div"></div>

	<h2>Modicar cantidad instancias</h2>
    <form method="post">
    	<p>
        	<label>Instancias</label>
        	<select name="instancias">
        	<?php for ($i = 1; $i <= $max; $i++): ?>
        		<option<?php if ($desiredCapacity == $i): ?> selected="selected"<?php endif; ?>><?php echo $i ?></option>
        	<?php endfor; ?>
        	</select>      
        	instancia(s).   	
        </p>
        <p>
    		<input type="submit" value="Modificar cantidad de instancias" />
    	</p>
    </form>
</div>