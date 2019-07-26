<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if IE 8 ]><html class="ie ie8" lang="es" xmlns="http://www.w3.org/1999/xhtml"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9" lang="es" xmlns="http://www.w3.org/1999/xhtml"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es" xmlns="http://www.w3.org/1999/xhtml"><!--<![endif]-->

    <head>    
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <?php $response = sfContext::getInstance()->getResponse(); ?>
        <?php $eshop = eshopTable::getInstance()->getCurrent(); ?>       
        
        <!-- START BASIC PAGE NEEDS -->
        <?php include_http_metas() ?>    
        <?php include_metas() ?>        
        <title><?php echo html_entity_decode($sf_response->getTitle(ESC_RAW)); ?></title>
        <link rel="icon" href="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/<?php echo $eshop->getIdEshop(); ?>/favicon.ico?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" type="image/x-icon"/>
        <link rel="shortcut icon" href="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/<?php echo $eshop->getIdEshop(); ?>/favicon.ico?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" />
        <!-- END BASIC PAGE NEEDS -->        
        
        <?php sfConfig::set('symfony.asset.stylesheets_included', true); ?>

        <link rel="stylesheet" type="text/css" href="<?php echo sfConfig::get('app_host_static'); ?>/css/eshop/flexslider.css?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo sfConfig::get('app_host_static'); ?>/css/eshop/smoothness/jquery-ui-1.10.3.custom.min.css?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo sfConfig::get('app_host_static'); ?>/css/eshop/mobile/reset.css?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo sfConfig::get('app_host_static'); ?>/css/eshop/mobile/style.css?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" />        
        <link rel="stylesheet" type="text/css" href="<?php echo sfConfig::get('app_host_static'); ?>/css/eshop/mobile/adaptaciones/<?php echo $eshop->getIdEshop() . '.css?v=' . cacheHelper::getInstance()->getStaticVersion(); ?>" />

        

    	<!--[if lt IE 9]>
    	<link rel="stylesheet" type="text/css" media="all" href="style-ie.css"/>
    	<![endif]-->
        
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
    	
        <script>
            var esEshop = true;
            var isMobile = true;
            var host_static =  '<?php echo sfConfig::get('app_host_static') ?>';
            var idEshop = <?php echo $eshop->getIdEshop(); ?>;
        </script>
        
        <?php sfConfig::set('symfony.asset.javascripts_included', true); ?>
        <?php foreach ($response->getJavascripts() as $file => $options): ?> 
        <script type="text/javascript" src="<?php echo sfConfig::get('app_host_static'); ?>/js/eshop/<?php echo $file . '?v=' . cacheHelper::getInstance()->getStaticVersion(); ?>"></script>
        <?php endforeach; ?>       
   
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        
          ga('create', 'UA-11788790-1', 'auto');
          ga('send', 'pageview');    
        </script>
    	
    	<script>
    		var isLogged =  <?php echo ( $sf_user->isAuthenticated() )? 'true' : 'false'; ?>;
    		var loginURL =  '<?php echo url_for('usuario') ?>';
    	</script>

        <?php if ( $eshop->getTags() ): ?>
        <?php echo $eshop->getTags(ESC_RAW); ?>
        <?php endif; ?>
    	        	    
    </head>
    
    <body class="mobile">
    
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=1467407926842746&version=v2.0";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <?php include_component('common', 'carritoRapido'); ?>

        <?php include_component('common', 'userBar'); ?>
       
        <?php include_component('common', 'mainBar'); ?>

        <?php include_component('common', 'header'); ?>

        <div class="content">
            <?php echo $sf_content ?>
        </div>

        <?php include_component('common', 'footer'); ?>
        
    </body>
	
</html>