<?php $outletData = $outlet->getData(); ?>

<?php if ( sfContext::getInstance()->getConfiguration()->getApplication() == 'frontend' ) : ?>
<a href="<?php echo url_for('producto_outlet') ?>"></a>
<?php endif; ?>

<div class="image">
    <img src="<?php echo  imageHelper::getInstance()->getUrl('outlet_banner', $outlet); ?>" width="292" height="280" />
    <img class="hover" src="<?php echo  imageHelper::getInstance()->getUrl('outlet_banner', $outlet, 'hover'); ?>" width="292" height="280" />
    <div class="denominacion"><?php echo $outletData['denominacion']; ?></div>
</div>

<?php if ( $outletData['mostrar_descripcion'] ) : ?>
<div class="description">
    <?php $dias = diasFaltantes( $outletData['fecha_fin'] ); ?>
	<div class="timeRemain">
    	<span class="contador_dias" rel="<?php echo $dias; ?>" ><?php echo $dias; ?> <?php echo( $dias != 1 ) ? ' Días' : ' Día' ?></span>
    	<span class="contador_horas columnRight"><?php echo tiempoFaltante( $outletData['fecha_fin'] ); ?></span>
    </div>
</div>
<?php endif; ?>