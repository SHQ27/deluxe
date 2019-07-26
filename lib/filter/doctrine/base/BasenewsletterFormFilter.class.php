<?php

/**
 * newsletter filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasenewsletterFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'        => new sfWidgetFormFilterInput(),
      'apellido'      => new sfWidgetFormFilterInput(),
      'sexo'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fecha_alta'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'source'        => new sfWidgetFormFilterInput(),
      'fecha_source'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'utm_campaign'  => new sfWidgetFormFilterInput(),
      'utm_term'      => new sfWidgetFormFilterInput(),
      'id_eshop'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nombre'        => new sfValidatorPass(array('required' => false)),
      'apellido'      => new sfValidatorPass(array('required' => false)),
      'sexo'          => new sfValidatorPass(array('required' => false)),
      'email'         => new sfValidatorPass(array('required' => false)),
      'fecha_alta'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'source'        => new sfValidatorPass(array('required' => false)),
      'fecha_source'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'utm_campaign'  => new sfValidatorPass(array('required' => false)),
      'utm_term'      => new sfValidatorPass(array('required' => false)),
      'id_eshop'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
    ));

    $this->widgetSchema->setNameFormat('newsletter_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'newsletter';
  }

  public function getFields()
  {
    return array(
      'id_newsletter' => 'Number',
      'nombre'        => 'Text',
      'apellido'      => 'Text',
      'sexo'          => 'Text',
      'email'         => 'Text',
      'fecha_alta'    => 'Date',
      'source'        => 'Text',
      'fecha_source'  => 'Date',
      'utm_campaign'  => 'Text',
      'utm_term'      => 'Text',
      'id_eshop'      => 'ForeignKey',
    );
  }
}
