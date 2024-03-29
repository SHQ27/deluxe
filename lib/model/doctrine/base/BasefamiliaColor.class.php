<?php

/**
 * BasefamiliaColor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_familia_color
 * @property string $denominacion
 * @property Doctrine_Collection $productoColor
 * 
 * @method integer             getIdFamiliaColor()   Returns the current record's "id_familia_color" value
 * @method string              getDenominacion()     Returns the current record's "denominacion" value
 * @method Doctrine_Collection getProductoColor()    Returns the current record's "productoColor" collection
 * @method familiaColor        setIdFamiliaColor()   Sets the current record's "id_familia_color" value
 * @method familiaColor        setDenominacion()     Sets the current record's "denominacion" value
 * @method familiaColor        setProductoColor()    Sets the current record's "productoColor" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasefamiliaColor extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('familia_color');
        $this->hasColumn('id_familia_color', 'integer', 4, array(
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
        $this->hasMany('productoColor', array(
             'local' => 'id_familia_color',
             'foreign' => 'id_familia_color'));
    }
}