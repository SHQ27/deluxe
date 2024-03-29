<?php use_helper('I18N', 'Date') ?>
<?php include_partial('controlStock/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Control de Stock (Solo Permanente)', array(), 'messages') ?></h1>

  <?php include_partial('controlStock/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('controlStock/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('controlStock/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('control_stock_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('controlStock/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'configuration' => $configuration)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('controlStock/list_batch_actions', array('helper' => $helper, 'configuration' => $configuration)) ?>
      <?php include_partial('controlStock/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('controlStock/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
