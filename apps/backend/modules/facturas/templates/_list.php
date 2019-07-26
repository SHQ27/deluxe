<?php foreach (incidenciaFacturaTable::getInstance()->listarNoCorrelativas() as $noCorrelativa) : ?>
<p><?php echo $noCorrelativa->getDescripcion(); ?> &nbsp;<a href="/backend/facturas/<?php echo $noCorrelativa->getValor() ?>/normalizarCorrelativo" onclick="if (confirm('Are you sure?')) { return true };return false;" id="comprobante" style="color:#CC0000" >Marcar como resuelta</a></p>
<?php endforeach; ?>
<div class="sf_admin_list">
  <?php if (!$pager->getNbResults()): ?>
    <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
    <table cellspacing="0">
      <thead>
        <tr>
          <?php include_partial('facturas/list_th_tabular', array('sort' => $sort)) ?>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="15">
            <?php if ($pager->haveToPaginate()): ?>
              <?php include_partial('facturas/pagination', array('pager' => $pager)) ?>
            <?php endif; ?>

            <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
            <?php if ($pager->haveToPaginate()): ?>
              <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
            <?php endif; ?>
          </th>
        </tr>
      </tfoot>
      <tbody>
        <?php foreach ($pager->getResults() as $i => $factura): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
          <tr class="sf_admin_row <?php echo $odd ?>">
            <?php include_partial('facturas/list_td_tabular', array('factura' => $factura)) ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>