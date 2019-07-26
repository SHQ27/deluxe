<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_imagen">
  <?php echo __('Imagen', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_id_producto">
  <?php if ('id_producto' == $sort[0]): ?>
    <?php echo link_to(__('Id', array(), 'messages'), '@producto', array('query_string' => 'sort=id_producto&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Id', array(), 'messages'), '@producto', array('query_string' => 'sort=id_producto&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_producto_categoria">
  <?php echo __('Categoria', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_denominacion">
  <?php if ('denominacion' == $sort[0]): ?>
    <?php echo link_to(__('Denominacion', array(), 'messages'), '@producto', array('query_string' => 'sort=denominacion&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Denominacion', array(), 'messages'), '@producto', array('query_string' => 'sort=denominacion&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_precio_deluxe">
  <?php if ('precio_deluxe' == $sort[0]): ?>
    <?php echo link_to(__('Precio<br/>DB', array(), 'messages'), '@producto', array('query_string' => 'sort=precio_deluxe&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Precio<br/>DB', array(), 'messages'), '@producto', array('query_string' => 'sort=precio_deluxe&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_costo">
  <?php if ('costo' == $sort[0]): ?>
    <?php echo link_to(__('Costo', array(), 'messages'), '@producto', array('query_string' => 'sort=costo&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Costo', array(), 'messages'), '@producto', array('query_string' => 'sort=costo&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_markup">
  <?php echo __('Markup', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_ventas_totales">
  <?php echo __('Vtas<br />Tot.', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_marca">
  <?php echo __('Marca', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_origen">
  <?php echo __('Origen', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>

<th class="sf_admin_text sf_admin_list_th_stock_permanente">
  <?php if ('stock_permanente_calculado' == $sort[0]): ?>
    <?php echo link_to(__('STK<br/>Per.', array(), 'messages'), '@producto', array('query_string' => 'sort=stock_permanente_calculado&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('STK<br/>Per.', array(), 'messages'), '@producto', array('query_string' => 'sort=stock_permanente_calculado&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_stock_campana">
  <?php if ('stock_campana_calculado' == $sort[0]): ?>
    <?php echo link_to(__('STK<br/>Cam.', array(), 'messages'), '@producto', array('query_string' => 'sort=stock_campana_calculado&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('STK<br/>Cam.', array(), 'messages'), '@producto', array('query_string' => 'sort=stock_campana_calculado&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_stock_outlet">
  <?php if ('stock_outlet_calculado' == $sort[0]): ?>
    <?php echo link_to(__('STK<br/>Out.', array(), 'messages'), '@producto', array('query_string' => 'sort=stock_outlet_calculado&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('STK<br/>Out.', array(), 'messages'), '@producto', array('query_string' => 'sort=stock_outlet_calculado&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_stock_refuerzo">
  <?php if ('stock_refuerzo_calculado' == $sort[0]): ?>
    <?php echo link_to(__('STK<br/>Ref.', array(), 'messages'), '@producto', array('query_string' => 'sort=stock_refuerzo_calculado&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('STK<br/>Ref.', array(), 'messages'), '@producto', array('query_string' => 'sort=stock_refuerzo_calculado&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_boolean sf_admin_list_th_activo">
  <?php if ('activo' == $sort[0]): ?>
    <?php echo link_to(__('Activo', array(), 'messages'), '@producto', array('query_string' => 'sort=activo&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Activo', array(), 'messages'), '@producto', array('query_string' => 'sort=activo&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_boolean sf_admin_list_th_activo">
  Set de Talles
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>