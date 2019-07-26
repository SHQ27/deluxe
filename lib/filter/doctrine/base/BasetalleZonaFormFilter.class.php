<?php

/**
 * talleZona filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasetalleZonaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'  => new sfWidgetFormFilterInput(),
      'orden'         => new sfWidgetFormFilterInput(),
      'descripcion'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'denominacion'  => new sfValidatorPass(array('required' => false)),
      'orden'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'descripcion'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('talle_zona_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'talleZona';
  }

  public function getFields()
  {
    return array(
      'id_talle_zona' => 'Number',
      'denominacion'  => 'Text',
      'orden'         => 'Number',
      'descripcion'   => 'Text',
    );
  }
}
