<?php include_partial('notificacionHeader', array('notificacionBackend' => $notificacionBackend)); ?>

<?php if ( !$data['errores'] ): ?>
<p class="ok">
    Todos los productos seleccionados fueron quitados del outlet correctamente.
</p>
<?php else: ?>
<p class="ko">
    De los <?php echo count ( $data['detalle'] ); ?> productos seleccionados:
    <br /><br />    
    &nbsp;&nbsp;&nbsp;- <?php echo $data['ok'] ?> <?php echo ngettext("producto se quito", "productos se quitaron", $data['ok']) ?> del outlet correctamente
    <br />
    &nbsp;&nbsp;&nbsp;- <?php echo $data['errores']; ?> <?php echo ngettext("no pudo", "no pudieron", $data['errores']) ?> quitarse al outlet (Ver detalles en el siguente listado).
    
</p>
<?php endif; ?>

<table>
    <tr>
        <th>Nombre</th>
        <th>Marca</th>
        <th>Imagen</th>
        <th>Precio Lista</th>
        <th>Precio Normal</th>
        <th>Costo</th>
        <th>Resultado</th>
    </tr>
    <?php foreach ($productos as $producto):?>
    <tr>
        <td><?php echo $producto->getDenominacion(); ?></td>
        <td><?php echo $producto->getMarca()->getNombre(); ?></td>
        <td><img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px"></td>
        <td><?php echo $producto->getPrecioLista(); ?></td>
        <td><?php echo $producto->getPrecioNormal(); ?></td>
        <td><?php echo $producto->getCosto(); ?></td>
        <td>
            <?php if ( $data['detalle'][ $producto->getIdProducto() ] ): ?>
            <span class="verde">El producto fue enviado a outlet</span>
            <?php else: ?>
            <span class="rojo">El producto no fue enviado a outlet pues<br /> el precio normal es menor o igual a $0</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include_partial('notificacionFooter', array('notificacionBackend' => $notificacionBackend)); ?>