<?php

/**
 * source filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasesourceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'       => new sfWidgetFormFilterInput(),
      'denominacion' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'       => new sfValidatorPass(array('required' => false)),
      'denominacion' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('source_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'source';
  }

  public function getFields()
  {
    return array(
      'id_source'    => 'Number',
      'codigo'       => 'Text',
      'denominacion' => 'Text',
    );
  }
}
