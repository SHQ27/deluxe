<?php

/**
 * Basestock
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_stock
 * @property timestamp $fecha
 * @property integer $id_producto_item
 * @property integer $id_stock_tipo
 * @property integer $cantidad
 * @property string $origen
 * @property integer $id_pedido_producto_item
 * @property clob $observacion
 * @property productoItem $productoItem
 * @property stockTipo $stockTipo
 * @property pedidoProductoItem $pedidoProductoItem
 * 
 * @method integer            getIdStock()                 Returns the current record's "id_stock" value
 * @method timestamp          getFecha()                   Returns the current record's "fecha" value
 * @method integer            getIdProductoItem()          Returns the current record's "id_producto_item" value
 * @method integer            getIdStockTipo()             Returns the current record's "id_stock_tipo" value
 * @method integer            getCantidad()                Returns the current record's "cantidad" value
 * @method string             getOrigen()                  Returns the current record's "origen" value
 * @method integer            getIdPedidoProductoItem()    Returns the current record's "id_pedido_producto_item" value
 * @method clob               getObservacion()             Returns the current record's "observacion" value
 * @method productoItem       getProductoItem()            Returns the current record's "productoItem" value
 * @method stockTipo          getStockTipo()               Returns the current record's "stockTipo" value
 * @method pedidoProductoItem getPedidoProductoItem()      Returns the current record's "pedidoProductoItem" value
 * @method stock              setIdStock()                 Sets the current record's "id_stock" value
 * @method stock              setFecha()                   Sets the current record's "fecha" value
 * @method stock              setIdProductoItem()          Sets the current record's "id_producto_item" value
 * @method stock              setIdStockTipo()             Sets the current record's "id_stock_tipo" value
 * @method stock              setCantidad()                Sets the current record's "cantidad" value
 * @method stock              setOrigen()                  Sets the current record's "origen" value
 * @method stock              setIdPedidoProductoItem()    Sets the current record's "id_pedido_producto_item" value
 * @method stock              setObservacion()             Sets the current record's "observacion" value
 * @method stock              setProductoItem()            Sets the current record's "productoItem" value
 * @method stock              setStockTipo()               Sets the current record's "stockTipo" value
 * @method stock              setPedidoProductoItem()      Sets the current record's "pedidoProductoItem" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basestock extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('stock');
        $this->hasColumn('id_stock', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('fecha', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('id_producto_item', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_stock_tipo', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('cantidad', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('origen', 'string', 6, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 6,
             ));
        $this->hasColumn('id_pedido_producto_item', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('observacion', 'clob', 65535, array(
             'type' => 'clob',
             'length' => 65535,
             ));


        $this->index('fk_stock_producto_item1', array(
             'fields' => 
             array(
              0 => 'id_producto_item',
             ),
             ));
        $this->index('ix_stock_origen', array(
             'fields' => 
             array(
              0 => 'origen',
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

        $this->hasOne('stockTipo', array(
             'local' => 'id_stock_tipo',
             'foreign' => 'id_stock_tipo',
             'owningSide' => true));

        $this->hasOne('pedidoProductoItem', array(
             'local' => 'id_pedido_producto_item',
             'foreign' => 'id_pedido_producto_item',
             'owningSide' => true));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             'created' => 
             array(
              'name' => 'fecha',
              'type' => 'timestamp',
              'format' => 'Y-m-d H:i:s',
             ),
             'updated' => 
             array(
              'disabled' => true,
             ),
             ));
        $this->actAs($timestampable0);
    }
}