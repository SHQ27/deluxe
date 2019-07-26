<div id="home">
	    <div id="campaignContainer">
            <div id="mainCampaign">
                <?php if ( $bannerDestacado ): ?>
                                
                <?php $imagenes = imagenBannerPrincipalTable::getInstance()->getList( $bannerDestacado->getIdBannerPrincipal(), imagenBannerPrincipal::TIPO_BANNER_PRINCIPAL ); ?>
                                
                <ul id="carrousel-banner-principal">
                <?php foreach ($imagenes as $imagen):?>
                    <?php $src = '/banner/principal/grande/' .  $imagen->getSrc(); ?>
                	<li><img src="<?php echo sfConfig::get('app_upload_url') . $src; ?>" width="1052" height="472" /></li>
                <?php endforeach;?>
                </ul>
                
                <?php if ( $bannerDestacado->getMostrarDescripcion() ) : ?>
                <?php $dias = diasFaltantes( $bannerDestacado->getFechaHasta() ); ?>
            	<div class="timeRemain sprite">
                	<span style="color:<?php echo $bannerDestacado->getColor(); ?>;" class="contador contador_dias" rel="<?php echo $dias; ?>"><?php echo $dias; ?> <?php echo( $dias != 1 ) ? ' Días' : ' Día' ?></span>
                	<span style="color:<?php echo $bannerDestacado->getColor(); ?>;" class="contador contador_horas"><?php echo tiempoFaltante( $bannerDestacado->getFechaHasta() ); ?> hs</span>
                </div>
                <?php endif; ?>                
                <a href="<?php echo $bannerDestacado->getUrl(); ?>"></a>
                
                <?php elseif ( $campanaDestacada ): ?>
                                
                <?php $imagenes = imagenBannerPrincipalTable::getInstance()->getList( $campanaDestacada->getIdCampana(), imagenBannerPrincipal::TIPO_CAMPANA ); ?>
                                
                <ul id="carrousel-banner-principal">
                <?php foreach ($imagenes as $imagen):?>
                    <?php $src = '/campana/banner/principal/' .  $imagen->getSrc(); ?>
                	<li><img src="<?php echo sfConfig::get('app_upload_url') . $src; ?>" width="1052" height="472" /></li>
                <?php endforeach;?>
                </ul>
                
                <?php if ( $campanaDestacada->getMostrarDescripcion() ) : ?>
                <?php $dias = diasFaltantes( $campanaDestacada->getFechaFin() ); ?>
            	<div class="timeRemain sprite">
                	<span style="color:<?php echo $campanaDestacada->getColor(); ?>;" class="contador contador_dias" rel="<?php echo $dias; ?>"><?php echo $dias; ?> <?php echo( $dias != 1 ) ? ' Días' : ' Día' ?></span>
                	<span style="color:<?php echo $campanaDestacada->getColor(); ?>;" class="contador contador_horas"><?php echo tiempoFaltante( $campanaDestacada->getFechaFin() ); ?> hs</span>
                </div>
                <?php endif; ?>             
                
                <a href="<?php echo url_for('ofertas_detalles', array('slugCampana' => $campanaDestacada->getSlug() ) ) ?>"></a>
                        
                <?php elseif ( $outletDestacado ): ?>
                <?php $outletData = $outletDestacado->getData(); ?>
                <?php $imagenes = imagenBannerPrincipalTable::getInstance()->getList( 1, imagenBannerPrincipal::TIPO_OUTLET); ?>    
                                
                <ul id="carrousel-banner-principal">
                <?php foreach ($imagenes as $imagen):?>
                    <?php $src = '/outlet/banner/principal/' .  $imagen->getSrc(); ?>
                	<li><img src="<?php echo sfConfig::get('app_upload_url') . $src; ?>" width="1052" height="472" /></li>
                <?php endforeach;?>
                </ul>
                
                <?php if ( $outletData['mostrar_descripcion'] ) : ?>
                <?php $dias = diasFaltantes( $outletData['fecha_fin'] ); ?>
            	<div class="timeRemain sprite">
                	<span class="contador contador_dias" rel="<?php echo $dias; ?>"><?php echo $dias; ?> <?php echo( $dias != 1 ) ? ' Días' : ' Día' ?></span>
                	<span class="contador contador_horas"><?php echo tiempoFaltante( $outletData['fecha_fin'] ); ?> hs</span>
                </div>
                <?php endif; ?>          

                <a href="<?php echo url_for('producto_outlet') ?>"></a>
                
                <?php endif; ?>
            </div>
            <div id="campains">
                <div class="doubleBoxContainer">
                <?php $items = $items->getRawValue(); ?>
                <?php $cantItems = count( $items ); ?>
                
                <?php $limit = ( $cantItems > 4 ) ? 4 : $cantItems; ?>
                <?php if ( count( $items ) ): ?>
                <?php for ( $i = 0 ; $i < $limit; $i++ ): ?>
                <?php $item = $items[$i]; ?>                    
	                <div class="boxContainer campain bannerChico <?php echo ($i % 2) ? '' : 'columnLeft'; ?>">
	                <?php if ( $item['tipo'] == 'campana' ): ?>	                
	                <?php include_partial('campana', array('campana' => $item['item'] ) ); ?>
	                <?php elseif ( $item['tipo'] == 'bannerPrincipal' ): ?>
	                <?php include_partial('bannerPrincipal', array('bannerPrincipal' => $item['item'] ) ); ?>
	                <?php else: ?>
	                <?php include_partial('outlet', array('outlet' => $item['item'] ) ); ?>
	                <?php endif; ?>
	                </div>
                <?php endfor; ?>
                <?php endif; ?>
                </div>			                 
                
                 <div class="boxContainer campain banner">
                    <ul id="carrousel-banners">
                        <?php foreach ( $banners as $banner): ?>                        
                        <li>                                                                    
                            <a <?php echo ( $banner->getVentanaNueva() ) ? 'target="_blank"' : ''; ?> href="<?php echo $banner->getUrl(); ?>">
                                <img src="<?php echo imageHelper::getInstance()->getUrl('banner_imagen', $banner); ?>" width="292" height="580">
                            </a>

                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                	
                <?php for ( $i = $limit ; $i < $cantItems ; $i++ ): ?>
                <?php $item = $items[$i]; ?>
	                <div class="boxContainer campain bannerChico <?php echo ($i % 3 == 1) ? 'columnLeft' : ''; ?> <?php echo ($i % 3 == 0) ? 'columnRight' : ''; ?>">
                    <?php if ( $item['tipo'] == 'campana' ): ?>                 
                    <?php include_partial('campana', array('campana' => $item['item'] ) ); ?>
                    <?php elseif ( $item['tipo'] == 'bannerPrincipal' ): ?>
                    <?php include_partial('bannerPrincipal', array('bannerPrincipal' => $item['item'] ) ); ?>
                    <?php else: ?>
                    <?php include_partial('outlet', array('outlet' => $item['item'] ) ); ?>
                    <?php endif; ?>
	                </div>
                <?php endfor; ?>
               
            </div>
        </div>

    <div class="clear"></div>
    
    <?php if ( count( $proximasCampanas  ) ): ?>
    <div class="upComingCampains">
        <div id="title">
        	<div class="sprite star first"></div>
            <h2>PRÓXIMAMENTE EN DELUXEBUYS.COM</h2>
            <div class="sprite star"></div>
        </div>			        
        <ul id="carrousel-proximas-campanas">
            <?php foreach ( $proximasCampanas as $campana ): ?>
            <li>
                <h2><?php echo  truncate_text($campana->getDenominacion(), 20); ?></h2>
                <h3><?php echo strftime('%e de %B' , strtotime( $campana->getFechaInicio() ) ); ?> <span><?php echo date('H:i' , strtotime( $campana->getFechaInicio() ) ); ?></span></h3>
                <img src="<?php echo  imageHelper::getInstance()->getUrl('campana_banner', $campana); ?>" width="202" height="194" />
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <div class="clear"></div>
    <div class="bannerBottom">
        <img src="<?php echo $bannerAlPie->getImage(); ?>" />
    </div>
</div>

<script src="http://vu.adschoom.com/trafic/retar.php?type=HOME&boutique=DELUXEBUYS" async="async" defer="defer"></script>

    <?php include_partial('global/tagsRemarketing', array('itemId1' => 'deluxebuys', 'pageType' => 'home' )); ?>