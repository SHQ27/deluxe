<?php $producto = $form->getObject(); ?>
<?php $productoCampanas = productoCampanaTable::getInstance()->listByIdProducto( $producto->getIdProducto() ) ?>


<table>
	<table cellpadding="0" cellspacing="5">
		<tr>
			<th>Campana</th>
			<th>Estado</th>
			<th>Acción</th>
		</tr>
		<?php if ( count($productoCampanas) ): ?>
    		<?php foreach ( $productoCampanas as $productoCampana ): ?>
    		<?php $campana = $productoCampana->getCampana(); ?>
    		<tr>
    			<td><?php echo $campana->getDenominacion() ?></td>
    			<td class="center">
    				<?php if ( $campana->getActivo() ): ?>
    				<img src="/backend/sfDoctrinePlugin/images/tick.png" title="Checked" alt="Checked">
    				<?php endif; ?>				
    			</td>
    			<td><a href="/backend/campanas/<?php echo $campana->getIdCampana() ?>/edit">Editar</a></td>
    		</tr>
    		<?php endforeach; ?>
    		<?php else: ?>
	        <tr>
	            <td colspan="3">El producto no esta asignado a campañas.</tr>
	        </tr>
            <?php endif; ?>
</table>