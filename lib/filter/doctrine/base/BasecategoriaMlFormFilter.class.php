<?php

/**
 * categoriaMl filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecategoriaMlFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_categoria_ml_padre' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('categoriaMlPadre'), 'add_empty' => true)),
      'denominacion'          => new sfWidgetFormFilterInput(),
      'id_externo'            => new sfWidgetFormFilterInput(),
      'tiene_hijos'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'attribute_types'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_categoria_ml_padre' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('categoriaMlPadre'), 'column' => 'id_categoria_ml')),
      'denominacion'          => new sfValidatorPass(array('required' => false)),
      'id_externo'            => new sfValidatorPass(array('required' => false)),
      'tiene_hijos'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'attribute_types'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categoria_ml_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'categoriaMl';
  }

  public function getFields()
  {
    return array(
      'id_categoria_ml'       => 'Number',
      'id_categoria_ml_padre' => 'ForeignKey',
      'denominacion'          => 'Text',
      'id_externo'            => 'Text',
      'tiene_hijos'           => 'Boolean',
      'attribute_types'       => 'Text',
    );
  }
}
