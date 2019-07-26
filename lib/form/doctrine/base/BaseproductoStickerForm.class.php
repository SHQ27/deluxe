<?php

/**
 * productoSticker form base class.
 *
 * @method productoSticker getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoStickerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_sticker' => new sfWidgetFormInputHidden(),
      'denominacion'        => new sfWidgetFormInputText(),
      'slug'                => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_producto_sticker' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto_sticker')), 'empty_value' => $this->getObject()->get('id_producto_sticker'), 'required' => false)),
      'denominacion'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slug'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'productoSticker', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('producto_sticker[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoSticker';
  }

}
