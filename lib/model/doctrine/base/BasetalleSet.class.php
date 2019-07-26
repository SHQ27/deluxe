<?php

/**
 * BasetalleSet
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_talle_set
 * @property string $denominacion
 * @property integer $id_marca
 * @property marca $marca
 * @property Doctrine_Collection $producto
 * @property Doctrine_Collection $talleSetZona
 * 
 * @method integer             getIdTalleSet()   Returns the current record's "id_talle_set" value
 * @method string              getDenominacion() Returns the current record's "denominacion" value
 * @method integer             getIdMarca()      Returns the current record's "id_marca" value
 * @method marca               getMarca()        Returns the current record's "marca" value
 * @method Doctrine_Collection getProducto()     Returns the current record's "producto" collection
 * @method Doctrine_Collection getTalleSetZona() Returns the current record's "talleSetZona" collection
 * @method talleSet            setIdTalleSet()   Sets the current record's "id_talle_set" value
 * @method talleSet            setDenominacion() Sets the current record's "denominacion" value
 * @method talleSet            setIdMarca()      Sets the current record's "id_marca" value
 * @method talleSet            setMarca()        Sets the current record's "marca" value
 * @method talleSet            setProducto()     Sets the current record's "producto" collection
 * @method talleSet            setTalleSetZona() Sets the current record's "talleSetZona" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasetalleSet extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('talle_set');
        $this->hasColumn('id_talle_set', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('denominacion', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('id_marca', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));


        $this->index('fk_talle_set_marca1', array(
             'fields' => 
             array(
              0 => 'id_marca',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('marca', array(
             'local' => 'id_marca',
             'foreign' => 'id_marca',
             'owningSide' => true));

        $this->hasMany('producto', array(
             'local' => 'id_talle_set',
             'foreign' => 'id_talle_set'));

        $this->hasMany('talleSetZona', array(
             'local' => 'id_talle_set',
             'foreign' => 'id_talle_set'));
    }
}