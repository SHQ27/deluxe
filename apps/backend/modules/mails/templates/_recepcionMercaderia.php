<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<?php if( $response['status'] == 'ok' ): ?>
<p style="text-align: center;">
	<br /><br /><br />
	<strong>No se registraron observaciones.</strong>
	<br /><br /><br />
</p>
<?php else: ?>
<p>
    <strong>Se registraron las siguientes observaciones:</strong>
    <br /><br /><br />
</p>

<table>
	<thead>
		<tr>
			<th>Imagen</th>
			<th>Producto</th>
			<th>Cod prod</th>
			<th>Color</th>
			<th>Talle</th>
		</tr>
	</thead>
	<tbody>

		<?php foreach ( $response['data'] as $row ): ?>

		<?php $producto = $row['producto']; ?>
		<?php $observacion = $row['observacion']; ?>

		<tr>
			<td><img src="<?php echo $producto['img']; ?>"/></td>
			<td><?php echo $producto['nombre']; ?></td>
			<td><?php echo $producto['codigo']; ?></td>
			<td><?php echo $producto['color']; ?></td>
			<td><?php echo $producto['talle']; ?></td>
		</tr>
		<tr>
			<td colspan="5">
				<p>
					<strong>Observación:</strong>
					<br /><br />
					<?php echo nl2br( $observacion); ?>
					<br /><br /><br />
				</p>
			</td>
		</tr>



		<?php endforeach; ?>
	</tbody>
</table>

<?php endif; ?>

<?php echo include_partial('mails/footer'); ?>