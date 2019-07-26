<?php ob_start(); ?>

<style>

	body { margin: 0 20px 0 20px; }

	p, h1, h2 { font-family: arial; }

	h1
	{
		margin: 20px 0 20px 0;
	}
	
	.alerta-premio
	{
		text-align: right;
	}
	
	.page-break
	{
		page-break-before: always;	
	}

	table.productos
	{
		border-right: solid #CCCCCC 1px;
		border-bottom: solid #CCCCCC 1px;
		font-size: 13px;
		font-family: arial;
	}
	
	table.productos td,
	table.productos th
	{
		border-left: solid #CCCCCC 1px;
		border-top: solid #CCCCCC 1px;
	}
	
	table.productos th
	{
		text-align: center;
	}
	
	table.productos td.center
	{
		text-align: center;
	}

</style>

<?php $isFirst = true; ?>

<?php if (count($data) > 0) { ?>

	<?php foreach( $data as $row ): ?>
	
	<?php $remito  = $row['remito']; ?>
	<?php $pedidos = $remito->getPedidos(); ?>
	<?php $pedido  = $pedidos[0] ?>
	<?php $usuario = $pedido->getUsuario(); ?>
	
  	<?php $pedidoDescuento = $pedido->getPedidoDescuento(); ?>
  	<?php $descuento = ( count($pedidoDescuento) )? $pedidoDescuento->getFirst()->getDescuento() : false; ?>
	
	<table <?php echo (!$isFirst) ? 'class="page-break"' : ''; ?>>
	   <tr>
            <td width="360">
            	<h1>
            	   	REMITO N° <?php echo $remito->getIdFormateado(); ?>
            	</h1>
            </td>
            <td width="380">
                <?php if ( $descuento && $descuento->getRecibePremio() ) : ?>
            	<h2 class="alerta-premio">
            	   <img src="<?php echo sfConfig::get('app_host'); ?>/backend/images/entregar_premio.jpg"/>
            	</h2>
            	<?php endif; ?>
            </td>
        </tr>
	</table>
	
	<table>
		<tr>
			<td style="padding: 0 30px 0 0;">
				<img src="data:image/png;base64,<?php echo $row['etiqueta']; ?>"/>
			</td>
			<td>
				<p>
				  	<strong>Fecha de emisión:</strong> <?php echo $dateNow; ?><br />
				</p>
				
				<p>
				  	<strong>Documento no válido como factura</strong>
				</p>
				
			  	<p>
				  	<strong><?php echo $razonSocial; ?></strong>
				  	<br />
				  	<?php echo $domicilioComercial; ?>
				  	<br />
				  	CUIT <?php echo $cuit; ?>
			  	</p>
			  			  	
            	<h1>
            		ENVIO A
            	    <?php if ($pedido->getEnvioTipo() == CarritoEnvio::SUCURSAL): ?>
            	   	SUCURSAL
            	    <?php else:?>
            	   	DOMICILIO
            	   	<?php endif;?>
            	</h1>
			  	<h2>Datos del envío:</h2>			  	

			  	<?php $envioDetalle = $pedido->getArrayEnvioDetalle(); ?>

			  	<p>
					<?php if ($pedido->getEnvioTipo() == CarritoEnvio::SUCURSAL): ?>
				  		<strong>A SUCURSAL</strong><br />
				  		<strong>Retira:</strong> <?php echo $envioDetalle['destinatario']; ?><br />
				  		<strong>Sucursal:</strong> <?php echo $envioDetalle['sucursal']; ?><br />
				  		<strong>Código postal:</strong> <?php echo $envioDetalle['codigo_postal']; ?><br />
				  		<strong>Dirección:</strong> <?php echo $envioDetalle['direccion']; ?><br />
				  		<strong>Localidad:</strong> <?php echo $envioDetalle['localidad']; ?><br />
				  		<strong>Provincia:</strong> <?php echo $envioDetalle['provincia']; ?>
					<?php else:?>
						<strong>A DOMICILIO</strong><br />
				  		<strong>Recibe:</strong> <?php echo $envioDetalle['destinatario']; ?><br />
				  		<strong>Dirección:</strong> <?php echo $envioDetalle['direccion']; ?><br />
				  		<strong>Código postal:</strong> <?php echo $envioDetalle['codigo_postal']; ?><br />
				  		<strong>Localidad:</strong> <?php echo $envioDetalle['localidad']; ?><br />
				  		<strong>Provincia:</strong> <?php echo $envioDetalle['provincia']; ?>
					<?php endif;?>
		  		</p>
		  		
		  		<h2>Datos del cliente:</h2>
		  	
			  	<p>
				  	<strong>Nombre y apellido:</strong> <?php echo  $usuario->getNombre() . ' ' . $usuario->getApellido(); ?><br />
				  	<strong>E-mail:</strong> <?php echo  $usuario->getEmail(); ?><br />
				  	<strong>Teléfono:</strong> <?php echo  $usuario->getTelefono(); ?>
			  	</p>
			</td>
		</tr>
		
		<?php foreach( $pedidos as $pedido ): ?>
		<tr>
			<td colspan="2">
				<br/>
				
				<p>
					<strong>CODIGO DEL PEDIDO: <?php echo $pedido->getIdPedido(); ?></strong>
					<br />
					<strong>Fecha del pedido:</strong> <?php echo $pedido->getDateTimeObject('fecha_alta')->format("y-m-d"); ?>
				</p>	
			    
				<h2>Datos de los productos:</h2>
			    <?php $pedidoProductoItems = $pedido->getPedidoProductoItem(); ?>
				
				<?php $alertaProductos = false; ?>
				<?php $totalUnidades = 0; ?>
				<?php foreach ($pedidoProductoItems as $pedidoProductoItem): ?>
				    <?php $cantidadFaltante = ( isset($faltantesXPedido[$pedido->getIdPedido()]) && isset($faltantesXPedido[$pedido->getIdPedido()][ $pedidoProductoItem->getIdProductoItem() ]) ) ? $faltantesXPedido[$pedido->getIdPedido()][ $pedidoProductoItem->getIdProductoItem() ] : 0 ?>
				    <?php $cantidad = $pedidoProductoItem->getCantidad() - $cantidadFaltante; ?>
				    <?php $totalUnidades += $cantidad; ?>
    		  		<?php if ( $cantidad > 1 ): ?>
        		  		<?php $alertaProductos = true; ?>		  		
    		  	    <?php endif; ?>
		  		<?php endforeach; ?>
		  		
			  	<?php if( $alertaProductos ): ?>
			  	<p style='border: 2px solid red; width: 90%; font-size: 13pt; font-weight: bold; padding: 8pt; text-align: center; margin: 0 auto 20px auto;'>
			  	      Atención este pedido tiene <?php echo $totalUnidades; ?> unidades.
			  	</p>
			  	<?php endif; ?>
								
				<table class="productos" cellpadding="5" cellspacing="0">
				
		  			<tr>
				  		<th>C.</th>
				  		<th>Oferta?</th>
				  		<th>Marca</th>
				  		<th>Producto</th>
				  		<th>Codigo</th>
				  		<th>Talle</th>
				  		<th>Color</th>
				  		<th>Outlet?</th>
		  			</tr>
				
				<?php foreach ($pedidoProductoItems as $pedidoProductoItem): ?>
				<?php $cantidadFaltante = ( isset($faltantesXPedido[$pedido->getIdPedido()]) && isset($faltantesXPedido[$pedido->getIdPedido()][ $pedidoProductoItem->getIdProductoItem() ]) ) ? $faltantesXPedido[$pedido->getIdPedido()][ $pedidoProductoItem->getIdProductoItem() ] : 0 ?>
				
				<?php $codigo = $pedidoProductoItem->getProductoItem()->getCodigo(); ?>
		  		<?php $producto = $pedidoProductoItem->getProductoItem()->getProducto(); ?>
		  		<?php $marca = $producto->getMarca(); ?>	  	
		  		<?php $productoNombre = $producto->getDenominacion(); ?>
		  		<?php $talle = $pedidoProductoItem->getProductoColor()->getDenominacion(); ?>
		  		<?php $color = $pedidoProductoItem->getProductoTalle()->getDenominacion(); ?>
		  		
		  		<?php $cantidad = $pedidoProductoItem->getCantidad() - $cantidadFaltante; ?>
		  		
		  		<?php if ( $cantidad > 0 ): ?>
		  			<tr>
				  		<td><?php echo $cantidad; ?></td>
				  		<td><?php echo $pedidoProductoItem->getDiversidad(' - '); ?></td>
				  		<td><?php echo $marca->getNombre(); ?></td>
				  		<td><?php echo $productoNombre; ?></td>
				  		<td><?php echo htmlentities($codigo); ?></td>
				  		<td><?php echo $talle; ?></td>
				  		<td><?php echo $color; ?></td>
				  		<td class="center"><?php echo ( $pedidoProductoItem->esOutlet() )? 'Si' : 'No'; ?></td>
		  			</tr>
		  	    <?php endif; ?>
		  		<?php endforeach; ?>
				</table>
				<br/><br/><br/><br/>
			</td>
		</tr>
		<?php endforeach; ?>
		
	</table>
	
	
	<?php $isFirst = false; ?>
	
	<?php endforeach; ?>
	
<?php } else { ?>
	<h2>No hay remitos asociados a los pedidos seleccionados.</h2>
<?php } ?>

<?php $html = ob_get_contents(); ?>

<?php ob_end_flush(); ?>

<?php $path = '/tmp/remitos_' . time() . '.html'; ?>
<?php $file = file_put_contents($path, $html); ?>
<?php header('Content-type: text/html.'); ?>
<?php header("Content-Length: ".filesize($path)); ?>
<?php header('Content-Disposition: attachment; filename="remitos.html"'); ?>
