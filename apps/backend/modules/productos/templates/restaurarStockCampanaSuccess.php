<div id="sf_admin_container" class="restaurarStockCampana">
	<h1>
	    Restaurar stock de la Campaña "<?php echo $campana->getDenominacion(); ?>" 
	    (<?php echo $campana->getDateTimeObject('fecha_inicio')->format('d/m/Y'); ?> al <?php echo $campana->getDateTimeObject('fecha_fin')->format('d/m/Y'); ?>)
	    <?php if ( $marca ): ?> 
	    para la marca "<?php echo $marca->getNombre(); ?>"
	    <?php endif; ?>
	    <?php if ( $productoCategoria ): ?> 
	    en la categoria "<?php echo $productoCategoria->getProductoGenero()->getDenominacion(); ?> :: <?php echo $productoCategoria->getDenominacion(); ?>"
	    <?php endif; ?>
    </h1>

    <p>
        <br />
        <strong>ALERTA:</strong>
        <br /><br />
        <strong>Al momento de restaurar stock el stock actual deberia ser 0 en la mayoria de los casos.</strong>
        <br /><br />
        <strong>Asi mismo, en caso de resturar y asignar productos a una campaña, es importnate verificar que los productos no se encuentren anteriormente en una campaña.</strong>
    </p>
	
	<?php if ( count($data) ): ?>
	<table>
	    <tr>
            <th><input class="checkAll" type="checkbox" name="all" checked="checked"></th>
            <th>Código</th>
            <th>Producto</th>
	        <th>Id Producto Item</th>
        	<th>Talle</th>
        	<th>Color</th>
            <th>Diversidad</th>
            <th>Stock Actual</th>
        	<th>Stock de Campana<br/>a restaurar</th>
            <th>Stock de Refuerzo<br/>a restaurar</th>
        	<th class="alert"></th>
	    </tr>

	   <?php foreach( $data as $idProducto => $row ): ?>
        <tr>
            <?php $rowspan = count($row['productoItems']); ?>
            <td rowspan="<?php echo $rowspan ?>"><input class="check" type="checkbox" value="<?php echo $row['producto']->getIdProducto(); ?>" name="ids[]" checked="checked"></td>
            <td rowspan="<?php echo $rowspan; ?>"><?php echo $row['producto']->getCodigo(); ?></td>
            <td rowspan="<?php echo $rowspan; ?>"><a href="/backend/productos/<?php echo $row['producto']->getIdProducto(); ?>/edit" target="_blank"><?php echo $row['producto']->getDenominacion(); ?></a></td>

            <?php $first = true; ?>
            <?php foreach( $row['productoItems'] as $rowItem ): ?>
            <?php $tieneFaltantes = ( in_array( $rowItem['idProductoItem'], $idProductoItemsConFaltantes->getRawValue() ) ); ?>

            <?php if ( !$first ): ?>
            <tr>
            <?php endif; ?>

    	        <td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> idProductoItem idProductoItem-<?php echo $row['producto']->getIdProducto(); ?>" data-id="<?php echo $rowItem['idProductoItem']; ?>" data-idProducto="<?php echo $row['producto']->getIdProducto(); ?>"><?php echo $rowItem['idProductoItem']; ?></td>
            	<td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> "><?php echo $rowItem['talle']; ?></td>
            	<td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> "><?php echo $rowItem['color']; ?></td>
                <td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> <?php echo ( $rowItem['diversidad'] != 'Stock Permanente' ) ? 'warning' : ''; ?> "><?php echo $rowItem['diversidad']; ?></td>
                <td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> <?php echo ( $rowItem['stockActual'] != 0 ) ? 'warning' : ''; ?> "><?php echo $rowItem['stockActual']; ?></td>
            	<td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> "><?php echo (int) $rowItem['stockCampanaARestaurar']; ?></td>
                <td class="center <?php echo ( $tieneFaltantes ) ? 'conFaltante' : ''; ?> "><?php echo (int) $rowItem['stockRefuerzoARestaurar']; ?></td>
            	<td class="alert">
            	<?php if ( $tieneFaltantes ): ?>
            	No se va a restaurar por haber tenido faltantes en esta campaña
            	<?php endif; ?>
            	</td>
    	    </tr>
            <?php $first = false; ?>
            <?php endforeach; ?>
	<?php endforeach; ?>

	</table>
	<?php endif; ?>

	<form action="<?php echo url_for('producto_restaurarStockCampanaMarcaResultado'); ?>" method="POST">
    	<?php if ( count($data) ): ?>
    	
    	    <div style="margin-top: 40px;">
        	    <label>Asignar los productos a:</label>
        	    <select name="asignar">
        	        <option value="">No asignar</option>
        	        <?php foreach ( $campanas as $rowCampana ): ?>    	        
        	        <?php echo $desde = $rowCampana->getDateTimeObject('fecha_inicio')->format("d/m/Y"); ?>
        	        <?php echo $hasta = $rowCampana->getDateTimeObject('fecha_fin')->format("d/m/Y"); ?>        
        	        <option value="<?php echo $rowCampana->getIdCampana(); ?>"><?php echo $rowCampana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')' ?></option>
        	        <?php endforeach; ?>
        	    </select>
    	    </div>
    	    
            <div style="margin: 20px 0 0 0;">
                <label>Sumar en stock de:</label>
                <select name="stockEn">
                    <option value="CAMPAN">Campaña</option>
                    <option value="STKPER">Stock Permanente</option>
                    <option value="OUTLET">Outlet</option>
                </select>
            </div>

            <div style="margin: 20px 0 30px 0;">
                <label>Restaurar stock de Refuerzo:</label>
                <select name="restaurarRefuerzo">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                </select>
            </div>
    	
    	    <input type="hidden" name="idCampana" value="<?php echo $campana->getIdCampana(); ?>" />
    	    <input type="hidden" name="idMarca" value="<?php echo ( $marca ) ? $marca->getIdMarca() : 0; ?>" />
    	    <input type="hidden" name="idProductoCategoria" value="<?php echo ( $productoCategoria) ? $productoCategoria->getIdProductoCategoria() : 0; ?>" />
            <input class="idsProductoItems" type="hidden" name="idsProductoItems" value="" />

    	    <input class="button" type="submit" value="Confirmar" />
    	<?php endif; ?>
	</form>
</div>