<?php

class productosPublicarMLForm extends sfFormSymfony
{
  	public function configure()
  	{
  		$this->setWidget('ids', new sfWidgetFormInputHidden());
  		$this->setValidator( 'ids', new sfValidatorPass());
  	      	    
		$this->getWidgetSchema()->setNameFormat('productosPublicarML[%s]');
  	}

	public function publicar()
	{
	    $values = $this->getValues();
	    
	    $ids = $values['ids'];
	    $idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();

	    $productos = productoTable::getInstance()->listByIdProductos( $ids );
	     
	    $result = array();
	    foreach( $productos as $producto )
	    {
	        $response = MercadoLibre::getInstance()->publicar($producto);
	    
	        if ( $response !== false )
	        {
	            $result[$producto->getIdProducto()] = $response;
	        }
	    }
	    
	    $response = array('ids' => $ids, 'result' => $result);
	     
	    // Creo la notificacion
	    $notificacionBackend = new notificacionBackend();
	    $notificacionBackend->setTipo( notificacionBackend::TIPO_PRODUCTO_PUBLICAR_ML );
	    $notificacionBackend->setResponse( json_encode( $response ) );
	    $notificacionBackend->setIdUsuario( $idUsuario );
	    $notificacionBackend->save();
	}
}