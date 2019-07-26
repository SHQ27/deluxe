<?php

/**
 * productoImagen filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseproductoImagenFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('producto'), 'add_empty' => true)),
      'orden'              => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_producto'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('producto'), 'column' => 'id_producto')),
      'orden'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('producto_imagen_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoImagen';
  }

  public function getFields()
  {
    return array(
      'id_producto_imagen' => 'Number',
      'id_producto'        => 'ForeignKey',
      'orden'              => 'Number',
    );
  }
}
