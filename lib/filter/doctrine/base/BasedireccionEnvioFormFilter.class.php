<?php

/**
 * direccionEnvio filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasedireccionEnvioFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_usuario'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => true)),
      'id_provincia'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'), 'add_empty' => true)),
      'localidad'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'calle'              => new sfWidgetFormFilterInput(),
      'numero'             => new sfWidgetFormFilterInput(),
      'piso'               => new sfWidgetFormFilterInput(),
      'depto'              => new sfWidgetFormFilterInput(),
      'codigo_postal'      => new sfWidgetFormFilterInput(),
      'horario'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_usuario'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('usuario'), 'column' => 'id_usuario')),
      'id_provincia'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('provincia'), 'column' => 'id_provincia')),
      'localidad'          => new sfValidatorPass(array('required' => false)),
      'calle'              => new sfValidatorPass(array('required' => false)),
      'numero'             => new sfValidatorPass(array('required' => false)),
      'piso'               => new sfValidatorPass(array('required' => false)),
      'depto'              => new sfValidatorPass(array('required' => false)),
      'codigo_postal'      => new sfValidatorPass(array('required' => false)),
      'horario'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('direccion_envio_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'direccionEnvio';
  }

  public function getFields()
  {
    return array(
      'id_direccion_envio' => 'Number',
      'id_usuario'         => 'ForeignKey',
      'id_provincia'       => 'ForeignKey',
      'localidad'          => 'Text',
      'calle'              => 'Text',
      'numero'             => 'Text',
      'piso'               => 'Text',
      'depto'              => 'Text',
      'codigo_postal'      => 'Text',
      'horario'            => 'Text',
    );
  }
}
