<?php use_helper('I18N', 'Date') ?>
<?php include_partial('pedidos/assets') ?>

<div id="sf_admin_container" class="pedidosList">
  <h1><?php echo __('Pedidos', array(), 'messages') ?></h1>

  <?php include_partial('pedidos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('pedidos/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('pedidos/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('pedido_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('pedidos/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'configuration' => $configuration)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('pedidos/list_batch_actions', array('helper' => $helper, 'configuration' => $configuration)) ?>
      <?php include_partial('pedidos/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
    
	<div class="guiaFiltros">
		<br/>
		
		<h3>Guia de filtros para cada tipo de reportes</h3>
  
		<table>
		  	<tr>
		  		<td><strong>Reporte</strong></td>
		  		<td><strong>Estado</strong></td>
		  		<td><strong>Diversidad</strong></td>
		  		<td><strong>Campaña</strong></td>
		  		<td><strong>Marca</strong></td>
		  		<td><strong>Fecha Pago</strong></td>
		  	</tr>
		  	<tr>
		  		<td>Descargar Armado de pedidos</td>
		  		<td>Pagado</td>
		  		<td>Stock Permanente o Mixta</td>
		  		<td>Solo si Diversidad = Mixta</td>
		  		<td>&nbsp;</td>
		  		<td>Desde/Hasta</td>
		  	</tr>
		</table>
	</div>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('pedidos/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
