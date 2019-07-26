<?php

/**
 * productoTalle filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseproductoTalleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'      => new sfWidgetFormFilterInput(),
      'orden'             => new sfWidgetFormFilterInput(),
      'id_familia_talle'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('familiaTalle'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'denominacion'      => new sfValidatorPass(array('required' => false)),
      'orden'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'id_familia_talle'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('familiaTalle'), 'column' => 'id_familia_talle')),
    ));

    $this->widgetSchema->setNameFormat('producto_talle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoTalle';
  }

  public function getFields()
  {
    return array(
      'id_producto_talle' => 'Number',
      'denominacion'      => 'Text',
      'orden'             => 'Number',
      'id_familia_talle'  => 'ForeignKey',
    );
  }
}
