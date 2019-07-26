<?php

/**
 * eshopTiendaTiendaCategoria form base class.
 *
 * @method eshopTiendaTiendaCategoria getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseeshopTiendaTiendaCategoriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop_tienda'           => new sfWidgetFormInputHidden(),
      'id_eshop_tienda_categoria' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id_eshop_tienda'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop_tienda')), 'empty_value' => $this->getObject()->get('id_eshop_tienda'), 'required' => false)),
      'id_eshop_tienda_categoria' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop_tienda_categoria')), 'empty_value' => $this->getObject()->get('id_eshop_tienda_categoria'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_tienda_tienda_categoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopTiendaTiendaCategoria';
  }

}
