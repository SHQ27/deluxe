<?php include_partial('notificacionHeader', array('notificacionBackend' => $notificacionBackend)); ?>

<?php if ( $status ): ?>
<p class="ok">
    El proceso de asignación finalizo correctamente para la campaña "<?php echo $nombreCampana; ?>".
    <br /><br />
    Asi quedaron los valores modificados:
</p>

<table>
    <?php foreach ($productos as $producto):?>

        <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Código</th>
            <th>Talle</th>
            <th>Color</th>
            <th>Stk. en<br/>Campañas</th>
            <th>Precio Lista</th>
            <th>Precio Normal</th>
            <th>Precio Costo</th>
        </tr>

        <?php $productoItems = $producto->getProductoItem(); ?>
        <?php foreach ($productoItems as $productoItem):?>
        <tr>
            <td><a href="/backend/productos/<?php echo $producto->getIdProducto(); ?>/edit"><img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px"></a></td>
            <td><a href="/backend/productos/<?php echo $producto->getIdProducto(); ?>/edit"><?php echo $producto->getDenominacion(); ?></a></td>
            <td><?php echo $productoItem->getCodigo(); ?></td>
    		<td class="center"><?php echo $productoItem->getProductoTalle(); ?></td>
    		<td class="center"><?php echo $productoItem->getProductoColor(); ?></td>
            <td class="center"><?php echo $productoItem->getStockCampana(); ?></td>
            <td class="center">$<?php echo $producto->getPrecioLista(); ?></td>
            <td class="center">$<?php echo $producto->getPrecioNormal(); ?></td>
            <td class="center">$<?php echo $producto->getCosto(); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td class="border-none" colspan="9"></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php else: ?>

<p class="ko">
    El proceso de asignación para la campaña "<?php echo $nombreCampana; ?>" no se pudo realizar pues el CSV contenía con los siguientes errores
</p>

<table>
    <tr>
        <th></th>
        <th>Error</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach( $errors as $error ): ?>
    <tr>
        <td class="center"><?php echo $i; ?></td>
        <td><?php echo html_entity_decode($error); ?></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
</table>

<?php endif; ?>

<?php include_partial('notificacionFooter', array('notificacionBackend' => $notificacionBackend)); ?>