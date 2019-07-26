<?php use_helper('I18N', 'Date') ?>
<?php include_partial('promosPago/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Promociones de Pago', array(), 'messages') ?></h1>

  <?php include_partial('promosPago/flashes') ?>


  <div id="sf_admin_header">
    <?php include_partial('promosPago/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('promosPago/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <p class="gris">
    <small><strong>Aviso:</strong> Las promociones de pago pueden ordenarse, siempre que se establezca un filtro para un eShop determinado y todas las promociones activas.</small>
  </p>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('promo_pago_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('promosPago/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'configuration' => $configuration)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('promosPago/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('promosPago/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('promosPago/list_footer', array('pager' => $pager)) ?>
  </div>
</div>

