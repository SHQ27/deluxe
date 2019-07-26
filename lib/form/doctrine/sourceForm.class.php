<?php

/**
 * source form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sourceForm extends BasesourceForm
{
  public function configure()
  {    
    // eShop
    $choices = array();
    $eshops = eshopTable::getInstance()->listAll();
    $choices[''] = 'Deluxe Buys';
    foreach ($eshops as $eshop)
    {
        $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
    }
    $this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
    $this->getWidget( 'id_eshop' )->setLabel('eShop');
    $this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );
    
    // Periodo
    $choices = array();
    $choices[''] = 'Seleccionar';
    for( $i = 0 ; $i < 6; $i++ )
    {
        $date = mktime (0, 0, 0, date('m') - $i, 1, date('Y'));
        $choices[ date('Y-m-d', $date) ] = ucfirst( strftime("%B %Y", $date) );
    }
    
    $this->setWidget( 'periodo', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
    $this->setValidator( 'periodo', new sfValidatorPass() );
    
    // Valor
    $this->setWidget( 'valor', new sfWidgetFormInput() );
    $this->setValidator( 'valor', new sfValidatorPass() );
  }
  
  protected function doSave($con = null)
  { 
    // Guardo el soruce
    $this->updateObject();
    $source = $this->getObject();
    $source->save($con);

    $valor = $this->getValue('valor');
    $idEshop = $this->getValue('id_eshop');
    $periodo = $this->getValue('periodo');
    
    if ( $periodo && $valor )
    {
        $sourceInversion = new sourceInversion();
        $sourceInversion->setValor( $valor );
        $sourceInversion->setFecha( $periodo );
        $sourceInversion->setIdEshop( $idEshop );
        $sourceInversion->setIdSource( $source->getIdSource() );
        $sourceInversion->save();
    }    
  }
  
}
