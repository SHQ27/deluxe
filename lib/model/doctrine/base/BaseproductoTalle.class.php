<?php

/**
 * BaseproductoTalle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_producto_talle
 * @property string $denominacion
 * @property integer $orden
 * @property integer $id_familia_talle
 * @property familiaTalle $familiaTalle
 * @property Doctrine_Collection $productoItem
 * @property Doctrine_Collection $pedidoProductoItem
 * @property Doctrine_Collection $talleSetZona
 * 
 * @method integer             getIdProductoTalle()    Returns the current record's "id_producto_talle" value
 * @method string              getDenominacion()       Returns the current record's "denominacion" value
 * @method integer             getOrden()              Returns the current record's "orden" value
 * @method integer             getIdFamiliaTalle()     Returns the current record's "id_familia_talle" value
 * @method familiaTalle        getFamiliaTalle()       Returns the current record's "familiaTalle" value
 * @method Doctrine_Collection getProductoItem()       Returns the current record's "productoItem" collection
 * @method Doctrine_Collection getPedidoProductoItem() Returns the current record's "pedidoProductoItem" collection
 * @method Doctrine_Collection getTalleSetZona()       Returns the current record's "talleSetZona" collection
 * @method productoTalle       setIdProductoTalle()    Sets the current record's "id_producto_talle" value
 * @method productoTalle       setDenominacion()       Sets the current record's "denominacion" value
 * @method productoTalle       setOrden()              Sets the current record's "orden" value
 * @method productoTalle       setIdFamiliaTalle()     Sets the current record's "id_familia_talle" value
 * @method productoTalle       setFamiliaTalle()       Sets the current record's "familiaTalle" value
 * @method productoTalle       setProductoItem()       Sets the current record's "productoItem" collection
 * @method productoTalle       setPedidoProductoItem() Sets the current record's "pedidoProductoItem" collection
 * @method productoTalle       setTalleSetZona()       Sets the current record's "talleSetZona" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseproductoTalle extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('producto_talle');
        $this->hasColumn('id_producto_talle', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('denominacion', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('orden', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('id_familia_talle', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));


        $this->index('fk_producto_talle_familia_talle1', array(
             'fields' => 
             array(
              0 => 'id_familia_talle',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('familiaTalle', array(
             'local' => 'id_familia_talle',
             'foreign' => 'id_familia_talle',
             'owningSide' => true));

        $this->hasMany('productoItem', array(
             'local' => 'id_producto_talle',
             'foreign' => 'id_producto_talle'));

        $this->hasMany('pedidoProductoItem', array(
             'local' => 'id_producto_talle',
             'foreign' => 'id_producto_talle'));

        $this->hasMany('talleSetZona', array(
             'local' => 'id_producto_talle',
             'foreign' => 'id_producto_talle'));
    }
}