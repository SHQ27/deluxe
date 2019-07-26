<?php

class pmWidgetTalleSetAssign extends sfWidgetForm
{
	
  public function getJavaScripts()
  {
  	return array('pmWidgetTalleSetAssign.js');
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
  	
  	$talleSetZonasAsignados = $this->getDefault();
  	
  	$identifier = $this->generateId($name);
  	
  	$productoTalles = productoTalleTable::getInstance()->listAll();
  	$talleZonas = talleZonaTable::getInstance()->listAll();
  	
  	$add  = '';

  	$displayAddTalle = 'block';
  	$displayAddZona = 'none';
  	if ( !count($talleSetZonasAsignados) )
  	{  	
  		$displayAddZona = 'block';
      	$displayAddTalle = 'none';
  	}
  	
    $add .= '<div class="addZona" style="display: ' . $displayAddZona . '">';
    $add .= '	<label>Zona</label>';
    $add .= '	<select id="' . $identifier . '_zona">';
    foreach ($talleZonas as $talleZona) $add .= '	<option value="' . $talleZona->getIdTalleZona() . '">' . $talleZona->getDenominacion() . '</option>';
    $add .= '	</select>';
    $add .= '  <a class="add">Agregar</a>';
    $add .= '  <span class="separator">|</span>';
    $add .= '  <a class="finish">Listo, ahora quiero agregar talles!</a>';
    $add .= '</div>';
  	
  	$add .= '<div class="addTalle" style="display: ' . $displayAddTalle . ';">';
  	$add .= '	<label>Talle</label>';
  	$add .= '	<select id="' . $identifier . '_talle">';
  	foreach ($productoTalles as $productoTalle) $add .= '	<option value="' . $productoTalle->getIdProductoTalle() . '">' . $productoTalle->getDenominacion() . '</option>';
  	$add .= '	</select>';
  	$add .= '  <a class="add">Agregar</a>';
  	$add .= '</div>';
  	
  	$table = '';
  	$table .= '<p class="aclaracion"><strong>Importante:</strong> Los talles deben estar ordenados del mas chico al mas grande. Podés ordenar las filas arrastrandolas.</p>';
  	$table .= '<table>';
  	$table .= '<thead>';
  	if ( count($talleSetZonasAsignados) )
  	{
  	    $data = $talles = $zonas = array();
  	    foreach ($talleSetZonasAsignados as $talleSetZona)
  	    {
  	        $talleZona = $talleSetZona->getTalleZona();
  	        $productoTalle = $talleSetZona->getProductoTalle();
  	        $zonas[$talleZona->getIdTalleZona()] = $talleZona->getDenominacion();
  	        $talles[$productoTalle->getIdProductoTalle()] = $productoTalle->getDenominacion();
  	        $data[$talleZona->getIdTalleZona()][$productoTalle->getIdProductoTalle()]['desde'] = $talleSetZona->getDesde();
  	        $data[$talleZona->getIdTalleZona()][$productoTalle->getIdProductoTalle()]['hasta'] = $talleSetZona->getHasta();
  	    }
  	      	      	    
  	    
  	    $colspanZonas = count($zonas) * 2;
  	    
  	    $table .= '<tr>';
  	    $table .= '    <th rowspan="3"></th>';
  	    $table .= '    <th rowspan="3">Talle</th>';
  	    $table .= '    <th colspan="' . $colspanZonas . '" class="titleZonas">Zonas</th>';
  	    $table .= '    <th></th>';
  	    $table .= '</tr>';
  	    $table .= '<tr class="zonas">';
  	    foreach($zonas as $idTalleZona => $denominacion )
  	    {
  	        $table .= '<th rel="' . $idTalleZona . '" colspan="2" class="zona">' . $denominacion . ' <a class="deleteZone" rel="' . $idTalleZona . '">(X)</a> </th>';
  	    }
  	    $table .= '    <th></th>';
  	    $table .= '</tr>';
  	    

        $table .= '<tr class="rangos">';
        foreach($zonas as $idTalleZona => $denominacion )
        {
            $table .= '<th rel="zona-' . $idTalleZona . '" colspan="">Desde</th>';
            $table .= '<th rel="zona-' . $idTalleZona . '" colspan="">Hasta</th>';
        }
        
        $table .= '    <th></th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
                
        foreach($talles as $idProductoTalle => $denominacion )
        {
            $table .= '<tr>';
            $table .= '<td class="acciones">Drag Me</td>';
            $table .= '<td rel="' . $idProductoTalle . '" class="talle">' . $denominacion . '</td>';
            
            foreach($zonas as $idTalleZona => $denominacion )
            {   
      	        $table .= '<td rel="zona-' . $idTalleZona . '"><input type="text" value="' . $data[$idTalleZona][$idProductoTalle]['desde'] . '" name="talle_set[asignacion][' . $idTalleZona . '][' . $idProductoTalle . '][desde]"></td>';
      	        $table .= '<td rel="zona-' . $idTalleZona . '"><input type="text" value="' . $data[$idTalleZona][$idProductoTalle]['hasta'] . '" name="talle_set[asignacion][' . $idTalleZona . '][' . $idProductoTalle . '][hasta]"></td>';
            }
            $table .= '<td class="acciones"><a class="remove">(X)</a></th>';
            $table .= '</tr>';
        }
        $table .= '</tbody>';
  	}
  	
  	$table .= '</table>';
  	
  	
    return
    	"
	    	<div class=\"pmWidgetTalleSetAssign\">
	    		$add
	    		$table
				<script>$(document).ready( function() { new pmWidgetTalleSetAssign('$formName', '$identifier'); } );</script>
	    	</div>
    	";
  }
  
}
?>