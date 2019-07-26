	<?php sfContext::getInstance()->getResponse()->setTitle($eshop->getMiCarroTitulo() . ' - Paso 1'); ?>
	
    <section id="checkout_carrito" class="seccion blanco paso1">
		<div class="titulo"><?php echo strtoupper( $eshop->getMiCarroTitulo() ); ?></div>

        <table class="tableCarrito">
            <thead class="headerCarrito">
                <tr>
                    <th class="carritoCol1y2" colspan="2">MIS PRODUCTOS</th>
                    <th class="carritoCol3">CANT.</th>
                    <th class="carritoCol4">PRECIO</th>
                    <th class="carritoCol5">&nbsp;</th>
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
                            <div class="customSelect">
                                <select>
                                    <?php $c = $carritoProductoItem->getProductoItem()->getMyCurrentStock(); ?>
                                    <?php for( $i = 1 ; $i <= $c ; $i++ ):?>
                                    <?php $selected = ($i == $carritoProductoItem->getCantidad())? 'selected="selected"' : ''; ?>
                                    <option <?php echo $selected ?> value="<?php echo $i; ?>"><?php echo sprintf('%02d', $i); ?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td class="carritoCol4 precio total">
                        $<?php echo formatHelper::getInstance()->decimalNumber($carritoProductoItem->getSubTotal()) ?>.-
                        <div class="alert hide"></div>
                    </td>
                    <td class="carritoCol5 eliminar"></td>
                </tr>
                <?php $total += $carritoProductoItem->getSubTotal(); ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" id="generalError" class="hide"></td>
                </tr>
            </tbody>
            <tfoot class="footerCarrito">
                <tr class="totales checkoutSubTotal">
                    <td class="carritoCol1">&nbsp;</td>
                    <td colspan="2" class="carritoCol2y3"><span class="bold">SUBTOTAL</span><br />SIN GASTOS DE ENVÍO</td>
                    <td colspan="2" class="precio total carritoCol4y5">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?>.-</td>
                </tr>
                <tr class="botonera">
                    <td class="carritoCol1y2" colspan="2"><a href="<?php echo url_for('productos_listado'); ?>" class="btSeguirComprando">< SEGUIR COMPRANDO</a></td>
                    <td class="carritoCol3y4y5" colspan="3"><a id="goToPaso2" href="<?php echo url_for('carrito_paso_2'); ?>" class="btContinuar">CONTINUAR</a></td>
                </tr>
            </tfoot>
        </table>
    </section>