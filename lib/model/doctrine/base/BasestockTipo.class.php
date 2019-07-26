<?php

/**
 * BasestockTipo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_stock_tipo
 * @property string $denominacion
 * @property boolean $es_de_sistema
 * @property Doctrine_Collection $stock
 * 
 * @method integer             getIdStockTipo()   Returns the current record's "id_stock_tipo" value
 * @method string              getDenominacion()  Returns the current record's "denominacion" value
 * @method boolean             getEsDeSistema()   Returns the current record's "es_de_sistema" value
 * @method Doctrine_Collection getStock()         Returns the current record's "stock" collection
 * @method stockTipo           setIdStockTipo()   Sets the current record's "id_stock_tipo" value
 * @method stockTipo           setDenominacion()  Sets the current record's "denominacion" value
 * @method stockTipo           setEsDeSistema()   Sets the current record's "es_de_sistema" value
 * @method stockTipo           setStock()         Sets the current record's "stock" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasestockTipo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('stock_tipo');
        $this->hasColumn('id_stock_tipo', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('denominacion', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             ));
        $this->hasColumn('es_de_sistema', 'boolean', null, array(
             'type' => 'boolean',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('stock', array(
             'local' => 'id_stock_tipo',
             'foreign' => 'id_stock_tipo'));
    }
}