<?php

/**
 * productoGenero form base class.
 *
 * @method productoGenero getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoGeneroForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_genero' => new sfWidgetFormInputHidden(),
      'denominacion'       => new sfWidgetFormInputText(),
      'meta_titulo'        => new sfWidgetFormInputText(),
      'meta_descripcion'   => new sfWidgetFormTextarea(),
      'meta_tags'          => new sfWidgetFormTextarea(),
      'slug'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_producto_genero' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto_genero')), 'empty_value' => $this->getObject()->get('id_producto_genero'), 'required' => false)),
      'denominacion'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'meta_titulo'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'meta_descripcion'   => new sfValidatorString(array('required' => false)),
      'meta_tags'          => new sfValidatorString(array('required' => false)),
      'slug'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'productoGenero', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('producto_genero[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoGenero';
  }

}
