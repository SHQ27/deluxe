<div id="sf_admin_container" class="reportes">
    
    <h1>Reporte de Campañas</h1>
		
    <form method="post">
    	<?php echo $reporteCampanasForm['_csrf_token']; ?>
    	<?php echo $reporteCampanasForm['campanas']->renderLabel(); ?>
		<?php echo $reporteCampanasForm['campanas']; ?>
		<br/>
        <input name="<?php echo $reporteCampanasForm['action']->renderName(); ?>" type="submit" class="button" value="Ver Online" />
        &nbsp;
        <input name="<?php echo $reporteCampanasForm['action']->renderName(); ?>" type="submit" class="button" value="Descargar" /> 
    </form>
    
    <br/><br/>
    
    <?php if ( sfContext::getInstance()->getUser()->hasFlash('result_reporteCampanaForm') ): ?>
    
        <?php $data = sfContext::getInstance()->getUser()->getFlash('result_reporteCampanaForm'); ?>
        <?php sfContext::getInstance()->getUser()->setFlash('result_reporteCampanaForm', null); ?>
    <table>
    <thead>
    <tr>
        <th>Campaña</th>
        <th>Rubro</th>
        <th>Fecha</th>
        <th>Ped.</th>
        <th>U. Vend.</th>
        <th>U. Prom.<br/>x Pedido</th>
        <th>Total<br/>Fact.</th>
        <th>PDB</th>
        <th>Costo<br/>Total</th>
        <th>Margen<br/>Bruto</th>
        <th>Margen<br/>Prom.</th>
        <th>Total<br/>stock</th>
        <th width="115">Ejecución<br/>de stock</th>
        <th width="420">Top 5 productos</th>
        <th>Ticket<br/>Prom.</th>
        <th>Obj. de<br/>Fact.</th>
        <th>Resultado</th>
        <th>Condicion<br/>Fiscal</th>
        <th>Ped. H</th>
        <th>Ped. M</th>
    </tr>
    </thead>
    
    <?php foreach($data as $reporteCampana): ?>
        
    <?php $campana = $reporteCampana->getCampana(); ?>
    
    <tr>    
        <td><?php echo $campana->getDenominacion(); ?></td>
        <td><?php echo $reporteCampana->getRubro(); ?></td>
        <td><?php echo date('d/m/Y', strtotime( $campana->getFechaInicio() ) ) . ' al ' . date('d/m/Y', strtotime( $campana->getFechaFin() ) ); ?></td>
        <td><?php echo $reporteCampana->getCantidadPedidos(); ?></td>
        <td><?php echo $reporteCampana->getUnidadesVendidas(); ?></td>
        <td><?php echo $reporteCampana->getUnidadesPromedioPedido(); ?></td>
        <td><?php echo '$' . $reporteCampana->getTotalFacturado(); ?></td>
        <td><?php echo '$' . $reporteCampana->getPdb(); ?></td>
        <td><?php echo '$' . $reporteCampana->getCostoTotal(); ?></td>
        <td><?php echo '$' . $reporteCampana->getMargenBruto(); ?></td>
        <td><?php echo $reporteCampana->getMargenPromedio(); ?></td>
        <td><?php echo $reporteCampana->getTotalStock(); ?></td>            
        <td><?php echo $reporteCampana->getEjecucionDeStock(); ?></td>
        <td><?php echo $reporteCampana->getTopProductos(); ?></td>    
        <td><?php echo '$' . $reporteCampana->getTicketPromedio(); ?></td>
        <td><?php echo $reporteCampana->getObjetivoFacturacion(); ?></td>
        <td><?php echo $reporteCampana->getObjetivoResultado(); ?></td>
        <td><?php echo $reporteCampana->getCondicionFiscal(); ?></td>
        <td><?php echo $reporteCampana->getCantidadPedidoHombre(); ?></td>
        <td><?php echo $reporteCampana->getCantidadPedidoMujer(); ?></td>
   
    </tr>
    <?php endforeach; ?>
    </table>
    <?php endif; ?>
</div>