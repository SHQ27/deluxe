<div id="suscripcionModal" class="register hide">
  <div class="leftContainer fleft">
    <!-- <div class="sprite homePopUpLogo" alt="homePopUpLogo"></div> -->
    <div class="sprite2 homePopUpImage" alt="homePopUpImage"></div>
  </div>
  <div class="rightContainer fleft">
    <div class="headerPopUp">
      <div class="sprite2 headerImage"></div>
      
    </div>
    <form>
      <input type="text" name="nombre" placeholder="Tu Nombre"/>
      <input type="text" name="apellido" placeholder="Tu Apellido"/>
      <input type="text" name="email" placeholder="Tu Email"/>
      <div class="gender">
      
          <div class="radioButton">
                <div class="sprite radio small Merriweather selected fleft">
                  <input id="female" type="radio" value="m" checked="checked" name="sexo" />
                </div>
            </div>
        <label for="female" class="radioLabel Merriweather femaleLabel">Mujer</label>
        <div class="radioButton">
                <div class="sprite radio small Merriweather  fleft">
                  <input id="male" type="radio" value="h" name="sexo" />
                </div>
            </div>
            <label for="male" class="radioLabel Merriweather">Hombre</label>
      </div>
      <p class="alert"></p>
      <a class="button sprite enviarNewsletterBtn" onclick="ga('send', 'event', 'boton', 'suscripcion newsletter', 'newsletter pop up');">INGRESAR</a>
    </form>
    <div class="facebook-link sprite">
        <div class="facebookButton">
                <fb:login-button size="xlarge" autologoutlink="true" perms="<?php echo sfConfig::get('app_facebook_permisos_login'); ?>" onlogin='facebookLogin.login();'>Ingresar con Facebook</fb:login-button>
                <div id="fb-root"></div>
            </div>
    </div>
    <!-- <a class="alreadyRegisterLink">ya estoy registrado</a> -->
  </div>
  <div class="footer fleft">
    <div class="sprite2 homePopUpFooter" alt="homePopUpFooter"></div>
  </div>
</div>    
   
<div id="footer">
    <?php if ($mostrarNewsletter): ?>
    <a id="newsletterModule" onclick="ga('send', 'event', 'boton', 'suscripcion newsletter', 'newsletter home');"></a>
    <?php endif; ?>
    
    <?php if ($mostrarFooterLinks): ?>
    <div class="separator"></div>
    <div id="deluxeBuysFooterModule">
        <div class="blockModule">
          <h2>seguinos!</h2>
          <ul id="seguinos">
              <li class="sprite pinterest"><a href="<?php echo sfConfig::get('app_follow_me_pinterest_url'); ?>" target="_blank"></a></li>
              <li class="sprite facebook"><a href="<?php echo sfConfig::get('app_follow_me_facebook_url'); ?>" target="_blank"></a></li>
              <li class="sprite twitter"><a href="<?php echo sfConfig::get('app_follow_me_twitter_url'); ?>" target="_blank"></a></li>
          </ul>		              
          
        </div>
        <div class="blockModule">
                <div class="imagen sprite envio"></div>
                <h2>envíos a todo el pais</h2>
        </div>
        <div class="blockModule">
            <a href="<?php echo sfConfig::get('app_follow_me_blog_url'); ?>" target="_blank">
                <div class="imagen sprite blog"></div>
                <h2>El blog de Deluxe</h2>
                <h3>últimas novedades</h3>
            </a>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if ($mostrarFooterAccesosRapidos): ?>
    <div class="separator"></div>
    <div id="links">
        <div class="blockModule space">
            <h2 class="Merriweather">consultas</h2>
            <ul>
                <li><a class="Merriweather" href="<?php echo url_for('consultas_como_comprar')?>">Como Comprar</a></li> 
                <li><a class="Merriweather" href="<?php echo url_for('consultas')?>">Preguntas Frecuentes</a></li> 
                <li><a class="Merriweather" href="<?php echo url_for('tyc')?>">Términos y Condiciones</a></li> 
            </ul>
        </div>
        <div class="blockModule space">
            <h2 class="Merriweather">mi deluxebuys</h2>
            <ul>
                <li><a class="Merriweather" href="<?php echo url_for('usuario')?>">Registro</a></li>
                <li><a class="Merriweather" href="<?php echo url_for('mi_cuenta')?>">Mis Datos Personales</a></li>
                <li><a class="Merriweather" href="<?php echo url_for('olvide_contrasena')?>">Olvide Mi Clave</a></li>
                <li><a class="Merriweather" href="<?php echo url_for('carrito')?>">Mi Carrito</a></li>
            </ul>
        </div>
        <div class="blockModule space">
            <h2 class="Merriweather">sobre deluxebuys</h2>
            <ul>
                <li><a class="Merriweather" href="<?php echo url_for('consultas'); ?>">Acerca de DeluxeBuys </a></li>
                <li><a class="Merriweather" href="<?php echo sfConfig::get('app_follow_me_blog_url'); ?>">DeluxeBuys Blog</a></li>
                <li><a class="Merriweather" href="mailto: rh@deluxebuys.com">Trabaja en DeluxeBuys</a></li>
            </ul>
        </div>
    </div> 
    <?php endif; ?>
        
    <div class="separator"></div>
    <div id="payAndCopyRight">
        <div id="formasDePago">
            <span>formas de pago</span>
            <div class="sprite formasDePago"></div>
            <a class="afip" href="https://servicios1.afip.gov.ar/clavefiscal/qr/mobilePublicInfo.aspx?req=e1ttZXRob2Q9Z2V0UHVibGljSW5mb11bcGVyc29uYT0zMDcxMTYzNTI0Ml1bdGlwb2RvbWljaWxpbz0wXVtzZWN1ZW5jaWE9MF1bdXJsPWh0dHA6Ly93d3cuZGVsdXhlYnV5cy5jb21dfQ==" target="_F960AFIPInfo">
                <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/afip-datafiscal.jpg" border="0" width="50">
            </a>


            <a class="cace" href="http://www.hotsale.com.ar/marcas/deluxebuys" target="_blank">
                <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/sello_cace.png" border="0">
            </a>
            
            <?php /*  ?>            
            <iframe src ='https://www.econfianza.org/ar/sitio/emblema_adhesion.php?e=294' width='150' height='50' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' style='margin-left: 25px;'></iframe>
            <?php */  ?>
            
        </div>
        <div id="copyright">
             <span>&copy;<?php echo date('Y'); ?></span>
             <div class="sprite copylogo"></div>
        </div>
    </div>
</div>