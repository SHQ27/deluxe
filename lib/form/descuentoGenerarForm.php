<?php

class descuentoGenerarForm extends sfFormSymfony
{		
  	public function configure()
  	{
  	    $choices = array('-' => '-', '_' => '_', '.' => '.', '/' => '/', '|' => '|', '#' => '#', '' => 'Sin Separador');
  	    
  	    $this->setWidgets(array(
  	            'prefijo'               => new sfWidgetFormInputText(),
  	            'separador'             => new sfWidgetFormSelect( array('choices' => $choices) ),
  	            'id_tipo_descuento'     => new sfWidgetFormDoctrineChoice(array('model' => 'tipoDescuento', 'add_empty' => false)),
  	            'valor'                 => new sfWidgetFormInputText(),
  	            'vigencia_desde'        => new pmWidgetFormDateTime(),
  	            'vigencia_hasta'        => new pmWidgetFormDateTime(),  	        
  	            'cantidad'              => new sfWidgetFormInputText()
  	    ));
  	    
  	    $this->setValidators(array(
  	            'prefijo'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
  	            'separador'             => new sfValidatorString(array('required' => false)),
  	            'id_tipo_descuento'     => new sfValidatorDoctrineChoice(array('model' => 'tipoDescuento') ),
  	            'valor'                 => new sfValidatorNumber(array('required' => false)),
  	            'vigencia_desde'      => new sfValidatorDateTime(array('required' => false)),
  	            'vigencia_hasta'      => new sfValidatorDateTime(array('required' => false)),
  	            'cantidad'              => new sfValidatorInteger(array('required' => false))
  	    ));
  	    
  	    $this->widgetSchema->setNameFormat('descuentoGenerar[%s]');
  	}

	public function generar()
	{
	    $values = $this->getValues();
	    $cantidad = (int) $values["cantidad"];
	    $separador = $values["separador"];
	    
	    $conn = Doctrine_Manager::connection();
	    $conn->beginTransaction();	    
	    
	    try {
	    
    	    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    	    $max = strlen($str) - 1;
    	    
    	    $codigos = array();
    	    
    	    for( $i = 0 ; $i < $cantidad ; )
    	    {
    	        $codigo = "";
    	        for( $j = 0 ; $j < 5 ; $j++ ) $codigo .= substr($str,rand(0,$max),1);
    	        
    	        if (in_array($codigo, $codigos)) continue;
    	        
    	        $descuento = descuentoTable::getInstance()->findByCodigo($codigo);
    	        if ( count($descuento) ) continue;
    	        
    	        $codigo = $values["prefijo"] . $separador . $codigo;
    	            	    
    	        $descuento = new Descuento();
    	        $descuento->setCodigo($codigo);
    	        $descuento->setIdTipoDescuento( $values["id_tipo_descuento"] );
    	        $descuento->setValor( $values["valor"] );
    	        $descuento->setVigenciaDesde( $values["vigencia_desde"] );
    	        $descuento->setVigenciaHasta( $values["vigencia_hasta"] );
    	        $descuento->setTotal("1");
    	        $descuento->setUtilizados("0");
    	        $descuento->save();
    	        
    	        $data[] = array('idDescuento' => $descuento->getIdDescuento(), 'codigo' => $codigo);
    	        $i++;
    	    }

	        $conn->commit();
	        
	        return array( 'status' => true, 'data' => $data, 'cantidad' => $cantidad);
	    }
	    catch (Exception $e)
	    {
	        $conn->rollback();
	        echo $e->getMessage();
	        exit;
	        return array( 'status' => false );
	    }
	    	    
	}
	
}