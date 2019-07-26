<?php

class importarProductosForm extends sfFormSymfony
{
  	public function configure()
  	{  	  		
	    $this->setWidgets(
	    	array
	    	(
	    		'csv' => new sfWidgetFormInputFile(),
				'imagenes' => new sfWidgetFormInputFile()
	    	)
	    );
	    
	    $this->setValidators
	    (
	    	array
	    	(
				'csv' => new sfValidatorFile(array('required' => false)),
	    		'imagenes' => new sfValidatorFile(array('required' => false))
	    	)
	    );
	    
		$this->getWidgetSchema()->setNameFormat('importarProductos[%s]');
  	}

	public function process()
	{	
		$files = $_FILES['importarProductos'];
		
		if ( $files["error"]['csv'] == UPLOAD_ERR_OK )
		{
			$tmp_name = $files["tmp_name"]["csv"];
			
			move_uploaded_file( $tmp_name, sfConfig::get('sf_temp_dir') . '/importacion/productos.csv');
		}
		
		if ( $files["error"]['imagenes'] == UPLOAD_ERR_OK )
		{
			$tmp_name = $files["tmp_name"]["imagenes"];
			move_uploaded_file( $tmp_name, sfConfig::get('sf_temp_dir') . '/importacion/imagenes.zip');
		}
	}
}