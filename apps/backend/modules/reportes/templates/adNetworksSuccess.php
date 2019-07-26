<div id="sf_admin_container" class="reportes adNetworks">
    
    <h1>Reporte de AdNetworks</h1>
	
    <?php $error = sfContext::getInstance()->getUser()->getFlash('ventasPorPeriodo_error'); ?>
    <?php if ($error): ?>
    <ul class="error_list">
    	<li><?php echo $error ?></li>
    </ul>
    <?php endif; ?>
	
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	<?php echo $form['pedidos']->renderLabel(); ?>
		<?php echo $form['pedidos']; ?>
		
		<br/><br/>
		
    	<?php echo $form['porcentaje_nuevos']->renderLabel(); ?>
		<?php echo $form['porcentaje_nuevos']; ?>
		
		<br/><br/>
		
    	<?php echo $form['porcentaje_recurrentes']->renderLabel(); ?>
		<?php echo $form['porcentaje_recurrentes']; ?>
		
		<br/><br/>
		
        <input type="submit" value="Ver Resultados" class="button" />        
    </form>
    
    <?php if ( $resultados ): ?>
    
    <h2>Resultados</h2>
    
    <table>
        <tr>
            <td>Cantidad Pedidos Nuevos</td>
            <td><?php echo $resultados['nuevos_cantidad']; ?></td>
            <td class="no-border-top no-border-bottom"></td>
            <td>Cantidad Pedidos Recurrentes</td>
            <td><?php echo $resultados['recurrentes_cantidad']; ?></td>
        </tr>
        <tr>
            <td>Listado de Ids</td>
            <td>
                <textarea><?php foreach( $resultados['nuevos_ids'] as $idPedido ): ?><?php echo $idPedido; ?>
                <?php endforeach; ?></textarea>
            </td>
            <td class="no-border-top no-border-bottom"></td>
            <td>Listado de Ids</td>
            <td>
                <textarea><?php foreach( $resultados['recurrentes_ids'] as $idPedido ): ?><?php echo $idPedido; ?>
                <?php endforeach; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>Monto total x ventas</td>
            <td>$<?php echo $resultados['nuevos_monto_total']; ?></td>
            <td class="no-border-top no-border-bottom"></td>
            <td>Monto total de ventas</td>
            <td>$<?php echo $resultados['recurrentes_monto_total']; ?></td>
        </tr>
        <tr>
            <td>Comisión (<?php echo $resultados['nuevos_porcentaje']; ?>%)</td>
            <td>$<?php echo $resultados['nuevos_comision']; ?></td>
            <td class="no-border-top no-border-bottom"></td>
            <td>Comisión (<?php echo $resultados['recurrentes_porcentaje']; ?>%)</td>
            <td>$<?php echo $resultados['recurrentes_comision']; ?></td>
        </tr>
    </table>
    <?php endif; ?>
    
</div>