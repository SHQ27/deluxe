<h1>
    <span class="sprite icon-star-left"></span>
    <span class="Raleway">Detalle del Pedido</span>
    <span class="sprite icon-camion"></span>
    <span class="sprite icon-star-right"></span>
</h1>

<h2>Este es el detalle del pedido #<?php echo $pedido->getIdPedido() ?></h2>


<div class="contain">
	
	
	<p>
		<label>Fecha de realización:</label>
		<?php echo date('d/m/Y', strtotime($pedido->getFechaAlta())); ?>
		<br />
		<label>Estado:</label>
		<?php echo $pedido->getEstado() ?>.
	</p>
	
	
    <table>
        <tr>
        	<th>Producto</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Marca</th>
            <th>Valor</th>
        </tr>
        <?php $i = 0; ?>
        <?php foreach ($pedido->getPedidoProductoItem() as $pedidoProductoItem): ?>
    	<?php $producto = $pedidoProductoItem->getProductoItem()->getProducto(); ?>
        <tr>
        	<td><img width="70" src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>" alt="<?php echo $producto->getDenominacion() ?>" /></td>
            <td><?php echo $producto->getDenominacion() ?></td>
            <td class="center"><?php echo $pedidoProductoItem->getCantidad() ?></td>
            <td class="center"><?php echo $producto->getMarca()->getNombre() ?></td>
            <td class="center" width="60">$ <?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ) ?>.-</td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>                            
    </table>
	
	
	
	<h3>
	    Detalle del pago
    	<?php if (!$pedido->getFechaPago() && !$pedido->getFechaBaja()): ?>
    	<span class="alerta-pago">( El pago aún no se ha procesado )</span>
    	<?php endif; ?>
    </h3>
	
	<p>			
		<label>Valor de los productos:</label> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoProductos() ) ?>
		<br />
		<label>Cargo de envío:</label> $ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoEnvio() ) ?>
		<br />
		<?php if ( (float) $pedido->getMontoDescuento() ): ?>
		<label>Valor por descuentos:</label> $ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoDescuento() ) ?>
		<br />
		<?php endif; ?>
		<?php if ( (float) $pedido->getMontoBonificacion() ): ?>
		<label>Valor por bonificaciones:</label> $ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoBonificacion() ) ?>
		<br />
		<?php endif; ?>
		<label>Valor Total:</label> $ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ) ?> 
	</p>
	
	<h3>Persona que recibirá el envío</h3>
	
	<?php $envioDetalle = $pedido->getArrayEnvioDetalle(); ?>

	<p>
	    <label>Destinatario:</label> <?php echo $envioDetalle['destinatario']; ?>
    </p>
	
	
	<?php if ($envioDetalle['tipo'] == CarritoEnvio::SUCURSAL): ?>
	<h3>Entrega en Sucursal "<?php echo $envioDetalle['sucursal']; ?>"</h3>
	<p>
		<label>Dirección:</label> <?php echo $envioDetalle['direccion']; ?>
		<br />
		<label>Localidad:</label> <?php echo $envioDetalle['localidad']; ?>
		<br />
		<label>Provincia:</label> <?php echo $envioDetalle['provincia']; ?>
		<br />
		<label>Teléfono de la sucursal:</label> <?php echo $envioDetalle['telefono']; ?>
		<br />
		<label>Horarios:</label> <?php echo $envioDetalle['horario']; ?>

	<?php else:?>
	<h3>Entrega en Domicilio Propio</h3>
	<p>
		<label>Dirección:</label> <?php echo $envioDetalle['direccion']; ?>
		<br />
		<label>Localidad:</label> <?php echo $envioDetalle['localidad']; ?>
		<br />
		<label>Provincia:</label> <?php echo $envioDetalle['provincia']; ?>
		<br />
		<label>Código postal:</label> <?php echo $envioDetalle['codigo_postal']; ?>
		<br />
	<?php endif;?>

		<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/enviopack/<?php echo $envioDetalle['correo']; ?>.png"/>
	</p>

	
	<a class="cerrar">Cerrar</a>
	
</div>
