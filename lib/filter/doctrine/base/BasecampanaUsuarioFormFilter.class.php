<?php

/**
 * campanaUsuario filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecampanaUsuarioFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_campana'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('campana'), 'add_empty' => true)),
      'id_sf_guard_user'   => new sfWidgetFormFilterInput(),
      'email'              => new sfWidgetFormFilterInput(),
      'usuario'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_campana'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('campana'), 'column' => 'id_campana')),
      'id_sf_guard_user'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'email'              => new sfValidatorPass(array('required' => false)),
      'usuario'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('campana_usuario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'campanaUsuario';
  }

  public function getFields()
  {
    return array(
      'id_campana_usuario' => 'Number',
      'id_campana'         => 'ForeignKey',
      'id_sf_guard_user'   => 'Number',
      'email'              => 'Text',
      'usuario'            => 'Text',
    );
  }
}
