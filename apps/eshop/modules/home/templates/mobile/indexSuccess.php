<?php foreach ($eshopHomes as $eshopHome): ?>
	<?php $tipo = $eshopHome->getTipo();?>
	<?php $subIndice = null; ?>

	<?php // Adecuacion a Grilla  ?>
	<?php preg_match('/GRLA([0-9]+)/', $tipo, $match); ?>
	<?php if ( isset( $match[1] ) ): ?>
	<?php   $subIndice = $match[1]; ?>
	<?php   $tipo = 'GRLAX'; ?>
	<?php endif; ?>

	<?php // Adecuacion a Banner Secundario ?>
	<?php preg_match('/BSX2([0-9]+)/', $tipo, $match); ?>
	<?php if ( isset( $match[1] ) ): ?>
	<?php   $subIndice = $match[1]; ?>
	<?php   $tipo = 'BSX2X'; ?>
	<?php endif; ?>
	
	<?php include_partial( $tipo , array('eshopHome' => $eshopHome, 'productosDestacados' => $productosDestacados, 'subIndice' => $subIndice ) ); ?>
<?php endforeach ?>