<?php

/**
 * codigoPostal form base class.
 *
 * @method codigoPostal getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecodigoPostalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_codigo_postal' => new sfWidgetFormInputHidden(),
      'valor'            => new sfWidgetFormInputText(),
      'id_provincia'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_codigo_postal' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_codigo_postal')), 'empty_value' => $this->getObject()->get('id_codigo_postal'), 'required' => false)),
      'valor'            => new sfValidatorString(array('max_length' => 8)),
      'id_provincia'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'))),
    ));

    $this->widgetSchema->setNameFormat('codigo_postal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'codigoPostal';
  }

}
