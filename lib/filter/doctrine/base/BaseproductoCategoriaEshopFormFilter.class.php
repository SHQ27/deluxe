<?php

/**
 * productoCategoriaEshop filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseproductoCategoriaEshopFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipo_prenda'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'orden'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'tipo_prenda'           => new sfValidatorPass(array('required' => false)),
      'orden'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('producto_categoria_eshop_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoCategoriaEshop';
  }

  public function getFields()
  {
    return array(
      'id_producto_categoria' => 'Number',
      'id_eshop'              => 'Number',
      'tipo_prenda'           => 'Text',
      'orden'                 => 'Number',
    );
  }
}
