    <?php sfContext::getInstance()->getResponse()->setTitle('Mi Carrito - Paso 3'); ?>


<div id="checkout_carrito" class="paso3">

    <div class="blank">

            <?php include_partial('carritoHeader', array('paso' => 3)); ?>

            <div class="clear"></div>
        <div class="checkoutDescription">
            <div class="sprite ico ticketBill"></div>
            <p>
                <span class="bold">DETALLE COMPLETO DE LA COMPRA.</span> ESTOS SON LOS PRODUCTOS QUE DESEA COMPRAR:
                    
                    <?php if ($tieneOfertas):?>
                    <span class="black"> RECORDA QUE EL PEDIDO SE ENVIARA LUEGO
                    DE LOS 10 DÍAS TERMINADA LA CAMPAÑA </span> 
                    <?php endif; ?>
                </p>
        </div>

        <div class="listProductItems checkout">

            <div class="hide" id="generalError"></div>
            
                <?php $total = 0; ?>
                <?php foreach ($carritoProductoItems as $carritoProductoItem): ?>
                <div class="item"
                id="carritoProductoItem_<?php echo $carritoProductoItem->getIdCarritoProductoItem() ?>">

                <a
                    href="<?php echo $carritoProductoItem->getProductoItem()->getProducto()->getDetalleUrl(); ?>">
                    <img
                    src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $carritoProductoItem->getProductoItem()->getProducto() )?>"
                    alt="<?php echo $carritoProductoItem->getProductoItem()->getProducto()->getDenominacion() ?>" />
                </a>

                <div class="producto">
                    <h3 class="Raleway">PRODUCTO</h3>
                    <h2 class="Raleway"><?php echo $carritoProductoItem->getProductoItem()->getProducto()->getDenominacion() ?></h2>
                    <p class="pink">
                            TALLE <?php echo $carritoProductoItem->getProductoItem()->getProductoTalle()->getDenominacion() ?>
                            <span>COLOR <?php echo $carritoProductoItem->getProductoItem()->getProductoColor()->getDenominacion() ?></span>
                    </p>
                    <p class="alert hide"></p>
                </div>
                <div class="precioUnidad">
                    <h3 class="Raleway">PRECIO UNIDAD</h3>
                    <h2>$<?php echo formatHelper::getInstance()->decimalNumber( $carritoProductoItem->getProductoItem()->getProducto()->getPrecioDeluxe() ) ?>.-</h2>
                </div>
                <div class="cantidad">
                    <h3 class="Raleway">CANTIDAD</h3>
                    <h2 class="Raleway"><?php echo $carritoProductoItem->getCantidad(); ?></h2>
                </div>
                <div class="valor">
                    <h3 class="Raleway">TOTAL</h3>
                    <h2 class="total">$<?php echo formatHelper::getInstance()->decimalNumber($carritoProductoItem->getSubTotal()) ?>.-</h2>
                </div>
            </div>
                <?php $total += $carritoProductoItem->getSubTotal(); ?>
                <?php endforeach; ?>
                
                
            </div>

    </div>

    <div class="row">
        <label class="Raleway">Subtotal</label>
        <div class="total">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?>.-</div>
    </div>

    <div class="row envio">
        <label class="Raleway">Cargos de Envio</label>
        <p>
            
                <?php if ( $carritoEnvio->getTipo() == carritoEnvio::DOMICILIO ): ?>
                (Envio a domicilio)
                <?php else: ?>
                (Envio a sucursal)
                <?php endif; ?>
                
                <a href="<?php echo url_for('carrito_paso_2') ?>">Modificar</a>
        </p>
        <div class="total">$<?php echo formatHelper::getInstance()->decimalNumber($costoEnvio) ?>.-</div>
    </div>

    <div class="row descuento">
        <label class="Raleway">Descuento</label>

        <div class="field">
                <?php $value = ($carritoDescuento)? $carritoDescuento->getDescuento()->getCodigo() : $codigoDescuentoDefault; ?>
                <input type="text" id="descuento_codigo"
                value="<?php echo $value ?>"
                placeholder="Ingrese Código" /> <a
                class="verificar-descuento show">Verificar</a> <a
                class="eliminar-descuento hide">Eliminar</a>
            <div class="response"></div>
        </div>

        <div class="promo-datos-adicionales">
                <?php $infoAdicional = ($carritoDescuento)? $carritoDescuento->getArrayInfoAdicional() : array(); ?>
                
                <div class="field promo">
                <input type="text" placeholder="Nº de credencial"
                    id="descuento_promo_numero" maxlength="19"
                    value="<?php echo ( isset($infoAdicional['numero']) ) ? $infoAdicional['numero'] : ''; ?>" />
                <div class="response"></div>
            </div>

            <div class="field promo">
                <input type="text"
                    placeholder="Nombre y apellido del socio"
                    id="descuento_promo_socio"
                    value="<?php echo ( isset($infoAdicional['socio']) ) ? $infoAdicional['socio'] : ''; ?>" />
                <div class="response"></div>
            </div>
        </div>

        <div class="total">$0,00</div>
    </div>
        
                
        <?php if ( count($bonificaciones) ): ?>
        <div class="row bonificacion">
        <label class="Raleway">Bonificaciones</label>

        <div class="field">
            <div class="customSelect">
                <select type="text">
                    <option value=""></option>
                        <?php foreach ($bonificaciones as $bonificacion):?>
                        <?php $selected = ($carritoBonificacion && $carritoBonificacion->getIdBonificacion() == $bonificacion->getIdBonificacion() )? 'selected="selected"' : '' ?>
                        <option <?php echo $selected ?>
                        value="<?php echo $bonificacion->getIdBonificacion() ?>"><?php echo $bonificacion->getFormateada() ?></option>
                        <?php endforeach; ?>
                    </select>
            </div>
        </div>

        <div class="total">$0,00</div>
    </div>
        <?php endif; ?>
        
        <div class="checkoutTotal">

        <div class="sprite yellowBgFlag fright">
            <span class="total">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?></span>
        </div>
    </div>

    <form method="post">
        
            <?php echo $form['_csrf_token']; ?>
            
            <div class="formaPago">

                <h2>Elegí como pagar tus productos</h2>


                <?php $fecha = date('Ymd'); ?>
                
                <div class="containerOption">
                    <div class="option">
                        <div class="sprite radio pink selected">
                            <input style="position: relative; top: -22px;"
                                type="radio" name="paso3[tipoPago]"
                                id="paso3_tipoPago_MP" value="MP"
                                checked="checked">
                        </div>
                        <label class="radioLabel" for="paso3_tipoPago_MP"> <img
                            src="<?php echo sfConfig::get('app_host_static'); ?>/images/CAPMP.jpg?v=<?php cacheHelper::getInstance()->getStaticVersion(); ?>" />
                        </label>
                    </div>
                </div>

                <?php foreach ($promosPago as $promoPago): ?>
                <div class="containerOption">
                    <div class="option">
                        <div class="sprite radio pink">
                            <input style="position: relative; top: -22px;"
                                type="radio" name="paso3[tipoPago]"
                                id="paso3_tipoPago_<?php echo $promoPago->getIdPromoPago() ?>" value="<?php echo $promoPago->getIdPromoPago() ?>">
                        </div>
                        <label class="radioLabel" for="paso3_tipoPago_<?php echo $promoPago->getIdPromoPago() ?>">
                            <img src="<?php echo imageHelper::getInstance()->getUrl('promo_pago_imagen', $promoPago)?>?v=<?php cacheHelper::getInstance()->getStaticVersion(); ?>" />
                        </label>
                    </div>

                    <?php $cuotas = explode(',', $promoPago->getCuotas()); ?>

                    <?php if ( count( $cuotas ) > 1 ): ?>
                    <div class="selectorCuotas hide">
                        <div class="row cuotas">
                            <label>Nº de Cuotas</label>
                            <div class="customSelect">
                                <select name="paso3[cuotas][<?php echo $promoPago->getIdPromoPago() ?>]">
                                    <?php foreach ($cuotas as $cuota): ?>
                                    <option><?php echo $cuota; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row porCuota">
                            <label>Monto por Cuota</label>
                            <div class="input">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?></div>
                        </div>
                        <div class="row total">
                            <label>Total</label>
                            <div class="input">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
                <?php endforeach; ?>
                                                    
            </div>



        <div class="datos-adicionales">
            <p>Para pedidos mayores a $1000 necesitamos que indiques un
                documento:</p>
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
            
            
            <?php if ($mostrarAlertaRopaInterior): ?>
            <div class="rojo">
                <?php echo $mensajeCategoriasRestringidas ?>
            </div>
            <?php elseif ( $tieneOutlet ): ?>
            <div class="rojo">
                Los productos del outlet, no tienen cambio ni devolución exceptuando fallas.
            </div>
            <?php endif; ?>        
            
    
            <div class="checkoutButton">
            <input class="Raleway sprite" type="submit" value="" onclick="ga('send', 'event', 'boton', 'intencion de compra', 'mercadopago');"/>
        </div>

    </form>

    <div class="bannerBottom">
        <img src="<?php echo $bannerAlPie->getImage(); ?>" />
    </div>

</div>


<?php include_partial('global/tagsRemarketing', array('itemId1' => 'Carrito - Paso 3', 'pageType' => 'conversionintent')); ?>