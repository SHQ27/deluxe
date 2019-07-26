<td>
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_view">
      <a rel="<?php echo $devolucion->getIdDevolucion(); ?>">Ver</a>
    </li>
    
    <?php if ( !$devolucion->getFechaCierre() ): ?>
        <?php echo $helper->linkToEdit($devolucion, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php  endif; ?>
    
    <?php if( $devolucion->getTipoEnvio() == devolucion::envio_oca ): ?>
	  <li class="sf_admin_action_enviooca">
      <a href="<?php echo url_for('devolucion_envioCorreo', array('idDevolucion' => $devolucion->getIdDevolucion() ) ); ?>">Imponer orden (Correo)</a>
    </li>
    <?php endif; ?>

    <?php if( !$devolucion->getFechaRecibido() ): ?>
    <li class="sf_admin_action_marcaRecibido">
      <a href="<?php echo url_for('devolucion_marcaRecibido', array('idDevolucion' => $devolucion->getIdDevolucion() ) ); ?>">Recibido</a>
    </li>
    <?php endif; ?>
    
    <?php if( $devolucion->getFechaRecibido() && !$devolucion->getFechaCierre() ): ?>
    <li class="sf_admin_action_procesar">
      <a href="<?php echo url_for('devolucion_procesar', array('idDevolucion' => $devolucion->getIdDevolucion() ) ); ?>">Procesar</a>
    </li>
    <?php endif; ?>
    
    <?php echo $helper->linkToDelete($devolucion, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
</td>
