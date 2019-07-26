<?php include_partial('mails/header', array('eshop' => $eshop, 'title' => $title) ) ?>
	
<?php foreach ($data as $label => $value): ?>
<p>
    <strong><?php echo $label; ?>:</strong>&nbsp;&nbsp;&nbsp;<?php echo $value; ?>
</p>
<?php endforeach; ?>

<?php echo include_partial('mails/footer', array('eshop' => $eshop) ) ?>