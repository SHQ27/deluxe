<?php

/**
 * invitacion filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseinvitacionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_usuario'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario_invitados'), 'add_empty' => true)),
      'email_invitado'      => new sfWidgetFormFilterInput(),
      'hash'                => new sfWidgetFormFilterInput(),
      'fue_enviada'         => new sfWidgetFormFilterInput(),
      'fecha'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'id_usuario_invitado' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => true)),
      'id_pedido_realizado' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => true)),
      'bonificacion'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'id_usuario'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('usuario_invitados'), 'column' => 'id_usuario')),
      'email_invitado'      => new sfValidatorPass(array('required' => false)),
      'hash'                => new sfValidatorPass(array('required' => false)),
      'fue_enviada'         => new sfValidatorPass(array('required' => false)),
      'fecha'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'id_usuario_invitado' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('usuario'), 'column' => 'id_usuario')),
      'id_pedido_realizado' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedido'), 'column' => 'id_pedido')),
      'bonificacion'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('invitacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'invitacion';
  }

  public function getFields()
  {
    return array(
      'id_invitacion'       => 'Number',
      'id_usuario'          => 'ForeignKey',
      'email_invitado'      => 'Text',
      'hash'                => 'Text',
      'fue_enviada'         => 'Text',
      'fecha'               => 'Date',
      'id_usuario_invitado' => 'ForeignKey',
      'id_pedido_realizado' => 'ForeignKey',
      'bonificacion'        => 'Boolean',
    );
  }
}
