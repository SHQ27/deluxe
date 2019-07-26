<?php

/**
 * talleSet filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasetalleSetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion' => new sfWidgetFormFilterInput(),
      'id_marca'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('marca'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'denominacion' => new sfValidatorPass(array('required' => false)),
      'id_marca'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('marca'), 'column' => 'id_marca')),
    ));

    $this->widgetSchema->setNameFormat('talle_set_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'talleSet';
  }

  public function getFields()
  {
    return array(
      'id_talle_set' => 'Number',
      'denominacion' => 'Text',
      'id_marca'     => 'ForeignKey',
    );
  }
}
