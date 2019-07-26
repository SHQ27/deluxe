<?php include_partial('notificacionHeader', array('notificacionBackend' => $notificacionBackend)); ?>

<p class="ok">
    La edicion masiva de precios finalizó correctamente, con el siguiente resultado:
</p>


<table>
    <tr>
        <th>Nombre</th>
        <th>Marca</th>
        <th>Imagen</th>
        <th>Precio Lista</th>
        <th>Precio Normal</th>
        <th>Precio Outlet</th>
        <th>Costo</th>
    </tr>
    <?php foreach ($productos as $producto):?>
    <tr>
        <td><?php echo $producto->getDenominacion(); ?></td>
        <td><?php echo $producto->getMarca()->getNombre(); ?></td>
        <td><img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px"></td>
        <td><?php echo $producto->getPrecioLista(); ?></td>
        <td><?php echo $producto->getPrecioNormal(); ?></td>
        <td><?php echo $producto->getPrecioOutlet(); ?></td>
        <td><?php echo $producto->getCosto(); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include_partial('notificacionFooter', array('notificacionBackend' => $notificacionBackend)); ?>