<p>
	<a href="<?php echo url_for("pedido_descargar_excel"); ?>">Descargar en formato Excel</a>
	&nbsp;|&nbsp;
	<a href="<?php echo url_for("pedido_exportar_comprobantes"); ?>">Exportar comprobantes</a>

	<?php $filtros = sfContext::getInstance()->getUser()->getAttribute('pedidos.filters', $configuration->getFilterDefaults(), 'admin_module'); ?>

	<?php if (count($filtros)):?>

		<?php if ( ( strpos($filtros['estado'],'PAGADO') !== false && (($filtros['fecha_pago']['from'] && $filtros['fecha_pago']['to']) || ($filtros['fecha_pago']['from'] && $filtros['fecha_pago']['to'])) && ( ($filtros['diversidad'] == 'STK_PER') || ($filtros['diversidad'] == 'MIX' && $filtros['campana']) ) ) || $filtros['buscador']): ?>
		&nbsp;|&nbsp;
		<a href="<?php echo url_for("pedido_armado"); ?>">Descargar Armado de pedidos</a>
		<?php endif; ?>
	<?php endif; ?>
		
</p>

<div class="sf_admin_list">
  <?php if (!$pager->getNbResults()): ?>
    <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
    <table cellspacing="0">
      <thead>
        <tr>
          <th id="sf_admin_list_batch_actions"><input id="sf_admin_list_batch_checkbox" type="checkbox" onclick="checkAll();" /></th>
          <?php include_partial('pedidos/list_th_tabular', array('sort' => $sort)) ?>
          <th id="sf_admin_list_th_actions"><?php echo __('Actions', array(), 'sf_admin') ?></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="17">
            <?php if ($pager->haveToPaginate()): ?>
              <?php include_partial('pedidos/pagination', array('pager' => $pager)) ?>
            <?php endif; ?>

            <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
            <?php if ($pager->haveToPaginate()): ?>
              <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
            <?php endif; ?>
          </th>
        </tr>
      </tfoot>
      <tbody>
        <?php foreach ($pager->getResults() as $i => $pedido): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
          <tr class="sf_admin_row <?php echo $odd ?> <?php echo ( $pedido->getRequiereIntervencionManual() )? 'requiereIntervencionManual-' . $pedido->getRequiereIntervencionManual() : '' ?> <?php echo ( $pedido->getTieneProblemaOca() )? 'tieneProblemasOCA' : '' ?>">
            <?php include_partial('pedidos/list_td_batch_actions', array('pedido' => $pedido, 'helper' => $helper)) ?>
            <?php include_partial('pedidos/list_td_tabular', array('pedido' => $pedido)) ?>
            <?php include_partial('pedidos/list_td_actions', array('pedido' => $pedido, 'helper' => $helper)) ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

</div>

<script type="text/javascript">
/* <![CDATA[ */
function checkAll()
{
  var boxes = document.getElementsByTagName('input'); for(var index = 0; index < boxes.length; index++) { box = boxes[index]; if (box.type == 'checkbox' && box.className == 'sf_admin_batch_checkbox') box.checked = document.getElementById('sf_admin_list_batch_checkbox').checked } return true;
}
/* ]]> */
</script>
