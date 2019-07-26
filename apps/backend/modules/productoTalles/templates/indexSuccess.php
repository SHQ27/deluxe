<?php use_helper('I18N', 'Date') ?>
<?php include_partial('productoTalles/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Talles', array(), 'messages') ?></h1>

  <?php include_partial('productoTalles/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('productoTalles/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('productoTalles/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('producto_talle_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('productoTalles/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'filters' => $filters)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('productoTalles/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('productoTalles/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('productoTalles/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
