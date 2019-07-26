<?php

class xmlAdsNetworksTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'xml-adsnetworks';
		$this->briefDescription = 'Genera el XML para distintas AdsNetworks';
		$this->detailedDescription = <<<EOF
La tarea [xml-adsnetworks|INFO] genera el XML para distintas AdsNetworks
Call it with: [php symfony deluxebuys:xml-adsnetworks|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "xmlAdsNetworks"');
		
		// Para DeluxeBuys
		$this->generarParaDeluxeBuys();

		// Para eShops
		$eshops = eshopTable::getInstance()->listAll();
		foreach ($eshops as $eshop) {
			$this->generarParaEshop( $eshop );
		}
		
		$this->log('--- Fin de ejecucion: "xmlAdsNetworks"');
	}  

	protected function generarParaDeluxeBuys() {

		$filePathVorcu =  sfConfig::get('sf_temp_dir') . '/vorcu.xml';
		$filePathFacebook =  sfConfig::get('sf_temp_dir') . '/facebook.xml';
		$filePathAdwords =  sfConfig::get('sf_temp_dir') . '/adwords.csv';

		@unlink($filePathVorcu);
		@unlink($filePathFacebook);
		@unlink($filePathAdwords);
				
		// Init Vorcu
		$xmlVorcu 	 = '<products>';


		// Init Facebook
		$xmlFacebook  = '<?xml version="1.0" encoding="utf-8"?>';
		$xmlFacebook .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
		$xmlFacebook .= '<channel>';

		// Init Adwords
		$fileAdwords = fopen($filePathAdwords, 'w');
		$data = array('ID','Item title','Final URL','Image URL','Item description','Item category','Price','Sale price');
        fputcsv($fileAdwords, $data, ',');
		
		$productos = productoTable::getInstance()->listXml();
		
		foreach ($productos as $producto)
		{			
			$productoImagenes  = productoImagenTable::getInstance()->listByIdProducto( $producto->getIdProducto() );
			$productoCategoria = $producto->getProductoCategoria();
			$productoGenero    = $productoCategoria->getProductoGenero();
		
			sfContext::getInstance()->getConfiguration()->loadHelpers('MakeUrl');
					
			$url = sfConfig::get('app_host') . '/producto/' . $productoGenero->getSlug() . '/' . $productoCategoria->getSlug() . '/' . $producto->getSlug();
					
			$masImagenes = '';
			$i = 0;
			foreach( $productoImagenes as $productoImagen )
			{
			    if ( $i == 0 )
			    {
			         $primerImagen = $productoImagen;    
			    }
			    else
			    {
			        $masImagenes .= '<image1_url><![CDATA[' . imageHelper::getInstance()->getUrl('producto_detalle_grande', $productoImagen) . ']]></image1_url>' . "\n";
			    }
			    
			    $i++;
			}			
			
			$xmlVorcu .=
			'
            <product>
                <product_id><![CDATA[' . $producto->getIdProducto() . ']]></product_id>
                <product_name><![CDATA[' . $producto->getDenominacion() . ']]></product_name>
                <product_category><![CDATA[' . $productoCategoria->getDenominacion() . ']]></product_category>
                <brand><![CDATA[' . $producto->getMarca()->getNombre() . ']]></brand>
                <url><![CDATA[' . $url . ']]></url>
                <description><![CDATA[' . $producto->getDescripcion() . ']]></description>
                <delivery_cost><![CDATA[0]]></delivery_cost>
                <previous_price><![CDATA[' . $producto->getPrecioLista() . ']]></previous_price>
                <current_price><![CDATA[' . $producto->getPrecioDeluxe() . ']]></current_price>
                <currency><![CDATA[ARS]]></currency>
                <image_thumbnail_url><![CDATA[' . imageHelper::getInstance()->getUrl('producto_lista_chica', $primerImagen) . ']]></image_thumbnail_url>
                <image_url><![CDATA[' . imageHelper::getInstance()->getUrl('producto_detalle_grande', $primerImagen) . ']]></image_url>
                ' . $masImagenes . '
            </product>
			';

			$foto1 = ( isset($productoImagenes[0]) ) ? imageHelper::getInstance()->getUrl('producto_detalle_grande', $productoImagenes[0]) : '';
			$foto2 = ( isset($productoImagenes[1]) ) ? imageHelper::getInstance()->getUrl('producto_detalle_grande', $productoImagenes[1]) : '';
			$fotoThumb = ( isset($productoImagenes[0]) ) ? imageHelper::getInstance()->getUrl('producto_thumb', $productoImagenes[0]) : '';
			


			$availability = ( $producto->estaAgotado() ) ? 'out of stock' : 'in stock';

			$xmlFacebook .=
			'
            <item>
	            <g:id>' . $producto->getIdProducto() . '</g:id>
	            <g:availability>' . $availability . '</g:availability>
	            <g:product_type><![CDATA[' . $productoGenero->getDenominacion() . ' > ' . $productoCategoria->getDenominacion() . ']]></g:product_type>
	            <g:image_link>' . $fotoThumb . '</g:image_link>
	            <g:brand><![CDATA[' . $producto->getMarca()->getNombre() . ']]></g:brand>
	            <title><![CDATA[' . $producto->getDenominacion() . ']]></title>
	            <g:price>' . $producto->getPrecioLista() . ' ARS</g:price>
	            <g:sale_price>' . $producto->getPrecioDeluxe() . ' ARS</g:sale_price>
	            <link><![CDATA[' . $url . ']]></link>
	            <description><![CDATA[' . strtolower( $producto->getDenominacion() ) . ']]></description>
            </item>
            ';

        
			$data = array(
				$producto->getIdProducto(),
				$producto->getDenominacion(),
				$url . '?source=Googleads&utm_source=Google&utm_medium=CPC&utm_campaign=RD',
				$fotoThumb,
				$producto->getDenominacion(),
				$productoGenero->getDenominacion() . ' > ' . $productoCategoria->getDenominacion(),
				$producto->getPrecioLista() . ' ARS',
                $producto->getPrecioDeluxe() . ' ARS',
			);

            fputcsv($fileAdwords, $data, ',');			
		}		


		// End Vorcu
		$xmlVorcu 	 .= '</products>';


		// End Facebook
		$xmlFacebook .= '</channel>';
		$xmlFacebook .= '</rss>';

		// End Adwords
		fclose($fileAdwords);

		file_put_contents($filePathVorcu, $xmlVorcu);
		file_put_contents($filePathFacebook, $xmlFacebook);
		file_put_contents($filePathGoogle, $xmlGoogle);
	}

	protected function generarParaEshop($eshop)
	{
		$idEshop = $eshop->getIdEshop();


		$filePathFacebook =  sfConfig::get('sf_temp_dir') . '/facebook_' . $idEshop . '.xml';

		@unlink($filePathFacebook);
				
		// Init Facebook
		$xmlFacebook  = '<?xml version="1.0" encoding="utf-8"?>';
		$xmlFacebook .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
		$xmlFacebook .= '<channel>';

		$productos = productoTable::getInstance()->listXml( $idEshop );
		
		foreach ($productos as $producto)
		{			
			$productoImagenes  = productoImagenTable::getInstance()->listByIdProducto( $producto->getIdProducto() );
			$productoCategoria = $producto->getProductoCategoria();
			$productoGenero    = $productoCategoria->getProductoGenero();
		
			sfContext::getInstance()->getConfiguration()->loadHelpers('MakeUrl');
					
			$url          = 'http://'. $eshop->getDominio() . '/producto/' . $productoCategoria->getSlug() . '/' . $producto->getSlug();		
			$fotoThumb    = ( isset($productoImagenes[0]) ) ? imageHelper::getInstance()->getUrl('producto_thumb', $productoImagenes[0]) : '';
			$availability = ( $producto->estaAgotado() ) ? 'out of stock' : 'in stock';

			$xmlFacebook .=
			'
            <item>
	            <g:id>' . $producto->getIdProducto() . '</g:id>
	            <g:availability>' . $availability . '</g:availability>
	            <g:condition>new</g:condition>
	            <g:product_type><![CDATA[' . $productoGenero->getDenominacion() . ' > ' . $productoCategoria->getDenominacion() . ']]></g:product_type>
	            <g:image_link>' . $fotoThumb . '</g:image_link>
	            <g:brand><![CDATA[' . $producto->getMarca()->getNombre() . ']]></g:brand>
	            <title><![CDATA[' . $producto->getDenominacion() . ']]></title>
	            <g:price>' . $producto->getPrecioLista() . ' ARS</g:price>
	            <g:sale_price>' . $producto->getPrecioDeluxe() . ' ARS</g:sale_price>
	            <link><![CDATA[' . $url . ']]></link>
	            <description><![CDATA[' . strtolower( $producto->getDenominacion() ) . ']]></description>
            </item>
            ';
		}		

		// End Facebook
		$xmlFacebook .= '</channel>';
		$xmlFacebook .= '</rss>';

		file_put_contents($filePathFacebook, $xmlFacebook);
	}
}
