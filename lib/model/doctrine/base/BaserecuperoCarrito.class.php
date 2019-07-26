<?php

/**
 * BaserecuperoCarrito
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_recupero_carrito
 * @property integer $id_pedido
 * @property boolean $mail_enviado
 * @property string $hash
 * @property pedido $pedido
 * 
 * @method integer         getIdRecuperoCarrito()   Returns the current record's "id_recupero_carrito" value
 * @method integer         getIdPedido()            Returns the current record's "id_pedido" value
 * @method boolean         getMailEnviado()         Returns the current record's "mail_enviado" value
 * @method string          getHash()                Returns the current record's "hash" value
 * @method pedido          getPedido()              Returns the current record's "pedido" value
 * @method recuperoCarrito setIdRecuperoCarrito()   Sets the current record's "id_recupero_carrito" value
 * @method recuperoCarrito setIdPedido()            Sets the current record's "id_pedido" value
 * @method recuperoCarrito setMailEnviado()         Sets the current record's "mail_enviado" value
 * @method recuperoCarrito setHash()                Sets the current record's "hash" value
 * @method recuperoCarrito setPedido()              Sets the current record's "pedido" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaserecuperoCarrito extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('recupero_carrito');
        $this->hasColumn('id_recupero_carrito', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_pedido', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('mail_enviado', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('hash', 'string', 40, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 40,
             ));


        $this->index('fk_recupero_carrito_pedido1', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('pedido', array(
             'local' => 'id_pedido',
             'foreign' => 'id_pedido',
             'owningSide' => true));
    }
}