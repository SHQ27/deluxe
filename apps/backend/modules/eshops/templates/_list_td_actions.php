<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($eshop, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($eshop, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    <li class="sf_admin_action"><a href="/backend/eshopHome?id_eshop=<?php echo $eshop->getIdEshop(); ?>">Home</a></li>

    <?php if ( $eshop->getUsaCampaign() ): ?>
    <li class="sf_admin_action"><a href="/backend/eshopImagenCampaign?id_eshop=<?php echo $eshop->getIdEshop(); ?>">Campaign</a></li>
	<?php endif; ?>

	<?php if ( $eshop->getUsaLookbook() ): ?>
    <li class="sf_admin_action"><a href="/backend/eshopLookbook?id_eshop=<?php echo $eshop->getIdEshop(); ?>">Lookbook</a></li>
	<?php endif; ?>

    <li class="sf_admin_action"><a href="/backend/eshopTiendas?id_eshop=<?php echo $eshop->getIdEshop(); ?>">Tiendas</a></li>
    <li class="sf_admin_action"><a href="/backend/eshops/<?php echo $eshop->getIdEshop(); ?>/ordenarCategorias">Ordenar Categorias</a></li>
    <li class="sf_admin_action"><a href="/backend/eshops/<?php echo $eshop->getIdEshop(); ?>/ordenarProductos">Ordenar Productos</a></li>
  </ul>
</td>

