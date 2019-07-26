<?php

class pmWidgetProductAssign extends sfWidgetForm
{
	
  public function getJavaScripts()
  {
  	return array('pmWidgetProductAssign.js');
  }
	
/**
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options,$attributes);
    $this->addOption('formName');
  	$this->addOption('marcas');
    $this->addOption('idEshop');
  	$this->addOption('filtrosActivos', array('marca', 'eshop'));
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
  	
  	$formName = $this->getOption('formName');
  	$marcas = $this->getOption('marcas');
  	$filtrosActivos = $this->getOption('filtrosActivos');
    $idEshop = $this->getOption('idEshop');
  	
  	
  	$productosAsignados = $this->getDefault();
  	
  	
  	
  	$identifier = $this->generateId($name);
  	
  	$filter  = '';
  	$filter .= '<h4>Filtros</h4>';


    $class = ( in_array('eshop', $filtrosActivos) ) ? 'show' : 'hide';
    $filter .= '<div class="filter ' . $class . '">';
    if ( $idEshop ) {
      $filter .= '  <input type="hidden" name="' . $identifier . '[eshop]" id="' . $identifier . '_eshop" value="' . $idEshop . '">';
    } else {
      $eshops = eshopTable::getInstance()->listAll();

      $filter .= '  <label>eShop</label>';
      $filter .= '  <select name="' . $identifier . '[eshop]" id="' . $identifier . '_eshop">';
      $filter .= '      <option value="">Todos</option>';
      $filter .= '      <option value="' . eshop::ESHOP_DELUXE . '">Deluxe Buys</option>';
      foreach ($eshops as $eshop)
      {
          $filter .= '  <option value="' . $eshop->getIdEshop() . '">' .  $eshop->getDenominacion() . '</option>';
      }
      $filter .= '  </select>';
    }
    $filter .= '</div>';
  	
  	$class = ( in_array('marca', $filtrosActivos) ) ? 'show' : 'hide';
  	$filter .= '<div class="filter ' . $class . '">';
  	$filter .= '	<label>Marca</label>';
  	$filter .= '	<select name="' . $identifier . '[marca]" id="' . $identifier . '_marca">';
  	$filter .= '	    <option value="">Todas</option>';
  	foreach ($marcas as $marca)
  	{
  		$filter .= '	<option value="' . $marca->getIdMarca() . '">' . $marca->getNombre() . '</option>';	
  	}
  	$filter .= '	</select>';
  	$filter .= '</div>';
  	
  	$campanas = campanaTable::getInstance()->listAll();
  	
  	$class = ( in_array('campana', $filtrosActivos) ) ? 'show' : 'hide';
  	$filter .= '<div class="filter ' . $class . '">';
  	$filter .= '	<label>Stk. Perm. / Campaña</label>';
  	$filter .= '	<select name="' . $identifier . '[campana]" id="' . $identifier . '_campana">';
  	$filter .= '	    <option value="">Ambos</option>';
  	$filter .= '	    <option value="STKPER">Stock Permanente</option>';
  	foreach ($campanas as $campana)
  	{
  	    $desde = $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y");
  	    $hasta = $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
  	    $filter .= '	<option value="' . $campana->getIdCampana() . '">' . $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')' . '</option>';
  	}
  	$filter .= '	</select>';
  	$filter .= '</div>';
  	
  	$class = ( in_array('activo', $filtrosActivos) ) ? 'show' : 'hide';
  	$filter .= '<div class="filter ' . $class . '">';
  	$filter .= '	<label>Activo</label>';
  	$filter .= '	<select name="' . $identifier . '[activo]" id="' . $identifier . '_activo">';
    $filter .= '	    <option value="">Ambos</option>';
  	$filter .= '	    <option value="1">Si</option>';
  	$filter .= '	    <option value="0">No</option>';
  	$filter .= '	</select>';
  	$filter .= '</div>';
  	
    $categorias = productoCategoriaTable::getInstance()->listAll();
    
    $class = ( in_array('categoria', $filtrosActivos) ) ? 'show' : 'hide';
    $filter .= '<div class="filter ' . $class . '">';
    $filter .= '  <label>Categoria</label>';
    $filter .= '  <select name="' . $identifier . '[categoria]" id="' . $identifier . '_categoria">';
    $filter .= '      <option value="">Todas</option>';
    foreach ($categorias as $categoria)
    {
        $filter .= '  <option value="' . $categoria->getIdProductoCategoria() . '">' .  $categoria->getProductoGenero() . ' :: ' . $categoria->getDenominacion() . '</option>';
    }
    $filter .= '  </select>';
    $filter .= '</div>';
  	
  	$filter .= '<input type="button" class="button" value="Filtrar">';
  	$filter .= '<a class="restablecer">Restablecer</a>';
  	
  	
  	
  	$results  = '';
  	$results .= '<h4>Resultados</h4>';
  	$results .= '	<a class="allocateAll">Asignar Todos</a>';
  	$results .= '<div id="' . $identifier . '_results" class="results">';
  	$results .= '<table>';
  	$results .= '    <thead>';
  	$results .= '		<tr>';
    $results .= '     <td><strong>Código/s</strong></td>';
  	$results .= '			<td><strong>Título del producto</strong></td>';
  	$results .= '			<td><strong>Marca</strong></td>';
    $results .= '     <td><strong>eShop</strong></td>';
  	$results .= '			<td><strong>Categoría</strong></td>';
  	$results .= '			<td><strong>Diversidad</strong></td>';
  	$results .= '			<td><strong>Activo</strong></td>';
  	
  	$results .= '			<td><strong>Stk. en<br />Perm</strong></td>';
  	$results .= '			<td><strong>Stk. de<br />Campañas</strong></td>';
  	$results .= '			<td><strong>Stk. en<br />Outlet</strong></td>';
  	
  	$results .= '			<td><strong>Imagen</strong></td>';
  	$results .= '			<td><strong>Precio de Lista</strong></td>';
  	$results .= '			<td><strong>Precio Deluxebuys</strong></td>';
  	$results .= '			<td><strong>Costo</strong></td>';
  	$results .= '			<td><strong>Acción</strong></td>';
  	$results .= '		</tr>';
  	$results .= '    </thead>';
  	$results .= '    <tbody>';
  	$results .= '    <tr>';
  	$results .= '        <td colspan="15" style="text-align: center;">Debe aplicar filtros para mostrar los productos</td>';
  	$results .= '    </tr>';
  	$results .= '    </tbody>';
  	$results .= '</table>';  	
  	$results .= '</div>';  	
  	
  	$selectedItems  = '';
  	$selectedItems .= '	<h4>Asignados</h4>';
  	$selectedItems .= '	<a class="deallocateAll">Desasignar Todos</a>';
  	$selectedItems .= '<div id="' . $identifier . '_selectedItems" class="selectedItems">';
  	$selectedItems .= '	<table>';
  	$selectedItems .= '		<tr>';
    $selectedItems .= '     <td><strong>Código/s</strong></td>';
  	$selectedItems .= '			<td><strong>Título del producto</strong></td>';
  	$selectedItems .= '     <td><strong>Marca</strong></td>';
    $selectedItems .= '     <td><strong>eShop</strong></td>';
  	$selectedItems .= '			<td><strong>Categoría</strong></td>';
	  $selectedItems .= '			<td><strong>Diversidad</strong></td>';
	  $selectedItems .= '			<td><strong>Activo</strong></td>';
	
  	$selectedItems .= '			<td><strong>Stk. en<br />Perm</strong></td>';
    $selectedItems .= '			<td><strong>Stk. de<br />Campañas</strong></td>';
    $selectedItems .= '			<td><strong>Stk. en<br />Outlet</strong></td>';
  	
  	$selectedItems .= '			<td><strong>Imagen</strong></td>';
  	$selectedItems .= '			<td><strong>Precio de Lista</strong></td>';
  	$selectedItems .= '			<td><strong>Precio Deluxebuys</strong></td>';
  	$selectedItems .= '			<td><strong>Costo</strong></td>';
  	$selectedItems .= '			<td><strong>Acción</strong></td>';
  	$selectedItems .= '		</tr>';
  	
  	
  	$asignados = array();
  	
  	if ( count($productosAsignados) )
  	{
		foreach ($productosAsignados as $producto)
	  	{
	  	    $asignados[] = $producto->getIdProducto();
	  	    
  		  	$selectedItems .= '		<tr rel="' . $producto->getIdProducto() . '">';
          $selectedItems .= '     <td>' . implode( '<br />', $producto->getCodigos() ) . '</td>';
  		  	$selectedItems .= '			<td>' . $producto->getDenominacion() . '</td>';
  		  		  	
  	  		$productoCategoria 	= $producto->getProductoCategoria();
  	  		$productoGenero 	= $producto->getProductoCategoria()->getProductoGenero();

  	  		$selectedItems .= '			<td class="marca "rel="' . $producto->getMarca()->getIdMarca() . '">' . $producto->getMarca()->getNombre() . '</td>';
          $selectedItems .= '     <td>' . $producto->getEshop() . '</td>';
  		  	$selectedItems .= '			<td>' . $productoGenero->getDenominacion() . ' - ' . $productoCategoria->getDenominacion() . '</td>';

  			  $selectedItems .= '			<td>' . $producto->getDiversidad() . '</td>';
  			  $selectedItems .= '			<td>' . ( ( $producto->getActivo() )? '<img src="/backend/sfDoctrinePlugin/images/tick.png" title="Checked" alt="Checked">' : '') . '</td>';
  		  	
  		  	$selectedItems .= '			<td>' . $producto->getStockPermanente() . '</td>';
  		  	$selectedItems .= '			<td>' . $producto->getStockCampana() . '</td>';
  		  	$selectedItems .= '			<td>' . $producto->getStockOutlet() . '</td>';
  		  	$selectedItems .= '			<td>';
  		  	if ( $producto->getIdProductoSticker() )
  		  	{
  		  		$selectedItems .= '			<div class="relative"><img class="sticker" src="' . imageHelper::getInstance()->getUrl('producto_sticker_chico', $producto->getProductoSticker() ) . '" /></div>';
  		  	}
  		  	$selectedItems .= '				<img src="' . imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto) . '"/></td>';
  		  	$selectedItems .= '			</td>';
  		  	
  		  	
  		  	$precioLista = ( $producto->getPrecioLista() )? $producto->getPrecioLista() : 0;
  		  	$selectedItems .= '			<td>' . $producto->getPrecioLista() . '</td>';
  		  	
  		  	$precioDeluxe= ( $producto->getPrecioDeluxe() )? $producto->getPrecioDeluxe() : 0;
  		  	$selectedItems .= '			<td class="precioDeluxe">' . $precioDeluxe . '</td>';
  		  	
  		  	$costo = ( $producto->getCosto() )? $producto->getCosto() : 0;
  		  	$selectedItems .= '			<td>' . $costo . '</td>';
  		  	
  		  	$selectedItems .= '			<td class="center" ><a class="remove">Eliminar</a></td>';
  		  	$selectedItems .= '		</tr>';	
	  	}
	}
  	else
  	{
  		$selectedItems .= '<tr rel="0"><td colspan="15">No hay productos asignados</td></tr>';	
  	}
  	
  	$selectedItems .= '	</table>';
  	$selectedItems .= '</div>';
  	
  	$selectedItems .= '<input type="hidden" value="' . implode(',', $asignados) . '" name="' . $formName . '[asignacion]">';
  	 	  	
    return
    	"
	    	<div class=\"pmWidgetProductAssign\">
	    		$filter
	    		$results
	    		$selectedItems
				<script>var pmWidgetProductAssign; $(document).ready( function() { pmWidgetProductAssign = new pmWidgetProductAssign('$formName', '$identifier'); } );</script>
	    	</div>
    	";
  }
  
}
?>