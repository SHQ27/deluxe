<?php $url = sfConfig::get('app_host') . '/ofertas/' . $form->getObject()->getSlug(); ?>

<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_denominacion">
    <div>
        <?php echo $form['denominacion']->renderLabel(); ?>
        <div class="content">
            <?php echo $form['denominacion']; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="link" href="<?php echo $url; ?>"><?php echo $url; ?></a>
        </div>
    </div>
</div>