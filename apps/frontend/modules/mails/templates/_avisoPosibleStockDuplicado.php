<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
	Se han registrado movimientos en los siguientes productos que podrían identificarse como duplicados,
	para estar seguro verifique la tabla histórica de stock del producto haciendo click en "Ver".
	<br/>
	De haber alguna inconsistencia real por favor comuniquese con soporte para revisar el problema.
	<br/><br/>
</p>

<table style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #333; font-size: 12px; line-height: 25px;" width="550px" cellpadding="10" cellspacing="0" border="0">
	<thead>
		<tr>
			<th style="border-bottom: solid #ccc 1px;" align="left">Producto</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">Talle</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">Color</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $row): ?>
		<tr>
			<td style="border-bottom: solid #ccc 1px;" align="left"><?php echo $row['producto']; ?></td>
			<td style="border-bottom: solid #ccc 1px;" align="center"><?php echo $row['productoTalle']; ?></td>
			<td style="border-bottom: solid #ccc 1px;" align="center"><?php echo $row['productoColor']; ?></td>
			<td style="border-bottom: solid #ccc 1px;" align="center"><a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host') . $row['URL']; ?>">Ver</a></td>
		</tr>
		<?php endforeach; ?>
		
	</tbody>
</table>

<?php echo include_partial('mails/footer'); ?>