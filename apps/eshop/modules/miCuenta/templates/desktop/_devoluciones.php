<script>
var topPosition = 300;
</script>

<div class="MS-13 subtitulo">
    DEVOLUCION
    <a id="button_historial" class="MS-13 color8 alignright">&gt; VER HISTORIAL DE DEVOLUCIONES</a>
    <a id="button_devolverProducto" class="MS-13 color8 alignright hide">&gt; DEVOLVER UN PRODUCTO</a>
</div>

<div id="devoluciones_main">
    <?php if (!$procesado): ?>

    <div class="steps">
    	<div class="MS-32 color7 step inline selected" rel="1">1</div>
    	<div class="MS-32 color7 step inline" rel="2">2</div>
    	<div class="MS-32 color7 step inline" rel="3">3</div>
    	<div class="MS-32 color7 step inline" rel="4">4</div>
    </div>
    
    <form method="post">
    
        <?php echo $form['_csrf_token'] ?>
    
    
        <div id="paso-1" class="show">
        
    		<div class="OS-11 color4 lh16">
    			Estos son los productos que estan en plazo de devolución (10 días luego de recibido el pedido.
    			<br />
    			Ver <a class="bold italic color4" href="<?php echo url_for('tyc')?>">Política de devoluciones.</a>
    		</div>
        
        	<div class="barra">
        		<div class="MS-13 color4 c1 c inline"></div>
        		<div class="MS-13 color4 c2 c inline">
        			PRODUCTO
        		</div>
        		<div class="MS-13 color4 c3 c inline">
        			CANTIDAD
        		</div>
        		<div class="MS-13 color4 c4 c inline">
        			VALOR
        		</div>
        	</div>
        
        	<div class="items">        	
        		<?php $index = 0; ?>
        		<?php foreach ($pedidoProductoItems as $pedidoProductoItem): ?>
        		<?php $productoItem = $pedidoProductoItem->getProductoItem(); ?>		
        		<?php $producto = $productoItem->getProducto(); ?>
                <div class="item">
        		
        		    <?php echo $form['pedido_producto_item[id]']->render( array( 'name' => 'devoluciones[pedido_producto_item_id][' . $index . ']', 'value' => $pedidoProductoItem->getIdPedidoProductoItem(), 'class' => 'hide' ) ); ?>
        		    
					<div class="columna c1 inline">
						<input type="button" class="checkbox formInputButton avoid-click" value="" rel="<?php echo $index; ?>">
					</div>
					<div class="columna c2 inline">
						<div class="foto inline">
						    <img width="63" src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>" alt="<?php echo $producto->getDenominacion() ?>" />
						</div>
						<div class="inline datos">
							<div class="nombre MS-18 color1" title="<?php echo $producto->getDenominacion(); ?>"><?php echo truncate_text( $producto->getDenominacion(), 18 ) ?></div>
    						<div class="OS-11 color1 lh18">TALLE. <?php echo $productoItem->getProductoTalle()->getDenominacion() ?></div>
    						<div class="OS-11 color2 lh18">COLOR. <?php echo $productoItem->getProductoColor()->getDenominacion() ?></div>
						</div>
					</div>
					<div class="columna c3 inline">
						<div class="cantidad OS-11 color2 lh16" data-peso="<?php echo $producto->getPeso(); ?>">
						    <div class="select customSelect avoid-click">
        					<select class="avoid-click" name="devoluciones[pedido_producto_item_cantidad][<?php echo $index; ?>]">
        						<?php for ($i = 1 ; $i <= $pedidoProductoItem->getCantidad() ; $i++ ): ?>
        						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        						<?php endfor; ?>
        					</select>
        					</div>
						</div>
					</div>
					<div class="columna c4 inline">
						<div class="subtotal MS-18 color8 precio" rel="<?php echo $pedidoProductoItem->getPrecioDeluxe(); ?>">$<?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ); ?></div>
					</div>
                </div>
        		<?php $index++; ?>
        		<?php endforeach; ?>
            </div>
        	
    		<div class="campo OS-11 color2">
    		    <div class="MS-13 color4">MOTIVO DE LA DEVOLUCION</div>
        		<div id="motivo" class="select OS-11 color2">
            		<div class="customSelect "> 
            			<?php echo $form['motivo'] ?>
            		</div>
                    <?php echo $form['motivo_abierto']->render( array( "class" => "OS-12 color4", "placeholder" => 'Describe aquí el motivo de la devolución...' ) ) ?> 
                	<div class="error rojo lh18"></div>
    			</div>
    		</div>
    		<input type="button" value="DEVOLVER" class="btOscuro MS-15 bold color7 buttonDevolver">
	   </div>
	

    	<div id="paso-2" class="hide">
    	    		
    		<div class="preferencia MS-13 color4">
    
        		<div class="radio small">
        			<input id="devoluciones_credito_MP" type="radio" value="MP" name="devoluciones[credito]" />
        		</div>
        		<label for="devoluciones_credito_MP" class="radioLabel">
        		      LA DEVOLUCIÓN SE REALIZARÁ POR MEDIO DE MERCADO PAGO
        		      <br />
        		      <span class="OS-11 lh21">(Ten en cuenta que puede demorar hasta 30 días hábiles en reflejarse en tu resumen)</span>
    		    </label>
    		    
    		</div>
    		
    		<div class="botones">
    			<div id="p2_btAnt" class="btOscuro MS-15 bold color7 inline buttonAnterior">ANTERIOR</div>
    			<div id="p2_btSig" class="btOscuro MS-15 bold color7 inline buttonSiguiente">SIGUIENTE</div>
    		</div>
    	</div>

        
    	<div id="paso-3" class="hide">
    	
    		<div class="preferencia MS-13 color4">		
        		<div class="radio small selected">
        		      <input id="devoluciones_entrega_OCA" type="radio" value="OCA" checked="checked" name="devoluciones[entrega]" />
        		</div>
        		<label for="devoluciones_entrega_OCA" class="radioLabel">
        		      RETIRAREMOS EL PRODUCTO EN TU DOMICILIO
        		      <br />
        		      <span class="OS-11" id="oca_aclaracion"></span>
    		    </label>
    		</div>
    		
    		<div class="form direccionEntrega">
    			<div class="campo MS-13 color4">
    			     NOMBRE
    				<?php echo $form['nombre']->render( array('class' => 'OS-12 color4') ); ?>
    			</div>
    			<div class="campo MS-13 color4">APELLIDO
    				<?php echo $form['apellido']->render( array('class' => 'OS-12 color4') ); ?>
    			</div>
    			<div class="campo medio MS-13 color4 inline">CALLE
    				<?php echo $form['calle']->render( array('class' => 'OS-12 color4') ); ?>
    			</div>
    			<div class="campo chico MS-13 color4 inline">NÚMERO
    				<?php echo $form['numero']->render( array('class' => 'OS-12 color4') ); ?>
    			</div>
    			<div class="campo medio MS-13 color4 inline">PISO
    				<?php echo $form['piso']->render( array('class' => 'OS-12 color4') ); ?>
    			</div>
    			<div class="campo chico MS-13 color4 inline">DEPARTAMENTO
    				<?php echo $form['dpto']->render( array('class' => 'OS-12 color4') ); ?>
    			</div>
    			<div class="campo OS-11 color2"><div class="MS-13 color4">PROVINCIA</div>
    				<div id="provincia" class="select OS-11 color2">
                        <div class="customSelect">
                        <?php echo $form['id_provincia']; ?>
                        </div>
    				</div>
    			</div>
    			<div class="campo MS-13 color4">LOCALIDAD
    				<?php echo $form['localidad']->render( array('class' => 'OS-12 color4') ); ?>
    			</div>
    			<div class="campo MS-13 color4">CÓDIGO POSTAL
    			    <?php echo $form['codigo_postal']->render( array('class' => 'OS-12 color4') ); ?>
    			</div>
    			
    			<div class="MS-15 bold color8 costoEnvio">COSTO DE ENVIO. $<span></span>.-</div>
            	<div class="error rojo lh18"></div>
    		</div>
    		<div class="botones">
    			<div class="btOscuro MS-15 bold color7 inline buttonAnterior">ANTERIOR</div>
    			<div class="btOscuro MS-15 bold color7 inline buttonSiguiente">SIGUIENTE</div>
    		</div>
    	</div>
	
        
        <div id="paso-4" class="hide">
    
    		<div class="OS-11 color4 lh16">
    			Verifica los productos y opciones de devolución elegidos y confirma para finalizar
    		</div>
    		
        	<div class="barra">
        		<div class="MS-13 color4 c1 c inline"></div>
        		<div class="MS-13 color4 c2 c inline">
        			PRODUCTO
        		</div>
        		<div class="MS-13 color4 c3 c inline">
        			CANTIDAD
        		</div>
        		<div class="MS-13 color4 c4 c inline">
        			VALOR
        		</div>
        	</div>
    		            
            <div class="listProductItems">
            </div>
                
    		<div class="resumen">
    			<div class="MS-13 color4 t">RESUMEN DE DEVOLUCIÓN</div>
    			<div class="OS-12 color4 lh19 opciones">
    			     <ul class="leyenda"></ul>
    		    </div>
		    </div>
            
		
    		<div class="botones">
    			<div id="p4_btAnt" class="btOscuro MS-15 bold color7 inline buttonAnterior">ANTERIOR</div>
    			<input type="submit" class="btOscuro MS-15 bold color7 inline" value="CONFIRMAR" />
    		</div>
        </div>
                
    </form>
    
    <?php else: ?>
    <div id="devoluciones_ok">
        <?php if ($procesado == 'ok'): ?>
        <div class="OS-11 color4 lh16 texto">
        	Se ha iniciado el proceso de devolución.
        	<br />
        	A la brevedad estarás recibiendo un e-mail con los pasos a seguir.			
        </div>
        <?php else: ?>
        <div class="OS-11 color4 lh16 texto">
        	Hubo un problema en el proceso de devolución
        	<br />
        	por favor intentalo nuevamente.			
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<div id="devoluciones_historial">

	<div class="barra">
		<div class="MS-13 color4 c1 c inline">
		    FECHA
		</div>
		<div class="MS-13 color4 c2 c inline">
			PRODUCTOS
		</div>
		<div class="MS-13 color4 c3 c inline">
			ESTADO
		</div>
		<div class="MS-13 color4 c4 c inline">
			MONTO
		</div>
	</div>

    <div class="items">	    
    	<?php foreach($historial as $devolucion): ?>
        <div class="item">	    
    		<div class="columna c1 inline OS-11 color2 lh16">
    			<?php echo $devolucion->getDateTimeObject('fecha')->format("d/m/Y"); ?>
    		</div>
    		<div class="columna c2 inline">
    			<?php foreach($devolucion->getDevolucionProductoItem() as $devolucionProductoItem): ?>
    			<?php $pedidoProductoItem = $devolucionProductoItem->getPedidoProductoItem(); ?>
        		<?php $productoItem = $pedidoProductoItem->getProductoItem(); ?>		
        		<?php $producto = $productoItem->getProducto(); ?>
    			<div class="foto inline">
    			    <img width="63" src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>" alt="<?php echo $producto->getDenominacion() ?>" />
    			</div>
    			<div class="inline datos">
    				<div class="nombre MS-18 color1" title="<?php echo $producto->getDenominacion(); ?>"><?php echo truncate_text( $producto->getDenominacion(), 18 ) ?></div>
    				<div class="OS-11 color1 lh18">TALLE. <?php echo $productoItem->getProductoTalle()->getDenominacion() ?></div>
    				<div class="OS-11 color2 lh18">COLOR. <?php echo $productoItem->getProductoColor()->getDenominacion() ?></div>
    			</div>
    			<?php endforeach; ?>
    		</div>
    		<div class="columna c3 inline OS-11 color2 lh16">
    			<?php if ( $devolucion->getFechaCierre() ): ?>
    			Finalizado
    			<?php else: ?>
    				<?php if ( $devolucion->getFechaRecibido() ): ?>
    				Recibido
    				<?php else: ?>
    				No Recibido
    				<?php endif; ?>
    			<?php endif; ?>
    		</div>
    		<div class="columna c4 inline">
    			<div class="subtotal MS-18 color8">
                    <?php if ( $devolucion->getMontoTotal() ): ?>
                    $ <?php echo formatHelper::getInstance()->decimalNumber( $devolucion->getMontoTotal() ); ?>
                    <?php else: ?>
                    $ <?php echo formatHelper::getInstance()->decimalNumber( $devolucion->calcularMontoTotal() ); ?>
                    <?php endif; ?>	
    			</div>
    		</div>
        </div>
    	<?php endforeach; ?>
	</div>
</div>

<script>
    var outlet = <?php echo html_entity_decode($outlet); ?>;
    var idCategorias = <?php echo html_entity_decode($idCategorias); ?>;
    var idCategoriasRestringidas = <?php echo $idCategoriasRestringidas ?>;
    var mensajeCategoriasRestringidas = '<?php echo $mensajeCategoriasRestringidas ?>';
</script>