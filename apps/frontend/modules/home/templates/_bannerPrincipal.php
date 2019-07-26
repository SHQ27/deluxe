<?php if ( sfContext::getInstance()->getConfiguration()->getApplication() == 'frontend' ) : ?>
<a href="<?php echo $bannerPrincipal->getUrl(); ?>"></a>
<?php endif; ?>

<div class="image">
	<img src="<?php echo  imageHelper::getInstance()->getUrl('banner_principal_chico', $bannerPrincipal); ?>" width="292" height="280" />
	<img class="hover" src="<?php echo  imageHelper::getInstance()->getUrl('banner_principal_chico', $bannerPrincipal, 'hover'); ?>" width="292" height="280" />
	<div class="denominacion"><?php echo $bannerPrincipal->getDenominacion(); ?></div>
</div>


<?php $now = date('Y-m-d H:i'); ?> 
<?php $classFinalSale = ( '2015-08-24 09:30:00' <= $now && $now <= '2015-08-31 12:00:00' ) ? 'finalsale' : ''; ?> 

<?php if ( $bannerPrincipal->getMostrarDescripcion() ) : ?>
<div class="description">
    <?php $dias = diasFaltantes( $bannerPrincipal->getFechaHasta() ); ?>
	<div class="timeRemain">
    	<span class="contador_dias" rel="<?php echo $dias; ?>" ><?php echo $dias; ?> <?php echo( $dias != 1 ) ? ' Días' : ' Día' ?></span>
    	<span class="contador_horas columnRight"><?php echo tiempoFaltante( $bannerPrincipal->getFechaHasta() ); ?></span>
    </div>
</div>
<?php endif; ?>