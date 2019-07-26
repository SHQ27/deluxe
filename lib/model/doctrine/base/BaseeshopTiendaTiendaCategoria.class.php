<?php

/**
 * BaseeshopTiendaTiendaCategoria
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_eshop_tienda
 * @property integer $id_eshop_tienda_categoria
 * @property eshopTienda $eshopTienda
 * @property eshopTiendaCategoria $eshopTiendaCategoria
 * 
 * @method integer                    getIdEshopTienda()             Returns the current record's "id_eshop_tienda" value
 * @method integer                    getIdEshopTiendaCategoria()    Returns the current record's "id_eshop_tienda_categoria" value
 * @method eshopTienda                getEshopTienda()               Returns the current record's "eshopTienda" value
 * @method eshopTiendaCategoria       getEshopTiendaCategoria()      Returns the current record's "eshopTiendaCategoria" value
 * @method eshopTiendaTiendaCategoria setIdEshopTienda()             Sets the current record's "id_eshop_tienda" value
 * @method eshopTiendaTiendaCategoria setIdEshopTiendaCategoria()    Sets the current record's "id_eshop_tienda_categoria" value
 * @method eshopTiendaTiendaCategoria setEshopTienda()               Sets the current record's "eshopTienda" value
 * @method eshopTiendaTiendaCategoria setEshopTiendaCategoria()      Sets the current record's "eshopTiendaCategoria" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseeshopTiendaTiendaCategoria extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('eshop_tienda_tienda_categoria');
        $this->hasColumn('id_eshop_tienda', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_eshop_tienda_categoria', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('eshopTienda', array(
             'local' => 'id_eshop_tienda',
             'foreign' => 'id_eshop_tienda',
             'owningSide' => true));

        $this->hasOne('eshopTiendaCategoria', array(
             'local' => 'id_eshop_tienda_categoria',
             'foreign' => 'id_eshop_tienda_categoria',
             'owningSide' => true));
    }
}