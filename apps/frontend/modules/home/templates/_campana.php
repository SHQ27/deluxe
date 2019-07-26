<?php if ( sfContext::getInstance()->getConfiguration()->getApplication() == 'frontend' ) : ?>
<a href="<?php echo url_for('ofertas_detalles', array('slugCampana' => $campana->getSlug() ) ) ?>"></a>
<?php endif; ?>

<div class="image">
	<img src="<?php echo  imageHelper::getInstance()->getUrl('campana_banner', $campana); ?>" width="292" height="280" />
	<img class="hover" src="<?php echo  imageHelper::getInstance()->getUrl('campana_banner', $campana, 'hover'); ?>" width="292" height="280" />
	<div class="denominacion"><?php echo $campana->getDenominacion(); ?></div>
</div>


<?php $now = date('Y-m-d H:i'); ?> 
<?php $classFinalSale = ( '2015-08-24 09:30:00' <= $now && $now <= '2015-08-31 12:00:00' ) ? 'finalsale' : ''; ?> 

<?php if ( $campana->getMostrarDescripcion() ) : ?>
<div class="description">
    <?php $dias = diasFaltantes( $campana->getFechaFin() ); ?>
	<div class="timeRemain">
    	<span class="contador_dias" rel="<?php echo $dias; ?>" ><?php echo $dias; ?> <?php echo( $dias != 1 ) ? ' Días' : ' Día' ?></span>
    	<span class="contador_horas columnRight"><?php echo tiempoFaltante( $campana->getFechaFin() ); ?></span>
    </div>
</div>
<?php endif; ?>