<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>

    <?php include_title() ?>
    
    <?php $response = sfContext::getInstance()->getResponse(); ?>
                
	<?php sfConfig::set('symfony.asset.stylesheets_included', true); ?>
	<?php foreach ($response->getStylesheets() as $file => $options): ?>
		 	
	<?php if (stripos($file, 'http') === false): ?>
	<link rel="stylesheet" type="text/css" href="<?php echo sfConfig::get('app_host'); ?>/backend/css/<?php echo str_replace('/sfDoctrinePlugin', '../sfDoctrinePlugin', $file) . '?v=' . cacheHelper::getInstance()->getStaticVersion(); ?>" />
	<?php else: ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $file; ?>" />
	<?php endif; ?>	
    <?php endforeach; ?>
	
	
	
	<?php sfConfig::set('symfony.asset.javascripts_included', true); ?>
	<?php foreach ($response->getJavascripts() as $file => $options): ?>
	<?php if (stripos($file, 'http') === false): ?>
	<script type="text/javascript" src="<?php echo sfConfig::get('app_host'); ?>/backend/js/<?php echo $file . '?v=' . cacheHelper::getInstance()->getStaticVersion(); ?>"></script>
	<?php else: ?>
	<script type="text/javascript" src="<?php echo $file; ?>"></script>
	<?php endif; ?>
	
    <?php endforeach; ?>

  </head>
  <body>
        <div class="header">
            <div class="top-bar"></div>
            <div class="bar">
                <a href="/backend/" class="logo deluxe active">
                    DeluxeBuys - Panel de Administración
                </a>
                
                <a id="notificaciones" href="<?php echo url_for('notificacion_backend'); ?>">
                    Notificaciones <span></span>
                </a>
                
                <a href="http://www.pragmore.com/" target="_blank" class="logo pragmore active">
                    <img alt="Logo pragmore" src="/backend/images/logoPragmore.png">
                </a>
            </div>
            <div class="bottom-bar"></div>
            <?php include_component('sfAdminDash','header'); ?>            
        </div>
        
        <?php echo $sf_content ?>
    	<?php include_partial('sfAdminDash/footer'); ?>
  </body>
</html>
