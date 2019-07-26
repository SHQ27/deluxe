<?php

/**
 * eshopTiendaCategoria form base class.
 *
 * @method eshopTiendaCategoria getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseeshopTiendaCategoriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop_tienda_categoria' => new sfWidgetFormInputHidden(),
      'denominacion'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_eshop_tienda_categoria' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop_tienda_categoria')), 'empty_value' => $this->getObject()->get('id_eshop_tienda_categoria'), 'required' => false)),
      'denominacion'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_tienda_categoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopTiendaCategoria';
  }

}
