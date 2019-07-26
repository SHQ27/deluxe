<?php $pedido = $faltante->getPedido(); ?>

<td>
  <ul class="faltante sf_admin_td_actions">
    <li class="sf_admin_action_devueltomp">
      <?php if ( !$faltante->getProcesado() ): ?>  
      <?php echo link_to(__('Devuelto x MP', array(), 'messages'), 'faltantes/ListDevueltoMP?id_faltante='.$faltante->getIdFaltante(), array()) ?>
      <?php endif; ?>
    </li>
    
    <li class="sf_admin_action_generarBonificacion">
    
      <?php if ( !$faltante->getProcesado() && !$pedido->getIdEshop() && $pedido->getIdFormaPago() != formaPago::MERCADOLIBRE ): ?>  
      <?php echo link_to(__('Generar Bonif.', array(), 'messages'), 'faltantes/ListGenerarBonificacion?id_faltante='.$faltante->getIdFaltante(), array()) ?>
      <?php endif; ?>
    </li>
    
    <?php if ( !$faltante->getProcesado() ): ?>  
    <li class="sf_admin_action_delete">
        <a href="/backend/faltantes/<?php echo $faltante->getIdFaltante(); ?>" onclick="if (confirm('¿Está seguro?')) { var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'post'; f.action = this.href;var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', 'sf_method'); m.setAttribute('value', 'delete'); f.appendChild(m);var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', '_csrf_token'); m.setAttribute('value', '620096fb635e5c5f17c38dc58382dcf4'); f.appendChild(m);f.submit(); };return false;">
            Borrar
        </a>
    </li>
    <?php endif; ?>
    
  </ul>
</td>
