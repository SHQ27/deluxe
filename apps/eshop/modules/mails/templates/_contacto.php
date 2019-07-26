<?php include_partial('mails/header', array('eshop' => $eshop, 'title' => $title) ) ?>
	
<p>
	<strong>Nombre y Apellido:</strong> <?php echo $nombre; ?>
	<br/><br/>
	<strong>E-Mail:</strong> <?php echo $email . ' ( http://www.deluxebuys.com/backend/pedidos?email=' . $email . ')'; ?>
	<br/><br/>
	<strong>Motivo de la consulta:</strong> <?php echo $motivoDenominacion; ?>
	<br/><br/>
	<strong>Sub Motivo:</strong> <?php echo $submotivoDenominacion; ?>
	<br/><br/>
	<?php if ( $idPedido ): ?>
	<strong># de pedido:</strong><?php echo '<a href="' . sfConfig::get('app_host') . '/backend/pedidos/'. $idPedido . '/ListView">' . $idPedido . '</a>' ?>
	<?php else: ?>
	<strong># de pedido:</strong>No informado
	<?php endif; ?>
	<br/><br/>
	<strong>eShop:</strong> <?php echo $eshopDenominacion; ?>
	<br/><br/>
	<strong>Experiencia:</strong> <?php echo $experiencia; ?>
	<br/><br/>
	<strong>Mensaje:</strong> <?php echo $mensaje; ?>
</p>	

<?php echo include_partial('mails/footer', array('eshop' => $eshop) ) ?>