<script>
    var topPosition = 0;
</script>

<h2 class="fleft">DEVOLUCIÓN</h2>

<a id="button_historial" class="fright termCondInputCheck">VER HISTORIAL DE DEVOLUCIONES</a>
<a id="button_devolverProducto" class="fright termCondInputCheck hide">DEVOLVER UN PRODUCTO</a>

<div class="clear"></div>

<div id="devoluciones_main">
    <?php if (!$procesado): ?>
    
    <div class="steps devoluciones">
    	<div class="sprite step fleft selected" rel="1">
            <span>1</span>
    	</div>
    	<div class="sprite stepSeparator fleft"></div>
    	<div class="sprite step fleft" rel="2">
            <span>2</span>
    	</div>
    	<div class="sprite stepSeparator fleft"></div>
    	<div class="sprite step fleft" rel="3">
            <span>3</span>
    	</div>
    	<div class="sprite stepSeparator fleft"></div>
    	<div class="sprite step fleft" rel="4">
            <span>4</span>
    	</div>
    </div>
    
    
    <form method="post">
    
        <?php echo $form['_csrf_token'] ?>
    
        <div id="paso-1" class="show">
        
        	<p class="margin-top30">
        	    Estos son los productos que estan en plazo de devolución (10 días luego de recibido el pedido)
        	    <a href="<?php echo url_for('tyc')?>">Politica de devoluciones</a>
        	</p>
        
        	<div class="listProductItems devoluciones margin-top30">
        		<?php $index = 0; ?>
        		<?php foreach ($pedidoProductoItems as $pedidoProductoItem): ?>		
        		<?php $producto = $pedidoProductoItem->getProductoItem()->getProducto(); ?>
        		<div class="item">
        		
        		    <?php echo $form['pedido_producto_item[id]']->render( array( 'name' => 'devoluciones[pedido_producto_item_id][' . $index . ']', 'value' => $pedidoProductoItem->getIdPedidoProductoItem(), 'class' => 'hide' ) ); ?>
        		
        			<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>"/>
        			<div class="producto">
        				<h3>PRODUCTO</h3>
        				<h2>
        				    <?php echo $producto->getDenominacion(); ?>
        				    <br /><br />
        				    <?php echo $pedidoProductoItem->getProductoTalle()->getDenominacion(); ?> / <?php echo $pedidoProductoItem->getProductoColor()->getDenominacion(); ?>    
        			    </h2>
        			</div>
        			<div class="marca">
        				<h3>MARCA</h3>
        				<h2><?php echo $producto->getMarca()->getNombre(); ?></h2>
        			</div>
        			<div class="cantidad" data-peso="<?php echo $producto->getPeso(); ?>">
        				<h3>CANTIDAD</h3>
        				<h2>
        					<select class="select" name="devoluciones[pedido_producto_item_cantidad][<?php echo $index; ?>]">
        						<?php for ($i = 1 ; $i <= $pedidoProductoItem->getCantidad() ; $i++ ): ?>
        						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        						<?php endfor; ?>
        					</select>
        				</h2>
        			</div>
        			<div class="valor">
        				<h3>VALOR</h3>
        				<h2 class="precio" rel="<?php echo $pedidoProductoItem->getPrecioDeluxe(); ?>">$ <?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ); ?></h2>
        			</div>
        			<input type="button" class="formInputButton smallInput" value="SELECCIONAR" rel="<?php echo $index; ?>">
        		</div>
        		<?php $index++; ?>
        		<?php endforeach; ?>
        	</div>
        		
        	<div class="devolucionMotivo">
        		<span>MOTIVO DE LA DEVOLUCIÓN:</span>
        		<div class="customSelect"> 
        			<?php echo $form['motivo'] ?>
        		</div>
        		
        	    <?php echo $form['motivo_abierto'] ?> 
        					
        		<div class="error"></div>
        	</div>
        	
            <div class="center margin-top30">
                <input type="button" value="DEVOLVER" class="formInputSubmit formInputButton inline buttonDevolver">
            </div>
        	
        </div>
        
        <div id="paso-2" class="hide">
        	
        	<p class="margin-top30">
        	    Contanos si preferis:
        	</p>
        	
        	<div class="opcionesDevolucionCredito">
        	
        		<div class="sprite radio small Merriweather selected fleft">
        			<input id="devoluciones_credito_DELUXE" type="radio" value="DELUXE" checked="checked" name="devoluciones[credito]" />
        		</div>
        		<label for="devoluciones_credito_DELUXE" class="fleft radioLabel">DEJAR CRÉDITO EN DELUXE PARA FUTURAS COMPRAS</label>
        		
        		<div class="clear margin-top15"></div>
        		
        		<div class="sprite radio small Merriweather fleft">
        			<input id="devoluciones_credito_MP" type="radio" value="MP" name="devoluciones[credito]" />
        		</div>
        		<label for="devoluciones_credito_MP" class="fleft radioLabel">SOLICITAR LA DEVOLUCIÓN POR MEDIO DE MERCADO PAGO</label>
        	            	    
        		<p class="advertisment fleft">(Tené en cuenta que puede demorar hasta 30 días habiles en reflejarse en tu resumen)</p>
        			
            </div>
            
            <div class="center margin-top30 clear-both">
            	<input type="button" class="formInputSubmit formInputButton inline buttonAnterior" value="ANTERIOR" />
            	<input type="button" class="formInputSubmit formInputButton inline buttonSiguiente" value="SIGUIENTE" />
            </div>
        	
        </div>
        
        <div id="paso-3" class="hide">
        
        	<p class="margin-top30">
        	    Contanos si preferis:
        	</p>
        
        	<div class="opcionesDevolucionEntrega">
        	
        		
        		<div class="sprite radio small Merriweather fleft selected">
        			<input id="devoluciones_entrega_OCA" type="radio" value="OCA" checked="checked" name="devoluciones[entrega]" />
        		</div>
        		<label for="devoluciones_entrega_OCA" class="fleft radioLabel">DELUXEBUYS RETIRA EL PRODUCTO EN TU DOMICILIO</label>
        
        		
        		<p id="oca_aclaracion" class="advertisment fleft"></p>
        		<div class="clear margin-bottom30"></div>
            	<div class="direccionEntrega">
            		<fieldset class="deluxeFormFieldset devoluciones3">
            			<dl>
                            <dt><label for="nombre">Nombre</label></dt>
                            <dd><?php echo $form['nombre']; ?></dd>
                            <dt><label for="apellido">Apellido</label></dt>
                            <dd><?php echo $form['apellido']; ?></dd>
                            <dt><label for="calle">Calle</label></dt>
                            <dd><?php echo $form['calle']; ?></dd>
                            <dt><label for="numero">Numero</label></dt>
                            <dd><?php echo $form['numero']; ?></dd>
                            <dt><label for="piso">Piso</label></dt>
                            <dd><?php echo $form['piso']; ?></dd>
                            <dt><label for="dpto">Departamento</label></dt>
                            <dd><?php echo $form['dpto']; ?></dd>
                            <dt><label for="id_provincia">Provincia</label></dt>
                            <dd>
                                <div class="customSelect">
                                <?php echo $form['id_provincia']; ?>
                                </div>
                            </dd>
                            <dt><label for="localidad">Localidad</label></dt>
                            <dd><?php echo $form['localidad']; ?></dd>
                            <dt><label for="codigo_postal">Codigo Postal</label></dt>
                            <dd><?php echo $form['codigo_postal']; ?></dd>
            			</dl>
            			
            			<div class="costoEnvio margin-top30 margin-bottom30 left" id="oca">
            			    COSTO DE ENVíO $ <span></span>
            			</div>
            			
            		</fieldset>
            	</div>
            	
            	<div class="error"></div>
            	
                <div class="center margin-top30 clear-both">
                	<input type="button" class="formInputSubmit formInputButton inline buttonAnterior" value="ANTERIOR" />
                	<input type="button" class="formInputSubmit formInputButton inline buttonSiguiente" value="SIGUIENTE" />
                </div>
            	
            </div>
                
        </div>
        
        <div id="paso-4" class="hide">
            <p class="margin-top30">
            	Verificá los productos y opciones de devolución y confirma para finalizar.
            </p>
            
            <div class="listProductItems devoluciones margin-top30">
            </div>
            
            <p class="margin-left15 margin-top15 margin-left15">
            	Opciones de devolución:
            </p>
            
            <ul class="leyenda"></ul>
            
            <div class="center margin-top30 clear-both">
            	<input type="button" class="formInputSubmit formInputButton inline buttonAnterior" value="ANTERIOR" />
            	<input type="submit" class="formInputSubmit formInputButton inline" value="CONFIRMAR" />
            </div>
        </div>
                
    </form>
    
    <?php else: ?>
    <div id="devoluciones_ok">
        <?php if ($procesado == 'ok'): ?>
        <p>
        	Se ha iniciado el proceso de devolución.
        	<br/>
        	A la brevedad estarás recibiendo un e-mail con los pasos a seguir.			
        </p>
        <?php else: ?>
        <p>
        	Hubo un problema en el proceso de devolución
        	<br/>
        	por favor intentalo nuevamente.			
        </p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<div id="devoluciones_historial">

	<table>
		<tr>
			<th width="105px">Fecha</th>
			<th>Productos</th>
			<th width="105px">Estado</th>
			<th width="60px">Monto</th>
		</tr>
		<?php foreach($historial as $devolucion): ?>
		<tr>
			<td><?php echo $devolucion->getDateTimeObject('fecha')->format("d/m/Y"); ?></td>
			<td>
			<?php foreach($devolucion->getDevolucionProductoItem() as $devolucionProductoItem): ?>
			
			<?php $pedidoProductoItem = $devolucionProductoItem->getPedidoProductoItem(); ?>
			<?php $productoItem = $pedidoProductoItem->getProductoItem(); ?>
			
			<?php $talle = $productoItem->getProductoTalle()->getDenominacion(); ?>
			<?php $color = $productoItem->getProductoColor()->getDenominacion(); ?>
			<?php $denominacion = $productoItem->getProducto()->getDenominacion(); ?>
			
			<?php echo $denominacion ?>
			<br/>
			<?php echo $talle; ?> / <?php echo $color; ?>
			
			<?php endforeach; ?>
			</td>
			<td>																
				<?php if ( $devolucion->getFechaCierre() ): ?>
				Finalizado
				<?php else: ?>
					<?php if ( $devolucion->getFechaRecibido() ): ?>
					Recibido
					<?php else: ?>
					No Recibido
					<?php endif; ?>
				<?php endif; ?>
			</td>
			<td>
                <?php if ( $devolucion->getMontoTotal() ): ?>
                $ <?php echo formatHelper::getInstance()->decimalNumber( $devolucion->getMontoTotal() ); ?>
                <?php else: ?>
                $ <?php echo formatHelper::getInstance()->decimalNumber( $devolucion->calcularMontoTotal() ); ?>
                <?php endif; ?>			
			</td>
		</tr>
		<tr>
			<td colspan="4">
			    <div class="separator"></div>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	
</div>

<script>
    var outlet = <?php echo html_entity_decode($outlet); ?>;
    var idCategorias = <?php echo html_entity_decode($idCategorias); ?>;
    var idCategoriasRestringidas = <?php echo $idCategoriasRestringidas ?>;
    var mensajeCategoriasRestringidas = '<?php echo $mensajeCategoriasRestringidas ?>';
</script>