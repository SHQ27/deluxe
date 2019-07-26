<?php

/**
 * sourceInversion form base class.
 *
 * @method sourceInversion getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesourceInversionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_source_inversion' => new sfWidgetFormInputHidden(),
      'id_source'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('source'), 'add_empty' => false)),
      'valor'               => new sfWidgetFormInputText(),
      'fecha'               => new sfWidgetFormDate(),
      'id_eshop'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_source_inversion' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_source_inversion')), 'empty_value' => $this->getObject()->get('id_source_inversion'), 'required' => false)),
      'id_source'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('source'))),
      'valor'               => new sfValidatorNumber(array('required' => false)),
      'fecha'               => new sfValidatorDate(array('required' => false)),
      'id_eshop'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('source_inversion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sourceInversion';
  }

}
