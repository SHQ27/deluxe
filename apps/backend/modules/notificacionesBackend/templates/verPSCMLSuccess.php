<?php include_partial('notificacionHeader', array('notificacionBackend' => $notificacionBackend)); ?>

<?php $response = $notificacionBackend->getResponseArray(); ?>

<p class="ok">
    Se seteo correctamente la categoria y parametros de Mercado Libre para los siguientes productos:
</p>

<table>
    <thead>
	<tr>
		<th>Id Producto</th>
		<th>Imagen</th>
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Marca</th>
		<th>Talle</th>
		<th>Color</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($response as $row):?>
	<tr>
		<td><?php echo $row['id_producto']; ?></td>
		<td>
		    <img src="<?php echo  $row['imagen'] ?>" width="100px">
	    </td>
		<td><?php echo $row['codigo'] ?></td>
		<td><a href="/backend/productos/<?php echo $row['id_producto'] ?>/edit"><?php echo  $row['denominacion'] ?></a></td>
		<td><?php echo $row['marca'] ?></td>
		<td><?php echo $row['talle'] ?></td>
		<td><?php echo $row['color'] ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php include_partial('notificacionFooter', array('notificacionBackend' => $notificacionBackend)); ?>