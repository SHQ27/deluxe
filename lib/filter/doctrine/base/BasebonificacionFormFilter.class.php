<?php

/**
 * bonificacion filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasebonificacionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_usuario'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => true)),
      'id_tipo_descuento'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tipoDescuento'), 'add_empty' => true)),
      'id_tipo_bonificacion' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tipoBonificacion'), 'add_empty' => true)),
      'valor'                => new sfWidgetFormFilterInput(),
      'fue_utilizada'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'vencimiento'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'es_interna'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'observaciones'        => new sfWidgetFormFilterInput(),
      'fecha_alta'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_usuario'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('usuario'), 'column' => 'id_usuario')),
      'id_tipo_descuento'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('tipoDescuento'), 'column' => 'id_tipo_descuento')),
      'id_tipo_bonificacion' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('tipoBonificacion'), 'column' => 'id_tipo_bonificacion')),
      'valor'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'fue_utilizada'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'vencimiento'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'es_interna'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'observaciones'        => new sfValidatorPass(array('required' => false)),
      'fecha_alta'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('bonificacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'bonificacion';
  }

  public function getFields()
  {
    return array(
      'id_bonificacion'      => 'Number',
      'id_usuario'           => 'ForeignKey',
      'id_tipo_descuento'    => 'ForeignKey',
      'id_tipo_bonificacion' => 'ForeignKey',
      'valor'                => 'Number',
      'fue_utilizada'        => 'Boolean',
      'vencimiento'          => 'Date',
      'es_interna'           => 'Boolean',
      'observaciones'        => 'Text',
      'fecha_alta'           => 'Date',
    );
  }
}
