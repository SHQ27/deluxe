<?php

/**
 * faqCategoria form base class.
 *
 * @method faqCategoria getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefaqCategoriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_faq_categoria' => new sfWidgetFormInputHidden(),
      'denominacion'     => new sfWidgetFormInputText(),
      'id_eshop'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'orden'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_faq_categoria' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_faq_categoria')), 'empty_value' => $this->getObject()->get('id_faq_categoria'), 'required' => false)),
      'denominacion'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_eshop'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'required' => false)),
      'orden'            => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('faq_categoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'faqCategoria';
  }

}
