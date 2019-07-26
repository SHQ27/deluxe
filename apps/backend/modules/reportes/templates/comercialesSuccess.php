<div id="sf_admin_container" class="reportes">
    
    <h1>Reporte de Comerciales</h1>
    	
    <?php $error = sfContext::getInstance()->getUser()->getFlash('reporteComercialesForm_error'); ?>
    <?php if ($error): ?>
    <ul class="error_list">
    	<li><?php echo $error ?></li>
    </ul>
    <?php endif; ?>
	
    <form method="post">
    	<?php echo $reporteComercialesForm['_csrf_token']; ?>
    	<?php echo $reporteComercialesForm['periodo']->renderLabel(); ?>
		<?php echo $reporteComercialesForm['periodo']; ?>
        <input type="submit" value="Generar" class="button" />        
    </form>
    
    <?php if ( isset ( $data ) ): ?>
    
    <h2>General - Ventas por Campañas</h2>            
    
    <div class="general">
    
        <table>
            <tr class="totalVentas">
                <td>Total de ventas (Precio DB x Cant.)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['general']['precio_deluxe']); ?></td>
            </tr>
            <?php $i = 0;?>
            <?php foreach ( $data['general']['desglose'] as $campana ): ?>
            <tr class="desglosePrecioDeluxe <?php if ($i == 0 ) echo 'first'; ?>">
                <td><?php echo $campana->getDenominacion(); ?> <br/>(<?php echo $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y"); ?> al <?php echo $campana->getDateTimeObject('fecha_fin')->format("d/m/Y"); ?>)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber( $campana->getPrecioDeluxe() ); ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
            <tr class="desglosePrecioDeluxe last">
                <td>Monto total de Envíos</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['general']['envio'] ); ?></td>
            </tr>
            <tr>
                <td>Total de pedidos</td>
                <td><?php echo $data['general']['cant_pedidos']; ?></td>
            </tr>
            <tr>
                <td>Total unidades</td>
                <td><?php echo $data['general']['unidades_vendidas']; ?></td>
            </tr>
            <tr>
                <td>Cant. uni. prom. por pedido</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($data['general']['unidades_promedio']); ?></td>
            </tr>
            <tr>
                <td>Ticket promedio</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($data['general']['ticket_promedio']); ?></td>
            </tr>
            <tr class="costo">
                <td>Costo de mercaderia (Total)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($data['general']['costo']); ?></td>
            </tr>
            <?php $i = 0;?>
            <?php $total = (count($data['general']['desglose']) - 1); ?>
            <?php foreach ( $data['general']['desglose'] as $campana ): ?>
            <tr class="desgloseCosto <?php if ($i == 0 ) echo 'first'; ?> <?php if ($i == $total) echo 'last'; ?>">
                <td><?php echo $campana->getDenominacion(); ?> <br/>(<?php echo $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y"); ?> al <?php echo $campana->getDateTimeObject('fecha_fin')->format("d/m/Y"); ?>)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber( $campana->getCosto() ); ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
            <tr>
                <td>Costo de mercaderia (Resp. Insc.)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($data['general']['costo_ri']); ?></td>
            </tr>
            <tr>
                <td>Costo de mercaderia (Monotributo)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($data['general']['costo_monotributo']); ?></td>
            </tr>
            <tr>
                <td>Margen promedio</td>
                <td><?php echo $data['general']['margen_promedio']; ?>%</td>
            </tr>
            <tr>
                <td>Cantidad Campañas</td>
                <td><?php echo $data['general']['cantidad_campanas']; ?></td>
            </tr>
        </table>
        
        <div id="chart_columns"class="grafico"></div>
        <div id="chart_pie"class="grafico"></div> 
    
    </div>
       
    <?php foreach ( $data['reporte'] as $row ): ?>
    
    <?php $precioDeluxe = ($row['reporte']['precio_deluxe']) ? $row['reporte']['precio_deluxe'] : 0; ?>
    <?php $pieData[] = "['" . $row['comercial']->getNombre() . " " .substr($row['comercial']->getApellido(), 0,1) . ".', " . $precioDeluxe . "]";?>
    <?php $namesComerciales[] = "'" . $row['comercial']->getNombre() . " " .substr($row['comercial']->getApellido(), 0,1) . ".'"; ?>
    <?php $valoresComerciales[] = $precioDeluxe; ?>
               
    <div class="comercial">
        
        <h2><?php echo $row['comercial']->getNombre(); ?> <?php echo $row['comercial']->getApellido(); ?></h2>
        
        <table>
            <tr class="totalVentas">
                <td>Total de ventas (Precio DB x Cant.)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber( $row['reporte']['precio_deluxe']); ?></td>
            </tr>
            <?php $i = 0;?>
            <?php foreach ( $row['reporte']['desglose'] as $campana ): ?>
            <tr class="desglosePrecioDeluxe <?php if ($i == 0 ) echo 'first'; ?>">
                <td><?php echo $campana['denominacion']; ?> <br/>(<?php echo date('d/m/Y', strtotime($campana['fecha_inicio'])); ?> al <?php echo date('d/m/Y', strtotime($campana['fecha_fin'])); ?>)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber( $campana['precio_deluxe'] ); ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
            <tr class="desglosePrecioDeluxe last">
                <td>Monto total de Envíos</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber( $row['reporte']['envio'] ); ?></td>
            </tr>
            <tr>
                <td>Apertura de marcas</td>
                <td>
                    <?php if ( count($row['reporte']['apertura']) ): ?>
                    <?php foreach ( $row['reporte']['apertura'] as $denominacion => $apertura ): ?>
                        <?php echo $denominacion; ?>($<?php echo $apertura; ?>)<br/>
                     <?php endforeach; ?>
                     <?php else: ?>
                     No hubo
                     <?php endif; ?>
                </td>
            </tr>
            <tr class="comision">
                <td>Comisión</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($row['reporte']['comision']); ?></td>
            </tr>
            <?php $i = 0;?>
            <?php $total = (count($row['reporte']['desglose']) - 1); ?>
            <?php foreach ( $row['reporte']['desglose'] as $campana ): ?>
            <tr class="desgloseComision <?php if ($i == 0 ) echo 'first'; ?> <?php if ($i == $total) echo 'last'; ?>">            
                <td><?php echo $campana['denominacion']; ?> <br/>(<?php echo date('d/m/Y', strtotime($campana['fecha_inicio'])); ?> al <?php echo date('d/m/Y', strtotime($campana['fecha_fin'])); ?>)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber( $campana['comision'] ); ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
            <tr>
                <td>Margen de sus campañas</td>
                <td><?php echo $row['reporte']['margen_promedio']; ?>%</td>
            </tr>
            <tr>
                <td>Margen bruto</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($row['reporte']['margen_bruto']); ?></td>
            </tr>
            <tr class="costo">
                <td>Costo de mercaderia (Total)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($row['reporte']['costo']); ?></td>
            </tr>
            <?php $i = 0;?>
            <?php $total = (count($row['reporte']['desglose']) - 1); ?>
            <?php foreach ( $row['reporte']['desglose'] as $campana ): ?>
            <tr class="desgloseCosto <?php if ($i == 0 ) echo 'first'; ?> <?php if ($i == $total) echo 'last'; ?>">
                <td><?php echo $campana['denominacion']; ?> <br/>(<?php echo date('d/m/Y', strtotime($campana['fecha_inicio'])); ?> al <?php echo date('d/m/Y', strtotime($campana['fecha_fin'])); ?>)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber( $campana['costo'] ); ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
            <tr>
                <td>Costo de mercaderia (Resp. Insc.)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($row['reporte']['costo_ri']); ?></td>
            </tr>
            <tr>
                <td>Costo de mercaderia (Monotributo)</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($row['reporte']['costo_monotributo']); ?></td>
            </tr>
            <tr>
                <td>Total de pedidos que genero sus marcas</td>
                <td><?php echo $row['reporte']['cant_pedidos']; ?></td>
            </tr>
            <tr>
                <td>Total unidades de sus campañas</td>
                <td><?php echo $row['reporte']['unidades_vendidas']; ?></td>
            </tr>
            <tr>
                <td>Ticket promedio</td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber($row['reporte']['ticket_promedio']); ?></td>
            </tr>
            <tr>
                <td>Cantidad Campañas</td>
                <td><?php echo $row['reporte']['cantidad_campanas']; ?></td>
            </tr>
        </table> 
        
    </div>
    
    <?php endforeach; ?>
    
    <script> var pieData = [<?php echo implode(',', $pieData); ?>]</script>
    <script> var columnsData = [['periodo', <?php echo implode(',', $namesComerciales)?>],['',<?php echo implode(',', $valoresComerciales); ?>]]</script>
    
    <?php endif; ?>
    
        
</div>