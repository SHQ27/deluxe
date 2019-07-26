<?php

class productosEditarSetTallesForm extends sfFormSymfony
{
  	public function configure()
  	{  		  		
  	    $this->setWidget('ids', new sfWidgetFormInputHidden());
  	    $this->setValidator( 'ids', new sfValidatorPass());
  	    
  		$productos = $this->getOption('productos');

  		foreach ($productos as $producto)
  		{

  			$setTalles = talleSetTable::getInstance()->listByIdMarca( $producto->getIdMarca() );
  			
  			$choices = array('' => 'Seleccionar');
  			foreach ($setTalles as $stm)
  			{
  				$choices[$stm->id_talle_set] = $stm->denominacion;
  			}
  			
  			$this->widgetSchema['set_talle_' . $producto->getIdMarca()] = new sfWidgetFormChoice(array(
	    		'choices'  => $choices,
	    		'multiple' => false,
	    		'expanded' => false,
		    )); 
  			
  			$this->widgetSchema['set_talle_' . $producto->getIdMarca()]->setDefault( $producto->getIdTalleSet() );

		    $this->validatorSchema['set_talle_' . $producto->getIdMarca()] = new sfValidatorChoice(array('choices' => array_keys($choices), 'required' => false));
		    
  		}

		$this->getWidgetSchema()->setNameFormat('productosSetTalles[%s]');
  	}

	public function save()
	{
		$values = $this->getValues();
		
		$ids = $values['ids'];		
		
		$productos = productoTable::getInstance()->listByIdProductos( $ids );
		
		foreach ($productos as $producto)
		{
		  $idSetTalle	= $values['set_talle_' . $producto->getIdMarca()];
		  
		  if ($idSetTalle == 'null') 
		  { 
			$idSetTalle = null;
		  }
		  
		  $producto->setIdTalleSet( $idSetTalle );
          $producto->doNotPostActions( array(
          										producto::POST_ACTION_UPDATE_PRECIO,
            									producto::POST_ACTION_UPDATE_STOCK,
            									producto::POST_ACTION_CERRAR_PUBLICACION_ML
            					     ) );
		  $producto->save();
		}
	}
}