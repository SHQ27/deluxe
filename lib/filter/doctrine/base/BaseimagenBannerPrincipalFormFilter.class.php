<?php

/**
 * imagenBannerPrincipal filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseimagenBannerPrincipalFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormFilterInput(),
      'tipo'                       => new sfWidgetFormFilterInput(),
      'src'                        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipo'                       => new sfValidatorPass(array('required' => false)),
      'src'                        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('imagen_banner_principal_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'imagenBannerPrincipal';
  }

  public function getFields()
  {
    return array(
      'id_imagen_banner_principal' => 'Number',
      'id'                         => 'Number',
      'tipo'                       => 'Text',
      'src'                        => 'Text',
    );
  }
}
