<?php use_helper('I18N', 'Date') ?>
<?php include_partial('eshopLookbook/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Lookbooks del eShop', array(), 'messages') ?></h1>

  <?php include_partial('eshopLookbook/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('eshopLookbook/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('eshopLookbook/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('eshop_lookbook_collection', array('action' => 'batch')) ?>?id_eshop=<?php echo $_GET['id_eshop']; ?>" method="post">
    <?php include_partial('eshopLookbook/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('eshopLookbook/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('eshopLookbook/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('eshopLookbook/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
