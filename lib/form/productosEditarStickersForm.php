<?php

class productosEditarStickersForm extends sfFormSymfony
{
  	public function configure()
  	{  	
  		$this->setWidget('ids', new sfWidgetFormInputHidden());
  		$this->setValidator( 'ids', new sfValidatorPass());
  		
        $this->setWidget('sticker', new sfWidgetFormDoctrineChoice(array('model' => 'productoSticker', 'add_empty' => true)));
        $this->setValidator('sticker', new sfValidatorDoctrineChoice(array('model' => 'productoSticker', 'required' => false))); 
        		
		$this->getWidgetSchema()->setNameFormat('productosStickers[%s]');
  	}

	public function save()
	{
		$values = $this->getValues();
		
		$ids = $values['ids'];
		
		$productos = productoTable::getInstance()->listByIdProductos( $ids );
		
		foreach ($productos as $producto)
		{
                    $idProductoSticker = $values['sticker'];
                    
                    $producto->setIdProductoSticker($idProductoSticker);
          		    $producto->doNotPostActions( array(
            											producto::POST_ACTION_UPDATE_PRECIO,
            											producto::POST_ACTION_UPDATE_STOCK,
                                  producto::POST_ACTION_UPDATE_ML,
                    							producto::POST_ACTION_CERRAR_PUBLICACION_ML
            						   		 ) );
                    $producto->save();
		}
		
		cacheHelper::getInstance()->deleteByPrefix('productoSticker_listVigentes');
	}
}