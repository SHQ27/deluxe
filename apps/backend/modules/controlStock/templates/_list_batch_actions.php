<?php $filtros = sfContext::getInstance()->getUser()->getAttribute('controlStock.filters', $configuration->getFilterDefaults(), 'admin_module'); ?>	

<?php if ( isset($filtros['marca']) ): ?>

<li class="sf_admin_batch_actions_choice">
  <select name="batch_action">
    <option value=""><?php echo __('Choose an action', array(), 'sf_admin') ?></option>
    <option value="batchDescargarReposicion"><?php echo __('Planilla de Reposición - Descargar', array(), 'sf_admin') ?></option>
  </select>
  <?php $form = new BaseForm(); if ($form->isCSRFProtected()): ?>
    <input type="hidden" name="<?php echo $form->getCSRFFieldName() ?>" value="<?php echo $form->getCSRFToken() ?>" />
  <?php endif; ?>
  <input type="submit" value="<?php echo __('go', array(), 'sf_admin') ?>" />
</li>

<?php endif; ?>