<?php

class ordenarProductosEshopsForm extends sfFormSymfony
{
  	public function configure()
  	{  	      	      	      	    
      $this->setWidget('data', new sfWidgetFormInputHidden() );
      $this->setValidator('data', new sfValidatorPass() );
        
  		$this->getWidgetSchema()->setNameFormat('ordenarProductosEshops[%s]');
  	}

  	
  	public function save()
  	{
  	    $data = $this->getValue('data');
        $data = json_decode($data, true);
        foreach ($data as $idProducto => $orden) {
          productoTable::getInstance()->updateOrdenEshop( $idProducto, $orden );
        }
  	}
}