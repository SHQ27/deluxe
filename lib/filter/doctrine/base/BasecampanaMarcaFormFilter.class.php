<?php

/**
 * campanaMarca filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecampanaMarcaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_comercial'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('comercial'), 'add_empty' => true)),
      'comision_comercial'        => new sfWidgetFormFilterInput(),
      'apertura_marca'            => new sfWidgetFormFilterInput(),
      'email_orden_compra'        => new sfWidgetFormFilterInput(),
      'telefono_orden_compra'     => new sfWidgetFormFilterInput(),
      'enviar_aviso_orden_compra' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fecha_estimada_entrega'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'comentario_marca'          => new sfWidgetFormFilterInput(),
      'comentario_interno'        => new sfWidgetFormFilterInput(),
      'ultimo_envio'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'hash'                      => new sfWidgetFormFilterInput(),
      'costo_total'               => new sfWidgetFormFilterInput(),
      'pagada'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'id_comercial'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('comercial'), 'column' => 'id_comercial')),
      'comision_comercial'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'apertura_marca'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'email_orden_compra'        => new sfValidatorPass(array('required' => false)),
      'telefono_orden_compra'     => new sfValidatorPass(array('required' => false)),
      'enviar_aviso_orden_compra' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fecha_estimada_entrega'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'comentario_marca'          => new sfValidatorPass(array('required' => false)),
      'comentario_interno'        => new sfValidatorPass(array('required' => false)),
      'ultimo_envio'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'hash'                      => new sfValidatorPass(array('required' => false)),
      'costo_total'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'pagada'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('campana_marca_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'campanaMarca';
  }

  public function getFields()
  {
    return array(
      'id_campana'                => 'Number',
      'id_marca'                  => 'Number',
      'id_comercial'              => 'ForeignKey',
      'comision_comercial'        => 'Number',
      'apertura_marca'            => 'Number',
      'email_orden_compra'        => 'Text',
      'telefono_orden_compra'     => 'Text',
      'enviar_aviso_orden_compra' => 'Boolean',
      'fecha_estimada_entrega'    => 'Date',
      'comentario_marca'          => 'Text',
      'comentario_interno'        => 'Text',
      'ultimo_envio'              => 'Date',
      'hash'                      => 'Text',
      'costo_total'               => 'Number',
      'pagada'                    => 'Boolean',
    );
  }
}
