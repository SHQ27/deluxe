<?php

/**
 * productoCategoria filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseproductoCategoriaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'          => new sfWidgetFormFilterInput(),
      'id_producto_genero'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoGenero'), 'add_empty' => true)),
      'slug'                  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'denominacion'          => new sfValidatorPass(array('required' => false)),
      'id_producto_genero'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoGenero'), 'column' => 'id_producto_genero')),
      'slug'                  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_categoria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoCategoria';
  }

  public function getFields()
  {
    return array(
      'id_producto_categoria' => 'Number',
      'denominacion'          => 'Text',
      'id_producto_genero'    => 'ForeignKey',
      'slug'                  => 'Text',
    );
  }
}
