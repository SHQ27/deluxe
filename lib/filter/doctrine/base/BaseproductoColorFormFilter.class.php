<?php

/**
 * productoColor filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseproductoColorFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'      => new sfWidgetFormFilterInput(),
      'id_familia_color'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('familiaColor'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'denominacion'      => new sfValidatorPass(array('required' => false)),
      'id_familia_color'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('familiaColor'), 'column' => 'id_familia_color')),
    ));

    $this->widgetSchema->setNameFormat('producto_color_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoColor';
  }

  public function getFields()
  {
    return array(
      'id_producto_color' => 'Number',
      'denominacion'      => 'Text',
      'id_familia_color'  => 'ForeignKey',
    );
  }
}
