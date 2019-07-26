        <section id="info" class="seccion">
        	<div class="container">
        		<div class="datos inline">
        			<div class="lista inline">
        				<div class="titulo MS-13 bold">CONSULTAS</div>
        				<div class="items">
                            <?php if ( $eshop->getUsaAcerca() ): ?>
                            <a href="<?php echo url_for('acerca'); ?>" class="item OS-11 lh21 acerca">Acerca De</a>
                            <?php endif; ?>
                            <a href="https://www.mercadopago.com.ar/promociones" class="item OS-11 lh21 mediosPago" target="_blank">Medios de Pago</a>
        					<a href="<?php echo url_for('consultas_como_comprar'); ?>" class="item OS-11 lh21">Como Comprar</a>
        					<a href="<?php echo url_for('consultas'); ?>" class="item OS-11 lh21">Preguntas Frecuentes</a>
        					<a href="<?php echo url_for('tyc'); ?>" class="item OS-11 lh21">Términos & Condiciones</a>
                            <?php if ( $eshop->getMailRRHH() ): ?>
                            <a href="mailto: <?php echo $eshop->getMailRRHH(); ?>" class="item OS-11 lh21">Trabajá en <?php echo $eshop->getDenominacion(); ?></a>
                            <?php endif; ?>
                            <?php if ( $eshop->getMailComercial() ): ?>
                            <a href="mailto: <?php echo $eshop->getMailComercial(); ?>" class="item OS-11 lh21">Contacto Área Comercial</a>
                            <?php endif; ?>
        				</div>
        			</div>
                    <div class="lista inline miCuenta">
        				<div class="titulo MS-13 bold">MI CUENTA</div>
        				<div class="items">
        					<a href="<?php echo url_for('usuario')?>" class="item OS-11 lh21">Registro</a>
        					<a href="<?php echo url_for('mi_cuenta')?>" class="item OS-11 lh21">Datos Personales</a>
        					<a href="<?php echo url_for('carrito')?>" class="item OS-11 lh21"><?php echo $eshop->getTextoCarroDeCompras(); ?></a>
        					<a href="<?php echo url_for('consultas')?>" class="item OS-11 lh21"><?php echo $eshop->getTextoConsultas(); ?></a>
        				</div>
        			</div>
                    <div class="lista inline">
                        <div class="titulo MS-13 bold"><?php echo $eshop->getTextoSeguinos(); ?></div>
                        <div class="items">
                            <?php if ( $eshop->getFacebook() ): ?>
                            <a id="facebook" href="<?php echo $eshop->getFacebook(); ?>" target="_blank" class="item red OS-11 lh21">Facebook</a>
                            <?php endif; ?>
                            <?php if ( $eshop->getTwitter() ): ?>
                            <a id="twitter" href="<?php echo $eshop->getTwitter(); ?>" target="_blank" class="item red OS-11 lh21">Twitter</a>
                            <?php endif; ?>
                            <?php if ( $eshop->getInstagram() ): ?>
                            <a id="instagram" href="<?php echo $eshop->getInstagram(); ?>" target="_blank" class="item red OS-11 lh21">Instagram</a>
                            <?php endif; ?>
                            <?php if ( $eshop->getYoutube() ): ?>
                            <a id="youtube" href="<?php echo $eshop->getYoutube(); ?>" target="_blank" class="item red OS-11 lh21">Youtube</a>
                            <?php endif; ?>
                            <?php if ( $eshop->getSnapchat() ): ?>
                            <a id="snapchat" href="<?php echo $eshop->getSnapchat(); ?>" target="_blank" class="item red OS-11 lh21">SnapChat</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="lista inline logoVisa">
                        <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/logo_visa.jpg" />
                    </div>

        		</div>
        		<div class="divisor_v inline" style="height: 140px;"></div>
        		<div class="inline newsletter">
        			<div class="titulo MS-13 bold">SUSCRIPCION A NEWSLETTER</div>
        			<div class="texto OS-11 lh21">
        			Ingresá tu correo y recibi
        			<br /> 
        			las últimas novedades.
        			</div>
        			<div id="newsletterModule" style="margin-top: 20px;">
        				<input type="text" placeholder="Ingrese su Correo" /><div class="boton inline"></div>
        			</div>
                    <div class="social MS-13 bold inline">
                        <p class="inline">DALE LIKE!</p>
                        <div class="fb-like" data-href="http://<?php echo $eshop->getDominio(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
                    </div>
        		</div>
        	</div>
        </section>
        
        <section id="footer" class="seccion">
        	<div class="container">
        		<div class="contenido OS-11 bold lh21 color9">
            		-
            		<br />
            		<strong><?php echo $eshop->getDenominacion(); ?> © <?php echo date('Y') ?></strong>
            		<br />
            		<span class="regular">TODOS LOS DERECHOS RESERVADOS</span>
        		</div>
				<?php if ( $eshop->getDataFiscal() ): ?>
				<a class="fiscal" href="<?php echo $eshop->getDataFiscal(); ?>"></a>
			    <?php endif; ?>
                <?php if ( $eshop->getLinkCace() ): ?>
                <a class="cace" href="<?php echo $eshop->getLinkCace(); ?>" target="_blank">
                    <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/<?php echo $eshop->getIdEshop(); ?>/sello_cace.png" border="0">
                </a>
                <?php endif; ?>
        	</div>
        </section>
        
        
        <div id="suscripcionModal">
            <div id="home-modal">        
            	<div class="logo alignC"></div>
            	<div class="texto OS-11 alignC lh16">
                   ¡Bienvenido a <?php echo $eshop->getDenominacion(); ?>!
                   <br />
                   Suscribite acá para recibir nuestra novedades por email.
        	    </div>
            	<div class="linea"><div class="triangulos"></div></div>
            	
            	<input type="hidden" id="sexo" name="sexo" value="<?php echo ( $eshop->getIdProductoGenero() == productoGenero::HOMBRE ) ? 'h' : 'm'; ?>"/>
            	
            	<div class="detalle">
            		<div class="campo MS-13">
            		    NOMBRE (*)
            			<input id="nombre" name="nombre" type="text" placeholder="Ingresa tu nombre" />
            		</div>
            		<div class="campo MS-13">
            		    APELLIDO (*)
            			<input id="apellido" name="apellido" type="text" placeholder="Ingresa tu apellido" />
            		</div>
            		<div class="campo MS-13">
            		    E-MAIL (*)
            			<input id="email" name="email" type="text" placeholder="Ingresa tu correo" />        			
            		</div>
            		
            		<div class="alert MS-13 rojo"></div>
            		
            		<div class="botones">
            			<div id="m_btRegistrar" class="btOscuro inline MS-15 bold color7 enviarNewsletterBtn">REGISTRARME</div>
            		</div>
            		
            	</div>
        	</div>
        </div>