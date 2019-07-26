<?php

/**
 * eshopHomeMultimedia filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseeshopHomeMultimediaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop_home'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshopHome'), 'add_empty' => true)),
      'indice'                   => new sfWidgetFormFilterInput(),
      'link'                     => new sfWidgetFormFilterInput(),
      'es_video'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'id_eshop_home'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshopHome'), 'column' => 'id_eshop_home')),
      'indice'                   => new sfValidatorPass(array('required' => false)),
      'link'                     => new sfValidatorPass(array('required' => false)),
      'es_video'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('eshop_home_multimedia_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopHomeMultimedia';
  }

  public function getFields()
  {
    return array(
      'id_eshop_home_multimedia' => 'Number',
      'id_eshop_home'            => 'ForeignKey',
      'indice'                   => 'Text',
      'link'                     => 'Text',
      'es_video'                 => 'Boolean',
    );
  }
}
