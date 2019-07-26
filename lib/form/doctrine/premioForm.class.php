<?php

/**
 * premio form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class premioForm extends BasepremioForm
{
    static $choicesTipoPremio = array(
                                    'MFIJO' => 'Monto Fijo en Pesos',
                                    'PORCE' => 'Porcentaje de una compra'
                                );
    
  public function configure()
  {
      $this->setWidget('fecha_desde', new pmWidgetFormDate() );
      $this->setWidget('fecha_hasta', new pmWidgetFormDate() );
      
      $this->setWidget('tipo_premio', new sfWidgetFormSelect( array('choices' => self::$choicesTipoPremio)) );
      $this->setValidator('tipo_premio', new sfValidatorChoice( array('choices' => array_keys(self::$choicesTipoPremio))) );
  }
}
