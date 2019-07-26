<?php

/**
 * imagenBannerPrincipal form base class.
 *
 * @method imagenBannerPrincipal getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseimagenBannerPrincipalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_imagen_banner_principal' => new sfWidgetFormInputHidden(),
      'id'                         => new sfWidgetFormInputText(),
      'tipo'                       => new sfWidgetFormInputText(),
      'src'                        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_imagen_banner_principal' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_imagen_banner_principal')), 'empty_value' => $this->getObject()->get('id_imagen_banner_principal'), 'required' => false)),
      'id'                         => new sfValidatorInteger(array('required' => false)),
      'tipo'                       => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'src'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('imagen_banner_principal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'imagenBannerPrincipal';
  }

}
