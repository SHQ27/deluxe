<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_id_pedido">
  <?php if ('id_pedido' == $sort[0]): ?>
    <?php echo link_to(__('Id pedido', array(), 'messages'), '@pedido', array('query_string' => 'sort=id_pedido&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Id pedido', array(), 'messages'), '@pedido', array('query_string' => 'sort=id_pedido&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_eshop">
  <?php echo __('eShop', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_date sf_admin_list_th_fecha_alta">
  <?php if ('fecha_alta' == $sort[0]): ?>
    <?php echo link_to(__('Fecha Alta', array(), 'messages'), '@pedido', array('query_string' => 'sort=fecha_alta&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Fecha Alta', array(), 'messages'), '@pedido', array('query_string' => 'sort=fecha_alta&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>

<th class="sf_admin_text sf_admin_list_th_datos_cliente">
  <?php if ('datos_cliente' == $sort[0]): ?>
    <?php echo link_to(__('Datos cliente', array(), 'messages'), '@pedido', array('query_string' => 'sort=datos_cliente&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Datos cliente', array(), 'messages'), '@pedido', array('query_string' => 'sort=datos_cliente&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_datos_envio">
  <?php echo __('Datos envio', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_forma_pago">
  <?php echo __('Forma pago', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_estado">
  <?php echo __('Estado', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_diversidad">
  <?php echo __('Diversidad', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_campana">
  <?php echo __('Campaña', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_tiene_outlet">
  Outlet?
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_cuotas">
  Cuotas
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_monto_productos">
  <?php if ('monto_productos' == $sort[0]): ?>
    <?php echo link_to(__('$ Prod.', array(), 'messages'), '@pedido', array('query_string' => 'sort=monto_productos&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('$ Prod.', array(), 'messages'), '@pedido', array('query_string' => 'sort=monto_productos&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_monto_descuento">
  <?php if ('monto_descuento' == $sort[0]): ?>
    <?php echo link_to(__('$ Desc.', array(), 'messages'), '@pedido', array('query_string' => 'sort=monto_descuento&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('$ Desc.', array(), 'messages'), '@pedido', array('query_string' => 'sort=monto_descuento&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_monto_bonificacion">
  <?php if ('monto_bonificacion' == $sort[0]): ?>
    <?php echo link_to(__('$ Bonif.', array(), 'messages'), '@pedido', array('query_string' => 'sort=monto_bonificacion&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('$ Bonif.', array(), 'messages'), '@pedido', array('query_string' => 'sort=monto_bonificacion&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_monto_total">
  <?php if ('monto_total' == $sort[0]): ?>
    <?php echo link_to(__('$ Total', array(), 'messages'), '@pedido', array('query_string' => 'sort=monto_total&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('$ Total', array(), 'messages'), '@pedido', array('query_string' => 'sort=monto_total&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>