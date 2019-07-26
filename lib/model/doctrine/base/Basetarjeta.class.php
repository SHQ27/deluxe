<?php

/**
 * Basetarjeta
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_tarjeta
 * @property string $denominacion
 * @property Doctrine_Collection $cuota
 * 
 * @method integer             getIdTarjeta()    Returns the current record's "id_tarjeta" value
 * @method string              getDenominacion() Returns the current record's "denominacion" value
 * @method Doctrine_Collection getCuota()        Returns the current record's "cuota" collection
 * @method tarjeta             setIdTarjeta()    Sets the current record's "id_tarjeta" value
 * @method tarjeta             setDenominacion() Sets the current record's "denominacion" value
 * @method tarjeta             setCuota()        Sets the current record's "cuota" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basetarjeta extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tarjeta');
        $this->hasColumn('id_tarjeta', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('denominacion', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('cuota', array(
             'local' => 'id_tarjeta',
             'foreign' => 'id_tarjeta'));
    }
}