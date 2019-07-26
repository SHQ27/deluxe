<?php

/**
 * talleSetZona filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasetalleSetZonaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_talle_set'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('talleSet'), 'add_empty' => true)),
      'id_talle_zona'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('talleZona'), 'add_empty' => true)),
      'id_producto_talle' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoTalle'), 'add_empty' => true)),
      'desde'             => new sfWidgetFormFilterInput(),
      'hasta'             => new sfWidgetFormFilterInput(),
      'orden'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_talle_set'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('talleSet'), 'column' => 'id_talle_set')),
      'id_talle_zona'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('talleZona'), 'column' => 'id_talle_zona')),
      'id_producto_talle' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoTalle'), 'column' => 'id_producto_talle')),
      'desde'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'hasta'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'orden'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('talle_set_zona_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'talleSetZona';
  }

  public function getFields()
  {
    return array(
      'id_talle_set_zona' => 'Number',
      'id_talle_set'      => 'ForeignKey',
      'id_talle_zona'     => 'ForeignKey',
      'id_producto_talle' => 'ForeignKey',
      'desde'             => 'Number',
      'hasta'             => 'Number',
      'orden'             => 'Number',
    );
  }
}
