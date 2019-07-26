<div class="history">

	<table cellpadding="0" cellspacing="5">
		<tr>
			<th class="movimiento">Mov. #</th>
			<th class="fecha">Fecha</th>
			<th class="cantidad">Cant.</th>
			<th class="outlet">En<br/>Outlet?</th>
			<th class="tipo">Tipo</th>
			<th class="observacion">Observacion</th>
			<th class="sumaParcial">Suma<br/>Parcial</th>
		</tr>
		
		<?php $i = 0; ?>
		<?php $sum = 0; ?>
		<?php foreach ($history as $stock): ?>

		<?php $observacion = $stock->getObservacion(); ?>
		<?php if ( stripos($stock->getObservacion(), 'Pedido') !== false ) $observacion = preg_replace('/Pedido\s+#(\d+)/i', '<a target="_blank" href="/backend/pedidos/$1/ListView">$0</a>', $stock->getObservacion()); ?>
		<?php if ( stripos($stock->getObservacion(), 'Campaña') !== false ) $observacion = preg_replace('/Campaña\s+#(\d+)/i', '<a target="_blank" href="/backend/campanas/$1/edit">$0</a>', $stock->getObservacion()); ?>
				
		<tr class="<?php echo ($i%2 == 0)? 'blanco' : 'gris' ?>">
			<td class="movimiento first"><?php echo $stock->getIdStockHistorico(); ?></td>
			<td class="fecha"><?php echo $stock->getDateTimeObject('fecha')->format("d/m/Y H:i:s") ?></td>
			<td class="cantidad"><?php echo $stock->getCantidad(); ?></td>
			<td class="outlet"><?php echo ( $stock->getEsOutlet() )? 'Si' : 'No' ?></td>
			<td class="tipo"><?php echo $stock->getStockTipo()->getDenominacion(); ?></td>
			<td class="observacion last"><?php echo $observacion; ?></td>
			<?php $sum += $stock->getCantidad(); ?>
			<td class="sumaParcial"><?php echo $sum; ?></td>
		</tr>
		<?php $i++; ?>
		<?php endforeach; ?>
		
	</table>

</div>