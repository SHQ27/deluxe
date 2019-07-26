<?php $filtros = sfContext::getInstance()->getUser()->getAttribute('promosPago.filters', $configuration->getFilterDefaults(), 'admin_module'); ?>


<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($promo_pago, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($promo_pago, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>

    <?php if ( isset( $filtros['id_eshop'] ) && isset( $filtros['activo'] ) && $filtros['id_eshop'] && $filtros['activo'] ): ?>

	<?php if( $promo_pago->canOrderUp() ):?>
	<li class="sf_admin_action_subir">
		<?php echo link_to(__('Subir', array(), 'messages'), '/backend/promosPago/' . $promo_pago->getIdPromoPago() . '/subir' , array('title' => 'Subir')) ?>
	</li>
	<?php else:?>
	<li class="sf_admin_action_none">
	    &nbsp;
	</li>
	<?php endif;?>
	
	<?php if( $promo_pago->canOrderDown() ):?>
	<li class="sf_admin_action_bajar">
	    <?php echo link_to(__('Bajar', array(), 'messages'), '/backend/promosPago/' . $promo_pago->getIdPromoPago() . '/bajar', array('title' => 'Bajar')) ?>
	</li>
	<?php else:?>
	<li class="sf_admin_action_none">
	    &nbsp;
	</li>
	<?php endif;?>
	<?php endif;?>    

  </ul>
</td>
