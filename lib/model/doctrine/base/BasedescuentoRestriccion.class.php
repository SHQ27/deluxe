<?php

/**
 * BasedescuentoRestriccion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_descuento_restriccion
 * @property integer $id_descuento
 * @property string $tipo
 * @property integer $valor
 * @property boolean $excluir
 * @property descuento $descuento
 * 
 * @method integer              getIdDescuentoRestriccion()   Returns the current record's "id_descuento_restriccion" value
 * @method integer              getIdDescuento()              Returns the current record's "id_descuento" value
 * @method string               getTipo()                     Returns the current record's "tipo" value
 * @method integer              getValor()                    Returns the current record's "valor" value
 * @method boolean              getExcluir()                  Returns the current record's "excluir" value
 * @method descuento            getDescuento()                Returns the current record's "descuento" value
 * @method descuentoRestriccion setIdDescuentoRestriccion()   Sets the current record's "id_descuento_restriccion" value
 * @method descuentoRestriccion setIdDescuento()              Sets the current record's "id_descuento" value
 * @method descuentoRestriccion setTipo()                     Sets the current record's "tipo" value
 * @method descuentoRestriccion setValor()                    Sets the current record's "valor" value
 * @method descuentoRestriccion setExcluir()                  Sets the current record's "excluir" value
 * @method descuentoRestriccion setDescuento()                Sets the current record's "descuento" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasedescuentoRestriccion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('descuento_restriccion');
        $this->hasColumn('id_descuento_restriccion', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_descuento', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('tipo', 'string', 5, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 5,
             ));
        $this->hasColumn('valor', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('excluir', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));


        $this->index('fk_descuento_restriccion_descuento1', array(
             'fields' => 
             array(
              0 => 'id_descuento',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('descuento', array(
             'local' => 'id_descuento',
             'foreign' => 'id_descuento',
             'owningSide' => true));
    }
}