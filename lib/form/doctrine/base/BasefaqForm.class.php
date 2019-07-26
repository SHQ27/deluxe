<?php

/**
 * faq form base class.
 *
 * @method faq getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefaqForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_faq'           => new sfWidgetFormInputHidden(),
      'id_faq_categoria' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('faqCategoria'), 'add_empty' => false)),
      'pregunta'         => new sfWidgetFormInputText(),
      'texto'            => new sfWidgetFormTextarea(),
      'orden'            => new sfWidgetFormInputText(),
      'es_como_comprar'  => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_faq'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_faq')), 'empty_value' => $this->getObject()->get('id_faq'), 'required' => false)),
      'id_faq_categoria' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('faqCategoria'))),
      'pregunta'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'texto'            => new sfValidatorString(array('required' => false)),
      'orden'            => new sfValidatorInteger(array('required' => false)),
      'es_como_comprar'  => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('faq[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'faq';
  }

}
