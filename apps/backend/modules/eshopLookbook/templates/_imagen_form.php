<div class="sf_admin_form_row lookbookImage">
    <?php $eshopLookbook = $form->getObject(); ?>
    <?php $eshop = $eshopLookbook->getEshop(); ?>
	<?php echo $form["imagen"]->renderError(); ?>

	<label>
        Imagen
        <?php if ( $eshop->getLookbook() === eshopLookbook::CON_ZOOM ): ?>
        <?php $key = 'eshop_lookbook_zoom'; ?>
        <small>(<?php echo imageHelper::getInstance()->getWidth('eshop_lookbook_zoom') ?> x <?php echo imageHelper::getInstance()->getHeight('eshop_lookbook_zoom') ?>)</small>
        <?php else: ?>
        <?php $key = 'eshop_lookbook'; ?>
        <small>(Ancho <?php echo imageHelper::getInstance()->getWidth('eshop_lookbook_x' . $eshop->getLookbookImagenesFila()) ?> px - Alto Variable)</small>
        <?php endif; ?>
    </label>
	
	<?php echo $form["imagen"]; ?>
    <div class="banner_file">
    <?php if (!$eshopLookbook->isNew()) : ?>
        <div class="image">
        <img src="<?php echo imageHelper::getInstance()->getUrl($key, $eshopLookbook) ?>"/>

        <?php $eshopLookbookProductos = $eshopLookbook->getEshopLookbookProducto(); ?>
        <?php foreach ($eshopLookbookProductos as $eshopLookbookProducto):?>
        <div class="pointer" style="top: <?php echo $eshopLookbookProducto->getPositionTop(); ?>px ;left: <?php echo $eshopLookbookProducto->getPositionLeft(); ?>px; background-color: <?php echo $eshopLookbookProducto->getBackgroundColor(); ?>;" rel="<?php echo $eshopLookbookProducto->getIdProducto(); ?>"></div>
        <?php endforeach; ?>
        <div>
    <?php endif; ?>
    </div>
</div>
