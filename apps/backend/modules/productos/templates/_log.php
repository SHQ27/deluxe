<?php $producto = $form->getObject(); ?>
<?php $log = $producto->getProductoLog();?>

<table class="logProducto">
    <tr>
        <th>Fecha</th>
        <th>Observación</th>
    </tr>
<?php if (count($log)): ?>
    <?php foreach ($log as $productoLog): ?>
    	<?php $observacion = $productoLog->getObservacion(); ?>
        <?php if ( stripos($productoLog->getObservacion(), 'Campaña') !== false ) $observacion = preg_replace('/Campaña\s+#(\d+)/i', '<a target="_blank" href="/backend/campanas/$1/edit">$0</a>', $productoLog->getObservacion()); ?>
    		
        <tr>
            <td><?php echo $productoLog->getDateTimeObject('fecha')->format('d/m/Y H:i'); ?></td>
            <td><?php echo $observacion; ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="2">Aun no se registraron movimientos</td>
    </tr>
<?php endif; ?>
</table>