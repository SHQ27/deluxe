<?php

/**
 * productoSticker filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseproductoStickerFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'        => new sfWidgetFormFilterInput(),
      'slug'                => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'denominacion'        => new sfValidatorPass(array('required' => false)),
      'slug'                => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_sticker_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoSticker';
  }

  public function getFields()
  {
    return array(
      'id_producto_sticker' => 'Number',
      'denominacion'        => 'Text',
      'slug'                => 'Text',
    );
  }
}
