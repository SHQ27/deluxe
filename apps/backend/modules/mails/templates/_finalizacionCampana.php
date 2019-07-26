<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />    
    Te contactamos para informarte que la campaña <?php echo $campana->getDenominacion() ?> donde realizaste la compra del pedido #<?php echo $pedido->getIdPedido() ?> finalizó en el día de hoy.
    Los pedidos serán despachados dentro de los siguientes 10 días al lugar que seleccionaste al momento de confirmar la compra.
</p>	

<?php $envioDetalle = $pedido->getArrayEnvioDetalle(); ?>

<p>	
    <strong>Recibe:</strong> <?php echo $envioDetalle['destinatario']; ?>
    <br /><br />

    <?php if ($envioDetalle['tipo'] == CarritoEnvio::SUCURSAL): ?>
    <strong>Sucursal:</strong> <?php echo $envioDetalle['sucursal']; ?>
    <br />
    <strong>Dirección:</strong> <?php echo $envioDetalle['direccion']; ?>
    <br />
    <strong>Localidad:</strong> <?php echo $envioDetalle['localidad']; ?>
    <br />
    <strong>Provincia:</strong> <?php echo $envioDetalle['provincia']; ?>
    <br />
    <strong>Teléfono de la sucursal:</strong> <?php echo $envioDetalle['telefono']; ?>
    <br />
    <strong>Horarios:</strong> <?php echo $envioDetalle['horario']; ?>
    <?php else:?>
    <strong>En:</strong> Domicilio Propio
    <br />
    <strong>Dirección:</strong> <?php echo $envioDetalle['direccion']; ?>
    <br />
    <strong>Localidad:</strong> <?php echo $envioDetalle['localidad']; ?>
    <br />
    <strong>Provincia:</strong> <?php echo $envioDetalle['provincia']; ?>
    <br />
    <strong>Código postal:</strong> <?php echo $envioDetalle['codigo_postal']; ?>
    <?php endif;?>
</p>

<?php echo include_partial('mails/footer'); ?>
