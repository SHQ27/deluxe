<?php

/**
 * usuarioTalleZona filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseusuarioTalleZonaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'medida'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'medida'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('usuario_talle_zona_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'usuarioTalleZona';
  }

  public function getFields()
  {
    return array(
      'id_talle_zona' => 'Number',
      'id_usuario'    => 'Number',
      'medida'        => 'Number',
    );
  }
}
