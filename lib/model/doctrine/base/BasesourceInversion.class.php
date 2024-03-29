<?php

/**
 * BasesourceInversion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_source_inversion
 * @property integer $id_source
 * @property float $valor
 * @property date $fecha
 * @property integer $id_eshop
 * @property source $source
 * @property eshop $eshop
 * 
 * @method integer         getIdSourceInversion()   Returns the current record's "id_source_inversion" value
 * @method integer         getIdSource()            Returns the current record's "id_source" value
 * @method float           getValor()               Returns the current record's "valor" value
 * @method date            getFecha()               Returns the current record's "fecha" value
 * @method integer         getIdEshop()             Returns the current record's "id_eshop" value
 * @method source          getSource()              Returns the current record's "source" value
 * @method eshop           getEshop()               Returns the current record's "eshop" value
 * @method sourceInversion setIdSourceInversion()   Sets the current record's "id_source_inversion" value
 * @method sourceInversion setIdSource()            Sets the current record's "id_source" value
 * @method sourceInversion setValor()               Sets the current record's "valor" value
 * @method sourceInversion setFecha()               Sets the current record's "fecha" value
 * @method sourceInversion setIdEshop()             Sets the current record's "id_eshop" value
 * @method sourceInversion setSource()              Sets the current record's "source" value
 * @method sourceInversion setEshop()               Sets the current record's "eshop" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasesourceInversion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('source_inversion');
        $this->hasColumn('id_source_inversion', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_source', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('valor', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('fecha', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('id_eshop', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));


        $this->index('fk_source_inversion_source1', array(
             'fields' => 
             array(
              0 => 'id_source',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('source', array(
             'local' => 'id_source',
             'foreign' => 'id_source',
             'owningSide' => true));

        $this->hasOne('eshop', array(
             'local' => 'id_eshop',
             'foreign' => 'id_eshop',
             'owningSide' => true));
    }
}