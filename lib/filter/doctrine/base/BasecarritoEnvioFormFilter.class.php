<?php

/**
 * carritoEnvio filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecarritoEnvioFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_session'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('session'), 'add_empty' => true)),
      'tipo'             => new sfWidgetFormFilterInput(),
      'enviopack_data'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_session'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('session'), 'column' => 'id_session')),
      'tipo'             => new sfValidatorPass(array('required' => false)),
      'enviopack_data'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('carrito_envio_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'carritoEnvio';
  }

  public function getFields()
  {
    return array(
      'id_carrito_envio' => 'Number',
      'id_session'       => 'ForeignKey',
      'tipo'             => 'Text',
      'enviopack_data'   => 'Text',
    );
  }
}
