<?php

/**
 * faqCategoria filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasefaqCategoriaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'     => new sfWidgetFormFilterInput(),
      'id_eshop'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'orden'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'denominacion'     => new sfValidatorPass(array('required' => false)),
      'id_eshop'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
      'orden'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('faq_categoria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'faqCategoria';
  }

  public function getFields()
  {
    return array(
      'id_faq_categoria' => 'Number',
      'denominacion'     => 'Text',
      'id_eshop'         => 'ForeignKey',
      'orden'            => 'Number',
    );
  }
}
