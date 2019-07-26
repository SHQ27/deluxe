<?php

/**
 * productoCategoria form base class.
 *
 * @method productoCategoria getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoCategoriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_categoria' => new sfWidgetFormInputHidden(),
      'denominacion'          => new sfWidgetFormInputText(),
      'id_producto_genero'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoGenero'), 'add_empty' => false)),
      'slug'                  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_producto_categoria' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto_categoria')), 'empty_value' => $this->getObject()->get('id_producto_categoria'), 'required' => false)),
      'denominacion'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_producto_genero'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoGenero'))),
      'slug'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_categoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoCategoria';
  }

}
