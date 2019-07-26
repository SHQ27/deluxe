<?php

/**
 * descuentoRestriccion filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasedescuentoRestriccionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_descuento'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'), 'add_empty' => true)),
      'tipo'                     => new sfWidgetFormFilterInput(),
      'valor'                    => new sfWidgetFormFilterInput(),
      'excluir'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'id_descuento'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('descuento'), 'column' => 'id_descuento')),
      'tipo'                     => new sfValidatorPass(array('required' => false)),
      'valor'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'excluir'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('descuento_restriccion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'descuentoRestriccion';
  }

  public function getFields()
  {
    return array(
      'id_descuento_restriccion' => 'Number',
      'id_descuento'             => 'ForeignKey',
      'tipo'                     => 'Text',
      'valor'                    => 'Number',
      'excluir'                  => 'Boolean',
    );
  }
}
