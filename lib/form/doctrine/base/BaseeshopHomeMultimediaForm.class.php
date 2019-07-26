<?php

/**
 * eshopHomeMultimedia form base class.
 *
 * @method eshopHomeMultimedia getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseeshopHomeMultimediaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop_home_multimedia' => new sfWidgetFormInputHidden(),
      'id_eshop_home'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshopHome'), 'add_empty' => false)),
      'indice'                   => new sfWidgetFormInputText(),
      'link'                     => new sfWidgetFormInputText(),
      'es_video'                 => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_eshop_home_multimedia' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop_home_multimedia')), 'empty_value' => $this->getObject()->get('id_eshop_home_multimedia'), 'required' => false)),
      'id_eshop_home'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshopHome'))),
      'indice'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'es_video'                 => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_home_multimedia[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopHomeMultimedia';
  }

}
