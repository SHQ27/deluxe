<?php if ($pedido->getEnvioTipo() == CarritoEnvio::SUCURSAL): ?>
A Sucursal
<?php else:?>
A Domicilio
<?php endif;?>