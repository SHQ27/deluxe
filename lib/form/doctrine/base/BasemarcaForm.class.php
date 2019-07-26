<?php

/**
 * marca form base class.
 *
 * @method marca getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemarcaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_marca'         => new sfWidgetFormInputHidden(),
      'nombre'           => new sfWidgetFormInputText(),
      'backstage_url'    => new sfWidgetFormInputText(),
      'id_marca_rubro'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('marcaRubro'), 'add_empty' => true)),
      'condicion_fiscal' => new sfWidgetFormInputText(),
      'email_comercial'  => new sfWidgetFormInputText(),
      'slug'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_marca'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_marca')), 'empty_value' => $this->getObject()->get('id_marca'), 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'backstage_url'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_marca_rubro'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('marcaRubro'), 'required' => false)),
      'condicion_fiscal' => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'email_comercial'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slug'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'marca', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('marca[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'marca';
  }

}
