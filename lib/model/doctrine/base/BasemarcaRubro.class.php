<?php

/**
 * BasemarcaRubro
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_marca_rubro
 * @property string $denominacion
 * @property Doctrine_Collection $marca
 * 
 * @method integer             getIdMarcaRubro()   Returns the current record's "id_marca_rubro" value
 * @method string              getDenominacion()   Returns the current record's "denominacion" value
 * @method Doctrine_Collection getMarca()          Returns the current record's "marca" collection
 * @method marcaRubro          setIdMarcaRubro()   Sets the current record's "id_marca_rubro" value
 * @method marcaRubro          setDenominacion()   Sets the current record's "denominacion" value
 * @method marcaRubro          setMarca()          Sets the current record's "marca" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemarcaRubro extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('marca_rubro');
        $this->hasColumn('id_marca_rubro', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('denominacion', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('marca', array(
             'local' => 'id_marca_rubro',
             'foreign' => 'id_marca_rubro'));
    }
}