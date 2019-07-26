<?php sfContext::getInstance()->getResponse()->setTitle( 'Tu compra ha sido exitosa' ); ?>

<div class="estatica">

	<h1>¡Tu compra ha sido exitosa!</h1>
	

    <p>Te hemos enviado a tu mail un detalle del pedido con el número de orden. En él encontrarás toda la información necesaria para realizar el seguimiento del pedido.</p>
    
    <a class="button "href="<?php echo url_for('homepage')?>">Seguir recorriendo el sitio</a>
        
    <p>
		Muchas gracias.
    </p>
    
	
	<p class="pie">
		deluxebuys.com
		<br/>
		Shopping Online de Moda
	<p>	
	
</div>

<!-- Google Code for OMP - Compra Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 943333905;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "KQ3dCIOLxF8QkcTowQM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/943333905/?label=KQ3dCIOLxF8QkcTowQM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<?php $idsProducto = array(); ?>
<?php foreach( $pedido->getPedidoProductoItem() as $pedidoProductoItem ): ?>
<?php $productoItem = $pedidoProductoItem->getProductoItem(); ?>
<?php $productoColor = $pedidoProductoItem->getProductoColor() ?>
<?php $productoTalle = $pedidoProductoItem->getProductoTalle() ?>
<?php $producto = $productoItem->getProducto(); ?>
<?php $idsProducto[] = $producto->getIdProducto(); ?>
<?php endforeach; ?>
	
<?php $resumenPedidos = pedidoTable::getInstance()->getResumenByIdUsuario( $pedido->getIdUsuario() ); ?>

<?php if ( isset($resumenPedidos['count']) && $resumenPedidos['count'] >= 1 ): ?>
<?php $montoTotalAdNetworks =  number_format( ($pedido->getMontoTotal() - $pedido->getMontoEnvio() ) * 0.5, 2); ?>
<?php else: ?>
<?php $montoTotalAdNetworks =  number_format(  $pedido->getMontoTotal() - $pedido->getMontoEnvio(), 2); ?>
<?php endif; ?>
	
<!-- PIXEL PAMPA NETWORKS -->
<?php if ( $montoTotalAdNetworks > 0 ): ?>
<img src="https://my.pampanetwork.com/scripts/sale.php?AccountId=6c1caa45&TotalCost=<?php echo $montoTotalAdNetworks; ?>&OrderID=<?php echo $pedido->getIdPedido(); ?>&ProductID=deluxe&ActionCode=sale&Currency=PES" width="1" height="1" >
<?php endif; ?>

<!-- PIXEL VORCU -->
<?php if ( $montoTotalAdNetworks > 0 ): ?>
<iframe src="http://t.vorc.us/SLK0?adv_sub=<?php echo $pedido->getIdPedido(); ?>&amount=<?php echo $montoTotalAdNetworks; ?>" scrolling="no" frameborder="0" width="1" height="1"></iframe>
<?php endif; ?>


<!-- Conversion Pixel - Deluxebuys AM - DO NOT MODIFY -->
<script src="http://ads.networkhm.com/px?id=141486&t=1" type="text/javascript"></script>
<!-- End of Conversion Pixel -->

<script src="http://vu.adschoom.com/trafic/retar.php?type=TRANSACTION&boutique=DELUXEBUYS&transaction_id=<?php echo $pedido->getIdPedido(); ?>&transaction_amount=<?php echo $pedido->getMontoFacturacion() - $pedido->getMontoEnvio(); ?>&valid=1&data=<?php echo implode(',', $idsProducto); ?>" async="async" defer="defer"></script>


<script>
	window._fbq = window._fbq || [];
	window._fbq.push(['track', 'Purchase', { content_ids: [<?php echo implode(',', $idsProducto); ?>], content_type: 'product' }]);
</script>

<script>(function() { var _fbq = window._fbq || (window._fbq = []); if (!_fbq.loaded) { var fbds = document.createElement('script'); fbds.async = true; fbds.src = '//connect.facebook.net/en_US/fbds.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(fbds, s); _fbq.loaded = true; } })(); window._fbq = window._fbq || []; window._fbq.push(['track', '6033090675592', {'value':'<?php echo $pedido->getMontoTotal(); ?>','currency':'ARS'}]); </script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6033090675592&amp;cd[value]=<?php echo $pedido->getMontoTotal(); ?>&amp;cd[currency]=ARS&amp;noscript=1" /></noscript>

<?php include_partial('global/tagsRemarketing', array('itemId1' => 'Compra - Confirmada', 'pageType' => 'conversion')); ?>