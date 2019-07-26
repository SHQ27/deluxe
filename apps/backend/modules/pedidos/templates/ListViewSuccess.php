<div id="sf_admin_container" class="detallePedido">

	<?php if ( $sf_user->getFlash('error') ): ?>
	<div class="error"><?php echo $sf_user->getFlash('error'); ?></div>
	<?php endif; ?>

	<h1>Detalle de pedido #<?php echo $pedido->getIdPedido(); ?></h1>
	
	<?php if ( $pedido->getFechaLimite() && $pedido->getFechaLimite() < $pedido->getFechaPago()  ): ?>
	<p class="alert">Importante: el pago de este pedido ingresó luego de la fecha limite!</p>
	<?php endif; ?>
	
	<?php if ( $pedido->getRequiereIntervencionManual()  ): ?>
	<p class="alert">
		Alerta: Este pedido requiere intervencion manual
		<a href="<?php echo url_for('pedido_quitarIntervencionManual', array('idPedido' => $pedido->getIdPedido())); ?>">Quitar Alerta</a>
	</p>
	<?php endif; ?>
		
	<h2>Datos del pedido</h2>
	<ul>
		<li><strong>IdPedido:</strong> <?php echo $pedido->getIdPedido(); ?></li>
		<li><strong>Fecha de Realización:</strong> <?php echo $pedido->getDateTimeObject('fecha_alta')->format("d/m/Y H:i:s") ?></li>
		<?php if ( $pedido->getSource() ): ?>
		<li>&nbsp;</li>
		<?php if ( $pedido->getSourceDenominacion() ): ?>
		<li><strong>Source:</strong> <?php echo $pedido->getSourceDenominacion(); ?></li>
		<li><strong>Registrado:</strong> <?php echo $pedido->getDateTimeObject('fecha_source')->format("d/m/Y H:i:s") ?></li>
		<?php else: ?>
		<li><strong>Source:</strong> El pedido se realizo con un codigo de source "<?php echo $pedido->getSource() ?>", pero el mismo todavia no ha sido dado de alta en el backend.</li>
		<?php endif; ?>
		<?php endif; ?>
	</ul>
	
	<h2>Estado del pedido</h2>	
	
	<div class="leyenda">
	    <strong>Aclaraciones de uso</strong>
	    <br /><br />
	    Las acciones de "Marcado" no realizan ningun proceso mas que solo anotar al pedido en un estado indicado.
	    <br />
	    El resto de las acciones realiza procesos complejos que pueden emitir mails al cliente y/o facturacion hace AFIP.  
	</div>
	
	<table class="detalleEstados">
		<tr>
			<td><strong>Estado</strong></td>
			<td><strong>Detalle</strong></td>
			<td><strong>Acción</strong></td>
		</tr>
		<tr>
			<td>Pagado</td>
			<td><?php echo ($pedido->getFechaPago()? $pedido->getDateTimeObject('fecha_pago')->format("d/m/Y H:i:s") : 'No' ); ?></td>
			<td>
			    <?php if ( !$pedido->getFechaPago() ): ?>
			    <a class="confirm" href="<?php echo url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'PROCESAR_PAGO') ); ?>">PROCESAR PAGO y realizar la FACTURACIÓN (No se puede deshacer)</a>
			    <br /><br />
			    <?php endif; ?>
			    
			    <a class="confirm" <?php echo ($pedido->getFechaPago())? 'href="' . url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'NO_PAGADO')) . '">Marcar como NO PAGADO':'<a href="' . url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'PAGADO') ) . '">Marcar como PAGADO'; ?></a>
            </td>
		</tr>
		<tr>
			<td>Enviado</td>
			<td>
			     <?php echo ($pedido->getFechaEnvio()? $pedido->getDateTimeObject('fecha_envio')->format("d/m/Y H:i:s") : 'No' ); ?> <?php echo ($pedido->getCodigoEnvio())? ' - Codigo de Envio: ' . $pedido->getCodigoEnvio() : ''; ?>
			     <?php echo ( $pedido->getTieneProblemaOca() ) ? '<br /><br />Tiene problemas de envio en OCA' : ''; ?>
		    </td>
			<td>
			     <?php echo ($pedido->getFechaEnvio())? '<a class="NO_ENVIADO" href="' . url_for('pedido_changeEstadoEnvio', array('idPedido' => $pedido->getIdPedido()) ) . '">Marcar como NO ENVIADO</a>':'<a class="ENVIADO"  href="' . url_for('pedido_changeEstadoEnvio', array('idPedido' => $pedido->getIdPedido()) ) . '">Marcar como ENVIADO</a>'; ?>
			     <br /><br />
			     <?php echo ($pedido->getTieneProblemaOca())? '<a href="' . url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'OCA_NO_ERROR_ENVIO') ) . '">Los problemas en OCA fueron solucionados</a>':'<a href="' . url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'OCA_ERROR_ENVIO') ) . '">Tiene problemas de envio en OCA</a>'; ?>
    		</td>
		</tr>
		<tr>
			<td>Facturado</td>
			<td><?php echo ($pedido->getFechaFacturacion()? $pedido->getDateTimeObject('fecha_facturacion')->format("d/m/Y H:i:s") : 'No' ); ?></td>
			<td><a class="confirm" <?php echo ($pedido->getFechaFacturacion())? 'href="' . url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'NO_FACTURADO') ) . '">Marcar como NO FACTURADO':'<a href="' . url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'FACTURADO') ) . '">Marcar como FACTURADO'; ?></a></td>
		</tr>
		<tr>
			<td>Eliminado</td>
			<td><?php echo ($pedido->getFechaBaja()? $pedido->getDateTimeObject('fecha_baja')->format("d/m/Y H:i:s") : 'No' ); ?></td>
			<td>
			    <a class="confirm" <?php echo ($pedido->getFechaBaja())? 'href="' . url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'ALTA') ) . '">Dar de ALTA':'<a href="' . url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'BAJA') ) . '">Dar de BAJA'; ?></a>
			    <br /><br />
			    <a class="confirm" <?php echo ($pedido->getFechaBaja())? 'href="' . url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'ALTA_SIN_MODIF_STOCK') ) . '">Dar de ALTA (sin modificar stock)':'<a href="' . url_for('pedido_changeEstado', array('idPedido' => $pedido->getIdPedido(), 'estado' => 'BAJA_SIN_MODIF_STOCK') ) . '">Dar de BAJA (sin modificar stock)'; ?></a>
            </td>
		</tr>
		<tr>
			<td>Aviso de pago</td>
			<td><?php echo ($pedido->getFechaAvisoPago()? 'Enviado el ' . $pedido->getDateTimeObject('fecha_aviso_pago')->format("d/m/Y H:i:s") : 'No enviado' ); ?></td>
			<td>&nbsp;</td>
		</tr>
	</table>
	
	
	
	<h2>Detalle de productos</h2>
	
	<table class="detalleProductos">
		<tr>
			<td><strong>Codigo</strong></td>
			<td><strong>Producto</strong></td>
			<td><strong>Diversidad</strong></td>
			<td><strong>Outlet?</strong></td>
			<td><strong>Marca</strong></td>
			<td><strong>Talle</strong></td>
			<td><strong>Color</strong></td>
			<td><strong>Cantidad</strong></td>
			<td><strong>Precio</strong></td>
		</tr>
		<?php foreach($pedido->getPedidoProductoItem() as $pedidoProductoItem): ?>
		<tr <?php echo ( $pedidoProductoItem->tieneRefuerzo() ) ? 'class="es-refuerzo"' : ''; ?>>
			<?php $productoItem = $pedidoProductoItem->getProductoItem(); ?>
			<?php $producto = $productoItem->getProducto(); ?>
			
			<td><?php echo $productoItem->getCodigo(); ?></td>
			<td><a href="/backend/productos/<?php echo $producto->getIdProducto() ?>/edit"><?php echo $producto->getDenominacion(); ?></a></td>
			<td><?php echo $pedidoProductoItem->getDiversidad(ESC_RAW) ?></td>
			<td><?php echo ( $pedidoProductoItem->esOutlet() ) ? 'Si' : 'No' ?></td>
			<td><?php echo $producto->getMarca()->getNombre(); ?></td>
			<td><?php echo $pedidoProductoItem->getProductoTalle()->getDenominacion(); ?></td>
			<td><?php echo $pedidoProductoItem->getProductoColor()->getDenominacion(); ?></td>
			<td><?php echo $pedidoProductoItem->getCantidad(); ?></td>
			<td>$<?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ); ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
		
	<ul>	
		<li><strong>Total de productos:</strong> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoProductos() ); ?></li>
				
		<li>
			<strong>Total de descuentos:</strong> 
			($<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoDescuento() ); ?>)
			<?php echo ($descuento) ? ' :: <a class="background-none coral" href="/backend/descuentos/' . $descuento->getIdDescuento() . '/edit">Ver descuento con código "' . $descuento->getCodigo() . '"</a>' : '' ?>
		</li>
				
		<li>
			<strong>Total de bonificaciones:</strong> 
			($<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoBonificacion() ); ?>)
			<?php echo ($bonificacion) ? ' :: <a class="background-none coral" href="/backend/bonificaciones/' . $bonificacion->getIdBonificacion() . '/edit">' . 'Ver' . '</a>' : '' ?>
		</li>
		
		<li><strong>Cargo de envío:</strong> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoEnvio() ); ?></li>
		<li><strong>Financiación:</strong> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getInteres() ); ?></li>
		<li><strong>Total del pedido:</strong> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ); ?></li>
	</ul>
	
	
	
	<h2>Detalle de la entrega</h2>
	
	<ul id="entrega_view">
	
		<?php $envioDetalle = $pedido->getArrayEnvioDetalle(); ?>
		<li><strong>Recibe:</strong> <?php echo $envioDetalle['destinatario']; ?><br/><br/></li>
		
		<?php if ($envioDetalle['tipo'] == CarritoEnvio::SUCURSAL): ?>
		<li><strong>Sucursal "<?php echo $envioDetalle['sucursal']; ?>"</strong></li>
		<li><strong>Dirección:</strong> <?php echo $envioDetalle['direccion']; ?></li>
		<li><strong>Localidad:</strong> <?php echo $envioDetalle['localidad']; ?></li>
		<li><strong>Provincia:</strong> <?php echo $envioDetalle['provincia']; ?></li>
		<li><strong>Teléfono de la sucursal:</strong> <?php echo $envioDetalle['telefono']; ?></li>
		<li><strong>Horarios:</strong> <?php echo $envioDetalle['horario']; ?></li>
		<?php else:?>
		<li><strong>En:</strong> Domicilio Propio</li>
		<li><strong>Dirección:</strong> <?php echo $envioDetalle['direccion']; ?></li>
		<li><strong>Localidad:</strong> <?php echo $envioDetalle['localidad']; ?></li>
		<li><strong>Provincia:</strong> <?php echo $envioDetalle['provincia']; ?></li>
		<li><strong>Código postal:</strong> <?php echo $envioDetalle['codigo_postal']; ?></li>
		<?php endif;?>
		<li>
			<br />
			<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/enviopack/<?php echo $envioDetalle['correo']; ?>.png"/>
			<br />
			Servicio <?php echo EnvioPack::getInstance( $pedido->getIdEshop() )->getNombreServicio( $envioDetalle['servicio'] ); ?>
		</li>
	</ul>



	<?php $tracking = $pedido->getTracking(); ?>
	
	<?php if ( $tracking && count($tracking) ): ?>
		
	<h2>Seguimiento del Envío</h2>
	
	<table>
		<tr>
			<th>Fecha</th>
			<th>Estado</th>
		</tr>
	
	    <?php foreach ($tracking as $row): ?>
        <tr>
           	<td><?php echo $row['fecha']; ?></td>
          	<td><?php echo $row['mensaje']; ?></td>
        </tr>   
	    <?php endforeach; ?>
	    
	<?php endif; ?>
	</table>
		
	
	<h2>Detalle del pago</h2>
	
	<ul>	
		<li><strong>Forma de Pago:</strong> <?php echo $pedido->getFormaPago()->getDenominacion(); ?></li>
		
		<?php if ( $pedido->getDatosPago() ): ?>
		    <?php $datosPago = json_decode( $pedido->getDatosPago(ESC_RAW), true ); ?>

    		<?php foreach( $datosPago as $key => $value ): ?>    		
    		<li><strong><?php echo ucwords(str_replace('_', ' ', $key)); ?>:</strong> <?php echo $value; ?></li>
    		<?php endforeach; ?>
    		
		<?php else: ?>
		<li>Todavia no hay datos de pago</li>
		<?php endif; ?>
	</ul>
	
	<h2>Datos del cliente</h2>
	
	<ul>	
		<li><strong>Nombre:</strong> <?php echo $pedido->getNombre(); ?></li>
		<li><strong>Apellido:</strong> <?php echo $pedido->getApellido(); ?></li>
		<li><strong>E-mail:</strong> <?php echo $pedido->getEmail(); ?></li>
		<li><strong>Teléfono:</strong> <?php echo $pedido->getTelefono(); ?></li>
		<li><strong>Celular:</strong> <?php echo $pedido->getCelular(); ?></li>
		<?php if ($usuario->getDocumento()):?>
		<li><br/><strong>Documento:</strong> <?php echo $usuario->getTipoDocumento() . ' - ' . $usuario->getDocumento(); ?></li>
		<?php endif; ?>
	</ul>

	
	<h2>Observaciones</h2>
	
	<ul>	
		<li><?php echo ( $pedido->getObservaciones() )? $pedido->getObservaciones() : 'Sin observaciones'; ?></li>
	</ul>
	
	
	<h2>Comentarios Internos</h2>
	
	<ul>
		<li>
			<form action="<?php echo url_for('pedido_nota_save', array('idPedido' => $pedido->getIdPedido() ) ) ?>" method="post">
				<?php echo $pedidoNotaForm['_csrf_token'] ?>
				<?php echo $pedidoNotaForm['nota'] ?>
				<br/>
				<input type="submit" value="Guardar Comentarios" />
			</form>
		</li>
	</ul>
	
	
	<h2>Datos de seguimiento del pago</h2>
	
	<table>
		<tr>
			<td><strong>Fecha</strong></td>
			<td><strong>Mensaje</strong></td>
			<td><strong>Metodo</strong></td>
			<td><strong>Procesado</strong></td>
			<td colspan="2" style="text-align: center;"><strong>Response</strong></td>
		</tr>
		<?php foreach( $pedido->getPagoNotificacion() as $pagoNotificacion ): ?>
		<?php $response = $pagoNotificacion->getResponseArray(); ?>
		<?php $mensaje = $pagoNotificacion->getMensaje(ESC_RAW); ?>
		<?php $rowspan = count($response); ?>
		<tr>
		
			<td rowspan="<?php echo $rowspan; ?>"><?php echo $pagoNotificacion->getDateTimeObject('fecha')->format("d/m/Y H:i:s") ?></td>
			<td rowspan="<?php echo $rowspan; ?>"><?php echo $mensaje; ?></td>
			<td rowspan="<?php echo $rowspan; ?>"><?php echo $pagoNotificacion->getMetodo(); ?></td>
			<td rowspan="<?php echo $rowspan; ?>"><?php echo ( $pagoNotificacion->getProcesado() )? 'Si' : 'No'; ?></td>

			<?php $i = 0; ?>
			
			<?php if ( $response ): ?>
    		<?php foreach( $response as $key => $value ): ?>
    		<?php if ($i > 0 ) echo '<tr>'; ?>
    			<td class="tituloResponse"><?php echo ucfirst(str_replace('_', ' ', $key)); ?>:</td>
    			<td><?php echo $value; ?></td>
    		<?php $i++; ?>
    		<?php endforeach; ?>
    		<?php else: ?>
    			<td colspan="2"></td>
    		<?php endif; ?>
    	</tr>
		<?php endforeach; ?>
	</table>

	<h2>Faltantes en el pedido</h2>
	<table class="detalleProductos">
		<tr>
			<td><strong>Codigo</strong></td>
			<td><strong>Producto</strong></td>
			<td><strong>Marca</strong></td>
			<td><strong>Talle</strong></td>
			<td><strong>Color</strong></td>
			<td><strong>Cantidad</strong></td>
			<td><strong>Estado</strong></td>
			<td><strong>Fecha de Proc.</strong></td>
			<td><strong>Detalles</strong></td>
		</tr>
		<?php if ( count($faltantes) ): ?>
    		<?php foreach($faltantes as $faltante): ?>
    		<tr>
    		    <?php $productoItem = $faltante->getProductoItem(); ?>
    			<?php $producto = $productoItem->getProducto(); ?>
    			
    			<td><?php echo htmlentities($productoItem->getCodigo()); ?></td>
    			<td><a href="/backend/productos/<?php echo $producto->getIdProducto() ?>/edit"><?php echo $producto->getDenominacion(); ?></a></td>
    			<td><?php echo $producto->getMarca()->getNombre(); ?></td>
    			<td><?php echo $productoItem->getProductoTalle()->getDenominacion(); ?></td>
    			<td><?php echo $productoItem->getProductoColor()->getDenominacion(); ?></td>
    			<td><?php echo $faltante->getCantidad(); ?></td>
    			<td><?php echo $faltante->getEstadoHTML(ESC_RAW); ?></td>
    			<td><?php echo $faltante->getFechaProcesado() ? $faltante->getDateTimeObject('fecha_procesado')->format("d/m/Y H:i:s") : 'Aún no fue procesado'; ?></td>
    			<td>
    				<?php if ( $faltante->getIdBonificacion() ): ?>
						<?php $bonificacion = $faltante->getBonificacion(); ?>
						<?php if ( $bonificacion->getFueUtilizada() ): ?>
						La bonificación fue utilizada en el/los pedido/s:
						<br /><br />
						<?php $pedidos = $bonificacion->getPedidosAsociados(); ?>
						<?php foreach ( $pedidos as $pedido ): ?>
							<a href="/backend/pedidos/<?php echo $pedido->getIdPedido(); ?>/ListView"><?php echo $pedido->getIdPedido(); ?></a> -> Estado: <?php echo $pedido->getEstado(); ?><br />
						<?php endforeach;?>

						<?php else: ?>
						La bonificación aún no fue utilizada.
						<?php endif; ?>
					<?php endif; ?>
    			</td>
    		</tr>
    		<?php endforeach; ?>
		<?php else: ?>
    		<tr>
    			<td colspan="9">No se registran faltantes en este pedido</td>
    		</tr>
		<?php endif; ?>
	</table>

	<h2>Devoluciones sobre el pedido</h2>
	<table class="detalleProductos">
		<tr>
			<td><strong>Codigo</strong></td>
			<td><strong>Producto</strong></td>
			<td><strong>Marca</strong></td>
			<td><strong>Talle</strong></td>
			<td><strong>Color</strong></td>
			<td><strong>Cantidad</strong></td>
			<td><strong>Id Devolución</strong></td>
			<td><strong>Tipo de Crédito</strong></td>
			<td><strong>Estado</strong></td>
			<td><strong>Fecha de Proc.</strong></td>
			<td><strong>Detalles</strong></td>
		</tr>
		<?php if ( count($devolucionProductoItems) ): ?>
    		<?php foreach($devolucionProductoItems as $devolucionProductoItem): ?>
    		<tr>
    		    <?php $productoItem = $devolucionProductoItem->getPedidoProductoItem()->getProductoItem(); ?>
    			<?php $producto = $productoItem->getProducto(); ?>
    			<?php $devolucion = $devolucionProductoItem->getDevolucion(); ?>
    			
    			<td><?php echo htmlentities($productoItem->getCodigo()); ?></td>
    			<td><a href="/backend/productos/<?php echo $producto->getIdProducto() ?>/edit"><?php echo $producto->getDenominacion(); ?></a></td>
    			<td><?php echo $producto->getMarca()->getNombre(); ?></td>
    			<td><?php echo $productoItem->getProductoTalle()->getDenominacion(); ?></td>
    			<td><?php echo $productoItem->getProductoColor()->getDenominacion(); ?></td>
    			<td><?php echo $devolucionProductoItem->getCantidad(); ?></td>
    			<td><?php echo $devolucion->getIdDevolucion(); ?></td>
    			<td><?php echo $devolucion->getTipoCredito() == 'DELUXE' ? 'Bonificación' : 'Mercado Pago'; ?></td>
    			<td><?php echo $devolucion->getEstadoHTML(ESC_RAW); ?></td>
    			<td><?php echo $devolucion->getFechaCierre() ? $devolucion->getDateTimeObject('fecha_cierre')->format("d/m/Y H:i:s") : 'Aún no fue procesada'; ?></td>
    			<td>
    				<?php if ( $devolucion->getIdBonificacion() ): ?>
						<?php $bonificacion = $devolucion->getBonificacion(); ?>
						<?php if ( $bonificacion->getFueUtilizada() ): ?>
						La bonificación fue utilizada en el/los pedido/s:
						<br /><br />
						<?php $pedidos = $bonificacion->getPedidosAsociados(); ?>
						<?php foreach ( $pedidos as $pedido ): ?>
							<a href="/backend/pedidos/<?php echo $pedido->getIdPedido(); ?>/ListView"><?php echo $pedido->getIdPedido(); ?></a> -> Estado: <?php echo $pedido->getEstado(); ?><br />
						<?php endforeach;?>

						<?php else: ?>
						La bonificación aún no fue utilizada.
						<?php endif; ?>
					<?php endif; ?>
    			</td>
    		</tr>
    		<?php endforeach; ?>
		<?php else: ?>
    		<tr>
    			<td colspan="11">No se registran productos devueltos de este pedido</td>
    		</tr>
		<?php endif; ?>
	</table>
	
	<h2>Remitos</h2>
	<table>
		<tr>
			<td><strong>Remito</strong></td>
			<td><strong>Id de Envio en EnvioPack</strong></td>
		</tr>
		
		<?php if ( count($remitos) ): ?>
		<?php foreach($remitos as $remito): ?>
		<tr>
			<td><?php echo $remito->getIdRemito(); ?></td>
			<td><?php echo $remito->getIdEnvio(); ?></td>
		</tr>
		<?php endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="2">No hay remitos asociados a este pedido</td>
		</tr>
		<?php endif; ?>
	</table>
	
	<h2>Comprobantes Afip asociados al pedido</h2>
	
	<table>
		<tr>
			<td><strong>Fecha</strong></td>
			<td><strong>Tipo</strong></td>
			<td><strong>Entorno</strong></td>
			<td><strong>Nº de Comprobante </strong></td>
			<td><strong>CAE</strong></td>
			<td><strong>Vencimiento CAE</strong></td>
			<td><strong>Importe Total</strong></td>
			<td><strong>Descargar</strong></td>
		</tr>
		
		<?php if ( $factura && $factura->getComprobante() ): ?>
		<tr>
			<td><?php echo $factura->getFechaEmision(); ?></td>
			<td>Factura B</td>
			<td><?php echo ($factura->getEntorno() == Afip::PROD) ? 'Producción' : 'Homologación'; ?></td>
			<td><?php echo $factura->getComprobante(); ?></td>
			<td><?php echo $factura->getCAE(); ?></td>
			<td><?php echo $factura->getCAEVencimiento(); ?></td>
			<td>$<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ); ?></td>
			<td><a href="/backend/facturacion/<?php echo $pedido->getIdPedido(); ?>/descargarFactura"><img src="/backend/images/icons/small/backup.png" border="0" alt="Descargar" title="Descargar"></a></td>
		</tr>
		<?php endif; ?>
		
		<?php if ( !$factura): ?>
		<tr>
			<td colspan="8">No hay comprobantes asociados a este pedido</td>
		</tr>
		<?php endif; ?>
	</table>
	
	
	<h2>Imprimir Recibo de Devolución</h2>
	
	<input name="devolucion[idPedido]" type="hidden" value="<?php echo $pedido->getIdPedido();?>" />
	
	<ul id="reciboDevolucion">
		<li>
			<p>
				<label class="float-left">Monto</label>
				<input name="devolucion[monto]" type="text" />
			</p>
			<p>
				<label class="float-left">Devolución</label>
				<input name="devolucion[devolucion]" type="radio" value="MP" /> En Mercado Pago
				&nbsp;&nbsp;&nbsp;
				<input name="devolucion[devolucion]" type="radio" value="CREDITO" /> Credito en DeluxeBuys
			</p>
			
			<p>
				<label class="float-left">Detalle</label>
				<table>
					<tr>
						<th><strong>Producto</strong></th>
						<th><strong>Marca</strong></th>
						<th><strong>Talle</strong></th>
						<th><strong>Color</strong></th>
						<th><strong>Cantidad</strong></th>
						<th><strong>Acción</strong></th>
					</tr>
					<?php foreach($pedido->getPedidoProductoItem() as $pedidoProductoItem): ?>
					<tr>
						<?php $producto = $pedidoProductoItem->getProductoItem()->getProducto(); ?>
						
						<td><?php echo $producto->getDenominacion(); ?></td>
						<td><?php echo $producto->getMarca()->getNombre(); ?></td>
						<td><?php echo $pedidoProductoItem->getProductoTalle()->getDenominacion(); ?></td>
						<td><?php echo $pedidoProductoItem->getProductoColor()->getDenominacion(); ?></td>
						<td><input class="cantidad" name="devolucion[cantidad]" rel="<?php echo $pedidoProductoItem->getIdProductoItem(); ?>" type="text" value="<?php echo $pedidoProductoItem->getCantidad(); ?>" /></td>
						<td><a class="eliminar">Eliminar</a></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</p>
			
			<p>
				<input class="button" name="devolucion[button]" type="button" value="Previsualizar" />
			</p>
			
		</li>
	</ul>
	
</div>