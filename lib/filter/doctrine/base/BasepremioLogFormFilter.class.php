<?php

/**
 * premioLog filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepremioLogFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_premio'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('premio'), 'add_empty' => true)),
      'id_bonificacion' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'), 'add_empty' => true)),
      'id_pedido'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_premio'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('premio'), 'column' => 'id_premio')),
      'id_bonificacion' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('bonificacion'), 'column' => 'id_bonificacion')),
      'id_pedido'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedido'), 'column' => 'id_pedido')),
    ));

    $this->widgetSchema->setNameFormat('premio_log_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'premioLog';
  }

  public function getFields()
  {
    return array(
      'id_premio_log'   => 'Number',
      'id_premio'       => 'ForeignKey',
      'id_bonificacion' => 'ForeignKey',
      'id_pedido'       => 'ForeignKey',
    );
  }
}
