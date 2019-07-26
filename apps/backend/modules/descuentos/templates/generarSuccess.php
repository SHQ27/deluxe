<div id="sf_admin_container" class="descuentoGenerar">

    <h1>Generación de descuentos para Cuponeras</h1>

    <?php if ( !isset($result) ): ?>
    
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	    	
    	<div class="row">
	    	<?php echo $form['prefijo']->renderLabel(); ?>
			<?php echo $form['prefijo']; ?>
		</div>
		
    	<div class="row">
	    	<?php echo $form['separador']->renderLabel(); ?>
			<?php echo $form['separador']; ?>
		</div>
		
		<div class="row">
	    	<?php echo $form['cantidad']->renderLabel(); ?>
			<?php echo $form['cantidad']; ?>
		</div>
		
		<div class="row">	
	    	<?php echo $form['id_tipo_descuento']->renderLabel(); ?>
			<?php echo $form['id_tipo_descuento']; ?>
		</div>
		
		<div class="row">
	    	<?php echo $form['valor']->renderLabel(); ?>
			<?php echo $form['valor']; ?>
		</div>

		<div class="row">
	    	<?php echo $form['vigencia_desde']->renderLabel(); ?>
			<?php echo $form['vigencia_desde']; ?>
		</div>
		
		<div class="row">
	    	<?php echo $form['vigencia_hasta']->renderLabel(); ?>
			<?php echo $form['vigencia_hasta']; ?>
		</div>
		
        <input type="submit" value="Generar" />        
    </form>
    
    <?php else: ?>
    
        <?php if ($result['status']):?>
            <p><strong>Se generaron <?php echo $result['cantidad']; ?> cupones con los siguientes codigos:</strong></p>
            <p class="descuentosGenerados">
                <?php foreach( $result['data'] as $row ): ?>
                <a href="/backend/descuentos/<?php echo $row['idDescuento']; ?>/edit"><?php echo $row['codigo']; ?></a>
                <br>
                <?php endforeach; ?>
            </p>
        <?php else: ?>
            Hubo un error al generar los cupones, por favor intentá nuevamente.
        <?php endif; ?>
        
        <p class="volver"><a href="<?php echo url_for('descuento'); ?>">Volver al listado de descuentos</a></p>
    
    <?php endif; ?>
    
</div>