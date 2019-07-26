<?php

/**
 * eshopImagenCampaign filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseeshopImagenCampaignFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'slide'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'activo'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'orden'                    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_eshop'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
      'slide'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'activo'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'orden'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('eshop_imagen_campaign_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopImagenCampaign';
  }

  public function getFields()
  {
    return array(
      'id_eshop_imagen_campaign' => 'Number',
      'id_eshop'                 => 'ForeignKey',
      'slide'                    => 'Boolean',
      'activo'                   => 'Boolean',
      'orden'                    => 'Number',
    );
  }
}
