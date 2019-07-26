<div class="waitListDetails">

	<table cellpadding="0" cellspacing="5">
		<tr>
			<th class="email">Usuario</th>
			<th class="fecha">Fecha</th>
			<th class="talle">Talle</th>
			<th class="color">Color</th>
			<th class="cantidad">Cantidad</th>
		</tr>
		<?php $i = 0; ?>
		<?php foreach ($waitList as $row): ?>
		<tr class="<?php echo ($i%2 == 0)? 'blanco' : 'gris' ?>">
			<td class="email"><?php echo $row->getUsuario(); ?></td>
			<td class="fecha"><?php echo $row->getDateTimeObject('fecha')->format("d/m/Y H:i:s") ?></td>
			<td class="talle"><?php echo $row->getProductoItem()->getProductoTalle()->getDenominacion(); ?></td>
			<td class="color"><?php echo $row->getProductoItem()->getProductoColor()->getDenominacion(); ?></td>
			<td class="cantidad"><?php echo $row->getCantidad(); ?></td>
		</tr>
		<?php $i++; ?>
		<?php endforeach; ?>
			
	</table>

</div>