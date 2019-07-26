<?php

/**
 * avisoPedido filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseavisoPedidoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_tipo_aviso_pedido' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tipoAvisoPedido'), 'add_empty' => true)),
      'fecha'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'id_pedido'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => true)),
      'hash'                 => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_tipo_aviso_pedido' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('tipoAvisoPedido'), 'column' => 'id_tipo_aviso_pedido')),
      'fecha'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'id_pedido'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedido'), 'column' => 'id_pedido')),
      'hash'                 => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('aviso_pedido_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'avisoPedido';
  }

  public function getFields()
  {
    return array(
      'id_aviso_pedido'      => 'Number',
      'id_tipo_aviso_pedido' => 'ForeignKey',
      'fecha'                => 'Date',
      'id_pedido'            => 'ForeignKey',
      'hash'                 => 'Text',
    );
  }
}
