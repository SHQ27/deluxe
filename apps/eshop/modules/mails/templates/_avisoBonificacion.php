<?php include_partial('mails/header', array('eshop' => $eshop, 'title' => $title) ) ?>
	
<p>
    Gracias por tu interés en formar parte del eShop de <?php echo $eshop->getDenominacion(); ?>.
</p>

<?php echo include_partial('mails/footer', array('eshop' => $eshop) ) ?>