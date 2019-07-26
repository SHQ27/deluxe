<?php

class importacionInicialProductosForm extends sfFormSymfony
{
  	public function configure()
  	{  	  		
  	    // Widget CSV
	    $this->setWidget( 'csv', new sfWidgetFormInputFile() );
	    $this->setValidator( 'csv', new sfValidatorString(array('required' => false)) );
	    
	    // Widget para Marcas
	    $choicesMarcas = array();
	    $marcas = marcaTable::getInstance()->listAll();
	    foreach ($marcas as $marca)
	    {
	        $choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
	    }
	    
	    $this->setWidget( 'id_marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );
	    $this->getWidget( 'id_marca' )->setLabel('Marca');
	    $this->setValidator( 'id_marca', new sfValidatorChoice( array( 'choices' => array_keys($choicesMarcas), 'required' => false ) ) );
	    
		$this->getWidgetSchema()->setNameFormat('importacionInicialProductos[%s]');
  	}

	public function process()
	{	
		$files = $_FILES['importacionInicialProductos'];

		if ( $files["error"]['csv'] == UPLOAD_ERR_OK )
		{
			$tmp_name = $files["tmp_name"]["csv"];
			move_uploaded_file( $tmp_name, sfConfig::get('sf_temp_dir') . '/importacion_2p/productos_inicial.csv');
		}
	}
}