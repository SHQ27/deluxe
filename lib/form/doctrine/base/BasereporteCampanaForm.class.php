<?php

/**
 * reporteCampana form base class.
 *
 * @method reporteCampana getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasereporteCampanaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_reporte_campana'       => new sfWidgetFormInputHidden(),
      'id_campana'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('campana'), 'add_empty' => false)),
      'rubro'                    => new sfWidgetFormInputText(),
      'cantidad_pedidos'         => new sfWidgetFormInputText(),
      'unidades_vendidas'        => new sfWidgetFormInputText(),
      'unidades_promedio_pedido' => new sfWidgetFormInputText(),
      'total_facturado'          => new sfWidgetFormInputText(),
      'pdb'                      => new sfWidgetFormInputText(),
      'costo_total'              => new sfWidgetFormInputText(),
      'margen_bruto'             => new sfWidgetFormInputText(),
      'margen_promedio'          => new sfWidgetFormInputText(),
      'total_stock'              => new sfWidgetFormInputText(),
      'ejecucion_de_stock'       => new sfWidgetFormTextarea(),
      'top_productos'            => new sfWidgetFormTextarea(),
      'ticket_promedio'          => new sfWidgetFormInputText(),
      'objetivo_facturacion'     => new sfWidgetFormInputText(),
      'objetivo_resultado'       => new sfWidgetFormInputText(),
      'condicion_fiscal'         => new sfWidgetFormInputText(),
      'cantidad_pedido_hombre'   => new sfWidgetFormInputText(),
      'cantidad_pedido_mujer'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_reporte_campana'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_reporte_campana')), 'empty_value' => $this->getObject()->get('id_reporte_campana'), 'required' => false)),
      'id_campana'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('campana'))),
      'rubro'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cantidad_pedidos'         => new sfValidatorInteger(array('required' => false)),
      'unidades_vendidas'        => new sfValidatorInteger(array('required' => false)),
      'unidades_promedio_pedido' => new sfValidatorNumber(array('required' => false)),
      'total_facturado'          => new sfValidatorNumber(array('required' => false)),
      'pdb'                      => new sfValidatorNumber(array('required' => false)),
      'costo_total'              => new sfValidatorNumber(array('required' => false)),
      'margen_bruto'             => new sfValidatorNumber(array('required' => false)),
      'margen_promedio'          => new sfValidatorNumber(array('required' => false)),
      'total_stock'              => new sfValidatorInteger(array('required' => false)),
      'ejecucion_de_stock'       => new sfValidatorString(array('required' => false)),
      'top_productos'            => new sfValidatorString(array('required' => false)),
      'ticket_promedio'          => new sfValidatorNumber(array('required' => false)),
      'objetivo_facturacion'     => new sfValidatorNumber(array('required' => false)),
      'objetivo_resultado'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'condicion_fiscal'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cantidad_pedido_hombre'   => new sfValidatorInteger(array('required' => false)),
      'cantidad_pedido_mujer'    => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('reporte_campana[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'reporteCampana';
  }

}
