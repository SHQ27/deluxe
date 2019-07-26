	<?php sfContext::getInstance()->getResponse()->setTitle($eshop->getMiCarroTitulo() . ' - Paso 3'); ?>
	
    <section id="checkout_carrito" class="seccion blanco paso3">
    	<div class="container">

            <?php $img = imageHelper::getInstance()->getUrl('eshop_medios_pagos_carrito', $eshop); ?>
            <?php if ( imageHelper::getInstance()->exists( $img ) ): ?>
            <div class="banner-medios-pagos">
                <img src="<?php echo $img; ?>" />
            </div>
            <?php endif; ?>
        
    		<div class="linea"><div class="triangulos"></div></div>
    		<div class="pantalla">

    		    <?php include_partial('carritoHeader', array('paso' => 3, 'eshop' => $eshop)); ?>
    			
    			<div class="barra">
    				<div class="header MS-13 color4 inline c1">
    					MIS PRODUCTOS
    				</div><div class="header MS-13 color4 inline c2">
    					PRECIO UNITARIO
    				</div><div class="header MS-13 color4 inline c3">
    					CANTIDAD
    				</div><div class="header MS-13 color4 inline c4">
    					SUBTOTAL
    				</div>
    			</div>
    			<div class="items">    			
                    <?php $total = 0; ?>
                    <?php foreach ($carritoProductoItems as $carritoProductoItem): ?>
                    <div class="item" id="carritoProductoItem_<?php echo $carritoProductoItem->getIdCarritoProductoItem() ?>">
    					<div class="columna c1 inline">
    						<div class="foto inline">
    						  <img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $carritoProductoItem->getProductoItem()->getProducto() )?>" alt="<?php echo $carritoProductoItem->getProductoItem()->getProducto()->getDenominacion() ?>" />
    						</div>
    						<div class="inline datos">
    							<div class="nombre MS-18 color1"><?php echo truncate_text( $carritoProductoItem->getProductoItem()->getProducto()->getDenominacion(), 25 ) ?></div>
    							<div class="OS-11 color1 lh18">TALLE. <?php echo $carritoProductoItem->getProductoItem()->getProductoTalle()->getDenominacion() ?></div>
    							<div class="OS-11 color2 lh18">COLOR. <?php echo $carritoProductoItem->getProductoItem()->getProductoColor()->getDenominacion() ?></div>
    						</div>
    					</div>
					    <div class="columna c2 inline">
    					   <div class="unitario MS-18 color1">$<?php echo formatHelper::getInstance()->decimalNumber( $carritoProductoItem->getProductoItem()->getProducto()->getPrecioDeluxe() ) ?>.-</div>
    					</div>
    					<div class="columna c3 inline">
    					   <div class="cantidad OS-11 color2 lh16"><?php echo $carritoProductoItem->getCantidad(); ?></div>
    					</div>
    					<div class="columna c4 inline">
    					   <div class="subtotal MS-18 color8 total">$<?php echo formatHelper::getInstance()->decimalNumber($carritoProductoItem->getSubTotal()) ?>.-</div>
    					</div>
                    </div>
                    <?php $total += $carritoProductoItem->getSubTotal(); ?>
            		<?php endforeach; ?>
    			
    			</div>
    			
    			<div class="renglones">
    				<div class="renglon MS-13 color4 lh18">
    					SUBTOTAL
    					<span class="importe MS-18 color8 total">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?>.-</span>
    				</div>
    				<div class="renglon MS-13 color4 lh18 envio">
    					CARGOS DE ENVIO
    					<div class="detalle inline OS-11 color2">
                		    <?php if ( $carritoEnvio->getTipo() == carritoEnvio::DOMICILIO ): ?>
                		    (ENVIO A DOMICILIO)
                		    <?php else: ?>
                		    (ENVIO A SUCURSAL)
                		    <?php endif; ?>
    						
    						<div class="divisorV inline"></div>
    						<a href="<?php echo url_for('carrito_paso_2') ?>" class="OS-11 color8 bold">MODIFICAR</a>
    					</div>
    					<span class="importe MS-18 color8 total">$<?php echo formatHelper::getInstance()->decimalNumber($costoEnvio) ?>.-</span>
    				</div>
    				
    				<div class="renglon MS-13 color4 lh18 descuento">
    					DESCUENTO
    					<div class="detalle inline OS-11 color2">
    					    <?php $value = ($carritoDescuento)? $carritoDescuento->getDescuento()->getCodigo() : $codigoDescuentoDefault; ?>
    						<input type="text" id="descuento_codigo" class="OS-12 color4" value="<?php echo $value ?>" placeholder="Ingrese Código"/>
    						<div class="divisorV inline"></div>
    						<a class="OS-11 color8 bold verificar-descuento">VERIFICAR</a>
    						<a class="OS-11 color8 bold eliminar-descuento">ELIMINAR</a>
    						<div class="response"></div>
    					</div>
    					<span class="importe MS-18 color13 total">($0,00).-</span>    					
    				</div>
    				
                	<div class="renglon MS-13 color4 lh18 promo-datos-adicionales">
                    	<?php $infoAdicional = ($carritoDescuento)? $carritoDescuento->getArrayInfoAdicional() : array(); ?>
                    	
    					<div class="detalle inline OS-11 color2">
    					    <?php $value = ($carritoDescuento)? $carritoDescuento->getDescuento()->getCodigo() : ''; ?>
    						<input type="text" placeholder="Nº de credencial" id="descuento_promo_numero" maxlength="19" value="<?php echo ( isset($infoAdicional['numero']) ) ? $infoAdicional['numero'] : ''; ?>" class="OS-12 color4"/>
    						<div class="response inline rojo"></div>
    					</div>
    					
    					<div class="detalle inline OS-11 color2">
    					    <?php $value = ($carritoDescuento)? $carritoDescuento->getDescuento()->getCodigo() : ''; ?>
    						<input type="text" placeholder="Nombre y apellido del socio" id="descuento_promo_socio" value="<?php echo ( isset($infoAdicional['socio']) ) ? $infoAdicional['socio'] : ''; ?>" class="OS-12 color4"/>
    						<div class="response inline rojo"></div>
    					</div>
                	</div>
				    				
    				
    				<div class="renglon alto MS-13 color4 lh18 checkoutTotal">
    					<span class="MS-24 color8 total">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?>.-</span>
    					
    				</div>
    			</div>
    			
    			<div class="barra">
    				<div class="header MS-13 color4 inline c1">
    					ELEGÍ COMO PAGAR TUS PRODUCTOS
    				</div>
    			</div>
    			
      
                <form method="post">
                
                	<?php echo $form['_csrf_token']; ?>

                    <?php $fecha = date('Ymd'); ?>
                    <?php $ocultarMP = false; ?>
                    <?php $ocultarMP = $eshop->getIdEshop() == '10' && $fecha <= '20161201'; ?>
                    
                    <?php if ( !$ocultarMP ): ?>
                    <div class="opciones">
                        <div class="opcion">
                            <div class="radio selected opcPago">
                                <input type="radio" name="paso3[tipoPago]" id="paso3_tipoPago_MP" value="MP" checked="checked">
                            </div>
                            <label class="radioLabel" for='paso3_tipoPago_MP'>
                                <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/CAPMP.jpg?v=<?php cacheHelper::getInstance()->getStaticVersion(); ?>" />
                            </label>
                        </div>
                    </div>
                    <?php else: ?>
                        <script>
                        $(document).ready( function() { $(".opciones input").first().click(); } );
                        </script>
                    <?php endif; ?>
                    

                    <?php foreach ($promosPago as $promoPago): ?>
                    <div class="opciones">
                        <div class="opcion">
                            <div class="radio opcPago">
                                <input type="radio" name="paso3[tipoPago]" id="paso3_tipoPago_<?php echo $promoPago->getIdPromoPago() ?>" value="<?php echo $promoPago->getIdPromoPago() ?>">
                            </div>
                            <label class="radioLabel" for='paso3_tipoPago_<?php echo $promoPago->getIdPromoPago() ?>'>
                                <img src="<?php echo imageHelper::getInstance()->getUrl('promo_pago_imagen', $promoPago)?>?v=<?php cacheHelper::getInstance()->getStaticVersion(); ?>" />
                            </label>
                        </div>


                        <?php $cuotas = explode(',', $promoPago->getCuotas()); ?>

                        <?php if ( count( $cuotas ) > 1 ): ?>
                        <div class="selectorCuotas hide">
                            <div class="row cuotas">
                                <label class="color4">Nº de Cuotas</label>
                                <div class="customSelect">
                                    <select name="paso3[cuotas][<?php echo $promoPago->getIdPromoPago() ?>]">
                                        <?php foreach ($cuotas as $cuota): ?>
                                        <option><?php echo $cuota; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row porCuota">
                                <label class="color4">Monto por Cuota</label>
                                <div class="input color8">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?></div>
                            </div>
                            <div class="row total">
                                <label class="color4">Total</label>
                                <div class="input color8">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                    <?php endforeach; ?>
                    

        			
        			<div class="datos-adicionales">
        			    <div class="barra">
                            <div class="header MS-13 color4 inline">
            					PARA PEDIDOS MAYORES A $1000 NECESITAMOS QUE INDIQUES UN DOCUMENTO:
            				</div>
        				</div>
        				
        				<div class="renglon MS-13 color4 lh18">
                    	    <div class="customSelect">
            	        	<?php echo $form['tipoDocumento']; ?>
            	        	</div>
            	        	
            	        	<?php echo $form['documento']; ?>
            	        	<?php echo $form['montoTotal']; ?>
            	        	
                    		<?php if ($form['documento']->getError()): ?>
                    		<div class="error inline rojo">
                    		  <?php echo $form['documento']->getError(); ?>
                    		</div>
                    		<?php elseif ($form->hasGlobalErrors()): ?>
                    		<div class="error inline rojo">
                    		  <?php $error = str_replace( 'documento [', '', $form->getErrorSchema() ); ?>
                    		  <?php echo str_replace( ']', '', $error ); ?>
                    		  <?php echo str_replace( 'Este campo es obligatorio', '', $error ); ?>
                    		</div>
                    		<?php endif; ?>
                    		
        				</div>

        		    </div>
        		    
                    <?php if ($mostrarAlertaRopaInterior): ?>
                    <div class="rojo">
                        <?php echo $mensajeCategoriasRestringidas ?>
                    </div>
                    <?php elseif ( $tieneOutlet ): ?>
                    <div class="rojo">
                        Los productos del outlet, no tienen cambio ni devolución exceptuando fallas.
                    </div>
                    <?php endif; ?>        
                			
        			<div class="renglones buttons">
        			    <div class="renglon alto ancho dotted" >
        			    </div>
        				<div class="renglon alto ancho dotted MS-13 color4 lh18 submitContainer" >
        					<div class="inline floatR">
        						<input class="btOscuro btComprar MS-15 bold color7 lh16" type="submit" value="COMPRAR"/>
        					</div>
        				</div>
        			</div>

    			</form>
    			
    		</div>
    	</div>
    </section>
    <div class="scrollToTop"></div>