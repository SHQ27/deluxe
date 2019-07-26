<?php

/**
 * bannerPrincipal form base class.
 *
 * @method bannerPrincipal getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasebannerPrincipalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_banner_principal' => new sfWidgetFormInputHidden(),
      'denominacion'        => new sfWidgetFormInputText(),
      'url'                 => new sfWidgetFormInputText(),
      'activo'              => new sfWidgetFormInputCheckbox(),
      'fecha_desde'         => new sfWidgetFormDateTime(),
      'fecha_hasta'         => new sfWidgetFormDateTime(),
      'orden'               => new sfWidgetFormInputText(),
      'mostrar_descripcion' => new sfWidgetFormInputCheckbox(),
      'color'               => new sfWidgetFormInputText(),
      'off'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_banner_principal' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_banner_principal')), 'empty_value' => $this->getObject()->get('id_banner_principal'), 'required' => false)),
      'denominacion'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'url'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'activo'              => new sfValidatorBoolean(array('required' => false)),
      'fecha_desde'         => new sfValidatorDateTime(array('required' => false)),
      'fecha_hasta'         => new sfValidatorDateTime(array('required' => false)),
      'orden'               => new sfValidatorInteger(array('required' => false)),
      'mostrar_descripcion' => new sfValidatorBoolean(array('required' => false)),
      'color'               => new sfValidatorPass(array('required' => false)),
      'off'                 => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('banner_principal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'bannerPrincipal';
  }

}
