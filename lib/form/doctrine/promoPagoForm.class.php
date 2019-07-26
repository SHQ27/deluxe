<?php

/**
 * promoPago form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class promoPagoForm extends BasepromoPagoForm
{
  public function configure()
  {

    unset( $this->widgetSchema['dias_semana'], $this->widgetSchema['cuotas'] );
    unset( $this->validatorSchema['dias_semana'], $this->validatorSchema['cuotas'] );

  	$promoPago = $this->getObject();

    // Forma de pago
  	$choices = array( '' => '', formaPago::DECIDIR => 'Decidir', formaPago::NPS => 'NPS' );

  	$this->setWidget('id_forma_pago', new sfWidgetFormSelect( array('choices' => $choices) ) );
  	$this->setValidator('id_forma_pago', new sfValidatorChoice( array('choices' => array_keys($choices) ) ) );

    // Identificador
  	$this->setWidget('identificador', new sfWidgetFormInput( array(), array('placeholder' => 'Completar solo si aplica a la promoción') ) );
  	$this->setValidator('identificador', new sfValidatorString() );

    $params = $promoPago->getParams();
    $params = json_decode($params, true);

    if ( count( $params ) ) {
      if ( $promoPago->getIdFormaPago() == formaPago::NPS ) {
        $this->setDefault('identificador', $params['promotionCode']);
      } else {
        $this->setDefault('identificador', $params['IDSITE']);
      }
    }


  	// Vigencia
    $this->setWidget('vigencia_desde', new pmWidgetFormDateTime() );
    $this->setValidator('vigencia_desde', new sfValidatorDateTime( array('required' => true) ) );

    $this->setWidget('vigencia_hasta', new pmWidgetFormDateTime() );
    $this->setValidator('vigencia_hasta', new sfValidatorDateTime( array('required' => true) ) );

    // Dias de la Semana
    $choices = array( '2' => 'Lunes', '3' => 'Martes', '4' => 'Miércoles', '5' => 'Jueves', '6' => 'Viernes', '7' => 'Sabado', '1' => 'Domingo' );
    $this->setWidget( "dias_de_semana", new sfWidgetFormSelectDoubleList( array('choices' => $choices, 'label_unassociated' => 'No Asociadas', 'label_associated' => 'Asociadas') ) );
    $this->setValidator( "dias_de_semana", new sfValidatorChoice( array('choices' => array_keys($choices), 'multiple' => true, 'required' => false ) ) );
    $this->getWidget("dias_de_semana")->setLabel('Restricion por dia de la semana<br/><br/><small>(Si no se asocia ningún dia,<br/>la promocion aplicará para todos los dias)</small>');

  	if ( $promoPago->getDiasSemana() ) {
  		$this->setDefault("dias_de_semana", explode(',', $promoPago->getDiasSemana() ) );
  	}	

    // Cuotas
    $choices = array();
    for( $i = 1 ; $i <= 24 ; $i++ ) { $choices[$i] = $i; }
    $this->setWidget( "definicion_cuotas", new sfWidgetFormSelectDoubleList( array('choices' => $choices, 'label_unassociated' => 'No Asociadas', 'label_associated' => 'Asociadas') ) );
    $this->setValidator( "definicion_cuotas", new sfValidatorChoice( array('choices' => array_keys($choices), 'multiple' => true, 'required' => true ) ) );
    $this->getWidget("definicion_cuotas")->setLabel('Cuotas <small>Sin interés</small>');

    if ( $promoPago->getCuotas() ) {
      $this->setDefault("definicion_cuotas", explode(',', $promoPago->getCuotas() ) );
    } 

  	// Proveedor
    	$choices = array(
        '' => '',
  		  formaPago::DECIDIR . '-' . Decidir::PAGO_VISA => formaPago::DECIDIR . '|Visa',
  		  formaPago::DECIDIR . '-' . Decidir::PAGO_AMERICAN => formaPago::DECIDIR . '|American Express',
        formaPago::DECIDIR . '-' . Decidir::PAGO_MASTERCARD => formaPago::DECIDIR . '|MasterCard',
  	    formaPago::NPS . '-' . NPS::PAGO_VISA => formaPago::NPS . '|Visa',
  	    formaPago::NPS . '-' . NPS::PAGO_AMERICAN => formaPago::NPS . '|American Express',
  	    formaPago::NPS . '-' . NPS::PAGO_MASTERCARD => formaPago::NPS . '|MasterCard',
  	);


  	$this->setWidget('tarjeta', new sfWidgetFormSelect( array('choices' => $choices) ) );
  	$this->setValidator('tarjeta', new sfValidatorChoice( array('choices' => array_keys($choices) ) ) );
  	$this->setDefault('tarjeta', $promoPago->getIdFormaPago() . '-' . $promoPago->getProveedor() );


    // Descuento
    $descuento = $promoPago->getDescuento();
  	$choices = array( 'BANCO' => 'El descuento lo realiza el banco en su totalidad', 'DELUXE' => 'Parte del descuento debe realizarse en el checkout');

  	$this->setWidget('descuento_tipo', new sfWidgetFormSelect( array('choices' => $choices) ) );
  	$this->setValidator('descuento_tipo', new sfValidatorChoice( array('choices' => array_keys($choices) ) ) );
  	$this->getWidget("descuento_tipo")->setLabel('Forma de descuento');
  	if ( $descuento->getIdDescuento() ) {
      $this->setDefault("descuento_tipo", 'DELUXE');
    } else {
      $this->setDefault("descuento_tipo", 'BANCO');
    }

  	$choices = array();
  	for( $i = 0 ; $i <= 10000 ; $i=$i+50 ) { $choices[$i] = sprintf('%.02f', $i/100). ' %'; }
  	$this->setWidget('descuento_porcentaje', new sfWidgetFormSelect( array('choices' => $choices) ) );
  	$this->setValidator('descuento_porcentaje', new sfValidatorChoice( array('choices' => array_keys($choices) ) ) );
  	$this->getWidget("descuento_porcentaje")->setLabel('Porcentaje de Descuento');

  	if ( $descuento->getIdDescuento() ) {
  		$this->setDefault("descuento_porcentaje", $descuento->getValor() * 100 );
  	}

  // Widget para eShops
  $choices = array();
  $eshops = eshopTable::getInstance()->listAll();
  $choices[''] = 'Deluxe Buys';
  foreach ($eshops as $eshop)
  {
      $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
  }
  $this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
  $this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );

  // Orden
	$this->setWidget('orden', new sfWidgetFormInputHidden()) ;
	
	if ( $this->isNew() )
	{
	    $ultimoOrden = promoPagoTable::getInstance()->getLast();
	    $ultimoOrden = ($ultimoOrden)? $ultimoOrden->getOrden() + 1 : 1;
	    $this->setDefault('orden', $ultimoOrden);
	}	
        
    // Imagen
    $this->setWidget("imagen", new sfWidgetFormInputFile());
    
    $this->setValidator("imagen", new sfValidatorFile(
        array(
            "required" => false,
            "path" => '/tmp',
        ), array(
            'required' => 'No ha seleccionado ningún elemento.'
        )
    ));

    // Imagen Mobile
    $this->setWidget("imagen_mobile", new sfWidgetFormInputFile());
    
    $this->setValidator("imagen_mobile", new sfValidatorFile(
        array(
            "required" => false,
            "path" => '/tmp',
        ), array(
            'required' => 'No ha seleccionado ningún elemento.'
        )
    ));

  }

  protected function doSave($con = null)
  {  	
  	$promoPago = $this->getObject();
  	  	
  	$file = $this->getValue('imagen');
    $fileMobile = $this->getValue('imagen_mobile');

  	unset($this->values['imagen']);
    unset($this->values['imagen_mobile']);
  	  			      	
    $this->updateObject();

    // Seteo de proveedor
    $proveedor = $this->getValue('tarjeta');
    $data = explode('-', $proveedor);
    $promoPago->setProveedor( $data[1] );

    // Seteo de dias de la semana
    $diasSemana = $this->getValue('dias_de_semana');
    if ( $diasSemana ) {
      $promoPago->setDiasSemana( implode(',', $diasSemana) );
    }

    // Seteo de cuotas
    $cuotas = $this->getValue('definicion_cuotas');
    if ( count($cuotas) ) {
      $promoPago->setCuotas( implode(',', $cuotas) );
    } else {
      $promoPago->setCuotas( null );
    }

    // Seteo de descuento
    if ( $this->getValue('descuento_tipo') == 'DELUXE' ) {

      $descuento = $promoPago->getDescuento();

      $descuentoPorcentaje = $this->getValue('descuento_porcentaje') / 100;

      if ( !$descuento->getIdDescuento() || $descuento->getValor() != $descuentoPorcentaje ) {

        if ( !$descuento->getIdDescuento() ) {
          $descuento = new Descuento(); 
        }

        $descuento->setCodigo('Asociado a una Promoción de Pago' );
        $descuento->setIdTipoDescuento( tipoDescuento::PORCENTAJE );
        $descuento->setValor( $descuentoPorcentaje );
        $descuento->setVigenciaDesde( null );
        $descuento->setVigenciaHasta( null );
        $descuento->setTotal(9999);
        $descuento->setUtilizados(0);
        $descuento->setIdEshop( $promoPago->getIdEshop() );
        $descuento->setEsInterno( true );
        $descuento->save();
      }

      $promoPago->setIdDescuento( $descuento->getIdDescuento() );
      $promoPago->setDescuento( $descuento );
      $promoPago->save();

    } else {
      $promoPago->setDescuento( null );
    }

    // Identificador
    $identificador = $this->getValue('identificador');
    if ( $identificador ) {

      if ( $this->getValue('id_forma_pago') == formaPago::NPS ) {
        $params = array('promotionCode' => $identificador);
      } else {
        $params = array('IDSITE' => $identificador);  
      }
      
    } else {
      $params = array();
    }
    $promoPago->setParams( json_encode($params) );
    $promoPago->save($con);

    if ( $promoPago->getDescuento() ) {
      $descuento = $promoPago->getDescuento();
      $descuento->setCodigo('Promoción de Pago #' . $promoPago->getIdPromoPago() );
      $descuento->save();
    }
    
      	
    if ( isset($file) )
    {
       imageHelper::getInstance()->processDeleteFile('promo_pago_imagen', $promoPago, true);
       imageHelper::getInstance()->processSaveFile('promo_pago_imagen', $promoPago, $file);
    }

    if ( isset($fileMobile) )
    {
       imageHelper::getInstance()->processDeleteFile('promo_pago_imagen_mobile', $promoPago, true);
       imageHelper::getInstance()->processSaveFile('promo_pago_imagen_mobile', $promoPago, $fileMobile);
    }
        
  }


}
