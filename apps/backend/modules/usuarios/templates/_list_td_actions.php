<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($usuario, array(  'label' => 'Editar',  'params' =>   array(  ),  'class_suffix' => 'edit',)) ?>
    <li class="sf_admin_action_view">
      <?php echo link_to(__('Ver', array(), 'messages'), 'usuarios/ListView?id_usuario='.$usuario->getIdUsuario(), array()) ?>
    </li>
    
    <?php if ( $usuario->getFechaBaja() ): ?>
    <li class="sf_admin_action_reactivar">
      <a class="reactivar" href="/backend/usuarios/<?php echo $usuario->getIdUsuario(); ?>/reactivar">Reactivar</a>
    </li>    
    <?php else: ?>
    <?php echo $helper->linkToDelete($usuario, array(  'label' => 'Eliminar',  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',)); ?>
    <?php endif; ?>
  </ul>
</td>
