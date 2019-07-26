	<?php sfContext::getInstance()->getResponse()->setTitle($eshop->getMiCarroTitulo() . ' - Paso 3'); ?>
	
    <section id="checkout_carrito" class="seccion blanco paso3">
        <div class="titulo"><?php echo strtoupper( $eshop->getMiCarroTitulo() ); ?></div>

        <table class="tableCarrito">
            <thead class="headerCarrito">
                <tr>
                    <th class="carritoCol1y2" colspan="2">MIS PRODUCTOS</th>
                    <th class="carritoCol3">CANT.</th>
                    <th class="carritoCol4">PRECIO</th>
                </tr>
            </thead>
            <tbody class="itemsCarrito">
                <?php $total = 0; ?>
                <?php foreach ($carritoProductoItems as $carritoProductoItem): ?>
                <tr class="item" id="carritoProductoItem_<?php echo $carritoProductoItem->getIdCarritoProductoItem() ?>">
                    <td class="carritoCol1 foto">
                        <img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $carritoProductoItem->getProductoItem()->getProducto() )?>" alt="<?php echo $carritoProductoItem->getProductoItem()->getProducto()->getDenominacion() ?>" width="100%" />
                    </td>
                    <td class="carritoCol2 datos">
                        <div class="nombre"><?php echo truncate_text( $carritoProductoItem->getProductoItem()->getProducto()->getDenominacion(), 30 ) ?></div>
                        <div class="talle">TALLE. <?php echo $carritoProductoItem->getProductoItem()->getProductoTalle()->getDenominacion() ?></div>
                        <div class="color">COLOR. <?php echo $carritoProductoItem->getProductoItem()->getProductoColor()->getDenominacion() ?></div>
                    </td>
                    <td class="carritoCol3">
                        <div class="cantidad">
                            <?php echo $carritoProductoItem->getCantidad(); ?>
                        </div>
                    </td>
                    <td class="carritoCol4 precio total">
                        $<?php echo formatHelper::getInstance()->decimalNumber($carritoProductoItem->getSubTotal()) ?>.-
                        <div class="alert hide"></div>
                    </td>
                </tr>
                <?php $total += $carritoProductoItem->getSubTotal(); ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="footerCarrito">
                <tr class="totales checkoutSubTotal">
                    <td colspan="3" class="carritoCol1y2y3"><span class="bold">SUBTOTAL</span></td>
                    <td class="precio total carritoCol4">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?>.-</td>
                </tr>
                <tr class="totales checkoutSubTotal envio">
                    <td colspan="3" class="carritoCol1y2y3">
                        <span class="bold">CARGOS DE ENVIO</span>
                        <div class="detalle">
                            <?php if ( $carritoEnvio->getTipo() == carritoEnvio::DOMICILIO ): ?>
                            (ENVIO A DOMICILIO)
                            <?php else: ?>
                            (ENVIO A SUCURSAL)
                            <?php endif; ?>
                            
                            <br /><br />
                            <a href="<?php echo url_for('carrito_paso_2') ?>" class="bold">MODIFICAR</a>
                        </div>
                    </td>
                    <td class="precio total carritoCol4">$<?php echo formatHelper::getInstance()->decimalNumber($costoEnvio) ?>.-</td>
                </tr>
                <tr class="totales checkoutSubTotal descuento">
                    <td colspan="3" class="carritoCol1y2y3">
                        <span class="bold">DESCUENTO</span>
                        <div class="detalle">
                            <?php $value = ($carritoDescuento)? $carritoDescuento->getDescuento()->getCodigo() : ''; ?>
                            <input type="text" id="descuento_codigo" value="<?php echo $value ?>" placeholder="Ingrese Código"/>
                            <br /><br />
                            <a class="bold verificar-descuento">VERIFICAR</a>
                            
                            <a class="bold eliminar-descuento"><div class="divisorV inline"></div>ELIMINAR</a>
                            <div class="response"></div>
                        </div>
                    </td>
                    <td class="precio total carritoCol4">($0,00).-</td>
                </tr>
                <tr class="totales checkoutSubTotal promo-datos-adicionales">
                    <td colspan="4">
                        <?php $infoAdicional = ($carritoDescuento)? $carritoDescuento->getArrayInfoAdicional() : array(); ?>

                        <div class="detalle">
                            <?php $value = ($carritoDescuento)? $carritoDescuento->getDescuento()->getCodigo() : ''; ?>
                            <input type="text" placeholder="Nº de credencial" id="descuento_promo_numero" maxlength="19" value="<?php echo ( isset($infoAdicional['numero']) ) ? $infoAdicional['numero'] : ''; ?>" class="OS-12 color4"/>
                            <div class="response inline rojo"></div>
                        </div>
                        <br />
                        <div class="detalle">
                            <?php $value = ($carritoDescuento)? $carritoDescuento->getDescuento()->getCodigo() : ''; ?>
                            <input type="text" placeholder="Nombre y apellido del socio" id="descuento_promo_socio" value="<?php echo ( isset($infoAdicional['socio']) ) ? $infoAdicional['socio'] : ''; ?>" class="OS-12 color4"/>
                            <div class="response inline rojo"></div>
                        </div>
                    </td>
                </tr>
                <tr class="totales checkoutTotal">
                    <td colspan="3" class="carritoCol1y2y3"><span class="bold">TOTAL</span></td>
                    <td class="precio total carritoCol4">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?>.-</td>
                </tr>
            </tfoot>
        </table>

        <div class="barra">
            <div class="header">
                ELEGÍ COMO PAGAR TUS PRODUCTOS
            </div>
        </div>

        <form method="post">
        
            <?php echo $form['_csrf_token']; ?>

            <?php $fecha = date('Ymd'); ?>
            
            <?php $ocultarMP = $eshop->getIdEshop() == '10' && $fecha <= '20161201'; ?>
            
            <?php if ( !$ocultarMP ): ?>
            <div class="opciones">
                <div class="opcion">
                    <div class="radio selected opcPago">
                        <input type="radio" name="paso3[tipoPago]" id="paso3_tipoPago_MP" value="MP" checked="checked">
                    </div>
                    <label class="radioLabel" for='paso3_tipoPago_MP'>
                        <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/mobile/CAPMP.jpg?v=<?php cacheHelper::getInstance()->getStaticVersion(); ?>" width="80%"/>
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
                        <img src="<?php echo imageHelper::getInstance()->getUrl('promo_pago_imagen_mobile', $promoPago)?>?v=<?php cacheHelper::getInstance()->getStaticVersion(); ?>" width="80%" />
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
                    <div class="header">
                        PARA PEDIDOS MAYORES A $1000 NECESITAMOS QUE INDIQUES UN DOCUMENTO:
                    </div>
                </div>
                
                <div class="pedidosMayores">
                    <div class="customSelect">
                    <?php echo $form['tipoDocumento']; ?>
                    </div>
                    
                    <?php echo $form['documento']; ?>
                    <?php echo $form['montoTotal']; ?>
                    
                    <?php if ($form['documento']->getError()): ?>
                    <div class="error">
                      <?php echo $form['documento']->getError(); ?>
                    </div>
                    <?php elseif ($form->hasGlobalErrors()): ?>
                    <div class="error">
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
                    
            <div class="botonera">
                <div class="row">
                    <div class="col21"><a href="<?php echo url_for('productos_listado'); ?>" class="btSeguirComprando">< SEGUIR COMPRANDO</a></div>
                    <div class="col22"><input class="btComprar" type="submit" value="COMPRAR"/></div>
                </div>
            </div>
        
        </form>
    </section>
    <div class="scrollToTop"></div>