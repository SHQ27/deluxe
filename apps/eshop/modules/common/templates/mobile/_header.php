<div class="row header">
    <div class="col21">
        <div class="logo">
            <a href="<?php echo url_for('homepage'); ?>"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/mobile/<?php echo $eshop->getIdEshop(); ?>/logo.png?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" /></a>
        </div>
    </div>
    <div class="col22">
        <div class="toolbar">
            <ul>
                <?php if ( !$sf_user->isAuthenticated()): ?>
                <li class="iconUserNotLogged"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/mobile/<?php echo $eshop->getIdEshop(); ?>/icon-login.png?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" /></li>
                <?php else: ?>
                <li class="iconUserLogged"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/mobile/<?php echo $eshop->getIdEshop(); ?>/icon-login.png?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" /></li>
                <?php endif; ?>
                <li class="iconCarrito"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/mobile/<?php echo $eshop->getIdEshop(); ?>/icon-carrito.png?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" /></li>
                <li class="iconMenu"></li>
            </ul>
        </div>
    </div>
</div>