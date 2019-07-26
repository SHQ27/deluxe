<?php

/**
 * banner filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasebannerFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'orden'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'activo'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ventana_nueva' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'url'           => new sfValidatorPass(array('required' => false)),
      'orden'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'activo'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ventana_nueva' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('banner_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'banner';
  }

  public function getFields()
  {
    return array(
      'id_banner'     => 'Number',
      'url'           => 'Text',
      'orden'         => 'Number',
      'activo'        => 'Boolean',
      'ventana_nueva' => 'Boolean',
    );
  }
}
