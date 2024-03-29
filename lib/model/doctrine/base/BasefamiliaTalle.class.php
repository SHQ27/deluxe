<?php

/**
 * BasefamiliaTalle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_familia_talle
 * @property string $denominacion
 * @property Doctrine_Collection $productoTalle
 * 
 * @method integer             getIdFamiliaTalle()   Returns the current record's "id_familia_talle" value
 * @method string              getDenominacion()     Returns the current record's "denominacion" value
 * @method Doctrine_Collection getProductoTalle()    Returns the current record's "productoTalle" collection
 * @method familiaTalle        setIdFamiliaTalle()   Sets the current record's "id_familia_talle" value
 * @method familiaTalle        setDenominacion()     Sets the current record's "denominacion" value
 * @method familiaTalle        setProductoTalle()    Sets the current record's "productoTalle" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasefamiliaTalle extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('familia_talle');
        $this->hasColumn('id_familia_talle', 'integer', 4, array(
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
        $this->hasMany('productoTalle', array(
             'local' => 'id_familia_talle',
             'foreign' => 'id_familia_talle'));
    }
}