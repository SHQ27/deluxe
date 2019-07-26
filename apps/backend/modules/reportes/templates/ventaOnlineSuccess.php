<div id="sf_admin_container" class="reporteVentaOnline">
	
	<?php if ( isset($deshabilitado) ): ?>
	<p>Esta seccion solo puede verse desde un usuario de la marca asignado a una campaña.</p>
	<?php else: ?>
		
	<h1>Reporte de ventas de la campaña "<?php echo $campana->getDenominacion() ?>"</h1>
	<p class="subtitulo">Del <?php echo date('d/m/Y', $fechaInicio); ?> al <?php echo date('d/m/Y', $fechaFin); ?></p>
	
	<table>
		<tr>	
			<th class="center">Imagen</th>
			<th class="center">Producto</th>
			<?php $cols = 0; ?>	
			<?php for($fecha = $fechaInicio ; $fecha <= $fechaFin ; $fecha = $fecha + 86400): ?>
			<th class="center"><?php echo ucfirst( strftime('%A', $fecha) ); ?><br/><?php echo strftime('%d/%m/%Y', $fecha); ?></th>
			<?php $cols++; ?>
			<?php endfor; ?>
			<th class="center">Fuera de<br/>Plazo <a class="helpButton" title="Se refiere a si el pago<br/>ingresa luego de finalizada<br/> la campaña">(?)</a></th>
			<th class="center">Total</th>
		</tr>
		<?php $i = 0; ?>
		<?php if ( count($productoItems) && count($datos) ): ?>
			
			<?php $total = 0; ?>
			<?php foreach($productoItems as $productoItem): ?>
			<?php $producto = $productoItem->getProducto(); ?>
			<tr class="<?php echo ( $i % 2 == 0 )? 'par' : 'impar' ?>">
				<td>
					<?php if ( is_file( imageHelper::getInstance()->getPath('producto_detalle_chica', $producto) ) ):?>
					<a class="enlargeImage" href="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_mediana', $producto)?>">
						<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>"/>
					</a>
					<?php endif; ?>
				</td>
				<td>
					<strong><?php echo $producto->getDenominacion(); ?></strong>
					<br/>
					<strong>Talle:</strong> <?php echo $productoItem->getProductoTalle()->getDenominacion(); ?>
					<br/>
					<strong>Color:</strong> <?php echo $productoItem->getProductoColor()->getDenominacion(); ?>
				</td>
				<?php $totalRow = 0; ?>
				<?php for($fecha = $fechaInicio ; $fecha <= $fechaFin ; $fecha = $fecha + 86400): ?>
				<td class="center">
					<?php if ( isset( $datos[ date('Y-m-d', $fecha) ] ) && isset( $datos[ date('Y-m-d', $fecha) ][ $productoItem->getIdProductoItem() ] ) ): ?>
					<?php echo $datos[ date('Y-m-d', $fecha) ][ $productoItem->getIdProductoItem() ]; ?>
					<?php $totalRow += $datos[ date('Y-m-d', $fecha) ][ $productoItem->getIdProductoItem() ]; ?>
					<?php else: ?>
					0
					<?php endif; ?>
				</td>
				<?php endfor; ?>
				<td class="center">
					<?php if ( isset( $datos[ 'FP' ] ) && isset( $datos[ 'FP' ][ $productoItem->getIdProductoItem() ] ) ): ?>
					<?php echo $datos[ 'FP' ][ $productoItem->getIdProductoItem() ]; ?>
					<?php $totalRow += $datos[ 'FP' ][ $productoItem->getIdProductoItem() ]; ?>
					<?php else: ?>
					0
					<?php endif; ?>
					
				</td>
				<td class="center">
					<?php $total += $totalRow; ?>
					<?php echo $totalRow; ?>					
				</td>
			</tr>
			<?php $i++; ?>
			<?php endforeach; ?>
			<tr class="<?php echo ( $i % 2 == 0 )? 'par' : 'impar' ?>">
				<td style="text-align: right;" colspan="<?php echo ($cols + 3) ?>">
					<strong>Total</strong>
				</td>
				<td class="center">
					<?php echo $total; ?>
				</td>
			</tr>
		<?php else: ?>
			<tr>
				<td class="center" colspan="<?php echo ($cols + 4) ?>">
					Todavia no hubo ventas para esta campaña
				</td>
			</tr>
		<?php endif; ?>
	</table>    
	
	<?php endif; ?>
</div>