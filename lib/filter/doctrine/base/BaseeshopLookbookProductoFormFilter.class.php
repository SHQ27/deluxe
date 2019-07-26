<?php

/**
 * eshopLookbookProducto filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseeshopLookbookProductoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop_lookbook'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshopLookbook'), 'add_empty' => true)),
      'id_producto'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('producto'), 'add_empty' => true)),
      'position_top'               => new sfWidgetFormFilterInput(),
      'position_left'              => new sfWidgetFormFilterInput(),
      'background_color'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_eshop_lookbook'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshopLookbook'), 'column' => 'id_eshop_lookbook')),
      'id_producto'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('producto'), 'column' => 'id_producto')),
      'position_top'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position_left'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'background_color'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_lookbook_producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopLookbookProducto';
  }

  public function getFields()
  {
    return array(
      'id_eshop_lookbook_producto' => 'Number',
      'id_eshop_lookbook'          => 'ForeignKey',
      'id_producto'                => 'ForeignKey',
      'position_top'               => 'Number',
      'position_left'              => 'Number',
      'background_color'           => 'Text',
    );
  }
}
