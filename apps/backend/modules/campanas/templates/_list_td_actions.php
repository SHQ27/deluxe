<td>
  <ul class="sf_admin_td_actions campanas">
    <?php echo $helper->linkToEdit($campana, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    
	<li class="sf_admin_action">
		<a href="/backend/campanas/<?php echo $campana->getIdCampana(); ?>/asignacionProductos" >Asignacion de productos</a>
	</li>
    
    <?php echo $helper->linkToDelete($campana, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    
	<li class="sf_admin_action">
		<a href="/backend/campanas/1" onclick="if ( confirm('Se va resetear el stock de todos los productos de la campaña\n\n<?php echo $campana->getDenominacion(); ?>.\n\n\n ¿Está seguro que desea proceder?') ) { window.location.href = '/backend/campanas/<?php echo $campana->getIdCampana(); ?>/resetearStock' };return false;">Resetear Stock</a>
	</li>
		
	<li class="sf_admin_action"> 	
		<a href="/backend/campanas/<?php echo $campana->getIdCampana(); ?>/usuariosQueCompraron" >Usuarios que Compraron</a>
	</li>
	
	<li class="sf_admin_action">
		<a href="/backend/campanas/<?php echo $campana->getIdCampana(); ?>/asignacionCSV" >Asignacion, Precios y Stocks</a>
	</li>
	
  </ul>
</td>
