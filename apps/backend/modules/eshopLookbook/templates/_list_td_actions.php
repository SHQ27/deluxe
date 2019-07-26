<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($eshop_lookbook, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($eshop_lookbook, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    
	<?php if( $eshop_lookbook->canOrderUp() ):?>
	<li class="sf_admin_action_subir">
		<?php echo link_to(__('Subir', array(), 'messages'), '/backend/eshopLookbook/' . $eshop_lookbook->getIdEshopLookbook() . '/subir' , array('title' => 'Subir')) ?>
	</li>
	<?php else:?>
	<li class="sf_admin_action_none">
	    &nbsp;
	</li>
	<?php endif;?>
	
	<?php if( $eshop_lookbook->canOrderDown() ):?>
	<li class="sf_admin_action_bajar">
	    <?php echo link_to(__('Bajar', array(), 'messages'), '/backend/eshopLookbook/' . $eshop_lookbook->getIdEshopLookbook() . '/bajar', array('title' => 'Bajar')) ?>
	</li>
	<?php else:?>
	<li class="sf_admin_action_none">
	    &nbsp;
	</li>
	<?php endif;?>
    
  </ul>
</td>
