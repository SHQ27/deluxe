<?php

class generarNotaCreditoForm extends sfFormSymfony
{	
  	public function configure()
  	{	  	
	  	// Widget de periodo
	  	$this->setWidget('id_pedido', new sfWidgetFormInput( ) ) ;
	  	$this->getWidget('id_pedido')->setLabel('Nº de pedido (Asociado a la nota de crédito');
	  	$this->setValidator('id_pedido', new sfValidatorNumber( array( 'required' => true ) ) );
	  		  	
	  	// Widget de periodo
	  	$this->setWidget('importe', new sfWidgetFormInput( ) ) ;
	  	$this->getWidget('importe')->setLabel('Importe');
	  	$this->setValidator('importe', new sfValidatorNumber( array( 'required' => true ) ) );
	  	
	  	$this->getWidgetSchema()->setNameFormat('generarNotaCreditoForm[%s]');
  	}

	public function generate()
	{
		$idPedido	  = (int) $this->getValue('id_pedido');
		$importe 	  = (int) $this->getValue('importe');
		$idFactura 	  = null;
		
		$configWS = sfConfig::get('app_afip_ws');		
				
		$factura = facturaTable::getInstance()->getByIdPedido($idPedido, $configWS['env'] );
		
    	if (!$factura)
		{
		    sfContext::getInstance()->getUser()->setFlash('generarNotaCredito_error', 'El Nº de Pedido informado no tiene facturas asociadas, por lo cual no se puede hacer una nota de crédito.');
		    return false;
		}
		
		ncreditoTable::getInstance()->insert( array( $idPedido ), $importe );
		return true;
	}
}