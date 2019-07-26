<?php

class pmWidgetMovStock extends sfWidgetForm
{
	
  public function getJavaScripts()
  {
  	return array('pmWidgetMovStock.js');
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
    $this->addOption('stockLimitado');
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
  	$stockLimitado = (int) $this->getOption('stockLimitado', false);
  	
  	$identifier = $this->generateId($name);
  	
  	$filter  = '';
  	$filter .= '<h4>Filtro</h4>';
  	$filter .= '<div class="filters">';
  	$filter .= '	<label>Marca</label>';
  	$filter .= '	<select name="' . $identifier . '[marca]" id="' . $identifier . '_marca">';
  	
  	$marcas = marcaTable::getInstance()->listAllOrdered();
  	foreach ($marcas as $marca)
  	{
  		$filter .= '	<option value="' . $marca->getIdMarca() . '">' . $marca->getNombre() . '</option>';	
  	}
  	
  	$filter .= '	</select>';
  	$filter .= '</div>';
  	
  	$filter .= '<div class="filters">';  	
  	$filter .= '	<label>Stock Remanente en la Campaña</label>';
  	$filter .= '	<select name="' . $identifier . '[campana]" id="' . $identifier . '_campana">';
  	$filter .= '	<option value="">No filtrar por campaña</option>';  	
  	$filter .= '	</select>';
  	
  	$filter .= '</div>';
  	
  	$results  = '';
  	$results .= '<h4>Resultados</h4>';
  	$results .= '<div id="' . $identifier . '_results" class="results"></div>';
  	
  	$selectedItems  = '';
  	$selectedItems .= '<h4>Resumen de envío</h4>';
  	$selectedItems .= '<div id="' . $identifier . '_selectedItems" class="selectedItems">';
  	  	
  	
  	$fieldName = str_replace($formName . '_', '', $identifier);
  	$asignadosHTML = ( isset( $_POST[$formName][$fieldName]['html'] ) ) ? ($_POST[$formName][$fieldName]['html']) : '';
  	$asignadosData = ( isset( $_POST[$formName][$fieldName] ) ) ? ($_POST[$formName][$fieldName]) : array();
  	
  	$arr = array();
  	foreach( $asignadosData as $idProductoItem => $stock)
  	{
  	    if ( $idProductoItem == 'html') continue;
  	    $arr[] = array( 'idProductoItem' => $idProductoItem, 'stock' => $stock );
  	}
  	$asignadosData = json_encode($arr);  	  	
  	
  	if ( $asignadosHTML )
  	{
  	    $selectedItems .= $asignadosHTML;
  	}
  	else
  	{
      	$selectedItems .= '	<table>';
      	$selectedItems .= '		<tr>';
      	$selectedItems .= '			<td><strong>Id Producto Item</strong></td>';
      	$selectedItems .= '			<td><strong>Imagen Producto</strong></td>';
      	$selectedItems .= '			<td><strong>Codigo</strong></td>';
      	$selectedItems .= '			<td><strong>Producto</strong></td>';
      	$selectedItems .= '			<td><strong>Marca</strong></td>';
      	$selectedItems .= '			<td><strong>Talle</strong></td>';
      	$selectedItems .= '			<td><strong>Color</strong></td>';
      	$selectedItems .= '			<td><strong>Cantidad</strong></td>';
      	$selectedItems .= '			<td><strong>Acciones</strong></td>';
      	$selectedItems .= '		</tr>';
      	$selectedItems .= '     <tr class="no-results"><td colspan="9">No hay productos asignados</td></tr>';
      	$selectedItems .= '	</table>';
      	
      	$selectedItems .= '<h4 id="' . $identifier . '_total">Cantidad Total: 0</h4>';
  	}
  	
  	$selectedItems .= '</div>';
  	  	
  	$asginadosHidden = new sfWidgetFormInputHidden(); 
  	$selectedItems .= $asginadosHidden->render($name.'[html]');
    	
  	
    return
    	"
	    	<div class=\"pmWidgetMovStock\">
	    		$filter
	    		$results
	    		$selectedItems
				<script>
				    $(document).ready( function() { new pmWidgetMovStock('$formName', '$identifier', $stockLimitado, $asignadosData); } );
			    </script>
	    	</div>
    	";
  }
  
}
?>