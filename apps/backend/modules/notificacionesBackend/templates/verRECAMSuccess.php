<div id="sf_admin_container" class="restaurarStockCampana">
    <h1>
        Se restauro el stock de los siguientes productos de la Campaña "<?php echo $campana->getDenominacion(); ?>" 
    </h1>

    <p class="ok">
        El proceso de restauración finalizó correctamente.
        <br /><br />
        <?php if ( $restaurarRefuerzo ): ?>    
            En esta ocasión elegiste tambien restaurar el stock de refuerzo.
        <?php else: ?>    
            En esta ocasión elegiste NO restaurar el stock de refuerzo.
        <?php endif; ?>
    </p>

    <p>
        Hace <a href="<?php echo url_for('producto_listRestaurarStockCampana'); ?>">click aquí</a> para elegir repetir el proceso con otro set de productos.
    </p>


    
    
    <table>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Id Producto Item</th>
            <th>Talle</th>
            <th>Color</th>
            <th>Stock Restaurado</th>
            <th class="alert"></th>
        </tr>

       <?php foreach( $data as $idProducto => $row ): ?>
        <tr>
            <?php $rowspan = count($row['productoItems']); ?>
            <td rowspan="<?php echo $rowspan; ?>"><?php echo $row['producto']->getCodigo(); ?></td>
            <td rowspan="<?php echo $rowspan; ?>"><a href="/backend/productos/<?php echo $row['producto']->getIdProducto(); ?>/edit" target="_blank"><?php echo $row['producto']->getDenominacion(); ?></a></td>

            <?php $first = true; ?>
            <?php foreach( $row['productoItems'] as $rowItem ): ?>
            <?php $tieneFaltantes = ( in_array( $rowItem['idProductoItem'], $idProductoItemsConFaltantes->getRawValue() ) ); ?>

            <?php if ( !$first ): ?>
            <tr>
            <?php endif; ?>

                <td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> idProductoItem" data-id="<?php echo $rowItem['idProductoItem']; ?>"><?php echo $rowItem['idProductoItem']; ?></td>
                <td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> "><?php echo $rowItem['talle']; ?></td>
                <td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> "><?php echo $rowItem['color']; ?></td>
                <td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> "><?php echo (int) $rowItem['stock']; ?></td>
                <td class="alert">
                <?php if ( $tieneFaltantes ): ?>
                No se va a restauró por haber tenido faltantes en la campaña
                <?php endif; ?>
                </td>
            </tr>
            <?php $first = false; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>

    </table>

</div>