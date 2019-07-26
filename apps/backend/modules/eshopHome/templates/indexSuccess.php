<?php use_helper('I18N', 'Date') ?>
<?php include_partial('eshopHome/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Home de eShops', array(), 'messages') ?></h1>

  <?php include_partial('eshopHome/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('eshopHome/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('eshopHome/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('eshop_home_collection', array('action' => 'batch')) ?>?id_eshop=<?php echo $_GET['id_eshop']; ?>" method="post">
    <?php include_partial('eshopHome/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('eshopHome/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('eshopHome/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('eshopHome/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
