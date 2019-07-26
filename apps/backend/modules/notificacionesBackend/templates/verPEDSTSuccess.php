<?php include_partial('notificacionHeader', array('notificacionBackend' => $notificacionBackend)); ?>

<p class="ok">
    La edicion masiva de stocks finalizó correctamente, con el siguiente resultado:
</p>

<?php foreach ($productos as $producto):?>
<div class="producto">
	<h2><?php echo $producto->getDenominacion(); ?></h2>
	
	<p><strong>Es Outlet:</strong> <?php echo ( $producto->getEsOutlet() ) ? 'Si' : 'No'; ?></p>
	

    <table>
        <tr>
            <th>Imagen</th>
            <th>Código</th>
            <th>Id Producto Item</th>
            <th>Talle</th>
            <th>Color</th>
            <th>Stk. en<br/>Perm</th>
            <th>Stk. en<br/>Campañas</th>
            <th>Stk. en<br/>Refuerzo</th>
        </tr>
        <?php $productoItems = $producto->getProductoItem(); ?>
        <?php foreach ($productoItems as $productoItem):?>
        <tr>
            <td><img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px"></td>
            <td class="center"><?php echo $productoItem->getCodigo(); ?></td>
    		<td class="center"><?php echo $productoItem->getIdProductoItem(); ?></td>
    		<td class="center"><?php echo $productoItem->getProductoTalle(); ?></td>
    		<td class="center"><?php echo $productoItem->getProductoColor(); ?></td>
            <td class="center"><?php echo $productoItem->getStockPermanente(); ?></td>
            <td class="center"><?php echo $productoItem->getStockCampana(); ?></td>
            <td class="center"><?php echo $productoItem->getStockRefuerzo(); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endforeach; ?>

<?php include_partial('notificacionFooter', array('notificacionBackend' => $notificacionBackend)); ?>