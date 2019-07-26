<?php

/**
 * reporteCampana filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasereporteCampanaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_campana'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('campana'), 'add_empty' => true)),
      'rubro'                    => new sfWidgetFormFilterInput(),
      'cantidad_pedidos'         => new sfWidgetFormFilterInput(),
      'unidades_vendidas'        => new sfWidgetFormFilterInput(),
      'unidades_promedio_pedido' => new sfWidgetFormFilterInput(),
      'total_facturado'          => new sfWidgetFormFilterInput(),
      'pdb'                      => new sfWidgetFormFilterInput(),
      'costo_total'              => new sfWidgetFormFilterInput(),
      'margen_bruto'             => new sfWidgetFormFilterInput(),
      'margen_promedio'          => new sfWidgetFormFilterInput(),
      'total_stock'              => new sfWidgetFormFilterInput(),
      'ejecucion_de_stock'       => new sfWidgetFormFilterInput(),
      'top_productos'            => new sfWidgetFormFilterInput(),
      'ticket_promedio'          => new sfWidgetFormFilterInput(),
      'objetivo_facturacion'     => new sfWidgetFormFilterInput(),
      'objetivo_resultado'       => new sfWidgetFormFilterInput(),
      'condicion_fiscal'         => new sfWidgetFormFilterInput(),
      'cantidad_pedido_hombre'   => new sfWidgetFormFilterInput(),
      'cantidad_pedido_mujer'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_campana'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('campana'), 'column' => 'id_campana')),
      'rubro'                    => new sfValidatorPass(array('required' => false)),
      'cantidad_pedidos'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'unidades_vendidas'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'unidades_promedio_pedido' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_facturado'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'pdb'                      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_total'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'margen_bruto'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'margen_promedio'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_stock'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ejecucion_de_stock'       => new sfValidatorPass(array('required' => false)),
      'top_productos'            => new sfValidatorPass(array('required' => false)),
      'ticket_promedio'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'objetivo_facturacion'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'objetivo_resultado'       => new sfValidatorPass(array('required' => false)),
      'condicion_fiscal'         => new sfValidatorPass(array('required' => false)),
      'cantidad_pedido_hombre'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cantidad_pedido_mujer'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('reporte_campana_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'reporteCampana';
  }

  public function getFields()
  {
    return array(
      'id_reporte_campana'       => 'Number',
      'id_campana'               => 'ForeignKey',
      'rubro'                    => 'Text',
      'cantidad_pedidos'         => 'Number',
      'unidades_vendidas'        => 'Number',
      'unidades_promedio_pedido' => 'Number',
      'total_facturado'          => 'Number',
      'pdb'                      => 'Number',
      'costo_total'              => 'Number',
      'margen_bruto'             => 'Number',
      'margen_promedio'          => 'Number',
      'total_stock'              => 'Number',
      'ejecucion_de_stock'       => 'Text',
      'top_productos'            => 'Text',
      'ticket_promedio'          => 'Number',
      'objetivo_facturacion'     => 'Number',
      'objetivo_resultado'       => 'Text',
      'condicion_fiscal'         => 'Text',
      'cantidad_pedido_hombre'   => 'Number',
      'cantidad_pedido_mujer'    => 'Number',
    );
  }
}
