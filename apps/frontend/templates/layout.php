<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
  <head>    
    <?php $response = sfContext::getInstance()->getResponse(); ?>
    <?php include_http_metas() ?>    
    <?php include_metas() ?>        
    
    <title><?php echo html_entity_decode($sf_response->getTitle(ESC_RAW)); ?></title>
    
	<?php $imageSrc = get_slot('imageSrc'); ?>
	<?php if ($imageSrc): ?>
	<link rel="image_src" href="<?php echo $imageSrc; ?>" />
	<?php endif; ?>
	
	<link rel="icon" href="<?php echo sfConfig::get('app_host_static'); ?>/images/favicon.ico?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" type="image/x-icon"/>
	<link rel="shortcut icon" href="<?php echo sfConfig::get('app_host_static'); ?>/images/favicon.ico?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" />
    
    <link rel="stylesheet" type="text/css" href="http://assets.zendesk.com/external/zenbox/v2.6/zenbox.css" />
    
	<?php sfConfig::set('symfony.asset.stylesheets_included', true); ?>
	<?php foreach ($response->getStylesheets() as $file => $options): ?> 
	<link rel="stylesheet" type="text/css" href="<?php echo sfConfig::get('app_host_static'); ?>/css/<?php echo $file . '?v=' . cacheHelper::getInstance()->getStaticVersion(); ?>" />
    <?php endforeach; ?>
	
	<?php sfConfig::set('symfony.asset.javascripts_included', true); ?>
	<?php foreach ($response->getJavascripts() as $file => $options): ?> 
	<script type="text/javascript" src="<?php echo sfConfig::get('app_host_static'); ?>/js/<?php echo $file . '?v=' . cacheHelper::getInstance()->getStaticVersion(); ?>"></script>
    <?php endforeach; ?>
    
    <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
    <script type="text/javascript" src="<?php echo sfConfig::get('app_host_static') ?>/js/facebookLogin.js"></script>
      
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-11788790-1', 'auto');
      ga('send', 'pageview');    
    </script>

	
	<script>
        var esEshop = false;
        var isMobile = false;
		var isLogged =  <?php echo ( $sf_user->isAuthenticated() )? 'true' : 'false'; ?>;
		var loginURL =  '<?php echo url_for('usuario') ?>';
        var host_static =  '<?php echo sfConfig::get('app_host_static') ?>';
	</script>

        <script>(function() { var _fbq = window._fbq || (window._fbq = []); if (!_fbq.loaded) { var fbds = document.createElement('script'); fbds.async = true; fbds.src = '//connect.facebook.net/en_US/fbds.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(fbds, s); _fbq.loaded = true; } _fbq.push(['addPixelId', '124045277927941']); })(); window._fbq = window._fbq || []; window._fbq.push(['track', 'PixelInitialized', {}]); </script>
        <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=124045277927941&amp;ev=PixelInitialized" /></noscript>
	    
  </head>
  <body>
  
        <div id="fb-root"></div>
	
		<div class="wrapper">
			<div id="links-menu">
				<a href="<?php echo url_for('consultas_como_comprar'); ?>">CÓMO COMPRAR</a>
				<span>/</span>
				<?php if ( !$sf_user->isAuthenticated()): ?>
				<a href="<?php echo url_for('usuario'); ?>">REGISTRATE</a>
				<?php else: ?>
				<a href="<?php echo url_for('mi_cuenta'); ?>">MI CUENTA</a>
				<span>/</span>
				<a href="<?php echo url_for('logout'); ?>">CERRAR SESIÓN</a>
				<?php endif; ?>
			</div>
		</div>
		<div id="wrapper-content">
			<div class="wrapper">
    			<div id="header">
    				<div id="logo">
    					<a href="/" class="sprite logo" alt="DeluxeBuys.com"></a>
    				</div>
    				<div id="menu-header">
    				
    				<?php $bannerHeader = configuracionTable::getInstance()->getById( configuracion::BANNER_HEADER );?>
    				    <img src="<?php echo $bannerHeader->getImage(); ?>" width="370" height="70" />
    				</div>
    				<?php include_component('common', 'carritoRapido')?>
    				
    				<div id="login">
    					<div class="sprite division"></div>
    					
	    				<?php if ( !$sf_user->isAuthenticated()): ?>
    					<a href="<?php echo url_for('usuario'); ?>" class="sprite login">
    						<span class="Merriweather">INGRESAR</span>
    						<div class="sprite rowDown"></div>
    					</a>
    					<?php else: ?>
    					<?php $usuario = $sf_user->getCurrentUser();?>
    					<a class="username" href="<?php echo url_for('mi_cuenta'); ?>">Hola<br/><?php echo $usuario->getNombre();?>!</a>
	    				<?php endif; ?>
	    				
    				</div>
    			</div>
    			
    			<?php include_component('common', 'mainBar'); ?>
    		
                <div id="content">
                <?php echo $sf_content ?>
                </div>

		    </div>
		</div>
		<div class="wrapper">
		    <?php include_component('common', 'footer'); ?>
		    <?php include_partial('common/promoModals'); ?>
		</div>

      	<div class="hide">
    	<?php if ( sfContext::getInstance()->getUser()->getFlash('registroOK') === true ): ?>
    	<?php include_partial( 'global/tagsRegistro')?>
    	<?php endif; ?>
    	</div>
		
        <?php $redirect = url_for('login_facebook', array('referrer' => 'homepage') ); ?>
        <script>
            var facebookLogin;        
            $(document).ready( function() { facebookLogin = new facebookLogin('<?php echo sfConfig::get('app_facebook_fb_api_id'); ?>','<?php echo $redirect?>'); } );
        </script>
    
        <?php $mostrarChat = configuracionTable::getInstance()->getValor( configuracion::MOSTRAR_CHAT  ); ?>
        <?php if ( $mostrarChat ): ?>
        <script type="text/javascript" src="//assets.zendesk.com/external/zenbox/v2.6/zenbox.js"></script>
    
        <script type="text/javascript">
            if (typeof(Zenbox) !== "undefined") {
                Zenbox.init({
                    dropboxID: "20082465",
                    url: "https://deluxebuys.zendesk.com",
                    tabTooltip: "Soporte",
                    tabImageURL: "<?php echo sfConfig::get('app_host_static'); ?>/images/chat_tab.png",
                    tabColor: "none",
                    borderColor: "none",
                    tabPosition: "Right"
                });
            }
        </script>
        <?php endif; ?>

        <script type="text/javascript">
            adroll_adv_id = "O6IQB5E2OZHG3IJJZFWFUV";
            adroll_pix_id = "2SNFIBKCVZHD7JPEV5QKZD";
            (function () {
            var oldonload = window.onload;
            window.onload = function(){
               __adroll_loaded=true;
               var scr = document.createElement("script");
               var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
               scr.setAttribute('async', 'true');
               scr.type = "text/javascript";
               scr.src = host + "/j/roundtrip.js";
               ((document.getElementsByTagName('head') || [null])[0] ||
                document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
               if(oldonload){oldonload()}};
            }());
        </script>
                	
  </body>
	
</html>