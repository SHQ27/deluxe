<?php

/**
 * BasecuponProducto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_cupon
 * @property integer $id_producto
 * @property cupon $cupon
 * @property producto $producto
 * 
 * @method integer       getIdCupon()     Returns the current record's "id_cupon" value
 * @method integer       getIdProducto()  Returns the current record's "id_producto" value
 * @method cupon         getCupon()       Returns the current record's "cupon" value
 * @method producto      getProducto()    Returns the current record's "producto" value
 * @method cuponProducto setIdCupon()     Sets the current record's "id_cupon" value
 * @method cuponProducto setIdProducto()  Sets the current record's "id_producto" value
 * @method cuponProducto setCupon()       Sets the current record's "cupon" value
 * @method cuponProducto setProducto()    Sets the current record's "producto" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasecuponProducto extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cupon_producto');
        $this->hasColumn('id_cupon', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_producto', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));


        $this->index('fk_cupon_has_producto_producto1', array(
             'fields' => 
             array(
              0 => 'id_producto',
             ),
             ));
        $this->index('fk_cupon_has_producto_cupon1', array(
             'fields' => 
             array(
              0 => 'id_cupon',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('cupon', array(
             'local' => 'id_cupon',
             'foreign' => 'id_cupon',
             'owningSide' => true));

        $this->hasOne('producto', array(
             'local' => 'id_producto',
             'foreign' => 'id_producto',
             'owningSide' => true));
    }
}