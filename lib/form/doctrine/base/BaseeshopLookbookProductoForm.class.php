<?php

/**
 * eshopLookbookProducto form base class.
 *
 * @method eshopLookbookProducto getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseeshopLookbookProductoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop_lookbook_producto' => new sfWidgetFormInputHidden(),
      'id_eshop_lookbook'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshopLookbook'), 'add_empty' => false)),
      'id_producto'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('producto'), 'add_empty' => false)),
      'position_top'               => new sfWidgetFormInputText(),
      'position_left'              => new sfWidgetFormInputText(),
      'background_color'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_eshop_lookbook_producto' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop_lookbook_producto')), 'empty_value' => $this->getObject()->get('id_eshop_lookbook_producto'), 'required' => false)),
      'id_eshop_lookbook'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshopLookbook'))),
      'id_producto'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('producto'))),
      'position_top'               => new sfValidatorInteger(array('required' => false)),
      'position_left'              => new sfValidatorInteger(array('required' => false)),
      'background_color'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_lookbook_producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopLookbookProducto';
  }

}
