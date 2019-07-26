<?php

/**
 * eshopImagenCampaign form base class.
 *
 * @method eshopImagenCampaign getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseeshopImagenCampaignForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop_imagen_campaign' => new sfWidgetFormInputHidden(),
      'id_eshop'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => false)),
      'slide'                    => new sfWidgetFormInputCheckbox(),
      'activo'                   => new sfWidgetFormInputCheckbox(),
      'orden'                    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_eshop_imagen_campaign' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop_imagen_campaign')), 'empty_value' => $this->getObject()->get('id_eshop_imagen_campaign'), 'required' => false)),
      'id_eshop'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'))),
      'slide'                    => new sfValidatorBoolean(array('required' => false)),
      'activo'                   => new sfValidatorBoolean(array('required' => false)),
      'orden'                    => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_imagen_campaign[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopImagenCampaign';
  }

}
