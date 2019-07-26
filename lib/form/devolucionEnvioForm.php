<?php

class devolucionEnvioForm extends sfFormSymfony
{		
  	public function configure()
  	{
  		
  	    // Calle
	  	$this->setWidget('calle', new sfWidgetFormInputText() );
	  	$this->setValidator('calle', new sfValidatorPass() );
	  	
	  	// Numero
	  	$this->setWidget('numero', new sfWidgetFormInputText() );
	  	$this->setValidator('numero', new sfValidatorPass() );
	  	
	  	// Piso
	  	$this->setWidget('piso', new sfWidgetFormInputText() );
	  	$this->setValidator('piso', new sfValidatorPass() );
	  	
	  	// Depto
	  	$this->setWidget('dpto', new sfWidgetFormInputText() );
	  	$this->setValidator('dpto', new sfValidatorPass() );
	  	
	  	// Codigo Postal
	  	$this->setWidget('cp', new sfWidgetFormInputText() );
	  	$this->setValidator('cp', new sfValidatorPass() );

	  	// Provincia
	  	$choicesProvincia = array();
	  	$provincias = provinciaTable::getInstance()->listAll();
	  	foreach ($provincias as $provincia)
	  	{
	  	    $choicesProvincia[ $provincia->getIdProvincia() ] = $provincia->getNombre();
	  	}
	  	
	  	$this->setWidget( 'provincia', new sfWidgetFormSelect( array('choices' => $choicesProvincia ) ) );
	  	$this->setValidator('provincia', new sfValidatorString(array('required' => false) ) );
	  	
	  	// Localidad
	  	$this->setWidget( 'localidad', new sfWidgetFormInputText( array(), array('max_length' => 50) ));
	  	$this->setValidator('localidad', new sfValidatorString(array('max_length' => 50, 'required' => false)));

		$this->getWidgetSchema()->setNameFormat('devolucionEnvio[%s]');
  	}

	public function enviarAOCA($devolucion)
	{			
	    $eshop = $devolucion->getEshop();
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
	    
		$values = $this->getValues();

		$devolucion->setCalle( $values["calle"] );
		$devolucion->setNumero( $values["numero"] );
		$devolucion->setPiso( $values["piso"] );
		$devolucion->setDpto( $values["dpto"] );
		$devolucion->setCodigoPostal( $values["cp"] );
		$devolucion->setIdProvincia( $values["provincia"] );
		$devolucion->setLocalidad( $values["localidad"] );
		$devolucion->save();

        $response = EnvioPack::getInstance( $idEshop )->imponerDevolucion( $devolucion );

        if ( !isset($response['id']) ) {
        	return array(
        		'status' => false,
        		'response' => $response,
        	);
        }

		$devolucion->setFechaEnvioOca( new Doctrine_Expression('now()') );
		$devolucion->setCodigoEnvio( $response['id'] );
		$devolucion->save();
				
    	return array(
    		'status' => true,
    		'response' => $response,
    	);
	}
	
	static protected function cleanText($text)
	{
		return utf8_decode(trim($text));
	}
	
	
}
