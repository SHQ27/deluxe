<?php

/**
 * BaseproductoColor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_producto_color
 * @property string $denominacion
 * @property integer $id_familia_color
 * @property familiaColor $familiaColor
 * @property Doctrine_Collection $productoItem
 * @property Doctrine_Collection $pedidoProductoItem
 * 
 * @method integer             getIdProductoColor()    Returns the current record's "id_producto_color" value
 * @method string              getDenominacion()       Returns the current record's "denominacion" value
 * @method integer             getIdFamiliaColor()     Returns the current record's "id_familia_color" value
 * @method familiaColor        getFamiliaColor()       Returns the current record's "familiaColor" value
 * @method Doctrine_Collection getProductoItem()       Returns the current record's "productoItem" collection
 * @method Doctrine_Collection getPedidoProductoItem() Returns the current record's "pedidoProductoItem" collection
 * @method productoColor       setIdProductoColor()    Sets the current record's "id_producto_color" value
 * @method productoColor       setDenominacion()       Sets the current record's "denominacion" value
 * @method productoColor       setIdFamiliaColor()     Sets the current record's "id_familia_color" value
 * @method productoColor       setFamiliaColor()       Sets the current record's "familiaColor" value
 * @method productoColor       setProductoItem()       Sets the current record's "productoItem" collection
 * @method productoColor       setPedidoProductoItem() Sets the current record's "pedidoProductoItem" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseproductoColor extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('producto_color');
        $this->hasColumn('id_producto_color', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('denominacion', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('id_familia_color', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));


        $this->index('fk_producto_color_familia_color1', array(
             'fields' => 
             array(
              0 => 'id_familia_color',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('familiaColor', array(
             'local' => 'id_familia_color',
             'foreign' => 'id_familia_color',
             'owningSide' => true));

        $this->hasMany('productoItem', array(
             'local' => 'id_producto_color',
             'foreign' => 'id_producto_color'));

        $this->hasMany('pedidoProductoItem', array(
             'local' => 'id_producto_color',
             'foreign' => 'id_producto_color'));
    }
}