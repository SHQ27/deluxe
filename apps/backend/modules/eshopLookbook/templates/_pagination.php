<div class="sf_admin_pagination">
  <a href="<?php echo url_for('@eshop_lookbook') ?>?page=1&id_eshop=<?php echo $_GET['id_eshop']; ?>">
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/first.png', array('alt' => __('First page', array(), 'sf_admin'), 'title' => __('First page', array(), 'sf_admin'))) ?>
  </a>

  <a href="<?php echo url_for('@eshop_lookbook') ?>?page=<?php echo $pager->getPreviousPage() ?>&id_eshop=<?php echo $_GET['id_eshop']; ?>">
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/previous.png', array('alt' => __('Previous page', array(), 'sf_admin'), 'title' => __('Previous page', array(), 'sf_admin'))) ?>
  </a>

  <?php foreach ($pager->getLinks() as $page): ?>
    <?php if ($page == $pager->getPage()): ?>
      <?php echo $page ?>
    <?php else: ?>
      <a href="<?php echo url_for('@eshop_lookbook') ?>?page=<?php echo $page ?>&id_eshop=<?php echo $_GET['id_eshop']; ?>"><?php echo $page ?></a>
    <?php endif; ?>
  <?php endforeach; ?>

  <a href="<?php echo url_for('@eshop_lookbook') ?>?page=<?php echo $pager->getNextPage() ?>&id_eshop=<?php echo $_GET['id_eshop']; ?>">
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/next.png', array('alt' => __('Next page', array(), 'sf_admin'), 'title' => __('Next page', array(), 'sf_admin'))) ?>
  </a>

  <a href="<?php echo url_for('@eshop_lookbook') ?>?page=<?php echo $pager->getLastPage() ?>&id_eshop=<?php echo $_GET['id_eshop']; ?>">
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/last.png', array('alt' => __('Last page', array(), 'sf_admin'), 'title' => __('Last page', array(), 'sf_admin'))) ?>
  </a>
</div>
