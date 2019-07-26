<?php

class ordenCompraForm extends sfFormSymfony
{
		
  	public function configure()
  	{
	  	// Widget de Action
	  	$this->setWidget('action', new sfWidgetFormInputHidden() );
  		
	  	// Widget de periodo
	  	$this->setWidget('periodo', new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false, 'template' => '<div class="selectPeriodo">from %from_date%<br/>to %to_date%</div>')));
	  	
	  	// Widget para Campañas
	  	$choices = array();
	  	$campanas = campanaTable::getInstance()->listUltimas(60);
	  	$choices['STKPER'] = 'Stock Permanente';
	  	foreach ($campanas as $campana)
	  	{
	  		$desde = $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y");
	  		$hasta = $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
	  		$choices[$campana->getIdCampana()] = $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')';
	  	}
	  	
	  	$this->setWidget( 'stock_campana', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	  	$this->getWidget('stock_campana')->setLabel('Stk. Perm. / Campaña');
	    
	  	// Widget para Marcas
	  	$choicesMarcas = array();
	  	$marcas = marcaTable::getInstance()->listAll();
	  	$choicesMarcas[''] = 'Todas';
	  	foreach ($marcas as $marca)
	  	{ 
	  		$choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
	  	}
	  	$this->setWidget( 'marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );
	  	
		$this->getWidgetSchema()->setNameFormat('ordenCompra[%s]');

		// Widget para Tipo de Stock
		$choicesTipoStock = array(
			'' 							       => 'Todos',
		    Producto::ORIGEN_STOCK_PERMANENTE  => 'Solo Stock Permanente',
		    Producto::ORIGEN_OUTLET            => 'Solo Stock de Outlet',
		    Producto::ORIGEN_OFERTA            => 'Solo Stock de Campaña',
		    Producto::ORIGEN_REFUERZO          => 'Solo Stock de Refuerzo'
		);

		$this->setWidget( "origen_stock", new sfWidgetFormSelect( array('choices' => $choicesTipoStock) ) );
		$this->getWidget( "origen_stock" )->setLabel('Tipo de Stock');
		
		// Widget para Columna de ids de pedidos
		$choicesMostrarPedidos = array( 0 => 'No', 1 => 'Si');
		$this->setWidget( "mostrar_pedidos", new sfWidgetFormSelect( array('choices' => $choicesMostrarPedidos) ) );
		$this->getWidget( "mostrar_pedidos" )->setLabel('Mostrar columna de pedidos');

	    $this->setValidators
	    (
	    	array
	    	(
	    		'action'		=> new sfValidatorPass(),
			    'periodo'		=> new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
			    'stock_campana'	=> new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ),
	    		'marca'			=> new sfValidatorChoice( array( 'choices' => array_keys($choicesMarcas), 'required' => false ) ),
	    	    'origen_stock'  => new sfValidatorChoice( array( 'choices' => array_keys($choicesTipoStock), 'required' => false ) ),
	    	    'mostrar_pedidos'  => new sfValidatorChoice( array( 'choices' => array_keys($choicesMostrarPedidos), 'required' => false ) ),
	    	)
	    );
	    
	    // Widget para eShops
	    $choices = array();
	    $eshops = eshopTable::getInstance()->listAll();
	    $choices[''] = 'Deluxe Buys';
	    foreach ($eshops as $eshop)
	    {
	        $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
	    }
	    $this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	    $this->getWidget( 'id_eshop' )->setLabel('eShop');
	    $this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );
	    
  	}

	public function download()
	{	    
		set_time_limit(0);
		
		$downloadEnabled = ($this->getValue('action') == 'Descargar');
		
		$data = array();
		
		// Elimino los archivos viejos
		$oldFiles = glob('/tmp/orden_de_compra_*');
		foreach ($oldFiles as $file) @unlink($file);
		
		$idEshop = $this->getValue('id_eshop');
		$periodo = $this->getValue('periodo');
		$fechaDesde = $periodo['from']; 
		$fechaHasta = $periodo['to'];
		$mostrarPedidos = $this->getValue('mostrar_pedidos');
		
		$eshop = eshopTable::getInstance()->getById( $idEshop );
	    $eshopNombre = ($eshop)? $eshop->getDenominacion() : 'Deluxe Buys';
	    $eshopSlug = StringHelper::getInstance()->slug( $eshopNombre ); 

		if ( $idEshop ) {
			$idMarca = $eshop->getIdMarca();
		} else {
			$idMarca = $this->getValue('marca');
		}
		
		$origenStock = $this->getValue('origen_stock');
		
		$stockCampana = $this->getValue('stock_campana');
		if ($stockCampana == 'STKPER')
		{
			$idMarcas = array();
						
			if ($idMarca)
			{
				$productos = ordenCompraHelper::getInstance()->makeOrdenCompra($idEshop, $fechaDesde, $fechaHasta, $idMarca, $downloadEnabled, null, null, $origenStock, $mostrarPedidos);
				
				if ( count($productos) )
				{
				    $data[] = array('marca' => marcaTable::getInstance()->getOneById($idMarca) , 'productos' => $productos);
				} 
			}
			else 
			{
				$marcas = marcaTable::getInstance()->listMarcasForOrdenDeCompra($fechaDesde, $fechaHasta);
				
				$zipGroup = time();
				
				foreach ($marcas as $marca)
				{
					$productos = ordenCompraHelper::getInstance()->makeOrdenCompra($idEshop, $fechaDesde, $fechaHasta, $marca->getIdMarca(), $downloadEnabled, null, $zipGroup, $origenStock, $mostrarPedidos);
					
					if ( count($productos) )
					{
					    $data[] = array('marca' => $marca, 'productos' => $productos);
					}
					
				}
				
				if ( $downloadEnabled )
				{
					// Creo el zip
					$zip = new ZipArchive();
					$zipname = tempnam(sys_get_temp_dir(), 'zip');
					$zip->open( $zipname, ZIPARCHIVE::CREATE);
					
					foreach ($marcas as $marca)
					{
						$zip->addFile( sfConfig::get('sf_temp_dir') . '/orden_de_compra_' . $eshopSlug . '_' . $marca->getSlug() . '_' . $zipGroup . '.xls', 'orden_de_compra_' . $marca->getSlug() . '.xls');
					}
					
					$zip->close();

					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
					header('Content-type: application/zip');
					header("Content-Length: ".filesize(sfConfig::get('sf_temp_dir') . '/'.$zipName));	
					header('Content-Disposition: attachment; filename="orden_de_compra.zip"');
				
					readfile( $zipname );
					unlink($zipname);
					exit;
				}
			}
		}
		else 
		{
			$idCampana = $stockCampana;
			$productos = ordenCompraHelper::getInstance()->makeOrdenCompra($idEshop, $fechaDesde, $fechaHasta, $idMarca, $downloadEnabled, $idCampana, null, $origenStock, $mostrarPedidos);
			$data[] = array('campana' => campanaTable::getInstance()->getById($idCampana), 'productos' => $productos);
		}
				
		return $data;
	}
	

	
}