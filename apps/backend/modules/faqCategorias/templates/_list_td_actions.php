<td>
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_go_to_faqs">
      <?php echo link_to(__('Gestión de Faqs', array(), 'messages'), 'faqCategorias/ListGoToFaqs?id_faq_categoria='.$faq_categoria->getIdFaqCategoria(), array()) ?>
    </li>
    
    <?php echo $helper->linkToEdit($faq_categoria, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($faq_categoria, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    
	<?php if( $faq_categoria->canOrderUp() ):?>
	<li class="sf_admin_action_subir">
		<?php echo link_to(__('Subir', array(), 'messages'), '/backend/faqCategorias/' . $faq_categoria->getIdFaqCategoria() . '/subir' , array('title' => 'Subir')) ?>
	</li>
	<?php else:?>
	<li class="sf_admin_action_none">
	    &nbsp;
	</li>
	<?php endif;?>
	
	<?php if( $faq_categoria->canOrderDown() ):?>
	<li class="sf_admin_action_bajar">
	    <?php echo link_to(__('Bajar', array(), 'messages'), '/backend/faqCategorias/' . $faq_categoria->getIdFaqCategoria() . '/bajar', array('title' => 'Bajar')) ?>
	</li>
	<?php else:?>
	<li class="sf_admin_action_none">
	    &nbsp;
	</li>
	<?php endif;?>
    
  </ul>
</td>
