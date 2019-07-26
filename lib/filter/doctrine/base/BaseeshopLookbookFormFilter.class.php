<?php

/**
 * eshopLookbook filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseeshopLookbookFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'      => new sfWidgetFormFilterInput(),
      'texto'             => new sfWidgetFormFilterInput(),
      'id_eshop'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'activo'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'orden'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'denominacion'      => new sfValidatorPass(array('required' => false)),
      'texto'             => new sfValidatorPass(array('required' => false)),
      'id_eshop'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
      'activo'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'orden'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('eshop_lookbook_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopLookbook';
  }

  public function getFields()
  {
    return array(
      'id_eshop_lookbook' => 'Number',
      'denominacion'      => 'Text',
      'texto'             => 'Text',
      'id_eshop'          => 'ForeignKey',
      'activo'            => 'Boolean',
      'orden'             => 'Number',
    );
  }
}
