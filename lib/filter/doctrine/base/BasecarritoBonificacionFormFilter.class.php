<?php

/**
 * carritoBonificacion filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecarritoBonificacionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_bonificacion'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'), 'add_empty' => true)),
      'id_session'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('session'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_bonificacion'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('bonificacion'), 'column' => 'id_bonificacion')),
      'id_session'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('session'), 'column' => 'id_session')),
    ));

    $this->widgetSchema->setNameFormat('carrito_bonificacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'carritoBonificacion';
  }

  public function getFields()
  {
    return array(
      'id_carrito_bonificacion' => 'Number',
      'id_bonificacion'         => 'ForeignKey',
      'id_session'              => 'ForeignKey',
    );
  }
}
