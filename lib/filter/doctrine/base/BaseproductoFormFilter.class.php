<?php

/**
 * producto filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseproductoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'          => new sfWidgetFormFilterInput(),
      'descripcion'           => new sfWidgetFormFilterInput(),
      'info_adicional'        => new sfWidgetFormFilterInput(),
      'id_marca'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('marca'), 'add_empty' => true)),
      'id_producto_categoria' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoCategoria'), 'add_empty' => true)),
      'fecha_modificacion'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'precio_lista'          => new sfWidgetFormFilterInput(),
      'mostrar_precio_lista'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'precio_normal'         => new sfWidgetFormFilterInput(),
      'precio_outlet'         => new sfWidgetFormFilterInput(),
      'precio_deluxe'         => new sfWidgetFormFilterInput(),
      'costo'                 => new sfWidgetFormFilterInput(),
      'peso'                  => new sfWidgetFormFilterInput(),
      'destacar'              => new sfWidgetFormFilterInput(),
      'vendidos'              => new sfWidgetFormFilterInput(),
      'visitas'               => new sfWidgetFormFilterInput(),
      'es_outlet'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'observacion'           => new sfWidgetFormFilterInput(),
      'activo'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'id_talle_set'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('talleSet'), 'add_empty' => true)),
      'id_producto_sticker'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoSticker'), 'add_empty' => true)),
      'id_categoria_ml'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('categoriaMl'), 'add_empty' => true)),
      'id_eshop'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'orden_eshop'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'denominacion'          => new sfValidatorPass(array('required' => false)),
      'descripcion'           => new sfValidatorPass(array('required' => false)),
      'info_adicional'        => new sfValidatorPass(array('required' => false)),
      'id_marca'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('marca'), 'column' => 'id_marca')),
      'id_producto_categoria' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoCategoria'), 'column' => 'id_producto_categoria')),
      'fecha_modificacion'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'precio_lista'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'mostrar_precio_lista'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'precio_normal'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'precio_outlet'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'precio_deluxe'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'peso'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'destacar'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'vendidos'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'visitas'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'es_outlet'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'observacion'           => new sfValidatorPass(array('required' => false)),
      'activo'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'id_talle_set'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('talleSet'), 'column' => 'id_talle_set')),
      'id_producto_sticker'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoSticker'), 'column' => 'id_producto_sticker')),
      'id_categoria_ml'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('categoriaMl'), 'column' => 'id_categoria_ml')),
      'id_eshop'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
      'orden_eshop'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'producto';
  }

  public function getFields()
  {
    return array(
      'id_producto'           => 'Number',
      'denominacion'          => 'Text',
      'descripcion'           => 'Text',
      'info_adicional'        => 'Text',
      'id_marca'              => 'ForeignKey',
      'id_producto_categoria' => 'ForeignKey',
      'fecha_modificacion'    => 'Date',
      'precio_lista'          => 'Number',
      'mostrar_precio_lista'  => 'Boolean',
      'precio_normal'         => 'Number',
      'precio_outlet'         => 'Number',
      'precio_deluxe'         => 'Number',
      'costo'                 => 'Number',
      'peso'                  => 'Number',
      'destacar'              => 'Number',
      'vendidos'              => 'Number',
      'visitas'               => 'Number',
      'es_outlet'             => 'Boolean',
      'observacion'           => 'Text',
      'activo'                => 'Boolean',
      'id_talle_set'          => 'ForeignKey',
      'id_producto_sticker'   => 'ForeignKey',
      'id_categoria_ml'       => 'ForeignKey',
      'id_eshop'              => 'ForeignKey',
      'orden_eshop'           => 'Number',
    );
  }
}
