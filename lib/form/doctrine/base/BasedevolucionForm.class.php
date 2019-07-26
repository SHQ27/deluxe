<?php

/**
 * devolucion form base class.
 *
 * @method devolucion getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasedevolucionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_devolucion'              => new sfWidgetFormInputHidden(),
      'fecha'                      => new sfWidgetFormDateTime(),
      'id_bonificacion'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'), 'add_empty' => true)),
      'id_usuario'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => false)),
      'tipo_envio'                 => new sfWidgetFormInputText(),
      'tipo_credito'               => new sfWidgetFormInputText(),
      'nombre'                     => new sfWidgetFormInputText(),
      'apellido'                   => new sfWidgetFormInputText(),
      'calle'                      => new sfWidgetFormInputText(),
      'numero'                     => new sfWidgetFormInputText(),
      'piso'                       => new sfWidgetFormInputText(),
      'dpto'                       => new sfWidgetFormInputText(),
      'codigo_postal'              => new sfWidgetFormInputText(),
      'id_provincia'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'), 'add_empty' => true)),
      'localidad'                  => new sfWidgetFormInputText(),
      'fecha_envio_oca'            => new sfWidgetFormDateTime(),
      'fecha_recibido'             => new sfWidgetFormDateTime(),
      'fecha_cierre'               => new sfWidgetFormDateTime(),
      'id_devolucion_motivo'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('devolucionMotivo'), 'add_empty' => true)),
      'motivo_otro'                => new sfWidgetFormTextarea(),
      'codigo_envio'               => new sfWidgetFormInputText(),
      'envio_id_pedido_envio_pack' => new sfWidgetFormInputText(),
      'monto_total'                => new sfWidgetFormInputText(),
      'id_eshop'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_devolucion'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_devolucion')), 'empty_value' => $this->getObject()->get('id_devolucion'), 'required' => false)),
      'fecha'                      => new sfValidatorDateTime(),
      'id_bonificacion'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'), 'required' => false)),
      'id_usuario'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'))),
      'tipo_envio'                 => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'tipo_credito'               => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'nombre'                     => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'apellido'                   => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'calle'                      => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'numero'                     => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'piso'                       => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'dpto'                       => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'codigo_postal'              => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'id_provincia'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'), 'required' => false)),
      'localidad'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_envio_oca'            => new sfValidatorDateTime(array('required' => false)),
      'fecha_recibido'             => new sfValidatorDateTime(array('required' => false)),
      'fecha_cierre'               => new sfValidatorDateTime(array('required' => false)),
      'id_devolucion_motivo'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('devolucionMotivo'), 'required' => false)),
      'motivo_otro'                => new sfValidatorString(array('required' => false)),
      'codigo_envio'               => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'envio_id_pedido_envio_pack' => new sfValidatorInteger(array('required' => false)),
      'monto_total'                => new sfValidatorNumber(array('required' => false)),
      'id_eshop'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('devolucion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'devolucion';
  }

}
