<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    El uso de procesador cayó a menos del 30%, por lo cual se recomienda reducir las instancias en ejecución.
    <br /><br />
    Verifique los gráficos de uso de procesador desde <a href="http://www.deluxebuys.com/backend/aws">http://www.deluxebuys.com/backend/aws</a>.
</p>

<?php echo include_partial('mails/footer'); ?>