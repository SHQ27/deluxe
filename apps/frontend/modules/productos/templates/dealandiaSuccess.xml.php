<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<dealandiaApi:city-list xmlns:dealandiaApi="http://www.dealandia.com/ns/2010/09" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dealandia.com/ns/2010/09 http://dealandia.com/schema/2011/06/dealandia-api-schema.xsd">
<city-deals>
<coupons-country-name>Argentina</coupons-country-name>
	<?php foreach ($cuponProductos as $cuponProducto): ?>
	
	<?php $producto = $cuponProducto->getProducto();  ?>
	<?php $cupon = $cuponProducto->getCupon();  ?>	
	
	<deal>
		<url><?php echo $producto->getDetalleUrl(true); ?></url>
		<imageUrl><?php echo imageHelper::getInstance()->getUrl('producto_detalle_mediana', $producto)?></imageUrl>
		<title><?php echo $producto->getDenominacion(); ?></title>
		<description><![CDATA[<?php echo $producto->getDescripcion(); ?>]]></description>
		<price><?php echo $producto->getPrecioDeluxe(); ?></price>
		<marketPrice><?php echo $producto->getPrecioLista(); ?></marketPrice>
		<discount><?php echo 100 - floor( ( $producto->getPrecioDeluxe() / $producto->getPrecioLista() ) * 100) ; ?></discount>
		<beginTime><?php echo $cupon->getFechaDesdeToXml(); ?></beginTime>
		<endTime><?php echo $cupon->getFechaHastaToXml(); ?></endTime>
		<purchased><?php echo $producto->getVendidosHoy(); ?></purchased>
		<quantity><?php echo $producto->getCurrentStock(); ?></quantity>
		<coupon-id><?php echo $producto->getIdProducto(); ?></coupon-id>
		<dealandiaApi:business-locations>
			<dealandiaApi:business-location address="Guatemala 4551" name="Deluxe Buys S.A.">
			<dealandiaApi:geo latitude="-34.585975" longitude="-58.417188"/></dealandiaApi:business-location>
		</dealandiaApi:business-locations>
	</deal>
	<?php endforeach; ?>
</city-deals>
</dealandiaApi:city-list>