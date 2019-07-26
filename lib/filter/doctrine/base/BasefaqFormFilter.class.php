<?php

/**
 * faq filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasefaqFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_faq_categoria' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('faqCategoria'), 'add_empty' => true)),
      'pregunta'         => new sfWidgetFormFilterInput(),
      'texto'            => new sfWidgetFormFilterInput(),
      'orden'            => new sfWidgetFormFilterInput(),
      'es_como_comprar'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'id_faq_categoria' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('faqCategoria'), 'column' => 'id_faq_categoria')),
      'pregunta'         => new sfValidatorPass(array('required' => false)),
      'texto'            => new sfValidatorPass(array('required' => false)),
      'orden'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'es_como_comprar'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('faq_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'faq';
  }

  public function getFields()
  {
    return array(
      'id_faq'           => 'Number',
      'id_faq_categoria' => 'ForeignKey',
      'pregunta'         => 'Text',
      'texto'            => 'Text',
      'orden'            => 'Number',
      'es_como_comprar'  => 'Boolean',
    );
  }
}
