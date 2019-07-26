<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($producto_talle, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($producto_talle, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
        
    <?php if( !$filters->getDefault('denominacion') ):?>
	<?php if( $producto_talle->canOrderUp() ):?>
	<li class="sf_admin_action_subir">
		<?php echo link_to(__('Subir', array(), 'messages'), '/backend/productoTalles/' . $producto_talle->getIdProductoTalle() . '/subir' , array('title' => 'Subir')) ?>
	</li>
	<?php else:?>
	<li class="sf_admin_action_none">
	    &nbsp;
	</li>
	<?php endif;?>
	
	<?php if( $producto_talle->canOrderDown() ):?>
	<li class="sf_admin_action_bajar">
	    <?php echo link_to(__('Bajar', array(), 'messages'), '/backend/productoTalles/' . $producto_talle->getIdProductoTalle() . '/bajar', array('title' => 'Bajar')) ?>
	</li>
	<?php else:?>
	<li class="sf_admin_action_none">
	    &nbsp;
	</li>
	<?php endif;?>
	<?php endif;?>    
    
  </ul>
</td>
