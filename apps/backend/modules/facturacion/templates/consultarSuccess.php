<div id="sf_admin_container" class="consultarComprobanteAfip">
    
    <h1>Consulta a AFIP por Comprobantes Emitidos</h1>
    		
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	
    	<div class="row">
	    	<?php echo $form['tipoComprobante']->renderLabel(); ?>
			<?php echo $form['tipoComprobante']; ?>
			<?php echo $form['tipoComprobante']->renderError(); ?>
		</div>
		
		<div class="row">	
	    	<?php echo $form['comprobante']->renderLabel(); ?>
			<?php echo $form['comprobante']; ?>
			<?php echo $form['comprobante']->renderError(); ?>
		</div>
		
        <input type="submit" value="Consultar" />        
    </form>
    
	<?php if ( isset($result) ): ?>
		
		<?php if ( !$result['error'] ): ?>
	
		<?php $data = $result['data']; ?>
		<table>
			<tr>
				<td><strong>Nº Comprobante:</strong></td>
				<td><?php echo $data['comprobante']; ?></td>
			</tr>
			<tr>
				<td><strong>Tipo Comprobante:</strong></td>
				<td><?php echo $data['tipoComprobante']; ?></td>
			</tr>
			<tr>
				<td><strong>Importe Comprobante:</strong></td>
				<td>$ <?php echo $data['importe']; ?></td>
			</tr>
			<tr>
				<td><strong>Fecha:</strong></td>
				<td><?php echo $data['fecha']; ?></td>
			</tr>
			<tr>
				<td><strong>CAE:</strong></td>
				<td><?php echo $data['CAE']; ?></td>
			</tr>
			<tr>
				<td><strong>Vencimiento CAE:</strong></td>
				<td><?php echo $data['CAEVencimiento']; ?></td>
			</tr>
			<tr>
				<td><strong>Punto de Venta Nº:</strong></td>
				<td><?php echo $data['puntDeVenta']; ?></td>
			</tr>
	    </table>
	    <?php else: ?>
	    <p><?php echo $result['error']; ?></p>
	    <?php endif; ?>
	    
    <?php endif; ?>
    
    
</div>
