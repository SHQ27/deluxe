<div class="history">

	<table cellpadding="0" cellspacing="5">
		<tr>
			<th class="movimiento">Mov. #</th>
			<th class="fecha">Fecha</th>
			<th class="cantidad">Cant.</th>
			<th class="tipo">Tipo</th>
			<th class="observacion">Observacion</th>
			<th class="sumaParcial">Suma<br/>STK<br/>Per.</th>
			<th class="sumaParcial">Suma<br/>STK<br/>Cam.</th>
			<th class="sumaParcial">Suma<br/>STK<br/>Out.</th>
			<th class="sumaParcial">Suma<br/>STK<br/>Ref.</th>
		</tr>
		
		<?php $i = 0; ?>
		<?php $sumPermanente = 0; $sumCampana = 0; $sumOutlet = 0; $sumRefuerzo = 0; ?>
		<?php foreach ($history as $stock): ?>
		
		<?php $observacion = $stock->getObservacion(); ?>
		<?php if ( stripos($stock->getObservacion(), 'Pedido') !== false ) $observacion = preg_replace('/Pedido\s+#(\d+)/i', '<a target="_blank" href="/backend/pedidos/$1/ListView">$0</a>', $stock->getObservacion()); ?>
		<?php if ( stripos($stock->getObservacion(), 'Campaña') !== false ) $observacion = preg_replace('/Campaña\s+#(\d+)/i', '<a target="_blank" href="/backend/campanas/$1/edit">$0</a>', $stock->getObservacion()); ?>
				
		<tr class="<?php echo ($i%2 == 0)? 'blanco' : 'gris' ?>">
			<td class="movimiento first"><?php echo $stock->getIdStock(); ?></td>
			<td class="fecha"><?php echo $stock->getDateTimeObject('fecha')->format("d/m/Y H:i:s") ?></td>
			<td class="cantidad"><?php echo $stock->getCantidad(); ?></td>
			<td class="tipo"><?php echo $stock->getStockTipo()->getDenominacion(); ?></td>
			<td class="observacion last">
				<?php echo $observacion; ?>
			</td>
			
			<?php 
			
			switch ($stock->getOrigen())
			{
			    case producto::ORIGEN_STOCK_PERMANENTE: 
			    	$sumPermanente += $stock->getCantidad();
                    break;
			    case producto::ORIGEN_OFERTA:
			    	$sumCampana += $stock->getCantidad();
					break;
			    case producto::ORIGEN_OUTLET:
			    	$sumOutlet += $stock->getCantidad();
					break;
			    case producto::ORIGEN_REFUERZO:
			    	$sumRefuerzo += $stock->getCantidad();
					break;
			}
			
			?>
			
			<td class="sumaParcial <?php if ( $stock->getOrigen() == producto::ORIGEN_STOCK_PERMANENTE ) echo 'highlight';?>"><?php echo $sumPermanente; ?></td>
			<td class="sumaParcial <?php if ( $stock->getOrigen() == producto::ORIGEN_OFERTA) echo 'highlight';?>"><?php echo $sumCampana; ?></td>
			<td class="sumaParcial <?php if ( $stock->getOrigen() == producto::ORIGEN_OUTLET) echo 'highlight';?>"><?php echo $sumOutlet; ?></td>	
			<td class="sumaParcial <?php if ( $stock->getOrigen() == producto::ORIGEN_REFUERZO) echo 'highlight';?>"><?php echo $sumRefuerzo; ?></td>	
		</tr>
		<?php $i++; ?>
		<?php endforeach; ?>
		
	</table>

</div>