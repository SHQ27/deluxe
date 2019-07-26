<?php if ( sfContext::getInstance()->getUser()->getFlash('devueltosOCA_envioOK') == 1 ): ?>
<div class="notice">Se reenvio el mail en forma correcta.</div>
<?php endif; ?>

<?php if ( sfContext::getInstance()->getUser()->getFlash('devueltosOCA_envioOK') == 2 ): ?>
<div class="notice">Se reenvio los mails a los pedidos seleccionados en forma correcta</div>
<?php endif; ?>