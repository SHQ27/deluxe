                <div id="menu">
                    <ul class="topnav">
                        <li class="ofertas first">
                            <a>OFERTAS</a>
                            <div class="sub">
                                <div class="separator"></div>
                                <div class="content">
                                
                                
                                
                                    <h4><strong>Hoy,</strong> <?php echo date('d'); ?> de <?php echo strftime('%B', time()); ?> <?php echo date('Y'); ?></h4>
                                
                                    <?php $fin = count($ofertas); ?>
                                    <?php $mitad = ceil($fin/2); ?>
                                    <ul class="first">
                                        <?php for ( $i = 0; $i < $mitad ; $i++ ):?>
                                        <?php $oferta = $ofertas[$i]->getRawValue(); ?>
                                        
                                        <?php if ( get_class($oferta) == 'campana' ): ?>
                                            <?php if ( $oferta->getMostrarBanner() ): ?>
                                            <li>
                                                <a href="<?php echo url_for('ofertas_detalles', array('slugCampana' => $oferta->getSlug() ) ) ?>" alt="<?php echo $oferta->getDenominacion(); ?> title="<?php echo $oferta->getDenominacion(); ?>">
                                                    <?php echo truncate_text($oferta->getDenominacion(), 20    ); ?>
                                                    <br/>
                                                    <small><?php echo $oferta->getTextoPromocion(); ?></small>
                                                </a>
                                            </li>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php $outletData = $oferta->getData(); ?>                                          
                                            <li>
                                                <a href="<?php echo url_for('producto_outlet') ?>" alt="<?php echo $outletData['denominacion']; ?> title="<?php echo $outletData['denominacion']; ?>">
                                                    <?php echo truncate_text($outletData['denominacion'], 20    ); ?>
                                                    <br/>
                                                    <small></small>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                                                                
                                        <?php endfor; ?>
                                    </ul>
                                    <ul>
                                        <?php for ( $i = $mitad ; $i < $fin ; $i++ ):?>
                                        <?php $oferta = $ofertas[$i]->getRawValue(); ?>

                                        <?php if ( get_class($oferta) == 'campana' ): ?>
                                            <?php if ( $oferta->getMostrarBanner() ): ?>
                                            <li>
                                                <a href="<?php echo url_for('ofertas_detalles', array('slugCampana' => $oferta->getSlug() ) ) ?>" alt="<?php echo $oferta->getDenominacion(); ?> title="<?php echo $oferta->getDenominacion(); ?>">
                                                    <?php echo truncate_text($oferta->getDenominacion(), 20    ); ?>
                                                    <br/>
                                                    <small><?php echo $oferta->getTextoPromocion(); ?></small>
                                                </a>
                                            </li>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php $outletData = $oferta->getData(); ?>                                          
                                            <li>
                                                <a href="<?php echo url_for('producto_outlet') ?>" alt="<?php echo $outletData['denominacion']; ?> title="<?php echo $outletData['denominacion']; ?>">
                                                    <?php echo truncate_text($outletData['denominacion'], 20    ); ?>
                                                    <br/>
                                                    <small></small>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php endfor; ?>
                                    </ul>
                                                                        
                                    <?php if ( count($proximasOfertas) ): ?>
                                    
                                    <div class="separator"></div>
                                    
                                    <?php $fecha = strtotime($proximasOfertas[0]->getFechaInicio()); ?>
                                    
                                    
                                    <h4><strong>Proximamente</strong> <?php echo date('d', $fecha); ?> de <?php echo strftime('%B', $fecha); ?> <?php echo date('Y', $fecha); ?></h4>
                                    
                                    <?php $fin = count($proximasOfertas); ?>
                                    <?php $mitad = ceil($fin/2); ?>
                                    <ul class="first">
                                        <?php for ( $i = 0; $i < $mitad ; $i++ ):?>
                                        <?php $oferta = $proximasOfertas[$i]; ?>
                                        <li>
                                            <span alt="<?php echo $oferta->getDenominacion(); ?> title="<?php echo $oferta->getDenominacion(); ?>" ><?php echo truncate_text($oferta->getDenominacion(), 20); ?></span>
                                        </li>
                                        <?php endfor; ?>
                                    </ul>
                                    
                                    <ul>
                                        <?php for ( $i = $mitad ; $i < $fin ; $i++ ):?>
                                        <?php $oferta = $proximasOfertas[$i]; ?>
                                        <li>
                                            <span alt="<?php echo $oferta->getDenominacion(); ?> title="<?php echo $oferta->getDenominacion(); ?>"><?php echo truncate_text($oferta->getDenominacion(), 20); ?></span>
                                        </li>
                                        <?php endfor; ?>
                                    </ul>
                                    
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        </li>
                        
                        <?php foreach($categorias as $categoria) :?>
                        <li class="categorias">                        
                            <a>
                                <?php echo mb_strtoupper($categoria['productoGenero']->getDenominacion(),'utf-8') ?>
                            </a>
                            <div class="sub">
                                <div class="content">                            

                                    <ul class="first">
                                        <?php for($i = 0 ; $i < $categoria['medio'] ; $i++ ):?>
                                        <?php $productoCategoria = $categoria['productoCategorias'][$i]; ?>
                                        <li>
                                            <a alt="<?php echo $productoCategoria->getDenominacion(); ?> title="<?php echo $productoCategoria->getDenominacion(); ?>" href="<?php echo url_for('productos_listado_categoria', array('slugProductoGenero' => $categoria['productoGenero']->getSlug(), 'slugProductoCategoria' => $productoCategoria->getSlug() ) ) ?>">
                                                <?php echo truncate_text($productoCategoria->getDenominacion(), 20); ?>
                                            </a>
                                        </li>
                                        <?php endfor;?>
                                    </ul>
                                    <ul>
                                        <?php for($i = $categoria['medio'] ; $i < $categoria['length'] ; $i++ ):?>
                                        <?php $productoCategoria = $categoria['productoCategorias'][$i]; ?>
                                        <li>
                                            <a alt="<?php echo $productoCategoria->getDenominacion(); ?> title="<?php echo $productoCategoria->getDenominacion(); ?>" href="<?php echo url_for('productos_listado_categoria', array('slugProductoGenero' => $categoria['productoGenero']->getSlug(), 'slugProductoCategoria' => $productoCategoria->getSlug() ) ) ?>">
                                                <?php echo truncate_text($productoCategoria->getDenominacion(), 20); ?>
                                            </a>
                                        </li>
                                        <?php endfor;?>
                                    </ul>
                                    <ul class="stickers">
                                        <?php foreach( $productoStickers[$categoria['productoGenero']->getIdProductoGenero()] as $productoSticker ): ?>
                                        <li>
                                            <a alt="<?php echo $productoSticker->getDenominacion(); ?> title="<?php echo $productoSticker->getDenominacion(); ?>" href="<?php echo url_for('productos_listado_sticker', array('slugProductoGenero' => $categoria['productoGenero']->getSlug(), 'slugProductoSticker' => $productoSticker->getSlug()  ) ) ?>">
                                                <span class="sprite star"></span>
                                                <?php echo $productoSticker->getDenominacion(); ?>
                                            </a>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    
                                </div>         
                            </div>
                        </li>
                        <?php endforeach; ?>
                        
                        <li class="comunidad">
                            <a>COMUNIDAD</a>
                            <div class="sub">
                                <div class="separator"></div>
                                <div class="content">
                                    <ul>
                                        <li><a target="_blank" href="<?php echo sfConfig::get('app_follow_me_blog_url'); ?>">BLOG</a></li>
                                        <li><a target="_blank" href="<?php echo sfConfig::get('app_follow_me_twitter_url'); ?>">TWITTER</a></li>
                                        <li><a target="_blank" href="<?php echo sfConfig::get('app_follow_me_facebook_url'); ?>">FACEBOOK</a></li>
                                        <li><a target="_blank" href="<?php echo sfConfig::get('app_follow_me_pinterest_url'); ?>">PINTEREST</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="<?php echo url_for('consultas'); ?>">CONSULTAS</a></li>
                    </ul>
                    <div class="fb-like" data-href="http://www.deluxebuys.com" data-width="450" data-layout="button_count" data-show-faces="false" data-send="false"></div>
                    
                    <?php /* ?>
                    <div id="searchBar">
                        <input type="text" name="searchBar" placeholder="REMERAS, ZAPATILLAS...">
                        <div class="sprite searchIcon"></div>
                    </div>
                    <?php */ ?>
                </div>