<?php

/**
 * BasepedidoProductoItem
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_pedido_producto_item
 * @property integer $id_producto_item
 * @property integer $id_pedido
 * @property integer $id_producto_talle
 * @property integer $id_producto_color
 * @property integer $cantidad
 * @property decimal $precio_lista
 * @property decimal $precio_deluxe
 * @property decimal $costo
 * @property string $origen
 * @property productoItem $productoItem
 * @property pedido $pedido
 * @property productoTalle $productoTalle
 * @property productoColor $productoColor
 * @property Doctrine_Collection $pedidoProductoItemCampana
 * @property Doctrine_Collection $stock
 * @property Doctrine_Collection $devolucionProductoItem
 * @property Doctrine_Collection $fallado
 * @property Doctrine_Collection $devueltoMarca
 * 
 * @method integer             getIdPedidoProductoItem()      Returns the current record's "id_pedido_producto_item" value
 * @method integer             getIdProductoItem()            Returns the current record's "id_producto_item" value
 * @method integer             getIdPedido()                  Returns the current record's "id_pedido" value
 * @method integer             getIdProductoTalle()           Returns the current record's "id_producto_talle" value
 * @method integer             getIdProductoColor()           Returns the current record's "id_producto_color" value
 * @method integer             getCantidad()                  Returns the current record's "cantidad" value
 * @method decimal             getPrecioLista()               Returns the current record's "precio_lista" value
 * @method decimal             getPrecioDeluxe()              Returns the current record's "precio_deluxe" value
 * @method decimal             getCosto()                     Returns the current record's "costo" value
 * @method string              getOrigen()                    Returns the current record's "origen" value
 * @method productoItem        getProductoItem()              Returns the current record's "productoItem" value
 * @method pedido              getPedido()                    Returns the current record's "pedido" value
 * @method productoTalle       getProductoTalle()             Returns the current record's "productoTalle" value
 * @method productoColor       getProductoColor()             Returns the current record's "productoColor" value
 * @method Doctrine_Collection getPedidoProductoItemCampana() Returns the current record's "pedidoProductoItemCampana" collection
 * @method Doctrine_Collection getStock()                     Returns the current record's "stock" collection
 * @method Doctrine_Collection getDevolucionProductoItem()    Returns the current record's "devolucionProductoItem" collection
 * @method Doctrine_Collection getFallado()                   Returns the current record's "fallado" collection
 * @method Doctrine_Collection getDevueltoMarca()             Returns the current record's "devueltoMarca" collection
 * @method pedidoProductoItem  setIdPedidoProductoItem()      Sets the current record's "id_pedido_producto_item" value
 * @method pedidoProductoItem  setIdProductoItem()            Sets the current record's "id_producto_item" value
 * @method pedidoProductoItem  setIdPedido()                  Sets the current record's "id_pedido" value
 * @method pedidoProductoItem  setIdProductoTalle()           Sets the current record's "id_producto_talle" value
 * @method pedidoProductoItem  setIdProductoColor()           Sets the current record's "id_producto_color" value
 * @method pedidoProductoItem  setCantidad()                  Sets the current record's "cantidad" value
 * @method pedidoProductoItem  setPrecioLista()               Sets the current record's "precio_lista" value
 * @method pedidoProductoItem  setPrecioDeluxe()              Sets the current record's "precio_deluxe" value
 * @method pedidoProductoItem  setCosto()                     Sets the current record's "costo" value
 * @method pedidoProductoItem  setOrigen()                    Sets the current record's "origen" value
 * @method pedidoProductoItem  setProductoItem()              Sets the current record's "productoItem" value
 * @method pedidoProductoItem  setPedido()                    Sets the current record's "pedido" value
 * @method pedidoProductoItem  setProductoTalle()             Sets the current record's "productoTalle" value
 * @method pedidoProductoItem  setProductoColor()             Sets the current record's "productoColor" value
 * @method pedidoProductoItem  setPedidoProductoItemCampana() Sets the current record's "pedidoProductoItemCampana" collection
 * @method pedidoProductoItem  setStock()                     Sets the current record's "stock" collection
 * @method pedidoProductoItem  setDevolucionProductoItem()    Sets the current record's "devolucionProductoItem" collection
 * @method pedidoProductoItem  setFallado()                   Sets the current record's "fallado" collection
 * @method pedidoProductoItem  setDevueltoMarca()             Sets the current record's "devueltoMarca" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasepedidoProductoItem extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('pedido_producto_item');
        $this->hasColumn('id_pedido_producto_item', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_producto_item', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_pedido', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_producto_talle', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_producto_color', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('cantidad', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('precio_lista', 'decimal', 12, array(
             'type' => 'decimal',
             'scale' => 2,
             'zerofill' => true,
             'length' => 12,
             ));
        $this->hasColumn('precio_deluxe', 'decimal', 12, array(
             'type' => 'decimal',
             'scale' => 2,
             'length' => 12,
             ));
        $this->hasColumn('costo', 'decimal', 12, array(
             'type' => 'decimal',
             'scale' => 2,
             'length' => 12,
             ));
        $this->hasColumn('origen', 'string', 6, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 6,
             ));


        $this->index('fk_pedido_producto_item_producto_item1', array(
             'fields' => 
             array(
              0 => 'id_producto_item',
             ),
             ));
        $this->index('fk_pedido_producto_item_pedido1', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
        $this->index('fk_pedido_producto_item_producto_talle1', array(
             'fields' => 
             array(
              0 => 'id_producto_talle',
             ),
             ));
        $this->index('fk_pedido_producto_item_producto_color1', array(
             'fields' => 
             array(
              0 => 'id_producto_color',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('productoItem', array(
             'local' => 'id_producto_item',
             'foreign' => 'id_producto_item',
             'owningSide' => true));

        $this->hasOne('pedido', array(
             'local' => 'id_pedido',
             'foreign' => 'id_pedido',
             'owningSide' => true));

        $this->hasOne('productoTalle', array(
             'local' => 'id_producto_talle',
             'foreign' => 'id_producto_talle',
             'owningSide' => true));

        $this->hasOne('productoColor', array(
             'local' => 'id_producto_color',
             'foreign' => 'id_producto_color',
             'owningSide' => true));

        $this->hasMany('pedidoProductoItemCampana', array(
             'local' => 'id_pedido_producto_item',
             'foreign' => 'id_pedido_producto_item'));

        $this->hasMany('stock', array(
             'local' => 'id_pedido_producto_item',
             'foreign' => 'id_pedido_producto_item'));

        $this->hasMany('devolucionProductoItem', array(
             'local' => 'id_pedido_producto_item',
             'foreign' => 'id_pedido_producto_item'));

        $this->hasMany('fallado', array(
             'local' => 'id_pedido_producto_item',
             'foreign' => 'id_pedido_producto_item'));

        $this->hasMany('devueltoMarca', array(
             'local' => 'id_pedido_producto_item',
             'foreign' => 'id_pedido_producto_item'));
    }
}