<style>

	body { margin: 0 0 0 0; }

	p { font-family: arial; }

	.reciboDevolucion
	{
		width: 620px;
		margin: 0 40px 0 40px;	
	}
	
	.reciboDevolucion p
	{
		margin: 60px 0 60px 0;
	}
	
	.reciboDevolucion p.no-margin
	{
		margin: 0;
	}

	.reciboDevolucion table
	{
		font-size: 13px;
	}
	
	.reciboDevolucion th
	{
		text-align: left;
	}

</style>


<div class="reciboDevolucion">

	<p class="no-margin" style="text-align: right;">
		<a href="javascript:window.print()">Imprimir</a>
	</p>
	
	<p style="text-align: center;">
		<img src="/backend/images/logo_deluxe.png" />
	</p>
	
	<p style="text-align: right;">
		<?php echo date('d/m/Y'); ?>
	</p>
	
	<p>
		Recibimos en concepto de devolución correspondiente al pedido #<?php echo $idPedido?> los siguientes productos:
		<br/><br/>
		<table>
		<tr>
			<th width="500">Producto</th>
			<th width="300">Marca</th>
			<th width="50">Talle</th>
			<th width="50">Color</th>
			<th width="50">Cant.</th>
		</tr>
		<?php foreach ($productos as $row): ?>
		<tr>
			<td><?php echo $row['denominacion']; ?></td>
			<td><?php echo $row['marca']; ?></td>
			<td><?php echo $row['talle']; ?></td>
			<td><?php echo $row['color']; ?></td>
			<td><?php echo $row['cantidad']; ?></td>
		</tr>
		<?php endforeach; ?>
		</table>

		<br/>
		
		<?php if ($devolucion == 'MP'): ?>
		Devolvemos el dinero a través de MercadoPago por un total de $<?php echo $monto; ?>.
		<?php else: ?>
		Dejamos el crédito a favor en Deluxebuys por un total de $<?php echo $monto; ?>
		<?php endif; ?>
	</p>
		 
	<p style="margin: 0 0 0 450px;">
		Noelia
	</p>
	
</div>