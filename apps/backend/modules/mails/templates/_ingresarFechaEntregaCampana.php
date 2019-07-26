<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    En el link que figura en la parte de abajo de este mail haciendo click vas a poder descargarte las ventas en Formato Excel.    
</p>

<p>
    <strong>Cuestiones importantes:</strong>
    <br/>
    - La mercadería solicitada deberá ser entregada en el lapso de 48hs en <strong>Guatemala 4551 (Portería)</strong> en el horario de 9 a 13 hs, y de 14 a 17 hs. El costo del envío  es a cargo de la marca.
    <br/>
    - Los productos deben ser entregados  en su bolsita de plástico, caja o packaging correspondiente con su respectivo código y talle visible. Adjuntamos una foto de como debe venir, enpaquetado, y con su código visible externamente. Cualquier incumplimiento de esto será motivo de rechazo de la  mercadería.
    <br/>
    - La  mercadería debe ser entregada con su remito y factura correspondiente para agilizar el pago.
    <br/>
    - No tener en cuenta muestras dentro del stock.
    <br/><br/>    
    <strong>NOTA IMPORTANTE:</strong> ES DE SUMA RELEVANCIA EN CASO DE TENER ALGUN PRODUCTO FUERA DE STOCK (FALTANTE) QUE SE NOTIFIQUE DETALLANDO LA PRENDA, EL COLOR EL TALLE Y SU CODIGO.
</p>

<p>
    POR CUESTIONES DE ENTREGAS, FALTANTES, DEL PEDIDO CONTACTARSE CON: <strong>javier.deluxebuys@gmail.com</strong> (Javier Antelo)
    <br />
    POR CUESTIONES DE PAGOS, DIFERENCIAS DE PRECIOS, DEL PEDIDO CONTACTARSE CON: <strong>administracion@deluxebuys.com</strong> (Hernan Salerno)
</p>
<p>
    Descargá las ventas ingresando a
    <br />
    <a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host'); ?>/backend/ingresarFechaEntrega/<?php echo $hash; ?>"><?php echo sfConfig::get('app_host'); ?>/backend/ingresarFechaEntrega/<?php echo $hash; ?></a> 
</p>

<p>
    Les dejamos un mapa de como llegar a nuestras Oficinas
    <br/><br/>
    <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/mapa.jpg" alt="Como llegar a DeluxeBuys" border="0"/> 
</p>

<?php echo include_partial('mails/footer'); ?>


