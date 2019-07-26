<?php

/**
 * codigoPostal filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecodigoPostalFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'valor'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_provincia'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'valor'            => new sfValidatorPass(array('required' => false)),
      'id_provincia'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('provincia'), 'column' => 'id_provincia')),
    ));

    $this->widgetSchema->setNameFormat('codigo_postal_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'codigoPostal';
  }

  public function getFields()
  {
    return array(
      'id_codigo_postal' => 'Number',
      'valor'            => 'Text',
      'id_provincia'     => 'ForeignKey',
    );
  }
}
