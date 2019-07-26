<?php

class consultarComprobanteAfipForm extends sfFormSymfony
{
	protected $tipoComprobanteChoices = array( Afip_WSFE::FACTURA_B => 'Factura B', Afip_WSFE::NOTA_DE_CREDITO_B => 'Nota de Credito B' );
	
  	public function configure()
  	{  		
	  	// Widget de Action
	  	$this->tipoComprobanteChoices = array( Afip_WSFE::FACTURA_B => 'Factura B', Afip_WSFE::NOTA_DE_CREDITO_B => 'Nota de Credito B' );
	  	$this->setWidget('tipoComprobante', new sfWidgetFormSelect( array('choices' => $this->tipoComprobanteChoices) ) );
	  	$this->getWidget('tipoComprobante')->setLabel('Tipo de Comprobante');
	  	$this->setValidator('tipoComprobante', new sfValidatorChoice( array( 'choices' => array_keys($this->tipoComprobanteChoices), 'required' => true ) ) );
	  	
	  	// Widget de periodo
	  	$this->setWidget('comprobante', new sfWidgetFormInput( ) ) ;
	  	$this->getWidget('comprobante')->setLabel('Nº de Comprobante');
	  	$this->setValidator('comprobante', new sfValidatorNumber( array( 'required' => true ) ) );
	  	
	  	$this->getWidgetSchema()->setNameFormat('consultarComprobanteAfipForm[%s]');
  	}

	public function getResponse()
	{
		$comprobante 	 = (int) $this->getValue('comprobante');
		$tipoComprobante = (int) $this->getValue('tipoComprobante');
		
		$response = Afip_WSFE::getInstance()->consultarComprobanteEmitido( $comprobante, $tipoComprobante );
		$response = (array) $response->FECompConsultarResult;
						
		if (isset($response['Errors']))
		{
			$error = (string)$response['Errors']->Err[0]->Msg;
			$data = array();
		}
		else 
		{
			$error = false;
			
			$data['comprobante'] = $comprobante;
			$data['tipoComprobante'] = $this->tipoComprobanteChoices[$tipoComprobante];
			$data['importe'] = formatHelper::getInstance()->decimalNumber( $response['ResultGet']->ImpTotal );
			$data['fecha'] = substr($response['ResultGet']->CbteFch, 6, 2) . '/' . substr($response['ResultGet']->CbteFch, 4, 2) . '/' . substr($response['ResultGet']->CbteFch, 0, 4);
			$data['CAE'] = $response['ResultGet']->CodAutorizacion;
			$data['CAEVencimiento'] = substr($response['ResultGet']->FchVto, 6, 2) . '/' . substr($response['ResultGet']->FchVto, 4, 2) . '/' . substr($response['ResultGet']->FchVto, 0, 4);
			$data['puntDeVenta'] = $response['ResultGet']->PtoVta;
		}
		
		return array('error' => $error, 'data' => $data);		
	}
}