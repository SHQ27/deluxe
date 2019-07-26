<?php

/**
 * familiaColor form base class.
 *
 * @method familiaColor getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefamiliaColorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_familia_color' => new sfWidgetFormInputHidden(),
      'denominacion'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_familia_color' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_familia_color')), 'empty_value' => $this->getObject()->get('id_familia_color'), 'required' => false)),
      'denominacion'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('familia_color[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'familiaColor';
  }

}
