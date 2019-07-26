<?php

/**
 * marca filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemarcaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'           => new sfWidgetFormFilterInput(),
      'backstage_url'    => new sfWidgetFormFilterInput(),
      'id_marca_rubro'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('marcaRubro'), 'add_empty' => true)),
      'condicion_fiscal' => new sfWidgetFormFilterInput(),
      'email_comercial'  => new sfWidgetFormFilterInput(),
      'slug'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nombre'           => new sfValidatorPass(array('required' => false)),
      'backstage_url'    => new sfValidatorPass(array('required' => false)),
      'id_marca_rubro'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('marcaRubro'), 'column' => 'id_marca_rubro')),
      'condicion_fiscal' => new sfValidatorPass(array('required' => false)),
      'email_comercial'  => new sfValidatorPass(array('required' => false)),
      'slug'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('marca_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'marca';
  }

  public function getFields()
  {
    return array(
      'id_marca'         => 'Number',
      'nombre'           => 'Text',
      'backstage_url'    => 'Text',
      'id_marca_rubro'   => 'ForeignKey',
      'condicion_fiscal' => 'Text',
      'email_comercial'  => 'Text',
      'slug'             => 'Text',
    );
  }
}
