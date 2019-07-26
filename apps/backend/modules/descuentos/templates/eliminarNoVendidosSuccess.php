<div id="sf_admin_container" class="descuentoEliminarNoVendidos">

    <h1>Eliminación de cupones no vendidos</h1>

    <?php if ( !isset($result) ): ?>
    
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	    	
    	<div class="row">
	    	<?php echo $form['codigos']->renderLabel(); ?>
			<?php echo $form['codigos']; ?>
		</div>
		
        <input type="submit" value="Eliminar" />        
    </form>
    
    <?php else: ?>
    
        <?php if ($result['status']):?>
            <p><strong>Se eliminaron <?php echo $result['cantidad']; ?> cupones.</strong></p>
        <?php else: ?>
            <p><?php echo $result['message']?></p>
                    
            <?php if ( isset($result['descuentosError']) ):?>
            <p>Los siguientes códigos de descuento estan asignados a un pedido:</p>
            <ul>
            <?php foreach( $result['descuentosError'] as $descuento ):?>    
                <li><a href="/backend/descuentos/<?php echo $descuento->getIdDescuento(); ?>/edit"><?php echo $descuento->getCodigo(); ?></a></li>
            <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            
        <?php endif; ?>
        
        <p class="volver"><a href="<?php echo url_for('descuento'); ?>">Volver al listado de descuentos</a></p>
    
    <?php endif; ?>
    
</div>