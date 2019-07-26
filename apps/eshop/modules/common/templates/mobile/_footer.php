<div class="footer">
    <div class="footer_content">
        <hr />
        <div class="section newsletter">
            <div class="titulo"><?php echo strtoupper( $eshop->getDenominacion() ); ?> NEWSLETTER</div>
            <div class="desc">Ingresá tu correo y recibi las últimas novedades.</div>
            <div id="newsletterModule"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/mobile/<?php echo $eshop->getIdEshop(); ?>/newsletter.jpg" /></div>
        </div>
        <hr />
        <div class="section">
            <div class="consultas">
                <div class="titulo">CONSULTAS</div>
                <ul>
                    <?php if ( $eshop->getUsaAcerca() ): ?>
                    <li class="desc acerca"><a href="<?php echo url_for('acerca'); ?>">Acerca De</a></li>
                    <?php endif; ?>
                    <li class="desc mediosPago"><a href="https://www.mercadopago.com.ar/promociones" target="_blank">Medios de Pago</a></li>
                    <li class="desc"><a href="<?php echo url_for('consultas_como_comprar'); ?>">Como Comprar</a></li>
                    <li class="desc"><a href="<?php echo url_for('consultas'); ?>">Preguntas Frecuentes</a></li>
                    <li class="desc"><a href="<?php echo url_for('tyc'); ?>">Términos & Condiciones</a></li>
                    <?php if ( $eshop->getMailRRHH() ): ?>
                    <li class="desc"><a href="mailto: <?php echo $eshop->getMailRRHH(); ?>">Trabajá en <?php echo $eshop->getDenominacion(); ?></a></li>
                    <?php endif; ?>
                    <?php if ( $eshop->getMailComercial() ): ?>
                    <li class="desc"><a href="mailto: <?php echo $eshop->getMailComercial(); ?>">Contacto Área Comercial</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="micuenta">
                <div class="titulo">MI CUENTA</div>
                <ul>
                    <?php if ( !$sf_user->isAuthenticated()): ?>
                    <li class="desc"><a href="<?php echo url_for('usuario_registro')?>">Registro</a></li>
                    <?php else: ?>
                    <li class="desc"><a href="<?php echo url_for('mi_cuenta')?>">Datos Personales</a></li>
                    <li class="desc"><a href="<?php echo url_for('carrito')?>"><?php echo $eshop->getTextoCarroDeCompras(); ?></a></li>
                    <?php endif; ?>
                    <li class="desc"><a href="<?php echo url_for('consultas')?>"><?php echo $eshop->getTextoConsultas(); ?></a></li>
                </ul>
            </div>
            <div class="row seguinos">
                <div class="col31">&nbsp;</div>
                <div class="col32">
                    <div class="titulo"><?php echo $eshop->getTextoSeguinos(); ?></div>
                    <div class="redesSociales">
                        <ul>
                            <?php if ( $eshop->getFacebook() ): ?>
                            <li class="desc"><a id="facebook" href="<?php echo $eshop->getFacebook(); ?>" target="_blank"><span class="text">Facebook</span></a></li>
                            <?php endif; ?>
                            <?php if ( $eshop->getTwitter() ): ?>
                            <li class="desc"><a id="twitter" href="<?php echo $eshop->getTwitter(); ?>" target="_blank"><span class="text">Twitter</span></a></li>
                            <?php endif; ?>
                            <?php if ( $eshop->getInstagram() ): ?>
                            <li class="desc"><a id="instagram" href="<?php echo $eshop->getInstagram(); ?>" target="_blank"><span class="text">Instagram</span></a></li>
                            <?php endif; ?>
                            <?php if ( $eshop->getYoutube() ): ?>
                            <li class="desc"><a id="youtube" href="<?php echo $eshop->getYoutube(); ?>" target="_blank"><span class="text">Youtube</span></a></li>
                            <?php endif; ?>
                            <?php if ( $eshop->getSnapchat() ): ?>
                            <li class="desc"><a id="snapchat" href="<?php echo $eshop->getSnapchat(); ?>" target="_blank"><span class="text">SnapChat</span></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col33">&nbsp;</div>
            </div>
        </div>
        <hr />
        <div class="row sectionlastline">
            <div class="col21">
                <div class="allrightsreserved">
                    © <?php echo date('Y') ?>&nbsp;<?php echo $eshop->getDenominacion(); ?><br/>ALL RIGHTS RESERVED.
                </div>
            </div>
            <div class="col22">
                <div class="datafiscal">
                    <?php if ( $eshop->getDataFiscal() ): ?>
                    <a href="<?php echo $eshop->getDataFiscal(); ?>"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/mobile/fiscal.jpg" /></a>
                    <?php endif; ?>

                    <?php if ( $eshop->getLinkCace() ): ?>
                    <a class="cace" href="<?php echo $eshop->getLinkCace(); ?>" target="_blank">
                        <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/<?php echo $eshop->getIdEshop(); ?>/sello_cace.png" border="0">
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="suscripcionModal">
    <div id="home-modal">        
        <div class="logopop"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/mobile/<?php echo $eshop->getIdEshop(); ?>/logo_pop.png?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" /></div>
        <div class="texto">
           Suscribite acá para recibir las últimas novedades y promociones.
        </div>
        
        <input type="hidden" id="sexo" name="sexo" value="<?php echo ( $eshop->getIdProductoGenero() == productoGenero::HOMBRE ) ? 'h' : 'm'; ?>"/>
        
        <div class="detalle">
            <div class="campo">
                NOMBRE (*)
                <input id="nombre" name="nombre" type="text" placeholder="Ingresa tu nombre" />
            </div>
            <div class="campo">
                APELLIDO (*)
                <input id="apellido" name="apellido" type="text" placeholder="Ingresa tu apellido" />
            </div>
            <div class="campo">
                E-MAIL (*)
                <input id="email" name="email" type="text" placeholder="Ingresa tu correo" />                   
            </div>
            
            <div class="alert"></div>
            
            <div class="botones">
                <div id="m_btRegistrar" class="enviarNewsletterBtn">REGISTRARME</div>
            </div>
            
        </div>
    </div>
</div>