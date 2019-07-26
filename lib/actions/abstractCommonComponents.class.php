<?php

class abstractCommonComponents extends sfComponents
{    
  /**
   *
   * Component to draw Filters
   * 
   */
  public function executeFilter(sfWebRequest $request) 
  {      
  	$filters['marcas']['table'] = marcaTable::getInstance();
  	$filters['marcas']['field'] = "nombre";
  	$filters['marcas']['groupfamily'] = false;
  	
  	$filters['categorias']['table'] = productoCategoriaTable::getInstance();
  	$filters['categorias']['field'] = "denominacion";
  	$filters['categorias']['groupfamily'] = false;
  	
  	$filters['talles']['table'] = productoTalleTable::getInstance();
  	$filters['talles']['field'] = "denominacion";
  	$filters['talles']['groupfamily'] = true;
  	
  	$filters['colores']['table'] = familiaColorTable::getInstance();
  	$filters['colores']['field'] = "color";
  	$filters['colores']['groupfamily'] = false;
  	
  	// initialize collector
  	$collector = array();
  	
  	// Load values for each filter and composed with the table identifier
  	foreach ($filters as $table => $filter) 
  	{
  		if (!isset($this->filters[$table]['notshow'])) 
  		{
	  		$filters[$table]['values'] = $filter['table']->filter($this->filters);
	  		$filters[$table]['id'] = $filter['table']->getIdentifier();
	  		
	  		if (count($filters[$table]['values']) > 1)
	  		{
	  			// Build cols for each filter
	  			$collector[$table] = $this->_drawFilterList(
	  				$filters[$table]['values'],
	  				$filters[$table]['id'],
	  				$filters[$table]['field'],
	  				$filters[$table]['groupfamily']
	  			);
	  		}
	  		
  		}
  	}
  	
  	$totalFiltros = count($collector);
  	$showFilter = true;
  	$this->headerWidthClass = "cols" . $totalFiltros;
  	
  	if ($totalFiltros == 0)
  	{
  		$showFilter = false;
  	}

  	if (!empty($this->filters['rango'])) 
  	{
  		$rangeSet = explode(",", $this->filters['rango']);
  		$this->rangeMin = $rangeSet[0];
  		$this->rangeMax = $rangeSet[1];
  		$this->rangeSettedMin = $rangeSet[2];
  		$this->rangeSettedMax = $rangeSet[3];
  	} 
  	else 
  	{   	  		
  		$this->rangeMin = (float) productoTable::getInstance()->queryRangeFilter($this->filters, 'MIN');
  		$this->rangeMax = (float) productoTable::getInstance()->queryRangeFilter($this->filters, 'MAX');
  		$this->rangeSettedMin = $this->rangeMin;
  		$this->rangeSettedMax = $this->rangeMax;
  	}
  	
  	// Set range slider values
  	$this->showFilter = $showFilter;
  	$this->filterId = (isset($this->filterId)) ? $this->filterId : '';
  	$this->collector = $collector;
  }
  
  /**
   * 
   * Divide a filterList in columns
   * 
   * @param unknown_type $list
   * @param unknown_type $identifier
   * @param unknown_type $field
   * @param unknown_type $groupFamily
   * @param unknown_type $cols
   * @return Array $collector
   */
  protected function _drawFilterList($list, $identifier, $field, $groupFamily, $cols = 4)
  {
  	// initialize vars to create column collector
  	$collector = array(); // column collector
  	$totalList = count($list); // total of items
  	$totalRowsPerCol = ceil($totalList / $cols); // cols per row
  	$row = 0; // start with the row 0
  	$index = 0; // just a flag
  	$tmp = array();
  	
  	$collector[$row] = array();
  	for ($i = 0; $i < $totalList; $i++) 
  	{
      $object = $list[$i];
	  	if ($index == $totalRowsPerCol) 
	  	{
	  		$index = 0;
	  		$row++;
	  	}

	  	if ($groupFamily === true) 
	  	{
	  		$title = $object->family;
	  		if (!is_null($title) && !in_array($title, $tmp)) 
	  		{
	  			$tmp[] = $title;
	  			$collector[$row][$index] = $title;
	  		}
	
	  		$collector[$row][($index+1)]['id'] = $object->{$identifier};
	  		$collector[$row][($index+1)]['value'] = $object->{$field};
        $collector[$row][($index+1)]['img'] = '';
	  		
	  	} else {      
        $collector[$row][$index]['id'] = $object->{$identifier}; 
		  	$collector[$row][$index]['value'] = $object->{$field};
        $collector[$row][$index]['img'] = '';

        if ( get_class( $object ) == 'familiaColor' ) {
          $collector[$row][$index]['img'] = imageHelper::getInstance()->getUrl('familia_color', $object );
        }

	  	}

	  	$index++;
  	}

  	return $collector;
  }
  
  public function executeCarritoRapido(sfWebRequest $request)
  {
      $session = sessionTable::getInstance()->getSession();
       
      $totalItems = 0;
      $total = 0;
       
      // Items
      $carritoProductoItems = carritoProductoItemTable::getInstance()->listForCarritoRapido( $session->getIdSession() );
       
      foreach ($carritoProductoItems as $carritoProductoItem)
      {
          $totalItems += $carritoProductoItem->getCantidad();
          $total += $carritoProductoItem->getProductoItem()->getProducto()->getPrecioDeluxe() * $carritoProductoItem->getCantidad();
      }
       
      $this->carritoProductoItems = $carritoProductoItems;
    	  
      $carritoEnvio = carritoEnvioTable::getInstance()->getByIdSession( $session->getIdSession() );
      $totalEnvio = ($carritoEnvio)? $carritoEnvio->getCosto() : 0;
       
      $carritoBonificacion = carritoBonificacionTable::getInstance()->getByIdSession( $session->getIdSession() );
      $totalBonificacion = ($carritoBonificacion)? $carritoBonificacion->getMonto(true) : 0;
       
      $carritoDescuento = carritoDescuentoTable::getInstance()->getByIdSession( $session->getIdSession() );
      $totalDescuento = ($carritoDescuento)? $carritoDescuento->getMonto(true) : 0;
       
      $this->montoTotal= (float) ($total + $totalEnvio) - ($totalBonificacion + $totalDescuento);
      $this->totalItems = $totalItems;

      $this->eshop = eshopTable::getInstance()->getCurrent();
  }
  
}
