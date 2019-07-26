<?php use_helper('I18N', 'Date') ?>
<?php include_partial('campanas/assets') ?>

<div id="sf_admin_container" class="campanas">
  <h1><?php echo __('Campañas', array(), 'messages') ?></h1>
     
  <?php if ( isset($_GET['resetear_stock']) ): ?>
  <div class="notice">Se resteó correctamente el stock de todos los productos asignados a la campaña.</div>
  <br />
  <?php endif; ?>
	
  <?php include_partial('campanas/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('campanas/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('campanas/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('campana_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('campanas/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('campanas/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('campanas/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('campanas/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
