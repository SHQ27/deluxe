<div id="sf_admin_container">
	<h1>Detalle del usuario "<?php echo $usuario->getEmail(); ?>"</h1>
	
	<h2>Datos del usuario</h2>
	<ul>
		<li><strong>Nombre:</strong> <?php echo $usuario->getNombre(); ?></li>
		<li><strong>Apellido:</strong> <?php echo $usuario->getApellido(); ?></li>
		<?php if ($usuario->getDocumento()):?>
		<li><strong>Documento:</strong> <?php echo $usuario->getTipoDocumento() . ' - ' . $usuario->getDocumento(); ?></li>
		<?php endif; ?>
		<li><strong>Sexo:</strong> <?php echo $usuario->getSexoNombre(); ?></li>
		<li><strong>Email:</strong> <?php echo $usuario->getEmail(); ?></li>
		<li><strong>Telefono:</strong> <?php echo $usuario->getTelefono(); ?></li>
		<li><strong>Celular:</strong> <?php echo $usuario->getCelular(); ?></li>
		<li><strong>Fecha Alta:</strong> <?php echo $usuario->getFechaAlta(); ?></li>
		<li><strong>Resumen de pedidos:</strong> <?php echo $usuario->getResumenPedidos(); ?></li>
		<li><strong>Activo:</strong> <?php echo ($usuario->getActivo())? 'Si' : 'No'; ?></li>
	</ul>	
	
	<h2>Direcciones Asociadas</h2>
	
		<?php if (count($direccionesAsociada)): ?>
			<ul>
			<?php foreach ($direccionesAsociada as $direccionAsociada): ?>
				<li>
					<strong><?php echo $direccionAsociada->getCalle(); ?> <?php echo $direccionAsociada->getNumero(); ?> <?php echo $direccionAsociada->getPiso(); ?> <?php echo $direccionAsociada->getDepto(); ?></strong>
					<br/>
					<?php echo $direccionAsociada->getLocalidad(); ?>,<?php echo $direccionAsociada->getProvincia()->getNombre(); ?>, Argentina
					<br/>
					CP. <?php echo $direccionAsociada->getCodigoPostal(); ?>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p>
				Este usuario todavía no tiene una dirección asociada.
			</p>
		<?php endif; ?>
		
		
    <h2>Productos disponibles para devolver</h2>
		
    <table>
        <tr>
            <th>Imagen</th>
            <th>Marca</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Valor</th>
        </tr>
    
        <?php if ( count( $pedidoProductoItems ) ): ?>
    		<?php foreach ($pedidoProductoItems as $pedidoProductoItem): ?>		
    		<?php $producto = $pedidoProductoItem->getProductoItem()->getProducto(); ?>
    
    		<tr>
    			<td class="imagen">
    				<div>
    					<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>"/>
    				</div>
    			</td>
    			<td class="marca">
    				<?php echo $producto->getMarca()->getNombre(); ?>
    			</td>
    			<td class="denominacion">
    				<?php echo $producto->getDenominacion(); ?>
    				<br/>
    				<?php echo $pedidoProductoItem->getProductoTalle()->getDenominacion(); ?> / <?php echo $pedidoProductoItem->getProductoColor()->getDenominacion(); ?>
    			</td>
    			<td class="cantidad" peso="<?php echo $producto->getPeso(); ?>">
    				<?php echo $pedidoProductoItem->getCantidad() ; ?>
    			</td>
    			<td class="precio" rel="<?php echo $pedidoProductoItem->getPrecioDeluxe(); ?>">
    				$ <?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ); ?>
    			</td>
    		</tr>
    		<?php endforeach; ?>
		<?php else: ?>
		    <tr>
		        <td colspan="5">Este usuario no tiene productos disponibles para devolver</td>
		    </tr>
		<?php endif; ?>
	</table>
	
</div>