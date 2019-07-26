<div id="sf_admin_container" class="ordenCompra">
    
    <h1>Ordenes de compra</h1>
    	
    <?php $error = sfContext::getInstance()->getUser()->getFlash('ordenesDeCompra_error'); ?>
    <?php if ($error): ?>
    <ul class="error_list">
    	<li><?php echo $error ?></li>
    </ul>
    <?php endif; ?>
	
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>

    	<div class="row">
	    	<?php echo $form['id_eshop']->renderLabel(); ?>
			<?php echo $form['id_eshop']; ?>
		</div>    	
    	
    	<div class="row">
	    	<?php echo $form['periodo']->renderLabel(); ?>
			<?php echo $form['periodo']; ?>
		</div>
		
		<div class="row deluxeRow">	
	    	<?php echo $form['stock_campana']->renderLabel(); ?>
			<?php echo $form['stock_campana']; ?>
		</div>
		
		<div class="row deluxeRow">
	    	<?php echo $form['marca']->renderLabel(); ?>
			<?php echo $form['marca']; ?>
		</div>
		
		<div class="row">
	    	<?php echo $form['origen_stock']->renderLabel(); ?>
			<?php echo $form['origen_stock']; ?>
		</div>

        <div class="row">
            <?php echo $form['mostrar_pedidos']->renderLabel(); ?>
            <?php echo $form['mostrar_pedidos']; ?>
        </div>
		
        <input name="<?php echo $form['action']->renderName(); ?>" type="submit" value="Ver Online" />
        &nbsp;
        <input name="<?php echo $form['action']->renderName(); ?>" type="submit" value="Descargar" />        
    </form>
    
    <?php if ( isset($data) ): ?>
    <ul>
    	<?php foreach ($data as $row): ?>
    	<li>
    		<h2>
	    		<?php if ( isset( $row['marca'] ) ):?>
	    		<?php echo $row['marca']->getNombre(); ?>
	    		<?php else: ?>
	    		<?php echo $row['campana']->getDenominacion(); ?>
	    		<?php endif; ?>
    		</h2>
    		<table>
    			<thead>
    				<tr>
    					<th>Imagen</th>
	    				<th>Cant.</th>
	    				<th>Outlet</th>
	    				<th>Producto</th>
	    				<th>Cod prod</th>
	    				<th>Color</th>
	    				<th>Talle</th>
	    				<th>Costo</th>
	    				<th>Costo (Sin IVA)</th>
	    				<th>Total</th>
	    				<th>Total (Sin IVA)</th>
                        <?php if ( $mostrarPedidos ):?>
                        <th>Pedidos Relacionados</th>
                        <?php endif; ?>
    				</tr>
    			</thead>
    			<tbody>
    				<?php $total = 0; ?>
    				<?php $totalSinIva = 0; ?>
    				<?php $cantidad = 0; ?>
    				<?php $devoluciones = 0; ?>
    				<?php foreach ( $row['productos'] as $producto ): ?>
    				<tr>
    					<?php $cantidad += $producto['cantidad']; ?>
    					<?php $devoluciones += $producto['cantidadOutlet']; ?>
    					<?php $total += $producto['subtotal']; ?>
    					<?php $totalSinIva += $producto['subtotalSinIva']; ?>
    					
    					<td>
							<a class="enlargeImage" href="<?php echo $producto['img_grande']; ?>"/>
								<img src="<?php echo $producto['img']; ?>"/>
							</a>
    					</td>
    					<td><?php echo $producto['cantidad']; ?></td>
    					<td><?php echo $producto['cantidadOutlet']; ?></td>
    					<td><?php echo $producto['nombre']; ?></td>
    					<td><?php echo $producto['codigo']; ?></td>
    					<td><?php echo $producto['color']; ?></td>
    					<td><?php echo $producto['talle']; ?></td>
    					<td>$<?php echo $producto['costo']; ?></td>
    					<td>$<?php echo $producto['costoSinIva']; ?></td>
    					<td>$<?php echo $producto['subtotal']; ?></td>
    					<td>$<?php echo $producto['subtotalSinIva']; ?></td>

                        <?php if ( $mostrarPedidos ):?>
                        <td><?php echo implode(', ', $producto['ids_pedidos']->getRawValue()); ?></td>
                        <?php endif; ?>
    				</tr>
    				<?php endforeach; ?>
    				<tr>
    					<td>&nbsp;</td>
    					<td><strong><?php echo $cantidad; ?></strong></td>
    					<td><strong><?php echo $devoluciones; ?></strong></td>
    					<td colspan="6" class="total">Totales</td>
    					<td><strong>$<?php echo sprintf('%01.2f', $total); ?></strong></td>
    					<td><strong>$<?php echo sprintf('%01.2f', $totalSinIva); ?></strong></td>
                        <?php if ( $mostrarPedidos ):?>
                        <td>&nbsp;</td>
                        <?php endif; ?>
    				</tr>
    			</tbody>
    		</table>
    	</li>
    	<?php endforeach; ?>
    </ul>
    <?php endif; ?>
    
    
</div>